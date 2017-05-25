<?php
namespace UserFrosting\Sprinkle\ExtendUser\Model;

use Illuminate\Database\Capsule\Manager as Capsule;
use UserFrosting\Sprinkle\Account\Model\User;
use UserFrosting\Sprinkle\ExtendUser\Model\Member;

trait LinkMember {
    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function bootLinkMember()
    {
        /**
         * Create a new Member if necessary, and save the associated member every time.
         */
        static::saved(function ($memberUser) {
            $memberUser->createRelatedMemberIfNotExists();

            // When creating a new MemberUser, it might not have had a `user_id` when the `member`
            // relationship was created.  So, we should set it on the Member if it hasn't been set yet.
            if (!$memberUser->member->user_id) {
                $memberUser->member->user_id = $memberUser->id;
            }

            $memberUser->member->save();
        });
    }
}
    
class MemberUser extends User {
    use LinkMember;

    protected $fillable = [
        "user_name",
        "first_name",
        "last_name",
        "email",
        "locale",
        "theme",
        "group_id",
        "flag_verified",
        "flag_enabled",
        "last_activity_id",
        "password",
        "deleted_at",
        "city",
        "country"
    ];

    /**
     * Required to be able to access the `member` relationship in Twig without needing to do eager loading.
     * @see http://stackoverflow.com/questions/29514081/cannot-access-eloquent-attributes-on-twig/35908957#35908957
     */
    public function __isset($name)
    {
        if (in_array($name, [
            'member'
        ])) {
            return true;
        } else {
            return parent::__isset($name);
        }
    }

    /**
     * Custom accessor for Member property
     */
    public function getCityAttribute($value)
    {
        return (count($this->member) ? $this->member->city : '');
    }

    /**
     * Custom accessor for Member property
     */
    public function getCountryAttribute($value)
    {
        return (count($this->member) ? $this->member->country : '');
    }

    /**
     * Get the member associated with this user.
     */
    public function member()
    {
        /** @var UserFrosting\Sprinkle\Core\Util\ClassMapper $classMapper */
        $classMapper = static::$ci->classMapper;

        return $this->hasOne($classMapper->getClassMapping('member'), 'user_id');
    }

    /**
     * Custom mutator for Member property
     */
    public function setCityAttribute($value)
    {
        $this->createRelatedMemberIfNotExists();

        $this->member->city = $value;
    }

    /**
     * Custom mutator for Member property
     */
    public function setCountryAttribute($value)
    {
        $this->createRelatedMemberIfNotExists();

        $this->member->country = $value;
    }

    /**
     * If this instance doesn't already have a related Member (either in the db on in the current object), then create one
     */
    protected function createRelatedMemberIfNotExists()
    {
        /** @var UserFrosting\Sprinkle\Core\Util\ClassMapper $classMapper */
        $classMapper = static::$ci->classMapper;

        if (!count($this->member)) {
            $member = $classMapper->createInstance('member', [
                'user_id' => $this->id
            ]);

            $this->setRelation('member', $member);
        }
    }
}

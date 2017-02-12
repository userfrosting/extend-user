<?php
namespace UserFrosting\Sprinkle\ExtendUser\Model;

use Illuminate\Database\Capsule\Manager as Capsule;
use UserFrosting\Sprinkle\Account\Model\User;
use UserFrosting\Sprinkle\ExtendUser\Model\Owler;

trait LinkOwler {
    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function bootLinkOwler()
    {
        /**
         * Create a new Owler if necessary, and save the associated owler every time.
         */
        static::saved(function ($owlerUser) {
            $owlerUser->createRelatedOwlerIfNotExists();

            // When creating a new OwlerUser, it might not have had a `user_id` when the `owler`
            // relationship was created.  So, we should set it on the Owler if it hasn't been set yet.
            if (!$owlerUser->owler->user_id) {
                $owlerUser->owler->user_id = $owlerUser->id;
            }

            $owlerUser->owler->save();
        });
    }
}
    
class OwlerUser extends User {
    use LinkOwler;

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
     * Required to be able to access the `owler` relationship in Twig without needing to do eager loading.
     * @see http://stackoverflow.com/questions/29514081/cannot-access-eloquent-attributes-on-twig/35908957#35908957
     */
    public function __isset($name)
    {
        if (in_array($name, [
            'owler'
        ])) {
            return isset($this->owler);
        } else {
            return parent::__isset($name);
        }
    }

    /**
     * Custom accessor for Owler property
     */
    public function getCityAttribute($value)
    {
        return (count($this->owler) ? $this->owler->city : '');
    }

    /**
     * Custom accessor for Owler property
     */
    public function getCountryAttribute($value)
    {
        return (count($this->owler) ? $this->owler->country : '');
    }

    /**
     * Get the owler associated with this user.
     */
    public function owler()
    {
        return $this->hasOne('\UserFrosting\Sprinkle\ExtendUser\Model\Owler', 'user_id');
    }

    /**
     * Custom mutator for Owler property
     */
    public function setCityAttribute($value)
    {
        $this->createRelatedOwlerIfNotExists();

        $this->owler->city = $value;
    }

    /**
     * Custom mutator for Owler property
     */
    public function setCountryAttribute($value)
    {
        $this->createRelatedOwlerIfNotExists();

        $this->owler->country = $value;
    }

    /**
     * If this instance doesn't already have a related Owler (either in the db on in the current object), then create one
     */
    protected function createRelatedOwlerIfNotExists()
    {
        if (!count($this->owler)) {
            $owler = new Owler([
                'user_id' => $this->id
            ]);

            $this->setRelation('owler', $owler);
        }
    }
}

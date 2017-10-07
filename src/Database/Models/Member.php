<?php
namespace UserFrosting\Sprinkle\ExtendUser\Database\Models;

use UserFrosting\Sprinkle\Account\Database\Models\User;
use UserFrosting\Sprinkle\ExtendUser\Database\Models\MemberAux;
use UserFrosting\Sprinkle\ExtendUser\Database\Scopes\MemberAuxScope;

trait LinkMemberAux
{
    /**
     * The "booting" method of the trait.
     *
     * @return void
     */
    protected static function bootLinkMemberAux()
    {
        /**
         * Create a new MemberAux if necessary, and save the associated member data every time.
         */
        static::saved(function ($member) {
            $member->createAuxIfNotExists();

            if ($member->auxType) {
                // Set the aux PK, if it hasn't been set yet
                if (!$member->aux->id) {
                    $member->aux->id = $member->id;
                }

                $member->aux->save();
            }
        });
    }
}

class Member extends User
{
    use LinkMemberAux;

    protected $fillable = [
        'user_name',
        'first_name',
        'last_name',
        'email',
        'locale',
        'theme',
        'group_id',
        'flag_verified',
        'flag_enabled',
        'last_activity_id',
        'password',
        'deleted_at',
        'city',
        'country'
    ];

    protected $auxType = 'UserFrosting\Sprinkle\ExtendUser\Database\Models\MemberAux';

    /**
     * Required to be able to access the `aux` relationship in Twig without needing to do eager loading.
     * @see http://stackoverflow.com/questions/29514081/cannot-access-eloquent-attributes-on-twig/35908957#35908957
     */
    public function __isset($name)
    {
        if (in_array($name, [
            'aux'
        ])) {
            return true;
        } else {
            return parent::__isset($name);
        }
    }

    /**
     * Globally joins the `members` table to access additional properties.
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new MemberAuxScope);
    }

    /**
     * Custom mutator for Member property
     */
    public function setCityAttribute($value)
    {
        $this->createAuxIfNotExists();

        $this->aux->city = $value;
    }

    /**
     * Custom mutator for Member property
     */
    public function setCountryAttribute($value)
    {
        $this->createAuxIfNotExists();

        $this->aux->country = $value;
    }

    /**
     * Relationship for interacting with aux model (`members` table).
     */
    public function aux()
    {
        return $this->hasOne($this->auxType, 'id');
    }

    /**
     * If this instance doesn't already have a related aux model (either in the db on in the current object), then create one
     */
    protected function createAuxIfNotExists()
    {
        if ($this->auxType && !count($this->aux)) {
            // Create aux model and set primary key to be the same as the main user's
            $aux = new $this->auxType;

            // Needed to immediately hydrate the relation.  It will actually get saved in the bootLinkMemberAux method.
            $this->setRelation('aux', $aux);
        }
    }
}

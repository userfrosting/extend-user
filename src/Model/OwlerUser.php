<?php
namespace UserFrosting\Sprinkle\ExtendUser\Model;

use UserFrosting\Sprinkle\Account\Model\User;
use UserFrosting\Sprinkle\ExtendUser\Model\Owler;

class OwlerUser extends User {

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
     * Extends the model save() method to also save the related Owler object.
     */
    public function save(array $options = array())
    {
        $this->createRelatedOwlerIfNotExists();

        $this->owler->save();

        return parent::save($options);
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

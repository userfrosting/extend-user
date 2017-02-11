<?php
namespace UserFrosting\Sprinkle\Site\Model;

use UserFrosting\Sprinkle\Account\Model\User;

class OwlerUser extends User {

    public function __isset($name)
    {
        if (in_array($name, [
            'owler'
        ])) {
            return true;
        } else {
            return parent::__isset($name);
        }
    }

    public function getCityAttribute($value)
    {
        return $this->owler->city;
    }

    public function getCountryAttribute($value)
    {
        return $this->owler->country;
    }

    /**
     * Get the owler associated with this user.
     */
    public function owler()
    {
        return $this->hasOne('\UserFrosting\Sprinkle\Site\Model\Owler', 'user_id');
    }

    public function save(array $options = array())
    {
        $this->owler->save();
        return parent::save($options);
    }

    public function setCityAttribute($value)
    {
        $this->owler->city = $value;
    }

    public function setCountryAttribute($value)
    {
        $this->owler->country = $value;
    }
}

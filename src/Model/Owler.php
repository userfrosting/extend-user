<?php
namespace UserFrosting\Sprinkle\Site\Model;

use UserFrosting\Sprinkle\Core\Model\UFModel;

class Owler extends UFModel {

    public $timestamps = true;

    /**
     * @var string The name of the table for the current model.
     */
    protected $table = "owlers";

    protected $fillable = [
        "user_id",
        "city",
        "country"
    ];

    /**
     * Directly joins the related user, so we can do things like sort, search, paginate, etc.
     */
    public function scopeJoinUser($query)
    {
        $query = $query->select('owlers.*');

        $query = $query->leftJoin('users', 'owlers.user_id', '=', 'users.id');

        return $query;
    }

    /**
     * Get the user associated with this owler.
     */
    public function user()
    {
        /** @var UserFrosting\Sprinkle\Core\Util\ClassMapper $classMapper */
        $classMapper = static::$ci->classMapper;

        return $this->belongsTo($classMapper->getClassMapping('user'), 'user_id');
    }
}

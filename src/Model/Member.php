<?php
namespace UserFrosting\Sprinkle\ExtendUser\Model;

use UserFrosting\Sprinkle\Core\Model\UFModel;

class Member extends UFModel {

    public $timestamps = true;

    /**
     * @var string The name of the table for the current model.
     */
    protected $table = "members";

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
        /** @var UserFrosting\Sprinkle\Core\Util\ClassMapper $classMapper */
        $classMapper = static::$ci->classMapper;
        $membersTable = $classMapper->createInstance('member')->getTable();
        $usersTable = $classMapper->createInstance('user')->getTable();

        $query = $query->select("$membersTable.*");

        $query = $query->leftJoin($usersTable, "$membersTable.user_id", '=', "$usersTable.id");

        return $query;
    }

    /**
     * Get the user associated with this member.
     */
    public function user()
    {
        /** @var UserFrosting\Sprinkle\Core\Util\ClassMapper $classMapper */
        $classMapper = static::$ci->classMapper;

        return $this->belongsTo($classMapper->getClassMapping('user'), 'user_id');
    }
}

<?php

namespace UserFrosting\Sprinkle\ExtendUser\Database\Scopes;

use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class MemberAuxScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return void
     */
    public function apply(Builder $builder, Model $model)
    {
        $baseTable = $model->getTable();
        // Hardcode the table name here, or you can access it using the classMapper and `getTable`
        $auxTable = 'members';

        // Specify columns to load from base table and aux table
        $builder->addSelect(
            "$baseTable.*",
            "$auxTable.city as city",
            "$auxTable.country as country"
        );

        // Join on matching `member` records
        $builder->leftJoin($auxTable, function ($join) use ($baseTable, $auxTable) {
            $join->on("$auxTable.id", '=', "$baseTable.id");
        });
    }
}

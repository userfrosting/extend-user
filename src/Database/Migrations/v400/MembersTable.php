<?php
namespace UserFrosting\Sprinkle\ExtendUser\Database\Migrations\v400;

use UserFrosting\System\Bakery\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Schema\Builder;

class MembersTable extends Migration
{
    public $dependencies = [
        '\UserFrosting\Sprinkle\Account\Database\Migrations\v400\UsersTable'
    ];

    public function up()
    {
        if (!$this->schema->hasTable('members')) {
            $this->schema->create('members', function (Blueprint $table) {
                $table->increments('id');
                $table->string('city', 255)->nullable();
                $table->string('country', 255)->nullable();

                $table->engine = 'InnoDB';
                $table->collation = 'utf8_unicode_ci';
                $table->charset = 'utf8';
                $table->foreign('id')->references('id')->on('users');
            });
        }
    }

    public function down()
    {
        $this->schema->drop('members');
    }
}

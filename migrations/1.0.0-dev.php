<?php
    use Illuminate\Database\Capsule\Manager as Capsule;
    use Illuminate\Database\Schema\Blueprint;
    /**
     * Owler table
     */
    if (!$schema->hasTable('owlers')) {
        $schema->create('owlers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned()->unique();
            $table->string('city', 255)->nullable();
            $table->string('country', 255)->nullable();
            $table->timestamps();

            $table->engine = 'InnoDB';
            $table->collation = 'utf8_unicode_ci';
            $table->charset = 'utf8';
            $table->foreign('user_id')->references('id')->on('users');
            $table->index('user_id');
        });
        echo "Created table 'owlers'..." . PHP_EOL;
    } else {
        echo "Table 'owlers' already exists.  Skipping..." . PHP_EOL;
    }
    
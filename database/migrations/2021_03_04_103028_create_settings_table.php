<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \Illuminate\Support\Facades\Schema::create('settings', function ($table) {
            $table->id();
            $table->string('key')->index()->unique();
            $table->text('value');
        });

        \Illuminate\Support\Facades\DB::table('settings')->insert([
            ['key' => 'repository_name', 'value' => ''],
            ['key' => 'author', 'value' => ''],
            ['key' => 'email', 'value' => ''],
            ['key' => 'active', 'value' => false],
            ['key' => 'company', 'value' => ''],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('settings');
    }
}

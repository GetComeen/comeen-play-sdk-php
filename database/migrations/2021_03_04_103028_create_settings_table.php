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
            ['key' => 'repository_name', 'value' => 'DynamicScreen App Server'],
            ['key' => 'author', 'value' => 'DynamicScreen'],
            ['key' => 'email', 'value' => 'bonjour@dynamicscreen.com'],
            ['key' => 'active', 'value' => true],
            ['key' => 'company', 'value' => 'DynamicScreen'],
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

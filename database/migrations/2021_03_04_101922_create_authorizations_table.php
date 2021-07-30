<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAuthorizationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('authorizations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('token')->nullable();
            $table->string('channel');
            $table->boolean('active')->default(true);
            $table->timestamps();
        });

        \Illuminate\Support\Facades\DB::table('authorizations')->insert([
            [
                'name' => 'Public',
                'token' => null,
                'channel' => 'stable',
            ],
            [
                'name' => 'Public',
                'token' => null,
                'channel' => 'rc',
            ],
            [
                'name' => 'Public',
                'token' => null,
                'channel' => 'beta',
            ],
            [
                'name' => 'Public',
                'token' => null,
                'channel' => 'alpha',
            ],
        ])->withTimestamps();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('authorizations');
    }
}

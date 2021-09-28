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
            $table->string('api_token')->nullable();
            $table->string('channel');
            $table->boolean('active')->default(true);
            $table->timestamps();
        });

        \Illuminate\Support\Facades\DB::table('authorizations')->insert([
            [
                'name' => 'Public',
                'api_token' => null,
                'channel' => 'stable',
            ],
            [
                'name' => 'Public',
                'api_token' => null,
                'channel' => 'rc',
            ],
            [
                'name' => 'Public',
                'api_token' => null,
                'channel' => 'beta',
            ],
            [
                'name' => 'Public',
                'api_token' => null,
                'channel' => 'alpha',
            ],
        ]);
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

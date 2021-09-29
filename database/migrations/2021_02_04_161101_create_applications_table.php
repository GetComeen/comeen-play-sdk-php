<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('applications', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description');
            $table->string('version');
            $table->string('identifier');
            $table->string('channel');
            $table->string('api_level');
            $table->string('logo')->default('fa fa-info-circle');
            $table->string('type');
            $table->string('import_type');
            $table->json('options');
            $table->boolean('auto_sync')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('applications');
    }
}

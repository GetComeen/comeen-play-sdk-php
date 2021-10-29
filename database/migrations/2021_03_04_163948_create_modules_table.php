<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateModulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('modules', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('type');
            $table->string('description');
            $table->string('logo')->default('fa fa-info-circle');
            $table->string('color')->default('#24A900');
            $table->string('identifier');
            $table->foreignId('application_id')
                ->constrained('applications')
                ->onDelete('cascade');
            $table->json('config');
            $table->json('options');
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
        Schema::dropIfExists('modules');
    }
}

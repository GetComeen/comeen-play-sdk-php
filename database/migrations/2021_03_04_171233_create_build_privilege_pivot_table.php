<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBuildPrivilegePivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('build_privilege', function (Blueprint $table) {
            $table->foreignId('build_id')->constrained('builds')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreignId('privilege_id')->constrained('privileges')
                ->onDelete('cascade')
                ->onUpdate('cascade');
//            $table->primary(['build_id', 'privilege_id']);
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
        Schema::dropIfExists('build_privilege');
    }
}

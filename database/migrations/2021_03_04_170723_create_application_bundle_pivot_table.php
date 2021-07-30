<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApplicationBundlePivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('application_bundle', function (Blueprint $table) {
            $table->foreignId('application_id')->constrained('applications')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreignId('bundle_id')->constrained('bundles')
                ->onDelete('cascade')
                ->onUpdate('cascade');
//            $table->primary(['application_id', 'bundle_id']);
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
        Schema::dropIfExists('application_bundle');
    }
}

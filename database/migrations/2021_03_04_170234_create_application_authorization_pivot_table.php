<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApplicationAuthorizationPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('application_authorization', function (Blueprint $table) {
            $table->foreignId('application_id')->constrained('applications')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreignId('authorization_id')->constrained('authorizations')
                ->onDelete('cascade')
                ->onUpdate('cascade');
//            $table->primary(['application_id', 'authorization_id']);
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
        Schema::dropIfExists('application_authorization');
    }
}

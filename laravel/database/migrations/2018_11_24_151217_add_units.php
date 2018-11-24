<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUnits extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('units', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code')->unique();
            $table->string('name');
            $table->string('short_name');
            $table->timestamps();
        });
        
        Schema::create('application_units', function (Blueprint $table) {
            $table->unsignedInteger('application_id');
            $table->unsignedInteger('unit_id');
            $table->timestamps();

            $table->primary(['application_id', 'unit_id']);

           $table->foreign('application_id')->references('id')->on('applications')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreign('unit_id')->references('id')->on('units')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('units');
        Schema::dropIfExists('application_units');
    }
}

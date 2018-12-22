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
        Schema::create('unit_areas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->unsignedInteger('sort_order')->nullable();
            $table->timestamps();
        });

        Schema::create('unit_types', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code')->unique();
            $table->string('name');
            $table->unsignedInteger('sort_order')->nullable();
            $table->timestamps();
        });

        Schema::create('units', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code')->unique();
            $table->string('name');
            $table->string('short_name');
            $table->unsignedInteger('area_id');
            $table->unsignedInteger('type_id');
            $table->timestamps();


            $table->foreign('area_id')->references('id')->on('unit_areas')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreign('type_id')->references('id')->on('unit_types')
                ->onUpdate('cascade')
                ->onDelete('cascade');
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
        Schema::dropIfExists('unit_areas');
        Schema::dropIfExists('unit_types');
        Schema::dropIfExists('application_units');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PeakPeriods extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('application_periods', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('application_id');
            
            $table->unsignedInteger('start_month')->nullable();
            $table->unsignedInteger('start_day')->nullable();
            $table->unsignedInteger('end_month')->nullable();
            $table->unsignedInteger('end_day')->nullable();

            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();

            $table->foreign('application_id')->references('id')->on('applications')
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
        Schema::dropIfExists('application_periods');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApplicationFeaturesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('application_features', function (Blueprint $table) {
            $table->unsignedInteger('application_id');
            $table->unsignedInteger('feature_id');
            $table->timestamps();

            $table->primary(['application_id', 'feature_id']);

            $table->foreign('application_id')->references('id')->on('applications')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreign('feature_id')->references('id')->on('features')
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
        Schema::dropIfExists('application_features');
    }
}

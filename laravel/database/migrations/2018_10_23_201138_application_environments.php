<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ApplicationEnvironments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('application_environments', function (Blueprint $table) {
            $table->unsignedInteger('application_id');
            $table->unsignedInteger('environment_id');
            $table->string('url')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();

            $table->primary(['application_id', 'environment_id']);

           $table->foreign('application_id')->references('id')->on('applications')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreign('environment_id')->references('id')->on('environments')
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
        Schema::dropIfExists('application_environments');
    }
}

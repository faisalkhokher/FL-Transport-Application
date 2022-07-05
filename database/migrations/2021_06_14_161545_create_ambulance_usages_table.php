<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAmbulanceUsagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ambulance_usages', function (Blueprint $table) {
            $table->id();
            $table->string('date');
            $table->string('name');
            $table->string('age_of_patient');
            $table->enum('gender' , ['male','female']);
            $table->unsignedBigInteger('village_id');
            $table->string('health_facility');
            $table->time('time_of_departure');
            $table->string('type_of_case');
            $table->unsignedBigInteger('ambulance_id');
            $table->string('deceased');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ambulance_usages');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAmbulancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ambulances', function (Blueprint $table) {
            $table->id();   
            $table->string('name');   
            $table->integer('village_id');   
            $table->integer('workplace_id');   
            $table->integer('sponsor_id');   
            $table->integer('field_id');   
            $table->string('latitude');   
            $table->string('longitude');   
            $table->date('next_repair')->nullable(); ;        
            $table->date('lastest_repair')->nullable();        
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
        Schema::dropIfExists('ambulances');
    }
}

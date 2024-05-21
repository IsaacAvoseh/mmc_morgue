<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCorpsesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('corpses', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('place_of_death')->nullable();
            $table->string('sex')->nullable();
            $table->string('age')->nullable();
            $table->string('address')->nullable();
            $table->string('date_of_death')->nullable();
            $table->string('time_of_death')->nullable();
            $table->string('date_received')->nullable();
            $table->string('time_received')->nullable();
            $table->string('family_rep1_address')->nullable();
            $table->string('family_rep1_name')->nullable();
            $table->string('family_rep1_phone')->nullable();
            $table->string('family_rep1_rel')->nullable();
            $table->string('family_rep2_address')->nullable();
            $table->string('family_rep2_name')->nullable();
            $table->string('family_rep2_phone')->nullable();
            $table->string('family_rep2_rel')->nullable();
            $table->string('death_cert')->nullable();
            $table->string('items_collected_by')->nullable();
            $table->string('items_collected_phone')->nullable();
            $table->string('no_of_days')->nullable();
            $table->foreignId('user_id')->constrained();
            $table->string('status')->default('admitted');
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
        Schema::dropIfExists('corpses');
    }
}

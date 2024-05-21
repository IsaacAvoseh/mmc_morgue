<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReleasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('releases', function (Blueprint $table) {
            $table->id();
            $table->foreignId('corpse_id')->constrained();
            $table->string('date_discharged');
            $table->string('collector');
            $table->string('relationship')->nullable();
            $table->string('collector_address')->nullable();
            $table->string('collector_phone')->nullable();
            $table->string('interment_address')->nullable();
            $table->string('interment_lga')->nullable();
            $table->string('driver_name')->nullable();
            $table->string('vehicle_number')->nullable();
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
        Schema::dropIfExists('releases');
    }
}

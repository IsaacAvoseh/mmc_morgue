<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReferralDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('referral_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('referral_id')->constrained();
            $table->foreignId('corpse_id')->constrained();
            $table->string('status')->nullable();
            $table->foreignId('user_id')->constrained();
            $table->decimal('amount', 14, 2)->nullable();
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
        Schema::dropIfExists('referral_details');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAnotherTwoColumnsToCorpsesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('corpses', function (Blueprint $table) {
            $table->string('date_from')->after('amount')->nullable();
            $table->string('date_to')->after('date_from')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('corpses', function (Blueprint $table) {
            //
        });
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTwoColumnaToCorpsesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('corpses', function (Blueprint $table) {
            $table->string('paid')->default('no')->after('status');
            $table->decimal('amount', 14, 2)->after('paid');
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

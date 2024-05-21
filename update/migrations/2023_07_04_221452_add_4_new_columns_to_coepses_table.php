<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Add4NewColumnsToCoepsesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('corpses', function (Blueprint $table) {
            $table->decimal('amount_paid', 14, 2)->nullable()->after('amount');
            $table->decimal('discount', 14, 2)->nullable()->after('amount_paid');
            $table->string('desc')->nullable()->after('discount');
            $table->decimal('affixed_bill',14,2)->nullable()->after('desc');
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

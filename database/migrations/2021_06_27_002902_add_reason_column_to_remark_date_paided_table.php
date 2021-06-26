<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddReasonColumnToRemarkDatePaidedTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('remark_date_paided', function (Blueprint $table) {
            $table->mediumText('reason')->nullable()->default(null);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('remark_date_paided', function (Blueprint $table) {
            $table->dropColumn('reason');
        });
    }
}

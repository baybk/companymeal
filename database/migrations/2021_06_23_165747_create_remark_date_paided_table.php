<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRemarkDatePaidedTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('remark_date_paided', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('team_id');
            $table->date('date_remark')->comment('Day paided');
            $table->integer('order_number')->comment('The number of pepples order in that day');
            $table->text('user_list_paid')->nullable()->default(null);
            $table->mediumText('reason')->nullable()->default(null);

            $table->foreign('team_id')->references('id')->on('teams')->onDelete('CASCADE');

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
        Schema::dropIfExists('remark_date_paided');
    }
}

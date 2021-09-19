<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('team_id');
            $table->string('customer_name');
            $table->string('customer_phone');
            $table->string('customer_email')->nullable()->default(null);
            $table->string('customer_address');
            $table->string('payment_status')->comment('enum: WAITING, PAID');
            $table->string('delivery_status')->comment('enum: REQUEST, CONFIRMED, DELIVERING, DELIVERED, CANCELED');
            $table->json('lines')->comment('list products ordered');
            $table->text('general_note')->nullable()->default(null);
            $table->text('admin_change_history')->nullable()->default(null);

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
        Schema::dropIfExists('orders');
    }
}

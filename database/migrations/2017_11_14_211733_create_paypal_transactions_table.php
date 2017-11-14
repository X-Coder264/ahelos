<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaypalTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('paypal_transactions', function (Blueprint $table) {
            $table->string('transaction_id');
            $table->primary('transaction_id');
            $table->unsignedInteger('payer_user_id');
            $table->string('payer_first_name');
            $table->string('payer_last_name');
            $table->string('payer_email');
            $table->dateTime('transaction_time');
            $table->string('transaction_amount');
            $table->enum('transaction_currency', ['EUR', 'USD'])->default('EUR');
            $table->foreign('payer_user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('paypal_transactions');
    }
}

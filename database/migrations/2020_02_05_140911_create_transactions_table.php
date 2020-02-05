<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('fk_currency');
            $table->foreign('fk_currency')->references('id')->on('currencies');
            $table->unsignedBigInteger('fk_user');
            $table->foreign('fk_user')->references('id')->on('users');
            $table->unsignedDecimal('amount')->default(0);
            $table->unsignedDecimal('quantity');
            $table->unsignedDecimal('purchase_price');
            $table->timestamp('purchase_date');
            $table->boolean('sold');
            $table->unsignedDecimal('selling_amount')->nullable();
            $table->timestamp('selling_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
}

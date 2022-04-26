<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComandaPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comanda_payments', function (Blueprint $table) {
            $table->id();
            $table->integer('client_id');
            $table->integer('comanda_id');
            $table->string('order_id')->nullable();
            $table->string('payment_method');
            $table->text('url_qr')->nullable();
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
        Schema::dropIfExists('comanda_payments');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComandasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comandas', function (Blueprint $table) {
            $table->id();
            $table->integer('client_id');
            $table->integer('waiter_id')->nullable();
            $table->integer('waiter_status')->default(0)->nullable();
            $table->string('table_code');
            $table->float('total_value')->nullable();
            $table->integer('replace')->default(1)->nullable();
            $table->string('payment_method')->nullable();
            $table->string('installments')->nullable();
            $table->string('troco')->nullable();
            $table->integer('status')->default(1)->nullable();
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
        Schema::dropIfExists('comandas');
    }
}

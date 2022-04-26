<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug');
            $table->string('resume')->nullable();
            $table->string('provider')->nullable();
            $table->string('provphone')->nullable();
            $table->string('provname')->nullable();
            $table->string('buyprice')->nullable();
            $table->string('sellprice');
            $table->string('bitterness')->nullable();
            $table->string('temperature')->nullable();
            $table->string('ibv')->nullable();
            $table->string('type')->nullable();
            $table->string('image')->nullable();
            $table->string('categoria')->nullable();
            $table->text('description')->nullable();
            $table->integer('spotlight')->nullable();
            $table->integer('status')->default(1);
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
        Schema::dropIfExists('products');
    }
}

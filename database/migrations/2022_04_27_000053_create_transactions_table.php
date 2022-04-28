<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();

            $table->uuid('uuid')->unique();

            $table->unsignedBigInteger('order_id');

            $table->enum('status', ['CREATED', 'PAYED', 'REJECTED', 'PENDING', 'EXPIRED', 'APPROVED', 'REFUNDED']);

            $table->string('reference')->nullable();
            $table->string('url')->nullable();
            $table->string('gateway')->nullable();
            $table->string('requestId')->nullable();

            $table->index('order_id');
            $table->foreign('order_id')->references('id')->on('orders')->onUpdate('cascade')->onDelete('cascade');

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
        Schema::dropIfExists('transactions');
    }
};

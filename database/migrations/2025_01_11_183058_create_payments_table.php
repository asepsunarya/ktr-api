<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ktr_request_id');
            $table->integer('total_cost');
            $table->string('payment_id');
            $table->string('status');
            $table->timestamps();

            $table->foreign('ktr_request_id')->references('id')->on('ktr_requests')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('payments');
    }
}

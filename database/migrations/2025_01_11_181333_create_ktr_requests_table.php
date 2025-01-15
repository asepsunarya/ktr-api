<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKtrRequestsTable extends Migration
{
    public function up()
    {
        Schema::create('ktr_requests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('job');
            $table->string('address');
            $table->string('act_as');
            $table->string('road');
            $table->string('subdistrict_id');
            $table->string('district_id');
            $table->string('regency_id');
            $table->string('land_area');
            $table->string('land_status');
            $table->string('purpose');
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->string('ktp_file');
            $table->string('land_document');
            $table->string('activity_location');
            $table->text('sign')->nullable();
            $table->string('status')->default('pending');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('ktr_requests');
    }
}

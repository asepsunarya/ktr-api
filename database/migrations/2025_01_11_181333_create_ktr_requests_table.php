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
            $table->string('user_id');
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
            $table->string('latitude');
            $table->string('longitude');
            $table->string('ktp_file');
            $table->string('land_document');
            $table->string('activity_location');
            $table->string('sign');
            $table->string('status')->default('pending');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('ktr_requests');
    }
}

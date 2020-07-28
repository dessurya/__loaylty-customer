<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer', function (Blueprint $table) {
            $table->id();
            $table->string('code')->nullable();
            $table->string('username')->unique();
            $table->string('name');
            $table->text('alamat');
            $table->string('no_hp');
            $table->string('no_rekening');
            $table->string('atas_nama_rekening');
            $table->bigInteger('website_id')->nullable()->unsigned();
            $table->string('website')->nullable();
            $table->bigInteger('bank_id')->nullable()->unsigned();
            $table->string('bank')->nullable();
            $table->bigInteger('tier_id')->nullable()->unsigned();
            $table->string('tier')->nullable();
            $table->timestamps();
        });

        Schema::table('customer', function($table) {
            $table->foreign('website_id')->references('id')->on('master_website')->onDelete('set null');
            $table->foreign('bank_id')->references('id')->on('master_bank')->onDelete('set null');
            $table->foreign('tier_id')->references('id')->on('master_tier')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customer');
    }
}

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
        Schema::create('staking_results', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('staking_id')->unsigned();
            $table->double('amount');
            $table->text('transaction_id');
            $table->timestamps();
        });
        Schema::table('staking_results', function (Blueprint $table) {
            $table->foreign('staking_id')->references('id')->on('stakings')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('staking_results');
    }
};

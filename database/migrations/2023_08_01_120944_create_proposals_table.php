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
        Schema::create('proposals', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('dao_id')->unsigned();
            $table->text('title');
            $table->text('about');
            $table->date('start_date');
            $table->date('end_date');
            $table->timestamps();
        });
        Schema::table('proposals', function (Blueprint $table) {
            $table->foreign('dao_id')->references('id')->on('daos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('proposals');
    }
};

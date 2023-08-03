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
        Schema::create('daos', function (Blueprint $table) {
            $table->id();
            $table->string('project');
            $table->string('asset');
            $table->string('logo');
            $table->json('accounts');
            $table->text('description');
            $table->string('domain');
            $table->bigInteger('holders');
            $table->json('approved_wallets');
            $table->bigInteger('required_tokens');
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
        Schema::dropIfExists('daos');
    }
};

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
        Schema::create('maintasks', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                  ->constrained('users')
                  ->onDelete('cascade');

            $table->string('title')->nullable();
            $table->string('priority_rank')->nullable();
            $table->string('purpose')->nullable();
            $table->string('status')->nullable();
            $table->dateTime('start_at')->nullable();
            $table->dateTime('finish_at')->nullable();
            $table->text('comment')->nullable();
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
        Schema::dropIfExists('maintasks');
    }
};

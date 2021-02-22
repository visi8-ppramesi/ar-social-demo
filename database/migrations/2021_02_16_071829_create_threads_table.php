<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateThreadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('threads', function (Blueprint $table) {
            $table->id();
            $table->text('message');
            $table->foreignId('user_id');
            // $table->foreign('user_id')->references('id')->on('users');
            $table->foreignId('group_id')->default(1);
            // $table->foreign('group_id')->references('id')->on('groups');
            $table->text('image')->nullable();
            $table->integer('likes')->default(0);
            $table->boolean('pinned')->default(0);
            $table->boolean('sidebar')->default(0);

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
        Schema::dropIfExists('threads');
    }
}

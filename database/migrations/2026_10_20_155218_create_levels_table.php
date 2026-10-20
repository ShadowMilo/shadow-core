<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('levels', function (Blueprint $table) {
            $table->integer('levelID', true);
            $table->text('name');
            $table->text('description');
            $table->text('username');
            $table->integer('userID');
            $table->text('udid');
            $table->string('ipHash', 64)->nullable();
            $table->integer('likes')->default(0);
            $table->integer('downloads')->default(0);
            $table->integer('gameVersion')->default(0);
            $table->integer('version')->default(0);
            $table->integer('timestamp')->default(0);
            $table->integer('length')->default(0);
            $table->integer('diff')->default(0);
            $table->integer('stars')->default(0);
            $table->integer('featureType')->default(0);
            $table->integer('featureScore')->default(0);
            $table->integer('song')->default(0);
            $table->integer('trendingScore')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('levels');
    }
};

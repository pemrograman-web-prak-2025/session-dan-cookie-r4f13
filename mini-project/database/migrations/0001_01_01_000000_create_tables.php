<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('leaders', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('password');
            $table->timestamps();
            $table->string('remember_token', 100)->nullable();
        });

        Schema::create('units', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('leader_id')->nullable();
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->text('description')->nullable();
            $table->text('location')->nullable();
            $table->text('image_url')->nullable();
            $table->timestamps();

            $table->foreign('leader_id')
                  ->references('id')
                  ->on('leaders')
                  ->nullOnDelete();

            $table->foreign('parent_id')
                  ->references('id')
                  ->on('units')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('units');
        Schema::dropIfExists('leaders');
    }
};

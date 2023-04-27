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
        Schema::create('exercises', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->integer('level');
            $table->text('muscle_groups');
            $table->string('video_url');
            $table->timestamps();
        });

        Schema::create('exercise_routine', function (Blueprint $table) {
            $table->id();
            $table->foreignId('exercise_id')->constrained()->onDelete('cascade');
            $table->foreignId('routine_id')->constrained()->onDelete('cascade');
            $table->integer('sets');
            $table->integer('repetitions');
            $table->integer('rest_time');
            $table->string('tips');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exercise_routine');
        Schema::dropIfExists('exercises');
    }
};

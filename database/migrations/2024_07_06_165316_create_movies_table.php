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
        Schema::create('movies', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('eid')->unique();
            $table->string('title');
            $table->text('description');
            $table->string('poster')->nullable();
            $table->string('banner')->nullable();
            $table->date('release_date');
            $table->decimal('vote', 8, 2);
            $table->bigInteger('vote_count');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movies');
    }
};

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
        Schema::create('archives_processed', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->string('archive_name');
            $table->char('archive_hash', 64);
            $table->string('archive_path', 255)->unique();
            $table->integer('archive_size_bytes');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('archives_processed');
    }
};

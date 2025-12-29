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
        if (!Schema::hasTable('biografis')) {
            Schema::create('biografis', function (Blueprint $table) {
                $table->id();
                $table->string('title');
                $table->string('slug')->unique();
                $table->text('description')->nullable();
                $table->longText('content');
                $table->foreignId('category_id')->nullable()->constrained('categories')->onDelete('set null');
                $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
                $table->enum('status', ['draft', 'published'])->default('draft');
                $table->string('image_path')->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('biografis');
    }
};

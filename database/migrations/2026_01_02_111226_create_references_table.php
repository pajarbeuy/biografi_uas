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
        Schema::create('references', function (Blueprint $table) {
            $table->id();
            $table->foreignId('biografi_id')->constrained('biografis')->onDelete('cascade');
            $table->string('title'); // Title of the reference
            $table->string('author')->nullable(); // Author(s)
            $table->string('year', 4)->nullable(); // Publication year
            $table->string('url')->nullable(); // URL to the reference
            $table->enum('type', ['book', 'paper', 'article', 'website', 'other'])->default('website');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('references');
    }
};

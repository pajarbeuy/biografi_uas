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
        Schema::table('biografis', function (Blueprint $table) {
            // Add slug column if it doesn't exist
            if (!Schema::hasColumn('biografis', 'slug')) {
                $table->string('slug')->unique()->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('biografis', function (Blueprint $table) {
            if (Schema::hasColumn('biografis', 'slug')) {
                $table->dropColumn('slug');
            }
        });
    }
};

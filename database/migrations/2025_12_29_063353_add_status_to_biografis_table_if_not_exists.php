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
            if (!Schema::hasColumn('biografis', 'status')) {
                $table->enum('status', ['draft', 'published'])->default('draft')->after('user_id');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('biografis', function (Blueprint $table) {
            if (Schema::hasColumn('biografis', 'status')) {
                $table->dropColumn('status');
            }
        });
    }
};

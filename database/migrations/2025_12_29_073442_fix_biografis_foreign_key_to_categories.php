<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Drop the old foreign key constraint that references 'kategoris'
        Schema::table('biografis', function (Blueprint $table) {
            // Check if the foreign key exists first
            $foreignKeys = DB::select("
                SELECT CONSTRAINT_NAME 
                FROM information_schema.KEY_COLUMN_USAGE 
                WHERE TABLE_SCHEMA = DATABASE() 
                AND TABLE_NAME = 'biografis' 
                AND COLUMN_NAME = 'category_id'
                AND REFERENCED_TABLE_NAME IS NOT NULL
            ");
            
            foreach ($foreignKeys as $fk) {
                $table->dropForeign($fk->CONSTRAINT_NAME);
            }
        });

        // Make category_id nullable
        Schema::table('biografis', function (Blueprint $table) {
            $table->unsignedBigInteger('category_id')->nullable()->change();
        });

        // Add the correct foreign key constraint to 'categories'
        Schema::table('biografis', function (Blueprint $table) {
            $table->foreign('category_id')
                ->references('id')
                ->on('categories')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('biografis', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
        });
    }
};

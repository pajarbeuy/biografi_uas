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
        // Update the enum to include new status values
        DB::statement("ALTER TABLE biografis MODIFY COLUMN status ENUM('draft', 'pending', 'approved', 'rejected', 'published') DEFAULT 'draft'");
        
        // Migrate existing data: draft stays draft, published becomes approved
        DB::table('biografis')->where('status', 'published')->update(['status' => 'approved']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert approved back to published
        DB::table('biografis')->where('status', 'approved')->update(['status' => 'published']);
        
        // Remove rejected and pending entries or convert them
        DB::table('biografis')->whereIn('status', ['rejected', 'pending'])->update(['status' => 'draft']);
        
        // Revert enum to original
        DB::statement("ALTER TABLE biografis MODIFY COLUMN status ENUM('draft', 'published') DEFAULT 'draft'");
    }
};

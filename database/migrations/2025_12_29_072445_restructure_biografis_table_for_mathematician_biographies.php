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
            // Rename Indonesian columns to English
            if (Schema::hasColumn('biografis', 'judul')) {
                $table->renameColumn('judul', 'name');
            }
            if (Schema::hasColumn('biografis', 'isi')) {
                $table->renameColumn('isi', 'life_story');
            }
            if (Schema::hasColumn('biografis', 'kategori_id')) {
                $table->renameColumn('kategori_id', 'category_id');
            }
            
            // Drop published column (we use status instead)
            if (Schema::hasColumn('biografis', 'published')) {
                $table->dropColumn('published');
            }
        });
        
        // Add new biography-specific columns
        Schema::table('biografis', function (Blueprint $table) {
            if (!Schema::hasColumn('biografis', 'birth_place')) {
                $table->string('birth_place')->nullable()->after('name');
            }
            if (!Schema::hasColumn('biografis', 'birth_date')) {
                $table->date('birth_date')->nullable()->after('birth_place');
            }
            if (!Schema::hasColumn('biografis', 'death_date')) {
                $table->date('death_date')->nullable()->after('birth_date');
            }
            if (!Schema::hasColumn('biografis', 'achievements')) {
                $table->text('achievements')->nullable()->after('death_date');
            }
            if (!Schema::hasColumn('biografis', 'image_path')) {
                $table->string('image_path')->nullable()->after('life_story');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('biografis', function (Blueprint $table) {
            // Revert column additions
            if (Schema::hasColumn('biografis', 'birth_place')) {
                $table->dropColumn('birth_place');
            }
            if (Schema::hasColumn('biografis', 'birth_date')) {
                $table->dropColumn('birth_date');
            }
            if (Schema::hasColumn('biografis', 'death_date')) {
                $table->dropColumn('death_date');
            }
            if (Schema::hasColumn('biografis', 'achievements')) {
                $table->dropColumn('achievements');
            }
            if (Schema::hasColumn('biografis', 'image_path')) {
                $table->dropColumn('image_path');
            }
        });
        
        Schema::table('biografis', function (Blueprint $table) {
            // Revert renames
            if (Schema::hasColumn('biografis', 'name')) {
                $table->renameColumn('name', 'judul');
            }
            if (Schema::hasColumn('biografis', 'life_story')) {
                $table->renameColumn('life_story', 'isi');
            }
            if (Schema::hasColumn('biografis', 'category_id')) {
                $table->renameColumn('category_id', 'kategori_id');
            }
            
            // Add back published column
            if (!Schema::hasColumn('biografis', 'published')) {
                $table->boolean('published')->default(false);
            }
        });
    }
};

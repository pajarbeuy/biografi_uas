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
        Schema::create('biography_views', function (Blueprint $table) {
            $table->id();
            $table->foreignId('biografi_id')->constrained('biografis')->onDelete('cascade');
            $table->string('ip_address', 45)->nullable(); // IPv4 or IPv6
            $table->text('user_agent')->nullable();
            $table->timestamp('viewed_at');
            $table->index(['biografi_id', 'viewed_at']); // For efficient querying
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('biography_views');
    }
};

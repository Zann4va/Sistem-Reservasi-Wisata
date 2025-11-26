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
        Schema::create('status_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('reservation_id')->constrained()->cascadeOnDelete();
            $table->enum('old_status', ['pending', 'confirmed', 'cancelled'])->nullable();
            $table->enum('new_status', ['pending', 'confirmed', 'cancelled']);
            $table->string('reason')->nullable(); // Alasan perubahan (khusus cancel)
            $table->string('changed_by')->nullable(); // Admin yang ubah
            $table->text('notes')->nullable(); // Catatan tambahan
            $table->timestamps();
            
            // Index untuk performa query
            $table->index('reservation_id');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('status_histories');
    }
};

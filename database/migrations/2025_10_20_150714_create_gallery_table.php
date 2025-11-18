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
        Schema::create('gallery', function (Blueprint $table) {
            $table->id('gallery_id'); // PK
            $table->string('title', 150);
            $table->text('description')->nullable();
            $table->string('image_url');
            $table->string('file_format', 10);
            $table->enum('status', [
                'not_sold', // tidak dibuat untuk dijual
                'available', // tersedia untuk diadopsi
                'reserved', // sudah ada yang memesan
                'sold', // sudah terjual
                'archived' // diarsipkan, tidak ditampilkan di gallery
            ])->default('not_sold');
            $table->float('price')->nullable();
            $table->timestamps();
            $table->softDeletes(); // deleted_at untuk soft delete
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gallery');
    }
};

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
        Schema::create('commission_progress', function (Blueprint $table) {
            $table->id('com_progress_id'); // PK
            $table->unsignedBigInteger('commission_id'); // FK ke commisions.commission_id tanpa constraint
            $table->string('image_link');
            $table->enum('stage', ['sketch', 'sketch_revision', 'coloring',  'coloring_revision', 'final'])->default('sketch');
            $table->text('revision_notes')->nullable();
            $table->timestamps();
            $table->softDeletes(); // deleted_at untuk soft delete
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('commission_progress');
    }
};

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
        Schema::create('commissions', function (Blueprint $table) {
            $table->id('commission_id'); // PK
            $table->unsignedBigInteger('member_id'); // FK ke members.member_id tanpa constraint
            $table->enum('category', ["headshot", 'bustup', 'halfbody', 'fullbody', 'cartoon_bustup', 'cartoon_halfbody', 'cartoon_fullbody']);
            $table->enum("background_type", ["none", "simple", "detailed"]);
            $table->boolean("is_commercial_use")->default(false);
            $table->integer("additional_characters")->default(0);
            $table->text('description');
            $table->text('reference_image')->nullable(); 
            $table->date('deadline')->nullable();
            $table->decimal('price', 12, 2);
            $table->enum('payment_status', ['pending', 'dp', 'paid', 'refunded'])->default('pending');
            $table->enum('progress_status', ['pending', 'accepted', 'declined', 'in_progress_sketch', 'in_progress_coloring', 'review', 'revision', 'completed', 'cancelled'])->default('pending');
            
            // Cancellation fields
            $table->text('cancellation_reason')->nullable();
            $table->enum('cancelled_by', ['artist', 'client', 'system'])->nullable();
            $table->timestamp('cancelled_at')->nullable();
            
            $table->timestamps();
            
            // Timestamp fields for tracking commission lifecycle
            $table->timestamp('started_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamp('fully_paid_at')->nullable();
            
            $table->softDeletes(); // deleted_at untuk soft delete
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('commissions');
    }
};

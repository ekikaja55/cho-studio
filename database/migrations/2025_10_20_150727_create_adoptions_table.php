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
        Schema::create('adoptions', function (Blueprint $table) {
            $table->id('adoption_id'); // PK
            $table->unsignedBigInteger("gallery_id"); // FK ke gallery.gallery_id tanpa constraint
            $table->string('email');
            $table->string('payment_confirmation')->nullable();
            $table->enum('order_status', ['placed', 'shipped', 'delivered', 'canceled'])->default('placed');
            $table->enum('payment_status', ['pending', 'paid', 'processing'])->default('pending');
            $table->timestamps();
            $table->softDeletes(); // deleted_at untuk soft delete
        });

        // Schema::create('adoptions', function (Blueprint $table) {
        //     $table->id('adoption_id'); // PK
        //     $table->unsignedBigInteger('gallery_id'); // FK to gallery - the artwork being adopted/purchased

        //     // Buyer information (guest checkout - no account required)
        //     $table->string('buyer_name'); // Buyer's full name
        //     $table->string('buyer_email'); // Buyer's email for communication and file delivery
        //     $table->string('buyer_phone')->nullable(); // Optional phone number

        //     // Order information
        //     $table->float('price'); // Purchase price (can differ from gallery price if there's a discount)
        //     $table->text(column: 'buyer_message')->nullable(); // Optional message from buyer to artist
        //     $table->text('delivery_notes')->nullable(); // Artist notes for delivery (e.g., file formats, resolution)
        //     $table->enum('delivery_type', ['upload_file', 'link'])->nullable();
        //     $table->text('delivery_file')->nullable();
        //     $table->timestamp('files_uploaded_at')->nullable();

        //     // Status tracking
        //     $table->enum('order_status', [
        //         'pending',      // Waiting for artist confirmation
        //         'confirmed',    // Artist confirmed the order
        //         'processing',   // Artist preparing the files
        //         'delivered',    // Files sent to customer
        //         'completed',    // Customer confirmed receipt
        //         'cancelled'     // Order cancelled
        //     ])->default('pending');

        //     $table->enum('payment_status', [
        //         'unpaid',       // Payment not yet received
        //         'paid',         // Payment confirmed
        //         'refunded',     // Payment refunded (if order cancelled)
        //         'failed'        // Payment failed
        //     ])->default('unpaid');

        //     // Important dates
        //     $table->timestamp('confirmed_at')->nullable(); // When artist confirmed order
        //     $table->timestamp('paid_at')->nullable(); // When payment was confirmed
        //     $table->timestamp('delivered_at')->nullable(); // When files were delivered
        //     $table->timestamp('completed_at')->nullable(); // When buyer confirmed receipt

        //     $table->timestamps(); // created_at, updated_at
        //     $table->softDeletes(); // deleted_at for soft delete

        //     // Add indexes for better query performance
        //     $table->index('gallery_id');
        //     $table->index('buyer_email'); // For tracking orders by email
        //     $table->index('order_status');
        //     $table->index('payment_status');
        // });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('adoptions');
    }
};

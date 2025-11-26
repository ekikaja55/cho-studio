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
        Schema::create('members', function (Blueprint $table) {
            $table->id('member_id'); // PK
            $table->string('username', 50)->unique();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('line_id')->nullable();
            $table->string('phone_number', 15)->nullable();
            $table->string('instagram', 50)->nullable();
            $table->enum('role', ['artist', 'client'])->default('client');
            $table->timestamps(); // created_at dan updated_at
            $table->softDeletes(); // deleted_at untuk soft delete
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('members');
    }
};

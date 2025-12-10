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
        Schema::create('hvp_items', function (Blueprint $table) {
            $table->id();
            $table->enum('part', ['part_1', 'part_2']);
            $table->string('content');
            $table->integer('correct_order');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hvp_items');
    }
};

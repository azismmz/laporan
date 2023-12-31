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
        Schema::create('lpg_subsidi_verifieds', function (Blueprint $table) {
            $table->id();
            $table->string('bulan');       
            $table->text('provinsi');       
            $table->decimal('volume', 8, 2); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lpg_subsidi_verifieds');
    }
};

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
        Schema::create('announcements', function (Blueprint $table) {
            $table->id();
            $table->text('announcement');
            $table->date('start_date');
            $table->date('end_date');
            $table->unsignedBigInteger('author');
            $table->unsignedBigInteger('editor')->nullable();
            $table->timestamps();


            $table->foreign('author')->references('id')->on('users')->onDelete('restrict')->onUpdate('restrict');
            
        });
    }
    
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('announcements');
    }
};

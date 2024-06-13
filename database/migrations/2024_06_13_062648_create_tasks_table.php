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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('subject');
            $table->longText('description');
            $table->date('startDate');
            $table->date('dueDate');
            $table->foreignId('user_id')->constrained();
            $table->enum('priority', ['High' , 'Medium' , 'Low'])->default('High');
            $table->enum('status', [ 'New' , 'Incomplete' , 'Complete'])->default('New');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};

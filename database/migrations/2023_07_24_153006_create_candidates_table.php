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
        Schema::create('candidates', function (Blueprint $table) {
            $table->id();
            $table->string('first_name', 40);
            $table->string('last_name', 40)->nullable();
            $table->string('email', 100)->nullable();
            $table->string('contact_number', 100)->nullable();
            $table->unsignedTinyInteger('gender')->nullable();
            $table->string('specialization', 200)->nullable();
            $table->integer('work_ex_year')->nullable();
            $table->bigInteger('candidate_dob')->nullable();
            $table->text('address')->nullable();
            $table->string('resume')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('candidates');
    }
};

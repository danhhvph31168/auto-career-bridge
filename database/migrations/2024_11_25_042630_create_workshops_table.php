<?php

use App\Models\University;
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
        Schema::create('workshops', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(University::class)->constrained();
            $table->string('title');
            $table->string('address');
            $table->text('requirement');
            $table->text('description');
            $table->date('start_date');
            $table->date('end_date');
            $table->integer('applicants')->unsigned()->nullable()->default(0);
            $table->string('slug')->unique();
            $table->boolean('status')->default(0);
            $table->boolean('is_active')->default(0);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('workshops');
    }
};

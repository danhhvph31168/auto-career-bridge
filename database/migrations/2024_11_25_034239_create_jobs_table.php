<?php

use App\Models\Enterprise;
use App\Models\Major;
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
        Schema::create('jobs', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Major::class)->constrained();
            $table->foreignIdFor(Enterprise::class)->constrained();
            $table->string('title');
            $table->string('address');
            $table->text('requirement');
            $table->string('working_time', 50);
            $table->string('experience_level', 50);
            $table->string('benefit');
            $table->date('start_date');
            $table->date('end_date');
            $table->decimal('salary', 10, 2)->nullable();
            $table->integer('applicants')->unsigned()->nullable()->default(0);
            $table->string('slug')->unique();
            $table->text('description');
            $table->enum('type', ['part_time', 'full_time', 'remote']);
            $table->boolean('status')->default(0);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jobs');
    }
};

<?php

use App\Models\Enterprise;
use App\Models\Role;
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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Enterprise::class)->nullable()->constrained();
            $table->foreignIdFor(University::class)->nullable()->constrained();
            $table->foreignIdFor(Role::class)->constrained();
            $table->string('username', 100);
            $table->string('email', 100)->unique();
            $table->string('password', 100);
            $table->string('avatar')->nullable();
            $table->string('phone')->unique()->nullable();
            $table->string('user_type')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->integer('status')->default(0);
            $table->integer('is_active')->default(0);
            $table->rememberToken();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};

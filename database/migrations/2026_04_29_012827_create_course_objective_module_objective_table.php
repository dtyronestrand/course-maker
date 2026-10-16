<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\CourseObjective;
use App\Models\ModuleObjective;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('course_objective_module_objective', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(CourseObjective::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(ModuleObjective::class)->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course_objective_module_objective');
    }
};

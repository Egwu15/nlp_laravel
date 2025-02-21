<?php

use App\Models\Law;
use App\Models\Part;
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
        Schema::create('sections', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('number');
            $table->text('content');
            $table->foreignIdFor(Part::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Law::class)->constrained()->cascadeOnDelete();
            $table->timestamps();
            $table->unique(['law_id', 'number']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sections');
    }
};

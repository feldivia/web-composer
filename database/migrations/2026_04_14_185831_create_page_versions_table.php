<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('page_versions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('page_id')->constrained()->cascadeOnDelete();
            $table->json('content')->nullable();
            $table->text('css')->nullable();
            $table->string('label')->nullable();
            $table->timestamp('created_at')->useCurrent();

            $table->index('page_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('page_versions');
    }
};

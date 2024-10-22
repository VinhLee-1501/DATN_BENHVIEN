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
        Schema::create('blogs', function (Blueprint $table) {
            // $table->string('blog_id', length:20)->primary();
            $table->id()->primary();
            $table->string('title', length:225);
            $table->longtext('content');
            $table->string('author', length:20);
            $table->longText('thumbnail')->nullable();
            $table->date('date');
            $table->tinyInteger('status');
            $table->text('describe');
            $table->string('slug')->unique();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blogs');
    }
};

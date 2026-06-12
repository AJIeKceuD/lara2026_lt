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
        Schema::create('top_images', function (Blueprint $table) {
            $table->id();
            
            // Мультиязычное поле для alt-текста (SEO)
            $table->json('alt_text')->nullable();
            
            // Путь к изображению
            $table->string('image_path');
            
            // Оригинальное имя файла (для отладки)
            $table->string('original_name')->nullable();
            
            // Размер файла в байтах
            $table->unsignedInteger('file_size')->nullable();
            
            // Языки для отображения (JSON массив)
            $table->json('languages')->nullable(); // ['en', 'zh', 'ru']
            
            // Сортировка и публикация
            $table->timestamp('published_at')->nullable();
            
            // Мягкое удаление
            $table->softDeletes();
            
            $table->timestamps();
            
            // Индексы
            $table->index('published_at');
            $table->index('deleted_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('top_images');
    }
};

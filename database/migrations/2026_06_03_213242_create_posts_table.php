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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();

            // Мультиязычные поля (JSON)
            $table->json('title');
            $table->json('slug');
            $table->json('content');
            
            // Обычные поля
            $table->string('preview_image')->nullable();
            $table->timestamp('published_at')->nullable();
            $table->unsignedSmallInteger('reading_time')->nullable()->comment('Время чтения в минутах');
            
            // Мягкое удаление
            $table->softDeletes();
            $table->timestamps();

            // // 📌 ВАЖНО: Индексы для JSON-полей через generated columns
            // // Для каждого языка создаём виртуальную колонку
            // $table->string('slug_en')->virtualAs('slug->>"$.en"')->nullable();
            // $table->string('slug_zh')->virtualAs('slug->>"$.zh"')->nullable();
            
            // // Уникальные индексы на виртуальных колонках
            // $table->unique('slug_en');
            // $table->unique('slug_zh');

            // 📌 КЛЮЧЕВОЙ МОМЕНТ: Генерируемые колонки для индексации slug
            $this->addSlugIndexes($table);
            
            // Индексы для оптимизации
            $table->index('published_at');
            $table->index('deleted_at');
        });
    }

    private function addSlugIndexes(Blueprint $table): void {
        // Получаем список языков из конфига или определяем вручную
        $locales = ['en', 'zh']; // Добавьте ваши языки
        
        foreach ($locales as $locale) {
            // Виртуальная колонка для извлечения slug на конкретном языке
            $columnName = "slug_{$locale}";
            
            // Используем JSON path expression для извлечения значения
            $table->string($columnName, 255)
                  ->virtualAs("JSON_UNQUOTE(JSON_EXTRACT(slug, '$.{$locale}'))")
                  ->nullable();
            
            // Уникальный индекс на этой виртуальной колонке
            $table->unique($columnName);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};

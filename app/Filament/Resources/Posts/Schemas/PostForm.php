<?php

namespace App\Filament\Resources\Posts\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\RichEditor;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Tabs;

class PostForm
{
    public static function configure(Schema $schema): Schema
    {
        // Определите поддерживаемые языки для вашего проекта
        $locales = [
            'en' => 'English',
            'zh' => 'Chinese',
        ];

        $tabs = [];
    
        foreach ($locales as $locale => $label) {
            $tabs[] = Tabs\Tab::make($label)
                ->schema([
                    TextInput::make("title.{$locale}")
                        ->label("Title ({$label})")
                        ->required()
                        ->maxLength(255),
                    
                    RichEditor::make("content.{$locale}")
                        ->label("Content ({$label})")
                        ->required()
                        ->fileAttachmentsDirectory('attachments'),
                    
                    // Для slug — проверка уникальности в рамках конкретного языка
                    TextInput::make("slug.{$locale}")
                        ->label("Slug ({$label})")
                        // ->required()
                        ->unique(table: 'posts', column: "slug->{$locale}", ignoreRecord: true)
                        ->helperText('Оставьте пустым для автоматической генерации'),
                ]);
        }

        return $schema
            ->components([
                Tabs::make('Translations')
                ->tabs($tabs)
                ->columnSpanFull(),

                // TextInput::make('title')
                //     ->required(),
                // TextInput::make('slug')
                //     ->required()
                //     ->helperText('Оставьте пустым для автоматической генерации'),
                // RichEditor::make('content')
                //     ->required()
                //     ->fileAttachmentsDirectory('attachments')
                //     ->columnSpanFull(),
                FileUpload::make('preview_image')
                    ->image()
                    ->imageEditor()
                    ->imageEditorViewportWidth('800')  // Replaces imageResizeTargetWidth
                    ->imageEditorViewportHeight('800') // Replaces imageResizeTargetHeight
                    ->directory('posts')
                    ->disk('public')
                    ->visibility('public')
                    // ->imageResizeMode('cover')
                    // ->imageCropAspectRatio('16:9')
                    ->maxSize(2048),
                    // ->imageResizeTargetWidth(800)
                    // ->imageResizeTargetHeight(450),
                DateTimePicker::make('published_at')
                    ->default(now())
                    ->displayFormat('Y-m-d H:i'),
                TextInput::make('reading_time')
                    ->numeric()
                    ->minValue(1)
                    ->maxValue(60)
                    ->helperText('Оставьте пустым для автоматического расчёта'),
                // TextInput::make('slug_en'),
                // TextInput::make('slug_zh'),
            ]);
    }
}

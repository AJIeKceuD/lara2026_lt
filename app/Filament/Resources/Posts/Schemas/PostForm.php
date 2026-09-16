<?php

namespace App\Filament\Resources\Posts\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\RichEditor\TextColor;
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
                        // ->required()
                        ->maxLength(255)
                        ->helperText('Пустые заголовки не будут выведены в соответствующей локали'),

                    TextInput::make("preview_title.{$locale}")
                        ->label("Preview Title ({$label})")
                        ->maxLength(255),

                    RichEditor::make("content.{$locale}")
                        ->label("Content ({$label})")
                        // ->required()
                        ->fileAttachmentsDirectory('attachments')
                        ->toolbarButtons([
                            ['textColor', 'bold', 'italic', 'underline', 'strike', 'subscript', 'superscript', 'link'],
                            ['h2', 'h3'],
                            ['alignStart', 'alignCenter', 'alignEnd', 'alignJustify'],
                            ['blockquote', 'codeBlock', 'bulletList', 'orderedList', 'horizontalRule'],
                            ['table', 'attachFiles'], // The `customBlocks` and `mergeTags` tools are also added here if those features are used.
                            ['clearFormatting', 'undo', 'redo'],
                        ])
                        ->textColors([
                            '#e4e4e4' => 'E4E4E4',
                            '#919191' => '919191',
                            ...TextColor::getDefaults(),
                        ]),

                    TextInput::make("meta_desc.{$locale}")
                        ->label("Meta Description ({$label})")
                        ->maxLength(160),

                    TextInput::make("main_image_alt.{$locale}")
                        ->label("Main Image Desc ({$label})")
                        ->maxLength(255),

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
                    // ->disk('public_html')
                    // ->visibility('public')
                    // ->imageResizeMode('cover')
                    // ->imageCropAspectRatio('16:9')
                    ->maxSize(2048),
                    // ->imageResizeTargetWidth(800)
                    // ->imageResizeTargetHeight(450),
                FileUpload::make('main_image')
                    ->label('Main Image')
                    ->image()
                    ->imageEditor()
                    ->directory('posts')
                    ->maxSize(5120),
                    // ->helperText('Recommended: 1200x675px (16:9)'),
                DateTimePicker::make('published_at')
                    ->default(now())
                    ->native(false)
                    ->displayFormat('Y-m-d H:i:s'),
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

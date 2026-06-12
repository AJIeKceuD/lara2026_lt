<?php

namespace App\Filament\Resources\TopImages\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\CheckboxList;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Tabs;

class TopImageForm
{
    public static function configure(Schema $schema): Schema
    {
        // Определяем поддерживаемые языки
        $locales = [
            'en' => 'English',
            'zh' => '中文',
        ];
        
        // Создаём вкладки для каждого языка
        $tabs = [];
        foreach ($locales as $locale => $label) {
            $tabs[] = Tabs\Tab::make($label)
                ->schema([
                    TextInput::make("alt_text.{$locale}")
                        ->label("Alt-text ({$label})")
                        ->maxLength(255)
                        ->helperText('Alt-text (for SEO)'),
                ]);
        }

        return $schema
            ->components([
                // Вкладки с переводами
                Tabs::make('Translations')
                    ->tabs($tabs)
                    ->columnSpanFull(),

                // TextInput::make('alt_text')
                //     ->label('Alt-text (for SEO)')
                //     ->translatable(),
                FileUpload::make('image_path')
                    ->image()
                    ->imageEditor()
                    ->required()
                    ->directory('top-images')
                    ->disk('public')
                    ->visibility('public')
                    ->helperText('Recomended size: 1200x675px (16:9)')
                    ->afterStateUpdated(function ($state, $set, $record) {
                        if ($state) {
                            // Получаем загруженный файл
                            $file = \Illuminate\Support\Facades\Request::file('image_path');
                            
                            if ($file) {
                                $set('original_name', $file->getClientOriginalName());
                                $set('file_size', $file->getSize());
                            }
                        }
                    }),
                TextInput::make('original_name')
                    ->disabled()
                    ->dehydrated(false),
                TextInput::make('file_size')
                    ->numeric()
                    ->disabled()
                    ->dehydrated(false)
                    ->formatStateUsing(fn ($state) => $state ? number_format($state / 1024, 2) . ' KB' : '—'),
                CheckboxList::make('languages')
                    ->label('Show on languges')
                    ->options([
                        'en' => 'English',
                        'zh' => '中文',
                    ])
                    ->helperText('Select nothing for show on all'),
                DateTimePicker::make('published_at')
                    ->native(false)
                    ->format('Y-m-d H:i:s')
                    ->displayFormat('Y-m-d H:i:s')
                    ->default(NULL)
                    ->nullable()
                    ->helperText('Leave empty for postpone publication'),
            ])->columns(2);
    }
}

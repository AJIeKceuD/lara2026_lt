<?php

namespace App\Filament\Resources\ProjectImages\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Components\Section;

class ProjectImageForm
{
    public static function configure(Schema $schema): Schema
    {
        $locales = [
            'en' => 'English',
            'zh' => '中文',
        ];

        $tabs_arr = [];
        foreach ($locales as $locale => $label) {
            $tabs_arr[] =
                Tab::make($label)
                    ->schema([
                        TextInput::make("title.{$locale}")
                            ->label("Title ({$label})")
                            ->maxLength(255),
                        Textarea::make("comment.{$locale}")
                            ->label("Comment ({$label})")
                            ->rows(4),
                    ])
            ;
        }

        return $schema
            ->components([
                Section::make('Image')
                    ->schema([
                        FileUpload::make('image_path')
                            ->image()
                            ->required()
                            ->imageEditor()
                            ->directory('projects-images')
                            // ->disk('public_html')
                            ->maxSize(5120)
                            ->helperText('Recommended: 478x692px')
                        ,
                    ]),
                Section::make('Publication')
                    ->schema([
                        DateTimePicker::make('published_at')
                            ->label('Published at')
                            ->native(false)
                            ->displayFormat('Y-m-d H:i:s')
                            ->nullable()
                            ->default(null)
                            ->helperText('Leave empty for draft'),
                    ]),
                Section::make('Translations')
                    ->schema([
                        Tabs::make('Tabs')->tabs($tabs_arr)
                    ])->columnSpanFull(),
            ]);
    }
}

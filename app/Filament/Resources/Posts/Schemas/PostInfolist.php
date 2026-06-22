<?php

namespace App\Filament\Resources\Posts\Schemas;

use App\Models\Post;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Tabs;

class PostInfolist
{
    public static function configure(Schema $schema): Schema
    {
        $locales = ['en' => 'English', 'zh' => '中文'];
        $tabs = [];
        
        foreach ($locales as $locale => $label) {
            $tabs[] = Tabs\Tab::make($label)
                ->schema([
                    TextEntry::make("title_{$locale}")
                        ->label("Title")
                        ->getStateUsing(fn ($record) => $record->getTranslation('title', $locale, false)),
                    TextEntry::make("slug_{$locale}")
                        ->label("Slug")
                        ->getStateUsing(fn ($record) => $record->getTranslation('slug', $locale, false)),
                    TextEntry::make("content_{$locale}")
                        ->label("Content")
                        ->getStateUsing(fn ($record) => $record->getTranslation('content', $locale, false))
                        ->html(),
                ]);
        }

        return $schema
            ->components([
                Tabs::make('Translations')
                ->tabs($tabs)
                ->columnSpanFull(),

                ImageEntry::make('preview_image')
                    // ->disk('public')
                    // ->visibility('public')
                    ->placeholder('-'),
                TextEntry::make('published_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('reading_time')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('deleted_at')
                    ->dateTime()
                    ->visible(fn (Post $record): bool => $record->trashed()),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
                // TextEntry::make('title_en')
                //     ->placeholder('-'),
                // TextEntry::make('title_zh')
                //     ->placeholder('-'),
                // TextEntry::make('slug_en')
                //     ->placeholder('-'),
                // TextEntry::make('slug_zh')
                //     ->placeholder('-'),
                // TextEntry::make('content_en')
                //     ->placeholder('-'),
                // TextEntry::make('content_zh')
                //     ->placeholder('-'),
            ]);
    }
}

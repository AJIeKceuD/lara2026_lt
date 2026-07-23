<?php

namespace App\Filament\Resources\FormContactUs\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class FormContactUsForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Message Details')
                    ->schema([
                        TextInput::make('name')
                            ->required(),
                        TextInput::make('email')
                            ->label('Email address')
                            ->email()
                            ->required(),
                        Textarea::make('message')
                            ->required()
                            ->columnSpanFull(),
                    ]),
                Section::make('Status')
                    ->schema([
                        Textarea::make('meta')
                            ->label('Meta (JSON)')
                            ->rows(8)
                            ->formatStateUsing(fn ($state) => json_encode($state, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE))
                            ->dehydrateStateUsing(fn ($state) => json_decode($state, true)),
                        TextInput::make('ip_address'),
                        TextInput::make('user_agent'),
                        Toggle::make('is_read')
                            ->required(),
                    ])->columns(2),
            ]);
    }
}

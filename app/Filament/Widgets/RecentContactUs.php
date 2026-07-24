<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use App\Models\FormContactUs;
use Filament\Actions\ViewAction;
use App\Filament\Resources\FormContactUs\FormContactUsResource;

class RecentContactUs extends BaseWidget
{
    protected static ?int $sort = 2;

    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                FormContactUs::query()
                    ->latest('created_at')
                    ->limit(3)
            )
            ->columns([
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Date')
                    ->dateTime('Y-m-d H:i:s')
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->label('Name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->label('Email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('message')
                    ->label('Message')
                    ->limit(30),
                Tables\Columns\IconColumn::make('is_read')
                    ->label('Read')
                    ->boolean(),
            ])
            ->recordActions([
                ViewAction::make()
                    ->url(fn ($record) => FormContactUsResource::getUrl('edit', ['record' => $record])),
            ])
            ->defaultSort('created_at', 'desc')
            ->searchable(false)
            ->paginated(false);
    }
}

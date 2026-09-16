<?php

namespace App\Filament\Resources\Posts\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class PostsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title_en')
                    ->label('Title (EN)')
                    ->state(fn ($record) => $record->getTranslation('title', 'en', false) ?? '—')
                    ->searchable(query: function ($query, $search) {
                        return $query->where('title->en', 'like', "%{$search}%");
                    })
                    ->limit(30, end: '…'),
                TextColumn::make('title_zh')
                    ->label('Title (ZH)')
                    ->state(fn ($record) => $record->getTranslation('title', 'zh', false) ?? '—')
                    ->searchable(query: function ($query, $search) {
                        return $query->where('title->zh', 'like', "%{$search}%");
                    })
                    ->limit(30, end: '…'),
                TextColumn::make('slug_en')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('slug_zh')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                ImageColumn::make('preview_image')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('published_at')
                    ->label('Published')
                    ->icon(fn ($record) => $record->isPublished()
                        ? 'heroicon-o-check-circle'
                        : 'heroicon-o-clock'
                    )
                    ->iconColor(fn ($record) => $record->isPublished() ? 'success' : 'warning')
                    ->formatStateUsing(fn ($record) => $record->published_at
                        ? $record->published_at->format('Y-m-d H:i')
                        : 'Draft'
                    )
                    ->sortable(),
                TextColumn::make('reading_time')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: false),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                TrashedFilter::make(),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make()
                    ->label('To trash'),
                RestoreAction::make(),
                ForceDeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
            ]);
    }
}

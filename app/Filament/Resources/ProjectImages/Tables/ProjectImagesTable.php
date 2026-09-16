<?php

namespace App\Filament\Resources\ProjectImages\Tables;

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
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class ProjectImagesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image_path')
                    ->label('Image')
                    ->circular()
                    ->width(60)
                    ->height(60),
                TextColumn::make('title')
                    ->label('Title')
                    ->formatStateUsing(function ($state, $record) {
                        $locale = app()->getLocale();
                        return $record->getTranslation('title', $locale, false)
                            ?? '—';
                    })
                    ->searchable()
                    ->limit(40),
                // TextColumn::make('published_at')
                //     ->dateTime()
                //     ->sortable(),
                TextColumn::make('published_at')
                    ->label('Published')
                    ->icon(fn ($record) => $record->isPublished()
                        ? 'heroicon-o-check-circle'
                        : 'heroicon-o-clock'
                    )
                    ->iconColor(fn ($record) => $record->isPublished() ? 'success' : 'warning')
                    // ->color(fn ($record) => $record->isPublished() ? 'success' : 'warning')
                    ->formatStateUsing(fn ($record) => $record->published_at
                        ? $record->published_at->format('Y-m-d H:i')
                        : 'Draft'
                    )
                    ->sortable(),
                TextColumn::make('deleted_at')
                    ->label('Status')
                    ->badge()
                    ->state(fn ($record) => $record->trashed() ? 'Trashed' : 'Active')
                    ->color(fn ($state) => $state === 'Trashed' ? 'danger' : 'success'),
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
                Filter::make('published')
                    ->label('Published only')
                    ->query(fn ($query) => $query->published()),
                Filter::make('drafts')
                    ->label('Drafts only')
                    ->query(fn ($query) => $query->whereNull('published_at')),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make()
                    ->label('To trash'),
                RestoreAction::make(),
                ForceDeleteAction::make()
                    ->label('Delete forever'),
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

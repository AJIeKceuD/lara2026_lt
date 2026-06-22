<?php

namespace App\Filament\Resources\TopImages\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Actions\ViewAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class TopImagesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image_path')
                    // ->disk('public')
                    ,
                TextColumn::make('original_name')
                    ->searchable(),
                // TextColumn::make('file_size')
                //     ->numeric()
                //     ->sortable(),
                TextColumn::make('formatted_file_size')
                    ->label('File size')
                    ->sortable(query: function ($query, $direction) {
                        return $query->orderBy('file_size', $direction);
                    }),
                TextColumn::make('languages')
                    ->sortable(),
                TextColumn::make('published_at')
                    ->dateTime('Y.m.d H:i:s')
                    ->placeholder('—') // показывать если null
                    ->sortable(),
                TextColumn::make('deleted_at')->label('Статус')
                    ->badge()
                    ->state(fn ($record) => $record->trashed() ? 'In trash' : 'Active')
                    ->color(fn ($state) => $state === 'In trash' ? 'danger' : 'success')
                    // ->dateTime()
                    // ->sortable()
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
                ForceDeleteAction::make()
                    ->label('Delete')
                    ->modalHeading('Permanent delete Top Image')
                    ->modalDescription('The image will be deleted from the server. You sure?'),
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

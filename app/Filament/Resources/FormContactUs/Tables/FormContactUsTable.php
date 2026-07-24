<?php

namespace App\Filament\Resources\FormContactUs\Tables;

use Filament\Actions\BulkAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Table;
use Filament\Notifications\Notification;

class FormContactUsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('created_at')
                    ->label('Date')
                    ->dateTime('Y-m-d H:i:s')
                    ->sortable(),
                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('email')
                    ->label('Email address')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('message')
                    ->label('Message Preview')
                    ->limit(30)
                    ->tooltip(fn ($record) => $record->message),
                // TextColumn::make('ip_address')
                //     ->searchable(),
                // TextColumn::make('user_agent')
                //     ->searchable(),
                ToggleColumn::make('is_read')
                    ->label('Read')
                    // ->trueIcon('heroicon-o-check-circle')
                    // ->falseIcon('heroicon-o-clock')
                    // ->trueColor('success')
                    // ->falseColor('warning')
                    ,
                IconColumn::make('meta.notifications.email.sent')
                    ->label('Email Sent')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger'),
                IconColumn::make('meta.notifications.telegram.sent')
                    ->label('TG Sent')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger'),
                TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                TrashedFilter::make(),
                SelectFilter::make('is_read')
                    ->label('Status')
                    ->options([
                        '0' => 'Unread',
                        '1' => 'Read',
                    ]),
                Filter::make('created_at')
                    ->form([
                        DatePicker::make('from')
                            ->label('From'),
                        DatePicker::make('until')
                            ->label('Until'),
                    ])
                    ->query(function ($query, array $data) {
                        return $query
                            ->when($data['from'], fn($q) => $q->whereDate('created_at', '>=', $data['from']))
                            ->when($data['until'], fn($q) => $q->whereDate('created_at', '<=', $data['until']));
                    }),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
                // ToggleAction::make('is_read')
                //     ->label('Toggle Read')
                //     ->icon('heroicon-o-check-circle')
                //     ->color('success')
                //     ->after(function ($record) {
                //         Notification::make()
                //             ->title($record->is_read ? 'Marked as read' : 'Marked as unread')
                //             ->success()
                //             ->send();
                //     }),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    BulkAction::make('markRead')
                        ->label('Mark as Read')
                        ->icon('heroicon-o-check-circle')
                        ->action(function ($records) {
                            $records->each->update(['is_read' => true]);
                        }),
                    BulkAction::make('markUnread')
                        ->label('Mark as Unread')
                        ->icon('heroicon-o-clock')
                        ->action(function ($records) {
                            $records->each->update(['is_read' => false]);
                        }),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
            ]);
    }
}

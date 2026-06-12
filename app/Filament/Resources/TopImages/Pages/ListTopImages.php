<?php

namespace App\Filament\Resources\TopImages\Pages;

use App\Filament\Resources\TopImages\TopImageResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListTopImages extends ListRecords
{
    protected static string $resource = TopImageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}

<?php

namespace App\Filament\Resources\TopImages\Pages;

use App\Filament\Resources\TopImages\TopImageResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewTopImage extends ViewRecord
{
    protected static string $resource = TopImageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}

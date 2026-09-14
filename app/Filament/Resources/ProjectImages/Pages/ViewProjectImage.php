<?php

namespace App\Filament\Resources\ProjectImages\Pages;

use App\Filament\Resources\ProjectImages\ProjectImageResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewProjectImage extends ViewRecord
{
    protected static string $resource = ProjectImageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}

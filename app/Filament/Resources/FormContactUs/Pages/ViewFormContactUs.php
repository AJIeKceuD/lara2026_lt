<?php

namespace App\Filament\Resources\FormContactUs\Pages;

use App\Filament\Resources\FormContactUs\FormContactUsResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewFormContactUs extends ViewRecord
{
    protected static string $resource = FormContactUsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}

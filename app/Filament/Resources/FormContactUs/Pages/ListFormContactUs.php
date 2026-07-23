<?php

namespace App\Filament\Resources\FormContactUs\Pages;

use App\Filament\Resources\FormContactUs\FormContactUsResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListFormContactUs extends ListRecords
{
    protected static string $resource = FormContactUsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}

<?php

namespace App\Filament\Resources\FormContactUs;

use App\Filament\Resources\FormContactUs\Pages\CreateFormContactUs;
use App\Filament\Resources\FormContactUs\Pages\EditFormContactUs;
use App\Filament\Resources\FormContactUs\Pages\ListFormContactUs;
use App\Filament\Resources\FormContactUs\Pages\ViewFormContactUs;
use App\Filament\Resources\FormContactUs\Schemas\FormContactUsForm;
use App\Filament\Resources\FormContactUs\Schemas\FormContactUsInfolist;
use App\Filament\Resources\FormContactUs\Tables\FormContactUsTable;
use App\Models\FormContactUs;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class FormContactUsResource extends Resource
{
    protected static ?string $model = FormContactUs::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedEnvelope;

    protected static ?string $recordTitleAttribute = 'FormContactUs';

    public static function form(Schema $schema): Schema
    {
        return FormContactUsForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return FormContactUsInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return FormContactUsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListFormContactUs::route('/'),
            'create' => CreateFormContactUs::route('/create'),
            'view' => ViewFormContactUs::route('/{record}'),
            'edit' => EditFormContactUs::route('/{record}/edit'),
        ];
    }

    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}

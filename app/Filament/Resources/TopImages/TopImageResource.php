<?php

namespace App\Filament\Resources\TopImages;

use App\Filament\Resources\TopImages\Pages\CreateTopImage;
use App\Filament\Resources\TopImages\Pages\EditTopImage;
use App\Filament\Resources\TopImages\Pages\ListTopImages;
use App\Filament\Resources\TopImages\Pages\ViewTopImage;
use App\Filament\Resources\TopImages\Schemas\TopImageForm;
use App\Filament\Resources\TopImages\Schemas\TopImageInfolist;
use App\Filament\Resources\TopImages\Tables\TopImagesTable;
use App\Models\TopImage;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TopImageResource extends Resource
{
    protected static ?string $model = TopImage::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedPhoto;

    protected static ?string $recordTitleAttribute = 'TopImage';

    public static function form(Schema $schema): Schema
    {
        return TopImageForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return TopImageInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return TopImagesTable::configure($table);
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
            'index' => ListTopImages::route('/'),
            'create' => CreateTopImage::route('/create'),
            'view' => ViewTopImage::route('/{record}'),
            'edit' => EditTopImage::route('/{record}/edit'),
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

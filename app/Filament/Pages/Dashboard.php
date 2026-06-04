<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Filament\Pages\Dashboard as BaseDashboard;
use Filament\Actions\Action;
use Illuminate\Support\Facades\Artisan;
use Filament\Notifications\Notification;
use BackedEnum;
use Filament\Support\Icons\Heroicon;

class Dashboard extends BaseDashboard
{
    // protected string $view = 'filament.pages.dashboard';
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    // Кнопка в шапке
    protected function getHeaderActions(): array
    {
        return [
            Action::make('maintenance')
                ->label(fn(): string => app()->isDownForMaintenance() ? '🔧 Сайт на ремонте' : '🟢 Включить режим обслуживания')
                ->color(fn(): string => app()->isDownForMaintenance() ? 'danger' : 'success')
                ->action(function () {
                    if (app()->isDownForMaintenance()) {
                        Artisan::call('up');
                        Notification::make()
                            ->title('Сайт снова работает')
                            ->success()
                            ->send();
                    } else {
                        Artisan::call('down', [
                            '--retry' => 60,
                            // '--message' => 'Идут технические работы. Мы скоро вернемся!',
                            // '--allow' => [request()->ip()],
                        ]);
                        Notification::make()
                            ->title('Сайт в режиме обслуживания')
                            ->warning()
                            ->send();
                    }
                }),
        ];
    }
}

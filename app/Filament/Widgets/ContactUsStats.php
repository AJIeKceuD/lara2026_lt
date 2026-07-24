<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\FormContactUs;

class ContactUsStats extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        $total = FormContactUs::count();
        $unread = FormContactUs::where('is_read', false)->count();
        $thisMonth = FormContactUs::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        return [
            Stat::make('Total Contact Us', $total)
                ->description('All time')
                ->descriptionIcon('heroicon-m-envelope')
                ->color('gray')
                ->chart([7, 3, 5, 8, 6, 4, 9]),

            Stat::make('Unread', $unread)
                ->description('Need attention')
                ->descriptionIcon('heroicon-m-envelope')
                ->color('warning')
                ->chart([3, 5, 2, 4, 6, 8, 7]),

            Stat::make('This Month', $thisMonth)
                ->description(now()->format('F Y'))
                ->descriptionIcon('heroicon-m-calendar')
                ->color('success')
                ->chart([2, 4, 3, 6, 5, 7, 8]),
        ];
    }
}

<?php

namespace App\Filament\Widgets;
use App\Models\items;
use App\Models\stores;
use App\Models\ictcategories;
use App\Models\equipment_types;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Support\Enums\IconPosition;

class Item extends BaseWidget
{
    protected function getStats(): array
    {
        return [
           Stat::make('Total Items', items::count())
                ->description('All items in Stock')
                ->color('success')
                ->chart([7,2,10,3,15,4,17])
                ->descriptionIcon('heroicon-m-arrow-trending-up', IconPosition::Before),
                Stat::make('Total Stores', Stores::count())
                ->description('All Stores')
                ->color('danger')
                ->chart([7,2,10,3,15,4,17])
                ->descriptionIcon('heroicon-m-arrow-trending-up', IconPosition::Before),
                Stat::make('Total ICT Categories', ictcategories::count())
                ->description('All ICT Categories')
                ->color('info')
                ->chart([7,2,10,3,15,4,17])
                ->descriptionIcon('heroicon-m-arrow-trending-up', IconPosition::Before),
                Stat::make('Total Equipment Type', equipment_types::count())
                ->description('All Equipment Type')
                ->color('warning')
                ->chart([7,2,10,3,15,4,17])
                ->descriptionIcon('heroicon-m-arrow-trending-up', IconPosition::Before),
        ];
    }
}

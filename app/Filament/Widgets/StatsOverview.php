<?php

declare(strict_types=1);

namespace App\Filament\Widgets;

use App\Models\FormSubmission;
use App\Models\Page;
use App\Models\Post;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Pages', Page::count()),
            Stat::make('Published Pages', Page::where('status', 'published')->count()),
            Stat::make('Total Posts', Post::count()),
            Stat::make('Published Posts', Post::where('status', 'published')->count()),
            Stat::make('Unread Messages', FormSubmission::unread()->count())
                ->color('danger'),
        ];
    }
}

<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\PatientTypeOverview;
use App\Filament\Widgets\TreatmentsChart;
use App\Models\Patient;
use Filament\Forms\Components\Builder;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Pages\Dashboard as BaseDashboard;
use Filament\Pages\Dashboard\Actions\FilterAction;
use Filament\Widgets\StatsOverviewWidget\Stat;

class Dashboard extends BaseDashboard
{

    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static string $view = 'filament.pages.dashboard';
    protected static string $routePath = 'dashboard';

    protected function getHeaderWidgets(): array
    {
        return [
            PatientTypeOverview::class,
            TreatmentsChart::class,
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            FilterAction::make()
                ->form([
                    DatePicker::make('startDate'),
                    DatePicker::make('endDate'),
                ]),
        ];
    }
}

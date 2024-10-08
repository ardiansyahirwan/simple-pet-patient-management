<?php

namespace App\Filament\Pages;

use App\Filament\Resources\PatientResource;
use App\Filament\Widgets\PatientTypeOverview;
use App\Filament\Widgets\TreatmentsChart;
use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{

    protected static ?string $navigationIcon = 'heroicon-o-home';
    protected static string $view = 'filament.pages.dashboard';
    protected static string $routePath = 'dashboard';

    protected function getHeaderWidgets(): array
    {
        return [
            PatientTypeOverview::class,
            TreatmentsChart::class,
        ];
    }

    public static function canAccess(): bool
    {
        return PatientResource::getRolesUser(auth()->user());
    }
}

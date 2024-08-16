<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\PatientResource;
use App\Models\Patient;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class PatientTypeOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Cats', function () {
                if (PatientResource::getRolesUser(auth()->user())) {
                    return Patient::query()
                        ->where('user_id', auth()->user()->getAuthIdentifier())
                        ->where('type', 'cat')
                        ->count();
                }
                return Patient::query()
                    ->where('type', 'cat')
                    ->count();
            }),
            Stat::make('Dogs', function () {
                if (PatientResource::getRolesUser(auth()->user())) {
                    return Patient::query()
                        ->where('user_id', auth()->user()->getAuthIdentifier())
                        ->where('type', 'dog')
                        ->count();
                }
                return Patient::query()
                    ->where('type', 'dog')
                    ->count();
            }),
            Stat::make('Rabbits', function () {
                if (PatientResource::getRolesUser(auth()->user())) {
                    return Patient::query()
                        ->where('user_id', auth()->user()->getAuthIdentifier())
                        ->where('type', 'rabbit')
                        ->count();
                }
                return Patient::query()
                    ->where('type', 'rabbit')
                    ->count();
            }),
            Stat::make('Total Pet', function () {
                if (PatientResource::getRolesUser(auth()->user())) {
                    return Patient::query()
                        ->where('user_id', auth()->user()->getAuthIdentifier())
                        ->count();
                }
                return Patient::query()
                    ->count();
            }),
        ];
    }
}

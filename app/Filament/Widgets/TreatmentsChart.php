<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\PatientResource;
use App\Models\Patient;
use App\Models\Treatment;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use Illuminate\Database\Eloquent\Builder;

class TreatmentsChart extends ChartWidget
{
    protected static ?string $heading = 'Overview';

    protected function getData(): array
    {
        $data = Trend::model(Treatment::class)
            ->query(
                PatientResource::getRolesUser(auth()->user())
                    ? Treatment::whereHas('patient', function (Builder $query) {
                        $query->where('user_id', auth()->user()->getAuthIdentifier());
                    })
                    : Treatment::has('patient')
            )
            ->between(
                start: now()->subYear(),
                end: now(),
            )
            ->perMonth()
            ->count();
        $dataPet = Trend::model(Patient::class)
            ->query(
                PatientResource::getRolesUser(auth()->user())
                    ? Patient::where('user_id', auth()->user()->getAuthIdentifier())
                    : Patient::query()
            )
            ->between(
                start: now()->subYear(),
                end: now(),
            )
            ->perMonth()
            ->count();

        return [
            'datasets' => [
                [
                    'label' => 'Treatments',
                    'data' => $data->map(fn (TrendValue $value) => $value->aggregate),
                    'borderColor' => 'red',
                ],
                [
                    'label' => 'Pets',
                    'data' => $dataPet->map(fn (TrendValue $value) => $value->aggregate),
                    'borderColor' => 'green',
                ],
            ],
            'labels' => $data->map(fn (TrendValue $value) => $value->date),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}

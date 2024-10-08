<?php

namespace App\Filament\Resources\PatientResource\Pages;

use App\Filament\Resources\PatientResource;
use App\Filament\Widgets\PatientTypeOverview;
use App\Models\Patient;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListPatients extends ListRecords
{
    protected static string $resource = PatientResource::class;
    protected ?string $heading = 'Pet Patients';
    protected ?string $subheading = 'There are list of pet on table';

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            PatientTypeOverview::class,
        ];
    }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make(),
            'dog' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->where('type', 'dog')),
            'cat' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->where('type', 'cat')),
            'rabbit' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->where('type', 'rabbit')),
        ];
    }
}

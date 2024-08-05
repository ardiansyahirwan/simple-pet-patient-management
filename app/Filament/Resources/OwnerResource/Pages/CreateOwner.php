<?php

namespace App\Filament\Resources\OwnerResource\Pages;

use App\Filament\Resources\OwnerResource;
use Filament\Actions;
use Filament\Forms\Components\Wizard\Step;
use Filament\Resources\Pages\CreateRecord;

class CreateOwner extends CreateRecord
{
    use CreateRecord\Concerns\HasWizard;

    protected static string $resource = OwnerResource::class;

    protected static function getSteps(): array
    {
        return [
            Step::make('Name')
                ->description('Type your fullname')
                ->schema([OwnerResource::getNameField()]),
            Step::make('Email')
                ->description('Make sure your email is valid')
                ->schema([OwnerResource::getEmailField()]),
            Step::make('Phone')
                ->description('Input your phone number')
                ->schema([OwnerResource::getPhoneField()]),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}

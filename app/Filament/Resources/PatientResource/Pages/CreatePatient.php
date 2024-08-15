<?php

namespace App\Filament\Resources\PatientResource\Pages;

use App\Filament\Resources\PatientResource;
use Filament\Actions;
use Filament\Forms\Components\Wizard\Step;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Filament\Forms;
use Illuminate\Database\Eloquent\Model;

class CreatePatient extends CreateRecord
{
    protected static string $resource = PatientResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->previousUrl ?? $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotification(): Notification
    {
        return Notification::make()
            ->success()
            ->title('Pet added successfully')
            ->body('Your pet successfully added into system');
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        return [
            'name' => $data['name'],
            'date_of_birth' => $data['date_of_birth'],
            'user_id' => static::getResource()::getRolesUser(auth()->user())
                ? auth()->user()->getAuthIdentifier()
                : $data['user_id'],
            'type' => $data['type'],
        ];
    }

    protected function handleRecordCreation(array $data): Model
    {
        return static::getModel()::create($data);
    }
}

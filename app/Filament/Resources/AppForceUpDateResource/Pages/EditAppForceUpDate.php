<?php

namespace App\Filament\Resources\AppForceUpDateResource\Pages;

use App\Filament\Resources\AppForceUpDateResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAppForceUpDate extends EditRecord
{
    protected static string $resource = AppForceUpDateResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}

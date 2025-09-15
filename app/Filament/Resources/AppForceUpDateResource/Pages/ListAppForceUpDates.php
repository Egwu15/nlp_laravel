<?php

namespace App\Filament\Resources\AppForceUpDateResource\Pages;

use App\Filament\Resources\AppForceUpDateResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAppForceUpDates extends ListRecords
{
    protected static string $resource = AppForceUpDateResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

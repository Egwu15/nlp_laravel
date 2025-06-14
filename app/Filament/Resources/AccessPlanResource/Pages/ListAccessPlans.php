<?php

namespace App\Filament\Resources\AccessPlanResource\Pages;

use App\Filament\Resources\AccessPlanResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAccessPlans extends ListRecords
{
    protected static string $resource = AccessPlanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

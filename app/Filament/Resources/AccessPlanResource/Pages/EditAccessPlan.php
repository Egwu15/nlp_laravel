<?php

namespace App\Filament\Resources\AccessPlanResource\Pages;

use App\Filament\Resources\AccessPlanResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAccessPlan extends EditRecord
{
    protected static string $resource = AccessPlanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}

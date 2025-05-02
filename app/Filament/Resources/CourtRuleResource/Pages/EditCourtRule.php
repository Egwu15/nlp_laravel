<?php

namespace App\Filament\Resources\CourtRuleResource\Pages;

use App\Filament\Resources\CourtRuleResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCourtRule extends EditRecord
{
    protected static string $resource = CourtRuleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}

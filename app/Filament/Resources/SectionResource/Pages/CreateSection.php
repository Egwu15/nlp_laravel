<?php

namespace App\Filament\Resources\SectionResource\Pages;

use App\Filament\Resources\SectionResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;


class CreateSection extends CreateRecord
{
    protected static string $resource = SectionResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        session()->put('last_used_law_id', $data['law_id']);
        session()->put('last_used_part_id', $data['part_id']);

        return $data;
    }

    //  /**
    //  * Override the record creation to catch unique constraint violations.
    //  *
    //  * @param  array  $data
    //  * @return \Illuminate\Database\Eloquent\Model
    //  *
    //  * @throws \Illuminate\Validation\ValidationException
    //  */
    // protected function handleRecordCreation(array $data): \Illuminate\Database\Eloquent\Model
    // {
    //     try {
    //         return parent::handleRecordCreation($data);
    //     } catch (QueryException $exception) {
    //         // Check if the exception message indicates a unique constraint violation
    //         if (str_contains($exception->getMessage(), 'UNIQUE constraint failed: sections.law_id, sections.number')) {
    //             // Convert the exception to a validation error for the "number" field.
    //             throw ValidationException::withMessages([
    //                 'number' => 'A section with this law and number already exists.',
    //             ]);
    //         }

    //         // Otherwise, rethrow the exception.
    //         throw $exception;
    //     }
    // }

}

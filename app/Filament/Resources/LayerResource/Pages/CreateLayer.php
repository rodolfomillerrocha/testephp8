<?php

namespace App\Filament\Resources\LayerResource\Pages;

use App\Filament\Resources\LayerResource;
use Filament\Resources\Pages\CreateRecord;

class CreateLayer extends CreateRecord
{
    protected static string $resource = LayerResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Garantir que geometry está em formato correto
        if (isset($data['geometry'])) {
            if (is_string($data['geometry'])) {
                $data['geometry'] = json_decode($data['geometry'], true);
            }
        }

        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}






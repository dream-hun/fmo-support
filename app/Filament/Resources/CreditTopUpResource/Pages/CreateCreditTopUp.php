<?php

namespace App\Filament\Resources\CreditTopUpResource\Pages;

use App\Filament\Resources\CreditTopUpResource;
use Filament\Resources\Pages\CreateRecord;

class CreateCreditTopUp extends CreateRecord
{
    protected static string $resource = CreditTopUpResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        if (($data['amount'] ?? 0) <= 0) {
            $totalAmount = \App\Models\Loan::query()
                ->where('vsla_id', $data['vsla_id'])
                ->where('done_at', $data['done_at'])
                ->sum('amount');

            if ($totalAmount > 0) {
                $this->halt('Cannot save with zero amount when there are loans for the selected date.');
            }
        }

        // Format the done_at date
        if (isset($data['done_at'])) {
            $data['done_at'] = date('Y-m-d', strtotime($data['done_at']));
        }

        return $data;
    }
}

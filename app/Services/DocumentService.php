<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class DocumentService {
    /**
     * Get pending documents for multiple types.
     *
     * @param array $documentTypes
     * @return bool
     */
    public function hasPendingDocuments(array $documentTypes): bool {
        return collect($documentTypes)->some(function ($field, $model) {
            return $model::where($field, 0)->exists();
        });
    }

    /**
     * Get count of pending documents for multiple types.
     *
     * @param array $documentTypes
     * @return array
     */
    public function getPendingDocumentsCount(array $documentTypes): array {
        return collect($documentTypes)->mapWithKeys(function ($field, $model) {
            return [$model => $model::where($field, 0)->count()];
        })->toArray();
    }
}
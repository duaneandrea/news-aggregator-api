<?php

namespace App\Contracts;

interface UserPreferenceInterface
{
    public function storeOrUpdate(int $userId, int $sourceId, int $categoryId);
    public function getPreferences(int $userId);
    public function updatePreferences(int $userId, array $data);
}

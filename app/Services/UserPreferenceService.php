<?php

namespace App\Services;

use App\Contracts\UserPreferenceInterface;
use App\Models\UserPreference;

class UserPreferenceService implements UserPreferenceInterface
{
    public function storeOrUpdate(int $userId, int $sourceId, int $categoryId): UserPreference
    {
        return UserPreference::updateOrCreate(
            ['user_id' => $userId],
            ['source_id' => $sourceId,'category_id' => $categoryId]
        );
    }

    public function getPreferences(int $userId)
    {
        return UserPreference::where('user_id', $userId)->get();
    }

    public function updatePreferences(int $userId, array $data): UserPreference
    {
        $preferences = UserPreference::where('user_id', $userId)->firstOrFail();
        $preferences->update($data);
        return $preferences;
    }
}

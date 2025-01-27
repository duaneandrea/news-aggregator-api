<?php

namespace App\Http\Controllers;

use App\Services\UserPreferenceService;
use Illuminate\Http\Request;

class UserPreferenceController extends Controller
{
    protected UserPreferenceService $userPreferenceService;

    public function __construct(UserPreferenceService $userPreferenceService)
    {
        $this->userPreferenceService = $userPreferenceService;
    }

    public function store(Request $request)
    {
        $preferences = $this->userPreferenceService->storeOrUpdate(
            $request->user()->id,
            $request->source_id,
            $request->category_id
        );

        return response()->json($preferences, 201);
    }

    public function show(Request $request)
    {
        $preferences = $this->userPreferenceService->getPreferences($request->user()->id);
        return response()->json($preferences);
    }

    public function update(Request $request)
    {
        $preferences = $this->userPreferenceService->updatePreferences(
            $request->user()->id,
            $request->only(['source_id', 'category_id'])
        );

        return response()->json($preferences);
    }
}

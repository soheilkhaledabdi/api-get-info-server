<?php

namespace App\Http\Controllers;

use App\Models\ApiKey;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ApiKeyController extends Controller
{
    public function store(Request $request)
    {
        $key = Str::uuid(); // Generate random key

        ApiKey::query()->create([
            'key' => $key,
            'description' => $request->input('description')
        ]);

        return response()->json(['key' => $key]);
    }
}

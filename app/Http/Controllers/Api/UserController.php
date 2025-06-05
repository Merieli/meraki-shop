<?php

namespace MerakiShop\Http\Controllers\Api;

use Illuminate\Http\Request;
use MerakiShop\Http\Controllers\Controller;
use MerakiShop\Models\User;

class UserController extends Controller
{
    public function index(Request $request)
    {
        try {
            return $request->user();
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
    }
}

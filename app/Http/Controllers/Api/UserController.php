<?php

namespace MerakiShop\Http\Controllers\Api;

use Illuminate\Http\Request;
use MerakiShop\Http\Controllers\Controller;
use MerakiShop\Models\User;

class UserController extends Controller
{
    public function index()
    {
        try {
            $query = User::query();

            return $query->paginate(20);
        } catch (\Throwable $th) {

        }
    }
}

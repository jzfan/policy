<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\RegistersUsers;

class ApiAuthController extends Controller
{
    use RegistersUsers;

    protected function registered(Request $request, $user)
    {
        return response()->json(['data' => $user->toArray()], 201);
    }

    protected function validator(array $data)
    {
        return \Validator::make($data, [
            'nickname' => 'required|string|max:255',
            'openid' => 'required_without:password|string|min:28',
        ]);
    }

    protected function create(array $data)
    {
        return User::create([
            'name' => $data['nickname'],
            'openid' => $data['openid'],
            'api_token' => str_random(60),
        ]);
    }
}

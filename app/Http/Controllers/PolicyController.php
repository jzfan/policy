<?php

namespace App\Http\Controllers;

use App\Policy;
use Illuminate\Http\Request;
use App\Http\Resources\PolicyResource;

class PolicyController extends Controller
{
    public function index()
    {
        //
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $data = $request->validate([
                'number' => 'required',
                'code' => 'required',
            ]);
        $policy = Policy::insure($data);
        return response()->json(['data' => $policy], 201);
    }

    public function show(Policy $policy)
    {
        //
    }

    public function edit(Policy $policy)
    {
        //
    }

    public function update(Request $request, Policy $policy)
    {
        //
    }

    public function destroy(Policy $policy)
    {
        //
    }
}

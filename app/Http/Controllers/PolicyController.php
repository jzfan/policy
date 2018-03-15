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

    public function store(Request $request, Policy $policyModel)
    {
        $data = $request->validate([
                'number' => 'required',
                'type' => 'required|in:shuang_se_qiu,san_d'
            ]);
        $policy = $policyModel->createByType($request->input());
        return response()->json(['data' => new PolicyResource($policy)], 201);
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

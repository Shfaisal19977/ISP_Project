<?php

namespace App\Http\Controllers;

use App\Models\Bundle;
use Illuminate\Http\Request;

class BundleController extends Controller
{
    // List all bundles
    public function index()
    {
        $bundles = Bundle::all();
        return response()->json($bundles);
    }

    // Show a specific bundle
    public function show($id)
    {
        $bundle = Bundle::find($id);
        if (!$bundle) {
            return response()->json(['error' => 'Bundle not found'], 404);
        }
        return response()->json($bundle);
    }

    // Create a new bundle
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'user_id' => 'required|exists:users,id',
            'bundle_type' => 'required|string',
            'price' => 'required|numeric',
            'max_speed' => 'required|integer',
            'max_bundle' => 'required|integer',
        ]);

        $bundle = Bundle::create($validatedData);
        return response()->json($bundle, 201);
    }

    // Update an existing bundle
    public function update(Request $request, $id)
    {
        $bundle = Bundle::find($id);
        if (!$bundle) {
            return response()->json(['error' => 'Bundle not found'], 404);
        }

        $validatedData = $request->validate([
            'user_id' => 'sometimes|required|exists:users,id',
            'bundle_type' => 'sometimes|required|string',
            'price' => 'sometimes|required|numeric',
            'max_speed' => 'sometimes|required|integer',
            'max_bundle' => 'sometimes|required|integer',
        ]);

        $bundle->update($validatedData);
        return response()->json($bundle);
    }

    // Delete a bundle
    public function destroy($id)
    {
        $bundle = Bundle::find($id);
        if (!$bundle) {
            return response()->json(['error' => 'Bundle not found'], 404);
        }

        $bundle->delete();
        return response()->json(['message' => 'Bundle deleted successfully']);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Developer;
use App\Models\Game;
use Illuminate\Http\Request;

class DeveloperController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    // Haal alle developers op
    public function index()
    {
        $response = [
            'success' => true,
            'data' => Developer::All()
        ];

        return response()->json($response, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Developer $developer)
    {
        $response = [
            'success' => true,
            'data' => $developer,
        ];

        return response()->json($response, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Developer $developer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Developer $developer)
    {
        //
    }
}

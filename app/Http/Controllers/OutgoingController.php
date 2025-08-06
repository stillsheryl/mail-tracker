<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOutgoingRequest;
use App\Http\Requests\UpdateOutgoingRequest;
use App\Models\Outgoing;
use App\Http\Resources\Outgoing\Outgoing as OutgoingResource;

class OutgoingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $outgoing = Outgoing::all();
        return response()->json(OutgoingResource::collection('outgoing'), 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     * POST /outgoing
     */
    public function store(StoreOutgoingRequest $request)
    {
        $validated = $request->validated();
        
        // Add the authenticated user's ID
        $validated['user_id'] = auth()->id();
        
        // Set default values for boolean fields
        $validated['thanked'] = $validated['thanked'] ?? false;
        $validated['has_been_sent'] = $validated['has_been_sent'] ?? false;

        $outgoing = Outgoing::create($validated);

        // For Inertia.js, return a redirect back to the page
        return redirect()->route('outgoing')->with('success', 'Outgoing mail created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $outgoing = Outgoing::findOrFail($id);
        return response()->json(new OutgoingResource($outgoing), 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Outgoing $outgoing)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOutgoingRequest $request, string $id)
    {
        $outgoing = Outgoing::findOrFail($id);
        $outgoing->update($request->all());
        return response()->json(new OutgoingResource($outgoing), 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $outgoing = Outgoing::findOrFail($id);
        $outgoing->delete();
        return response()->json(null, 204);
    }

    /**
     * Update the thanked status of an outgoing mail record.
     */
    public function updateThanked(Outgoing $outgoing)
    {
        // Ensure the outgoing record belongs to the authenticated user
        if ($outgoing->user_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }

        // Toggle the thanked status
        $outgoing->thanked = !$outgoing->thanked;
        $outgoing->save();

        // Return the updated record for frontend update
        return response()->json([
            'id' => $outgoing->id,
            'thanked' => $outgoing->thanked,
        ]);
    }
}

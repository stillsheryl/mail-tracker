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

        $outgoing = Outgoing::create($validated);

        return response()->json(new OutgoingResource($outgoing), 201);
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
}

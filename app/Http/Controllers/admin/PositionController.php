<?php

namespace App\Http\Controllers\admin;
use Inertia\Inertia;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Position;

class PositionController extends Controller
{
     public function index(Request $request)
    {


        return Inertia::render('Admin/user/position/Position', [
            'positions' => Position::query()->
            when($request->search,function($query) use ($request) {
                $query->where('position_name', 'like', '%' . $request->search . '%');
            })->get()
]);
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
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'position_name' => 'required|string|max:255|unique:positions,position_name',
        ]);

        Position::create([
            'position_name' => $validated['position_name'],
        ]);

        return back();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Position $position)
    {
            $validated = $request->validate([
            'position_name' => 'required|string|max:255|unique:positions,position_name',

        ]);

          $position->update($validated);

        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Position $position)
    {
    $position->delete();
    return back();
    }
}

<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Building;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BuildingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 30); // Default to 30 per page
        $search = $request->get('search', '');
        $country = $request->get('country', '');
        
        $query = Auth::user()->buildings();
        
        // Apply search filter
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('city', 'like', '%' . $search . '%')
                  ->orWhere('function', 'like', '%' . $search . '%');
            });
        }
        
        // Apply country filter
        if ($country) {
            $query->where('country', $country);
        }
        
        $buildings = $query->latest()->paginate($perPage);
        
        // Get unique countries for filter dropdown
        $countries = Auth::user()->buildings()->distinct()->pluck('country');
        
        return view('buildings.index', compact('buildings', 'search', 'country', 'countries'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('buildings.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'status' => 'required|in:Planned,Under Construction,Completed',
            'completion_year' => 'nullable|integer|min:1900|max:2100',
            'height' => 'required|string|max:50',
            'floors' => 'required|integer|min:1',
            'material' => 'required|string|max:255',
            'function' => 'required|string|max:255',
        ]);

        Auth::user()->buildings()->create($validated);

        return redirect()->route('buildings.index')
            ->with('success', 'Building created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Building $building)
    {
        // Simple ownership check
        if ($building->user_id !== Auth::id()) {
            abort(403);
        }
        return view('buildings.show', compact('building'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Building $building)
    {
        // Simple ownership check
        if ($building->user_id !== Auth::id()) {
            abort(403);
        }
        return view('buildings.edit', compact('building'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Building $building)
    {
        // Simple ownership check
        if ($building->user_id !== Auth::id()) {
            abort(403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'status' => 'required|in:Planned,Under Construction,Completed',
            'completion_year' => 'nullable|integer|min:1900|max:2100',
            'height' => 'required|string|max:50',
            'floors' => 'required|integer|min:1',
            'material' => 'required|string|max:255',
            'function' => 'required|string|max:255',
        ]);

        $building->update($validated);

        return redirect()->route('buildings.index')
            ->with('success', 'Building updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Building $building)
    {
        // Simple ownership check
        if ($building->user_id !== Auth::id()) {
            abort(403);
        }
        $building->delete();

        return redirect()->route('buildings.index')
            ->with('success', 'Building deleted successfully!');
    }
}

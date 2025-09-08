<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Building;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BuildingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 30); // Default to 30 per page
        $perPage = min($perPage, 100); // Maximum 100 per page
        
        $buildings = Building::select([
            'id', 'name', 'city', 'country', 'status', 'completion_year', 
            'height', 'floors', 'material', 'function', 'created_at', 'updated_at'
        ])
        ->orderBy('height', 'desc') // Order by height descending
        ->paginate($perPage);
        
        return response()->json([
            'success' => true,
            'data' => $buildings->items(),
            'pagination' => [
                'current_page' => $buildings->currentPage(),
                'last_page' => $buildings->lastPage(),
                'per_page' => $buildings->perPage(),
                'total' => $buildings->total(),
                'from' => $buildings->firstItem(),
                'to' => $buildings->lastItem(),
                'has_more_pages' => $buildings->hasMorePages(),
            ],
            'links' => [
                'first' => $buildings->url(1),
                'last' => $buildings->url($buildings->lastPage()),
                'prev' => $buildings->previousPageUrl(),
                'next' => $buildings->nextPageUrl(),
            ]
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'status' => 'required|in:Under Construction,Completed,Architecturally Topped Out',
            'completion_year' => 'nullable|integer|min:1900|max:2100',
            'height' => 'required|string|max:50',
            'floors' => 'required|integer|min:1',
            'material' => 'nullable|string|max:255',
            'function' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $building = Building::create([
            ...$request->all(),
            'user_id' => $request->user()->id
        ]);

        // Return building data without user information
        $building = Building::select([
            'id', 'name', 'city', 'status', 'completion_year', 
            'height', 'floors', 'material', 'function', 'created_at', 'updated_at'
        ])->find($building->id);

        return response()->json([
            'success' => true,
            'message' => 'Building created successfully',
            'data' => $building
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Building $building)
    {
        $buildingData = Building::select([
            'id', 'name', 'city', 'status', 'completion_year', 
            'height', 'floors', 'material', 'function', 'created_at', 'updated_at'
        ])->find($building->id);

        return response()->json([
            'success' => true,
            'data' => $buildingData
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Building $building)
    {
        // Check if user owns the building
        if ($building->user_id !== $request->user()->id) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 403);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|string|max:255',
            'city' => 'sometimes|string|max:255',
            'status' => 'sometimes|in:Under Construction,Completed,Architecturally Topped Out',
            'completion_year' => 'nullable|integer|min:1900|max:2100',
            'height' => 'sometimes|string|max:50',
            'floors' => 'sometimes|integer|min:1',
            'material' => 'sometimes|nullable|string|max:255',
            'function' => 'sometimes|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $building->update($request->all());

        // Return updated building data without user information
        $buildingData = Building::select([
            'id', 'name', 'city', 'status', 'completion_year', 
            'height', 'floors', 'material', 'function', 'created_at', 'updated_at'
        ])->find($building->id);

        return response()->json([
            'success' => true,
            'message' => 'Building updated successfully',
            'data' => $buildingData
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Building $building)
    {
        // Check if user owns the building
        if ($building->user_id !== $request->user()->id) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 403);
        }

        $building->delete();

        return response()->json([
            'success' => true,
            'message' => 'Building deleted successfully'
        ]);
    }

    /**
     * Get buildings by status
     */
    public function byStatus(Request $request, $status)
    {
        $perPage = $request->get('per_page', 30);
        $perPage = min($perPage, 100);
        
        $buildings = Building::select([
            'id', 'name', 'city', 'status', 'completion_year', 
            'height', 'floors', 'material', 'function', 'created_at', 'updated_at'
        ])
        ->where('status', $status)
        ->orderBy('height', 'desc')
        ->paginate($perPage);
        
        return response()->json([
            'success' => true,
            'data' => $buildings->items(),
            'pagination' => [
                'current_page' => $buildings->currentPage(),
                'last_page' => $buildings->lastPage(),
                'per_page' => $buildings->perPage(),
                'total' => $buildings->total(),
                'from' => $buildings->firstItem(),
                'to' => $buildings->lastItem(),
                'has_more_pages' => $buildings->hasMorePages(),
            ]
        ]);
    }

    /**
     * Get buildings by city
     */
    public function byCity(Request $request, $city)
    {
        $perPage = $request->get('per_page', 30);
        $perPage = min($perPage, 100);
        
        $buildings = Building::select([
            'id', 'name', 'city', 'status', 'completion_year', 
            'height', 'floors', 'material', 'function', 'created_at', 'updated_at'
        ])
        ->where('city', 'like', '%' . $city . '%')
        ->orderBy('height', 'desc')
        ->paginate($perPage);
        
        return response()->json([
            'success' => true,
            'data' => $buildings->items(),
            'pagination' => [
                'current_page' => $buildings->currentPage(),
                'last_page' => $buildings->lastPage(),
                'per_page' => $buildings->perPage(),
                'total' => $buildings->total(),
                'from' => $buildings->firstItem(),
                'to' => $buildings->lastItem(),
                'has_more_pages' => $buildings->hasMorePages(),
            ]
        ]);
    }

    /**
     * Search buildings
     */
    public function search(Request $request)
    {
        $query = $request->get('q', '');
        $perPage = $request->get('per_page', 30);
        $perPage = min($perPage, 100);
        
        $buildings = Building::select([
            'id', 'name', 'city', 'status', 'completion_year', 
            'height', 'floors', 'material', 'function', 'created_at', 'updated_at'
        ])
        ->where(function($q) use ($query) {
            $q->where('name', 'like', '%' . $query . '%')
              ->orWhere('city', 'like', '%' . $query . '%')
              ->orWhere('function', 'like', '%' . $query . '%');
        })
        ->orderBy('height', 'desc')
        ->paginate($perPage);
        
        return response()->json([
            'success' => true,
            'data' => $buildings->items(),
            'search_query' => $query,
            'pagination' => [
                'current_page' => $buildings->currentPage(),
                'last_page' => $buildings->lastPage(),
                'per_page' => $buildings->perPage(),
                'total' => $buildings->total(),
                'from' => $buildings->firstItem(),
                'to' => $buildings->lastItem(),
                'has_more_pages' => $buildings->hasMorePages(),
            ]
        ]);
    }
}

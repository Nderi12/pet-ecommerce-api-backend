<?php

namespace App\Http\Controllers;

use App\Http\Requests\BrandRequest;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class BrandController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     * @author Nderi Kamau <nderikamau1212@gmail.com>
     */
    public function __construct() {
        // Functions inside the authentication controller can not be accessed without having the valid token.
        $this->middleware('jwt');
    }
    
    /**
     * Display a listing of the resource.
     * 
     * @author Nderi Kamau <nderikamau1212@gmail.com>
     */
    public function index()
    {
        $brands = Brand::all();

        if (!$brands) {
            return response()->json([
                'error' => 'Brands not found'
            ], Response::HTTP_NOT_FOUND);
        }

        // Return response with message and data
        return response()->json([
            'brands' => $brands
        ], Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     * 
     * @author Nderi Kamau <nderikamau1212@gmail.com>
     */
    public function store(BrandRequest $request)
    {
        // Get the data from the request
        $data = $request->validated();

        // Create an empty brand
        $brand = Brand::make();

        DB::transaction(function () use ($data, $brand) {
            // create a new brand from the validated data
            $brand->create($data);
        });

        // Return response with message and data
        return response()->json([
            'message' => 'Brand created successfully!'
        ], Response::HTTP_CREATED); // 201 response for created
    }

    /**
     * Display the specified resource.
     * 
     * @author Nderi Kamau <nderikamau1212@gmail.com>
     */
    public function show($uuid)
    {
        $brand = Brand::where('uuid', $uuid)->first();

        if (!$brand) {
            return response()->json([
                'error' => 'Brand not found'
            ], Response::HTTP_NOT_FOUND);
        }

        return response()->json([
            'brand' => $brand
        ], Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     * 
     * @author Nderi Kamau <nderikamau1212@gmail.com>
     */
    public function update(BrandRequest $request, $uuid)
    {
        $brand = Brand::where('uuid', $uuid)->first();

        if (!$brand) {
            return response()->json([
                'error' => 'Brand not found'
            ], Response::HTTP_NOT_FOUND);
        }

        //validate data
        $data = $request->validated();

        // Update the $brand data
        $brand->update($data);

        //Return response with message and data
        return response()->json([
            'success' => 'Brand updated successfully!'
        ], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     * 
     * @author Nderi Kamau <nderikamau1212@gmail.com>
     */
    public function destroy($uuid)
    {
        $brand = Brand::where('uuid', $uuid)->first();

        if (!$brand) {
            return response()->json([
                'error' => 'Brand not found'
            ], Response::HTTP_NOT_FOUND);
        }

        //  Delete the brand
        $brand->delete();

        // Return response with message
        return response()->json([
            'success' => 'Brand deleted successfully!'
        ], Response::HTTP_OK);
    }
}
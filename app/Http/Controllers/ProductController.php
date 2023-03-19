<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     * @author Nderi Kamau <nderikamau1212@gmail.com>
     */
    public function __construct() {
        // Functions inside the authentication controller can not be accessed without having the valid token.
        // $this->middleware('auth:api');
    }
    
    /**
     * Display a listing of the resource.
     * 
     * @author Nderi Kamau <nderikamau1212@gmail.com>
     */
    public function index()
    {
        $products = Product::all();

        // Return response with message and data
        return response()->json([
            'message' => 'Products list',
            'products' => $products
        ], Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     * 
     * @author Nderi Kamau <nderikamau1212@gmail.com>
     */
    public function store(ProductRequest $request)
    {
        // Get the data from the request
        $data = $request->validated();

        // Create an empty product
        $product = Product::make();

        DB::transaction(function () use($data, $product) {
           // create a new product from the validated data
           $product->create($data);
        });


        // Return response with message and data
        return response()->json([
            'message' => 'Product created successfully!',
            'product' => $product
        ], Response::HTTP_CREATED); // 201 response for created
    }

    /**
     * Display the specified resource.
     * 
     * @author Nderi Kamau <nderikamau1212@gmail.com>
     */
    public function show($uuid)
    {
        $product = Product::where('uuid', $uuid)->first();

        return response()->json([
            'product' => $product
        ], Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     * 
     * @author Nderi Kamau <nderikamau1212@gmail.com>
     */
    public function update(ProductRequest $request, $uuid)
    {
        dd($uuid);
        $product = Product::where('uuid', $uuid)->first();

        //validate data
        $data = $request->validated();

        // Update the product data
        $product->update($data);

        // Return response with message and data
        return response()->json([
            'success' => 'Product updated successfully!',
            'product' => $product
        ], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     * 
     * @author Nderi Kamau <nderikamau1212@gmail.com>
     */
    public function destroy(Product $product)
    {
        // Delete the product
        $product->delete();

        // Return response with message
        return redirect()->back()->with([
            'success' => 'Product deleted successfully!'
        ], Response::HTTP_OK);
    }
}

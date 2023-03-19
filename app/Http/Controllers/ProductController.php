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
     * @OA\Get(
     *     path="/products",
     *     summary="Get a list of products",
     *     tags={"Products"},
     *     @OA\Response(
     *         response="200",
     *         description="List of products",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Products list"
     *             ),
     *             @OA\Property(
     *                 property="products",
     *                 type="array",
     *                 @OA\Items(ref="#/components/schemas/Product")
     *             )
     *         )
     *     )
     * )
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
     * @OA\Post(
     *     path="/api/products",
     *     summary="Create a new product",
     *     description="Create a new product with the given data",
     *     tags={"Products"},
     *     @OA\RequestBody(
     *         required=true,
     *         description="Data for the new product",
     *         @OA\JsonContent(ref="#/components/schemas/ProductRequest")
     *     ),
     *     @OA\Response(
     *         response="201",
     *         description="Product created successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Product created successfully!"),
     *             @OA\Property(property="product", ref="#/components/schemas/Product")
     *         )
     *     ),
     *     @OA\Response(
     *         response="422",
     *         description="Validation error",
     *         @OA\JsonContent(ref="#/components/schemas/ErrorResponse")
     *     )
     * )
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
     * @OA\Get(
     *     path="/api/products/{uuid}",
     *     summary="Get product details",
     *     description="Get details of the product with the given UUID",
     *     tags={"Products"},
     *     @OA\Parameter(
     *         name="uuid",
     *         in="path",
     *         description="UUID of the product",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Product details retrieved successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="product", ref="#/components/schemas/Product")
     *         )
     *     ),
     *     @OA\Response(
     *         response="404",
     *         description="Product not found",
     *         @OA\JsonContent(ref="#/components/schemas/ErrorResponse")
     *     )
     * )
     */
    public function show($uuid)
    {
        $product = Product::where('uuid', $uuid)->first();

        return response()->json([
            'product' => $product
        ], Response::HTTP_OK);
    }

    /**
     * Update a product with the given UUID.
     *
     * @OA\Put(
     *     path="/products/{uuid}",
     *     summary="Update a product",
     *     tags={"Products"},
     *     @OA\Parameter(
     *         name="uuid",
     *         in="path",
     *         description="The UUID of the product to update",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *             format="uuid"
     *         )
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         description="The data to update the product with",
     *         @OA\JsonContent(ref="#/components/schemas/ProductRequest")
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Product updated successfully",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="success",
     *                 type="string",
     *                 example="Product updated successfully!"
     *             ),
     *             @OA\Property(
     *                 property="product",
     *                 ref="#/components/schemas/Product"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response="404",
     *         description="Product not found",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="error",
     *                 type="string",
     *                 example="Product not found"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response="422",
     *         description="Unprocessable Entity",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="error",
     *                 type="string",
     *                 example="The given data was invalid"
     *             ),
     *             @OA\Property(
     *                 property="errors",
     *                 type="object",
     *                 ref="#/components/schemas/ValidationErrors"
     *             )
     *         )
     *     )
     * )
     */
    public function update(ProductRequest $request, $uuid)
    {
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
     * @OA\Delete(
     *     path="/api/products/{uuid}",
     *     summary="Delete a product by UUID",
     *     description="Delete a product by its UUID.",
     *     operationId="deleteProductByUUID",
     *     tags={"Products"},
     *     @OA\Parameter(
     *         name="uuid",
     *         in="path",
     *         description="UUID of the product to delete",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Product deleted successfully",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="success",
     *                 type="string",
     *                 example="Product deleted successfully!"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response="404",
     *         description="Product not found",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="error",
     *                 type="string",
     *                 example="Product not found"
     *             )
     *         )
     *     )
     * )
     */
    public function destroy($uuid)
    {
        $product = Product::where('uuid', $uuid)->first();

        if (!$product) {
            return response()->json([
                'error' => 'Product not found'
            ], Response::HTTP_NOT_FOUND);
        }

        // Delete the product
        $product->delete();

        // Return response with message
        return response()->json([
            'success' => 'Product deleted successfully!'
        ], Response::HTTP_OK);
    }
}

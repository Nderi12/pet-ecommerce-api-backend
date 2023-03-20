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
    public function __construct()
    {
        // Functions inside the authentication controller can not be accessed without having the valid token.
        $this->middleware('jwt');
    }

    /**
     * @OA\Get(
     *      path="/api/v1/products",
     *      operationId="getProductsList",
     *      summary="Get list of Products",
     *      description="Returns list of products",
     *      tags={"Products"},
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *      	  @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  property="products",
     *                  collectionFormat="multi"
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Products not found"
     *      )
     * )
     */
    public function index()
    {
        $products = Product::all();

        if (!$products) {
            return response()->json([
                'error' => 'Products not found'
            ], Response::HTTP_NOT_FOUND);
        }

        // Return response with message and data
        return response()->json([
            'products' => $products
        ], Response::HTTP_OK);
    }

    /**
     * @OA\Post(
     *     path="/api/v1/product/create",
     *     summary="Create a new product",
     *     tags={"Products"},
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="slug",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="title",
     *                     oneOf={
     *                     	   @OA\Schema(type="string"),
     *                     	   @OA\Schema(type="integer"),
     *                     }
     *                 ),
     *                 @OA\Property(
     *                     property="content",
     *                     oneOf={
     *                     	   @OA\Schema(type="string"),
     *                     	   @OA\Schema(type="integer"),
     *                     }
     *                 ),
     *                 @OA\Property(
     *                     property="metadata",
     *                     oneOf={
     *                     	   @OA\Schema(type="json"),
     *                     	   @OA\Schema(type="integer"),
     *                     }
     *                 ),
     *                 example={"slug": "product-slug", "title": "Product Title", "content": "Product Content", "metadata": {"brand": "UUID from petshop.brands","image": "UUID from petshop.files"
}}
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response="201",
     *         description="Product created successfully",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 description="A message indicating that the product was created successfully."
     *             )
     *         )
     *     )
     * )
     */
    public function store(ProductRequest $request)
    {
        // Get the data from the request
        $data = $request->validated();

        // Create an empty product
        $product = Product::make();

        DB::transaction(function () use ($data, $product) {
            // create a new product from the validated data
            $product->create($data);
        });

        // Return response with message and data
        return response()->json([
            'message' => 'Product created successfully!'
        ], Response::HTTP_CREATED); // 201 response for created
    }

    /**
     * @OA\Get(
     *     path="/api/v1/product/{uuid}",
     *     summary="Get a single product by UUID",
     *     tags={"Products"},
     *     @OA\Parameter(
     *         name="uuid",
     *         in="path",
     *         description="UUID of the product to get",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *             format="uuid"
     *         )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="product"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response="404",
     *         description="Product not found"
     *     )
     * )
     */
    public function show($uuid)
    {
        $product = Product::where('uuid', $uuid)->with(['category'])->first();

        if (!$product) {
            return response()->json([
                'error' => 'Product not found'
            ], Response::HTTP_NOT_FOUND);
        }

        return response()->json([
            'product' => $product
        ], Response::HTTP_OK);
    }

    /**
     * @OA\Put(
     *     path="/api/v1/product/{uuid}",
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
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="slug",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="title",
     *                     oneOf={
     *                     	   @OA\Schema(type="string"),
     *                     	   @OA\Schema(type="integer"),
     *                     }
     *                 ),
     *                 @OA\Property(
     *                     property="content",
     *                     oneOf={
     *                     	   @OA\Schema(type="string"),
     *                     	   @OA\Schema(type="integer"),
     *                     }
     *                 ),
     *                 @OA\Property(
     *                     property="metadata",
     *                     oneOf={
     *                     	   @OA\Schema(type="json"),
     *                     	   @OA\Schema(type="integer"),
     *                     }
     *                 ),
     *                 example={"slug": "product-slug", "title": "Product Title", "content": "Product Content", "metadata": {"brand": "UUID from petshop.brands","image": "UUID from petshop.files"
}}
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Product updated successfully"
     *     ),
     *     @OA\Response(
     *         response="404",
     *         description="Product not found"
     *     )
     * )
     */
    public function update(ProductRequest $request, $uuid)
    {
        $product = Product::where('uuid', $uuid)->first();

        if (!$product) {
            return response()->json([
                'error' => 'Product not found'
            ], Response::HTTP_NOT_FOUND);
        }

        //validate data
        $data = $request->validated();

        // Update the product data
        $product->update($request->all());

        //Return response with message and data
        return response()->json([
            'success' => 'Product updated successfully!'
        ], Response::HTTP_OK);
    }

    /**
     * @OA\Delete(
     *     path="/api/v1/product/{uuid}",
     *     summary="Delete a product",
     *     tags={"Products"},
     *     @OA\Parameter(
     *         name="uuid",
     *         in="path",
     *         description="The UUID of the product to delete",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *             format="uuid"
     *         )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Product deleted successfully"
     *     ),
     *     @OA\Response(
     *         response="404",
     *         description="Product not found"
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

        //  Delete the product
        $product->delete();

        // Return response with message
        return response()->json([
            'success' => 'Product deleted successfully!'
        ], Response::HTTP_OK);
    }
}

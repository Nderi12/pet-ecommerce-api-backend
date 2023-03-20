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
     * @OA\Get(
     *      path="/api/v1/brands",
     *      operationId="getBrandsList",
     *      summary="Get list of Brands",
     *      description="Returns list of brands",
     *      tags={"Brands"},
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *      	  @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  property="brands",
     *                  collectionFormat="multi"
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Brands not found"
     *      )
     * )
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
     * @OA\Post(
     *     path="/api/v1/brand/create",
     *     summary="Create a new brand",
     *     tags={"Brands"},
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
     *                 example={"slug": "brand-slug", "title": "Brand Title"}
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response="201",
     *         description="Brand created successfully",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 description="A message indicating that the brand was created successfully."
     *             )
     *         )
     *     )
     * )
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
     * @OA\Get(
     *     path="/api/v1/brand/{uuid}",
     *     summary="Get a single brand by UUID",
     *     tags={"Brands"},
     *     @OA\Parameter(
     *         name="uuid",
     *         in="path",
     *         description="UUID of the brand to get",
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
     *                 property="brand"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response="404",
     *         description="Brand not found"
     *     )
     * )
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
     * @OA\Put(
     *     path="/api/v1/brand/{uuid}",
     *     summary="Update a brand",
     *     tags={"Brands"},
     *     @OA\Parameter(
     *         name="uuid",
     *         in="path",
     *         description="The UUID of the brand to update",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *             format="uuid"
     *         )
     *     ),
     *     @OA\RequestBody(
     *         required=true
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Brand updated successfully"
     *     ),
     *     @OA\Response(
     *         response="404",
     *         description="Brand not found"
     *     )
     * )
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
     * @OA\Delete(
     *     path="/api/v1/brand/{uuid}",
     *     summary="Delete a brand",
     *     tags={"Brands"},
     *     @OA\Parameter(
     *         name="uuid",
     *         in="path",
     *         description="The UUID of the brand to delete",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *             format="uuid"
     *         )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Brand deleted successfully"
     *     ),
     *     @OA\Response(
     *         response="404",
     *         description="Brand not found"
     *     )
     * )
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
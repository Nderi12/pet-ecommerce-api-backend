<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
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
        // $this->middleware('auth:api');
    }

    /**
     * @OA\Get(
     *     path="/categories",
     *     summary="Get all categories",
     *     tags={"Categories"},
     *     @OA\Response(
     *         response="200",
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="categories",
     *                 type="array",
     *                 @OA\Items(ref="#/components/schemas/Category")
     *             )
     *         )
     *     )
     * )
     */
    public function index()
    {
        $categories = Category::all();

        // Return response with message and data
        return response()->json([
            'categories' => $categories
        ], Response::HTTP_OK);
    }

    /**
     * @OA\Post(
     *     path="/categories",
     *     summary="Create a new category",
     *     tags={"Categories"},
     *     @OA\RequestBody(
     *         required=true,
     *         description="Category object that needs to be created",
     *         @OA\JsonContent(ref="#/components/schemas/CategoryRequest")
     *     ),
     *     @OA\Response(
     *         response="201",
     *         description="Category created successfully",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 description="A message indicating that the category was created successfully."
     *             )
     *         )
     *     )
     * )
     */
    public function store(CategoryRequest $request)
    {
        // Get the data from the request
        $data = $request->validated();

        // Create an empty category
        $category = Category::make();

        DB::transaction(function () use ($data, $category) {
            // create a new category from the validated data
            $category->create($data);
        });

        // Return response with message and data
        return response()->json([
            'message' => 'Category created successfully!'
        ], Response::HTTP_CREATED); // 201 response for created
    }

    /**
     * @OA\Get(
     *     path="/categories/{uuid}",
     *     summary="Get a single category by UUID",
     *     tags={"Categories"},
     *     @OA\Parameter(
     *         name="uuid",
     *         in="path",
     *         description="UUID of the category to get",
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
     *                 property="category",
     *                 ref="#/components/schemas/Category"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response="404",
     *         description="Category not found"
     *     )
     * )
     */
    public function show($uuid)
    {
        $category = Category::where('uuid', $uuid)->first();

        return response()->json([
            'category' => $category
        ], Response::HTTP_OK);
    }

    /**
     * @OA\Put(
     *     path="/categories/{uuid}",
     *     summary="Update a category",
     *     tags={"Categories"},
     *     @OA\Parameter(
     *         name="uuid",
     *         in="path",
     *         description="The UUID of the category to update",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *             format="uuid"
     *         )
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/CategoryRequest")
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Category updated successfully"
     *     ),
     *     @OA\Response(
     *         response="404",
     *         description="Category not found"
     *     )
     * )
     */
    public function update(CategoryRequest $request, $uuid)
    {
        $category = Category::where('uuid', $uuid)->first();

        //validate data
        $data = $request->validated();

        // Update the category data
        $category->update($data);

        //Return response with message and data
        return response()->json([
            'success' => 'Category updated successfully!'
        ], Response::HTTP_OK);
    }

    /**
     * @OA\Delete(
     *     path="/categories/{uuid}",
     *     summary="Delete a category",
     *     tags={"Categories"},
     *     @OA\Parameter(
     *         name="uuid",
     *         in="path",
     *         description="The UUID of the category to delete",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *             format="uuid"
     *         )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Category deleted successfully"
     *     ),
     *     @OA\Response(
     *         response="404",
     *         description="Category not found"
     *     )
     * )
     */
    public function destroy($uuid)
    {
        $category = Category::where('uuid', $uuid)->first();

        //  Delete the category
        $category->delete();

        // Return response with message
        return response()->json([
            'success' => 'Category deleted successfully!'
        ], Response::HTTP_OK);
    }
}

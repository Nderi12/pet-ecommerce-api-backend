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
    public function __construct() {
        // Functions inside the authentication controller can not be accessed without having the valid token.
        $this->middleware('auth:api');
    }
    
    /**
     * Display a listing of the resource.
     * 
     * @author Nderi Kamau <nderikamau1212@gmail.com>
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
     * Store a newly created resource in storage.
     * 
     * @author Nderi Kamau <nderikamau1212@gmail.com>
     */
    public function store(CategoryRequest $request)
    {
        // Get the data from the request
        $data = $request->validated();

        // Create an empty category
        $category = Category::make();

        DB::transaction(function () use($data, $category) {
           // create a new category from the validated data
           $category->create($data);
        });

        // Return response with message and data
        return response()->json([
            'message' => 'Category created successfully!',
            'category' => $category
        ], Response::HTTP_CREATED); // 201 response for created
    }

    /**
     * Display the specified resource.
     * 
     * @author Nderi Kamau <nderikamau1212@gmail.com>
     */
    public function show(Category $category)
    {
        return response()->json([
            'category' => $category
        ], Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     * 
     * @author Nderi Kamau <nderikamau1212@gmail.com>
     */
    public function update(CategoryRequest $request, Category $category)
    {
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
     * Remove the specified resource from storage.
     * 
     * @author Nderi Kamau <nderikamau1212@gmail.com>
     */
    public function destroy(Category $category)
    {
        //  Delete the category
        $category->delete();

        // Return response with message
        return redirect()->back()->with([
            'success' => 'Category deleted successfully!'
        ], Response::HTTP_OK);
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\BlogRequest;
use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class BlogController extends Controller
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
     *      path="/api/v1/main/blogs",
     *      operationId="getBlogsList",
     *      summary="Get list of Blogs",
     *      description="Returns list of blogs",
     *      tags={"Blogs"},
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *      	  @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  property="blogs",
     *                  collectionFormat="multi"
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Blogs not found"
     *      )
     * )
     */
    public function index()
    {
        $blogs = Blog::all();

        if (!$blogs) {
            return response()->json([
                'error' => 'Blogs not found'
            ], Response::HTTP_NOT_FOUND);
        }

        // Return response with message and data
        return response()->json([
            'blogs' => $blogs
        ], Response::HTTP_OK);
    }

    /**
     * @OA\Post(
     *     path="/api/v1/main/blog/create",
     *     summary="Create a new blog",
     *     tags={"Blogs"},
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
     *                 example={"slug": "blog-slug", "title": "Blog Title", "content": "Blog Content", "metadata": {"author": "string","image": "UUID from petshop.files"}}
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response="201",
     *         description="Blog created successfully",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 description="A message indicating that the blog was created successfully."
     *             )
     *         )
     *     )
     * )
     */
    public function store(BlogRequest $request)
    {
        // Get the data from the request
        $data = $request->validated();

        // Create an empty blog
        $blog = Blog::make();

        DB::transaction(function () use ($data, $blog) {
            // create a new blog from the validated data
            $blog->create($data);
        });

        // Return response with message and data
        return response()->json([
            'message' => 'Blog created successfully!'
        ], Response::HTTP_CREATED); // 201 response for created
    }

    /**
     * @OA\Get(
     *     path="/api/v1/blog/{uuid}",
     *     summary="Get a single blog by UUID",
     *     tags={"Blogs"},
     *     @OA\Parameter(
     *         name="uuid",
     *         in="path",
     *         description="UUID of the blog to get",
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
     *                 property="blog"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response="404",
     *         description="Blog not found"
     *     )
     * )
     */
    public function show($uuid)
    {
        $blog = Blog::where('uuid', $uuid)->first();

        if (!$blog) {
            return response()->json([
                'error' => 'Blog not found'
            ], Response::HTTP_NOT_FOUND);
        }

        return response()->json([
            'blog' => $blog
        ], Response::HTTP_OK);
    }

    /**
     * @OA\Put(
     *     path="/api/v1/blog/{uuid}",
     *     summary="Update a blog",
     *     tags={"Blogs"},
     *     @OA\Parameter(
     *         name="uuid",
     *         in="path",
     *         description="The UUID of the blog to update",
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
     *                 example={"slug": "blog-slug", "title": "Blog Title", "content": "Blog Content", "metadata": {"author": "string","image": "UUID from petshop.files"}}
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Blog updated successfully"
     *     ),
     *     @OA\Response(
     *         response="404",
     *         description="Blog not found"
     *     )
     * )
     */
    public function update(BlogRequest $request, $uuid)
    {
        $blog = Blog::where('uuid', $uuid)->first();

        if (!$blog) {
            return response()->json([
                'error' => 'Blog not found'
            ], Response::HTTP_NOT_FOUND);
        }

        //validate data
        $data = $request->validated();

        // Update the blog data
        $blog->update($data);

        //Return response with message and data
        return response()->json([
            'success' => 'Blog updated successfully!'
        ], Response::HTTP_OK);
    }

    /**
     * @OA\Delete(
     *     path="/api/v1/blog/{uuid}",
     *     summary="Delete a blog",
     *     tags={"Blogs"},
     *     @OA\Parameter(
     *         name="uuid",
     *         in="path",
     *         description="The UUID of the blog to delete",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *             format="uuid"
     *         )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Blog deleted successfully"
     *     ),
     *     @OA\Response(
     *         response="404",
     *         description="Blog not found"
     *     )
     * )
     */
    public function destroy($uuid)
    {
        $blog = Blog::where('uuid', $uuid)->first();

        if (!$blog) {
            return response()->json([
                'error' => 'Blog not found'
            ], Response::HTTP_NOT_FOUND);
        }

        //  Delete the blog
        $blog->delete();

        // Return response with message
        return response()->json([
            'success' => 'Blog deleted successfully!'
        ], Response::HTTP_OK);
    }
}

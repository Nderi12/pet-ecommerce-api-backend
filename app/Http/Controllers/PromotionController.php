<?php

namespace App\Http\Controllers;

use App\Http\Requests\PromotionRequest;
use App\Models\Promotion;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class PromotionController extends Controller
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
     *      path="/api/promotions",
     *      operationId="getPromotionsList",
     *      summary="Get list of Promotions",
     *      description="Returns list of promotions",
     *      tags={"Promotions"},
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *      	  @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  property="promotions",
     *                  collectionFormat="multi"
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Promotions not found"
     *      )
     * )
     */
    public function index()
    {
        $promotions = Promotion::all();

        if (!$promotions) {
            return response()->json([
                'error' => 'Promotions not found'
            ], Response::HTTP_NOT_FOUND);
        }

        // Return response with message and data
        return response()->json([
            'promotions' => $promotions
        ], Response::HTTP_OK);
    }

    /**
     * @OA\Post(
     *     path="/promotions",
     *     summary="Create a new promotion",
     *     tags={"Promotions"},
     *     @OA\RequestBody(
     *         required=true,
     *         description="Promotion object that needs to be created"
     *     ),
     *     @OA\Response(
     *         response="201",
     *         description="Promotion created successfully",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 description="A message indicating that the promotion was created successfully."
     *             )
     *         )
     *     )
     * )
     */
    public function store(PromotionRequest $request)
    {
        // Get the data from the request
        $data = $request->validated();

        // Create an empty promotion
        $promotion = Promotion::make();

        DB::transaction(function () use ($data, $promotion) {
            // create a new promotion from the validated data
            $promotion->create($data);
        });

        // Return response with message and data
        return response()->json([
            'message' => 'Promotion created successfully!'
        ], Response::HTTP_CREATED); // 201 response for created
    }

    /**
     * @OA\Get(
     *     path="/promotions/{uuid}",
     *     summary="Get a single promotion by UUID",
     *     tags={"Promotions"},
     *     @OA\Parameter(
     *         name="uuid",
     *         in="path",
     *         description="UUID of the promotion to get",
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
     *                 property="promotion"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response="404",
     *         description="Promotion not found"
     *     )
     * )
     */
    public function show($uuid)
    {
        $promotion = Promotion::where('uuid', $uuid)->first();

        if (!$promotion) {
            return response()->json([
                'error' => 'Promotion not found'
            ], Response::HTTP_NOT_FOUND);
        }

        return response()->json([
            'promotion' => $promotion
        ], Response::HTTP_OK);
    }

    /**
     * @OA\Put(
     *     path="/promotions/{uuid}",
     *     summary="Update a promotion",
     *     tags={"Promotions"},
     *     @OA\Parameter(
     *         name="uuid",
     *         in="path",
     *         description="The UUID of the promotion to update",
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
     *         description="Promotion updated successfully"
     *     ),
     *     @OA\Response(
     *         response="404",
     *         description="Promotion not found"
     *     )
     * )
     */
    public function update(PromotionRequest $request, $uuid)
    {
        $promotion = Promotion::where('uuid', $uuid)->first();

        if (!$promotion) {
            return response()->json([
                'error' => 'Promotion not found'
            ], Response::HTTP_NOT_FOUND);
        }

        //validate data
        $data = $request->validated();

        // Update the promotion data
        $promotion->update($data);

        //Return response with message and data
        return response()->json([
            'success' => 'Promotion updated successfully!'
        ], Response::HTTP_OK);
    }

    /**
     * @OA\Delete(
     *     path="/promotions/{uuid}",
     *     summary="Delete a promotion",
     *     tags={"Promotions"},
     *     @OA\Parameter(
     *         name="uuid",
     *         in="path",
     *         description="The UUID of the promotion to delete",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *             format="uuid"
     *         )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Promotion deleted successfully"
     *     ),
     *     @OA\Response(
     *         response="404",
     *         description="Promotion not found"
     *     )
     * )
     */
    public function destroy($uuid)
    {
        $promotion = Promotion::where('uuid', $uuid)->first();

        if (!$promotion) {
            return response()->json([
                'error' => 'Promotion not found'
            ], Response::HTTP_NOT_FOUND);
        }

        //  Delete the promotion
        $promotion->delete();

        // Return response with message
        return response()->json([
            'success' => 'Promotion deleted successfully!'
        ], Response::HTTP_OK);
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderStatusRequest;
use App\Models\OrderStatus;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class OrderStatusController extends Controller
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
     *      path="/api/v1/orderStatuses",
     *      operationId="getOrderStatusesList",
     *      summary="Get list of OrderStatuses",
     *      description="Returns list of orderStatuses",
     *      tags={"OrderStatuses"},
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *      	  @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  property="orderStatuses",
     *                  collectionFormat="multi"
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="OrderStatuses not found"
     *      )
     * )
     */
    public function index()
    {
        $orderStatuses = OrderStatus::all();

        if (!$orderStatuses) {
            return response()->json([
                'error' => 'Order statuses not found'
            ], Response::HTTP_NOT_FOUND);
        }

        // Return response with message and data
        return response()->json([
            'message' => 'Order statuses list',
            'orderStatuses' => $orderStatuses
        ], Response::HTTP_OK);
    }

    /**
     * @OA\Post(
     *     path="/api/v1/orderStatus/create",
     *     summary="Create a new orderStatus",
     *     tags={"OrderStatuses"},
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="title",
     *                     oneOf={
     *                     	   @OA\Schema(type="string"),
     *                     	   @OA\Schema(type="integer"),
     *                     }
     *                 ),
     *                 example={"title": "OrderStatus Title"}
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response="201",
     *         description="OrderStatus created successfully",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 description="A message indicating that the orderStatus was created successfully."
     *             )
     *         )
     *     )
     * )
     */
    public function store(OrderStatusRequest $request)
    {
        // Get the data from the request
        $data = $request->validated();

        // Create an empty order
        $orderStatus = OrderStatus::make();

        DB::transaction(function () use($data, $orderStatus) {
           // create a new order status from the validated data
           $orderStatus->create($data);
        });

        // Return response with message and data
        return response()->json([
            'message' => 'Order status created successfully!'
        ], Response::HTTP_CREATED); // 201 response for created
    }

    /**
     * @OA\Get(
     *     path="/api/v1/orderStatus/{uuid}",
     *     summary="Get a single orderStatus by UUID",
     *     tags={"OrderStatuses"},
     *     @OA\Parameter(
     *         name="uuid",
     *         in="path",
     *         description="UUID of the orderStatus to get",
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
     *                 property="orderStatus"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response="404",
     *         description="OrderStatus not found"
     *     )
     * )
     */
    public function show($uuid)
    {
        $orderStatus = OrderStatus::where('uuid', $uuid)->first();

        if (!$orderStatus) {
            return response()->json([
                'error' => 'Order status not found'
            ], Response::HTTP_NOT_FOUND);
        }

        return response()->json([
            'orderStatus' => $orderStatus
        ], Response::HTTP_OK);
    }

    /**
     * @OA\Put(
     *     path="/api/v1/orderStatus/{uuid}",
     *     summary="Update a orderStatus",
     *     tags={"OrderStatuses"},
     *     @OA\Parameter(
     *         name="uuid",
     *         in="path",
     *         description="The UUID of the orderStatus to update",
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
     *                     property="title",
     *                     oneOf={
     *                     	   @OA\Schema(type="string"),
     *                     	   @OA\Schema(type="integer"),
     *                     }
     *                 ),
     *                 example={"title": "OrderStatus Title"}
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="OrderStatus updated successfully"
     *     ),
     *     @OA\Response(
     *         response="404",
     *         description="OrderStatus not found"
     *     )
     * )
     */
    public function update(OrderStatusRequest $request, $uuid)
    {
        $orderStatus = OrderStatus::where('uuid', $uuid)->first();

        //validate data
        $data = $request->validated();

        // Update the order status data
        $orderStatus->update($data);

        // Return response with message and data
        return response()->json([
            'success' => 'Order status updated successfully!'
        ], Response::HTTP_OK);
    }

    /**
     * @OA\Delete(
     *     path="/api/v1/orderStatus/{uuid}",
     *     summary="Delete a orderStatus",
     *     tags={"OrderStatuses"},
     *     @OA\Parameter(
     *         name="uuid",
     *         in="path",
     *         description="The UUID of the orderStatus to delete",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *             format="uuid"
     *         )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="OrderStatus deleted successfully"
     *     ),
     *     @OA\Response(
     *         response="404",
     *         description="OrderStatus not found"
     *     )
     * )
     */
    public function destroy($uuid)
    {
        $orderStatus = OrderStatus::where('uuid', $uuid)->first();

        if (!$orderStatus) {
            return response()->json([
                'error' => 'Order status not found'
            ], Response::HTTP_NOT_FOUND);
        }

        // Delete the order status
        $orderStatus->delete();

        // Return response with message
        return response()->json([
            'success' => 'Order status deleted successfully!'
        ], Response::HTTP_OK);
    }
}

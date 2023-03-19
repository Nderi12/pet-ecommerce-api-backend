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
        // $this->middleware('auth:api');
    }
    
    /**
     * @OA\Get(
     *     path="/api/order-statuses",
     *     summary="Get all order statuses",
     *     description="Retrieve a list of all available order statuses.",
     *     tags={"Order Statuses"},
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Order statuses list"
     *             ),
     *             @OA\Property(
     *                 property="orderStatuses",
     *                 type="array",
     *                 @OA\Items(ref="#/components/schemas/OrderStatus")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Order statuses not found",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="error",
     *                 type="string",
     *                 example="Order statuses not found"
     *             )
     *         )
     *     )
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
     *     path="/api/order-statuses",
     *     summary="Create a new order status",
     *     description="Create a new order status from the given data.",
     *     tags={"Order Statuses"},
     *     @OA\RequestBody(
     *         required=true,
     *         description="Data for creating a new order status",
     *         @OA\JsonContent(ref="#/components/schemas/OrderStatusRequest")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Order status created successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Order status created successfully!"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation errors",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="The given data was invalid."
     *             ),
     *             @OA\Property(
     *                 property="errors",
     *                 type="object",
     *                 ref="#/components/schemas/OrderStatusValidationErrors"
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
     *     path="/api/order-statuses/{uuid}",
     *     summary="Get a single order status",
     *     description="Retrieve a single order status by its UUID.",
     *     tags={"Order Statuses"},
     *     @OA\Parameter(
     *         name="uuid",
     *         in="path",
     *         description="UUID of the order status",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="orderStatus",
     *                 ref="#/components/schemas/OrderStatus"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Order status not found",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="error",
     *                 type="string",
     *                 example="Order status not found"
     *             )
     *         )
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
     *     path="/api/order-statuses/{uuid}",
     *     summary="Update an existing order status",
     *     description="Update an existing order status by its UUID.",
     *     tags={"Order Statuses"},
     *     @OA\Parameter(
     *         name="uuid",
     *         in="path",
     *         description="UUID of the order status",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         description="Data for updating an existing order status",
     *         @OA\JsonContent(ref="#/components/schemas/OrderStatusRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Order status updated successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="success",
     *                 type="string",
     *                 example="Order status updated successfully!"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Order status not found",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="error",
     *                 type="string",
     *                 example="Order status not found"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation errors",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="The given data was invalid."
     *             ),
     *             @OA\Property(
     *                 property="errors",
     *                 type="object",
     *                 ref="#/components/schemas/OrderStatusValidationErrors"
     *             )
     *         )
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
     *     path="/api/order-statuses/{uuid}",
     *     summary="Delete an existing order status",
     *     description="Delete an existing order status by its UUID.",
     *     tags={"Order Statuses"},
     *     @OA\Parameter(
     *         name="uuid",
     *         in="path",
     *         description="UUID of the order status",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Order status deleted successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="success",
     *                 type="string",
     *                 example="Order status deleted successfully!"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Order status not found",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="error",
     *                 type="string",
     *                 example="Order status not found"
     *             )
     *         )
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

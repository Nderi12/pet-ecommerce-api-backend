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
     * Display a listing of the resource.
     * 
     * @author Nderi Kamau <nderikamau1212@gmail.com>
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
     * Store a newly created resource in storage.
     * 
     * @author Nderi Kamau <nderikamau1212@gmail.com>
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
     * Display the specified resource.
     * 
     * @author Nderi Kamau <nderikamau1212@gmail.com>
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
     * Update the specified resource in storage.
     * 
     * @author Nderi Kamau <nderikamau1212@gmail.com>
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
     * Remove the specified resource from storage.
     * 
     * @author Nderi Kamau <nderikamau1212@gmail.com>
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
        return redirect()->back()->with([
            'success' => 'Order status deleted successfully!'
        ], Response::HTTP_OK);
    }
}

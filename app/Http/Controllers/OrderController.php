<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderRequest;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
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
        $products = Order::all();

        // Return response with message and data
        return response()->json([
            'message' => 'Orders list',
            'products' => $products
        ], Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     * 
     * @author Nderi Kamau <nderikamau1212@gmail.com>
     */
    public function store(OrderRequest $request)
    {
        // Get the data from the request
        $data = $request->validated();

        // Create an empty order
        $order = Order::make();

        DB::transaction(function () use($data, $order) {
           // create a new order from the validated data
           $order->create($data);
        });

        // Return response with message and data
        return response()->json([
            'message' => 'Order created successfully!',
            'order' => $order
        ], Response::HTTP_CREATED); // 201 response for created
    }

    /**
     * Display the specified resource.
     * 
     * @author Nderi Kamau <nderikamau1212@gmail.com>
     */
    public function show(Order $order)
    {
        return response()->json([
            'order' => $order
        ], Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     * 
     * @author Nderi Kamau <nderikamau1212@gmail.com>
     */
    public function update(OrderRequest $request, Order $order)
    {
        //validate data
        $data = $request->validated();

        // Update the order data
        $order->update($data);

        // Return response with message and data
        return response()->json([
            'success' => 'Order updated successfully!',
            'order' => $order
        ], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     * 
     * @author Nderi Kamau <nderikamau1212@gmail.com>
     */
    public function destroy(Order $order)
    {
        // Delete the order
        $order->delete();

        // Return response with message
        return redirect()->back()->with([
            'success' => 'Order deleted successfully!'
        ], Response::HTTP_OK);
    }
}

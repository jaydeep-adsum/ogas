<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\AppBaseController;
use App\Models\Order;
use App\Models\Status;
use App\Repositories\OrderRepository;
use Auth;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OrderController extends AppBaseController
{
    /**
     * @var OrderRepository
     */
    private OrderRepository $orderRepository;

    /**
     * OrderController constructor.
     * @param OrderRepository $orderRepository
     */
    public function __construct(OrderRepository $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    /**
     * Swagger defination Get Order
     *
     * @OA\Post(
     *     tags={"Order"},
     *     path="/get-order",
     *     description="
     *  Get Order
     *   Status :
     *     0: Ordered
     *     1: Confirmed
     *     2: On The Way
     *     3: Order Processing
     *     4: Delivered
     *     5: Canceled",
     *     summary="Get Order",
     *     operationId="getOrder",
     * @OA\Parameter(
     *     name="Content-Language",
     *     in="header",
     *     description="Content-Language",
     *     required=false,@OA\Schema(type="string")
     *     ),
     * @OA\RequestBody(
     *     required=true,
     * @OA\MediaType(
     *     mediaType="multipart/form-data",
     * @OA\JsonContent(
     * @OA\Property(
     *     property="status",
     *     type="string"
     *     ),
     *    )
     *   ),
     *  ),
     * @OA\Response(
     *     response=200,
     *     description="User response",@OA\JsonContent
     *     (ref="#/components/schemas/SuccessResponse")
     * ),
     * @OA\Response(
     *     response="400",
     *     description="Validation error",@OA\JsonContent
     *     (ref="#/components/schemas/ErrorResponse")
     * ),
     * @OA\Response(
     *     response="403",
     *     description="Not Authorized Invalid or missing Authorization header",@OA\
     *     JsonContent(ref="#/components/schemas/ErrorResponse")
     * ),
     * @OA\Response(
     *     response=500,
     *     description="Unexpected error",@OA\JsonContent
     *     (ref="#/components/schemas/ErrorResponse")
     * ),
     * security={
     *     {"API-Key": {}}
     * }
     * )
     */
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request)
    {
        try {
            $order = Order::where('customer_id', Auth::id());
            if ($request->status!=null){
                $order->whereHas('status', function ($q) use ($request) {
                    $q->where('status', $request->status);
                });
            }
            $orders= $order->get();

            return $this->sendResponse($orders, ('Order retrieved successfully'));
        } catch (Exception $ex) {
            return $this->sendError($ex);
        }
    }

    /**
     * Swagger defination create order
     *
     * @OA\Post(
     *     tags={"Order"},
     *     path="/order",
     *     description="
     *  Create Order
     *   Date : YYYY-MM-DD
     *   Time Slot :
     *     1: Now
     *     2: 09AM - 12PM
     *     3: 12pm - 03PM
     *     4: 03PM - 06pm
     *   Type:
     *     1: Refill
     *     2: New",
     *     summary="Create Order",
     *     operationId="order",
     * @OA\Parameter(
     *     name="Content-Language",
     *     in="header",
     *     description="Content-Language",
     *     required=false,@OA\Schema(type="string")
     *     ),
     * @OA\RequestBody(
     *     required=true,
     * @OA\MediaType(
     *     mediaType="multipart/form-data",
     * @OA\JsonContent(
     * @OA\Property(
     *     property="location",
     *     type="string"
     *     ),
     * @OA\Property(
     *     property="latitude",
     *     type="string"
     *     ),
     * @OA\Property(
     *     property="longitude",
     *     type="string"
     *     ),
     * @OA\Property(
     *     property="quantity1",
     *     type="number"
     *     ),
     * @OA\Property(
     *     property="quantity2",
     *     type="number"
     *     ),
     * @OA\Property(
     *     property="date",
     *     type="string"
     *     ),
     * @OA\Property(
     *     property="time_slot",
     *     type="number"
     *     ),
     * @OA\Property(
     *     property="type1",
     *     type="number"
     *     ),
     * @OA\Property(
     *     property="type2",
     *     type="number"
     *     ),
     * @OA\Property(
     *     property="total",
     *     type="number"
     *     ),
     * @OA\Property(
     *     property="driver_tip",
     *     type="number"
     *     ),
     * @OA\Property(
     *     property="product1_id",
     *     type="number"
     *     ),
     * @OA\Property(
     *     property="product2_id",
     *     type="number"
     *     ),
     * @OA\Property(
     *     property="customer_id",
     *     type="number"
     *     ),
     *    )
     *   ),
     *  ),
     * @OA\Response(
     *     response=200,
     *     description="User response",@OA\JsonContent
     *     (ref="#/components/schemas/SuccessResponse")
     * ),
     * @OA\Response(
     *     response="400",
     *     description="Validation error",@OA\JsonContent
     *     (ref="#/components/schemas/ErrorResponse")
     * ),
     * @OA\Response(
     *     response="403",
     *     description="Not Authorized Invalid or missing Authorization header",@OA\
     *     JsonContent(ref="#/components/schemas/ErrorResponse")
     * ),
     * @OA\Response(
     *     response=500,
     *     description="Unexpected error",@OA\JsonContent
     *     (ref="#/components/schemas/ErrorResponse")
     * ),
     * security={
     *     {"API-Key": {}}
     * }
     * )
     */
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        try {
            $order = $this->orderRepository->create($request->all());
            $order->status()->create([
                'order_id' => $order->id,
            ]);

            return $this->sendResponse($order, ('Order created successfully'));
        } catch (Exception $ex) {
            return $this->sendError($ex);
        }
    }

    /**
     * Swagger defination create order History
     *
     * @OA\Post(
     *     tags={"Order"},
     *     path="/store-order-history",
     *     summary="Create Order History",
     *     operationId="storeOrderHistory",
     * @OA\Parameter(
     *     name="Content-Language",
     *     in="header",
     *     description="Content-Language",
     *     required=false,@OA\Schema(type="string")
     *     ),
     * @OA\RequestBody(
     *     required=true,
     * @OA\MediaType(
     *     mediaType="multipart/form-data",
     * @OA\JsonContent(
     * @OA\Property(
     *     property="order_id",
     *     type="number"
     *     ),
     *    )
     *   ),
     *  ),
     * @OA\Response(
     *     response=200,
     *     description="User response",@OA\JsonContent
     *     (ref="#/components/schemas/SuccessResponse")
     * ),
     * @OA\Response(
     *     response="400",
     *     description="Validation error",@OA\JsonContent
     *     (ref="#/components/schemas/ErrorResponse")
     * ),
     * @OA\Response(
     *     response="403",
     *     description="Not Authorized Invalid or missing Authorization header",@OA\
     *     JsonContent(ref="#/components/schemas/ErrorResponse")
     * ),
     * @OA\Response(
     *     response=500,
     *     description="Unexpected error",@OA\JsonContent
     *     (ref="#/components/schemas/ErrorResponse")
     * ),
     * security={
     *     {"API-Key": {}}
     * }
     * )
     */
    public function storeOrderHistory(Request $request)
    {
        try {
            $order = $this->orderRepository->find($request->order_id);
            $stat = $order->status->toArray();

            $status = end($stat)['status'] + 1;

            Status::create([
                'order_id' => $order->id,
                'status' => (string)$status,
            ]);

            return $this->sendResponse($order, ('Order status changed'));
        } catch (Exception $ex) {
            return $this->sendError($ex);
        }
    }

    /**
     * Swagger defination get order History
     *
     * @OA\Post(
     *     tags={"Order"},
     *     path="/order-history",
     *     summary="Order History",
     *     operationId="orderHistory",
     * @OA\Parameter(
     *     name="Content-Language",
     *     in="header",
     *     description="Content-Language",
     *     required=false,@OA\Schema(type="string")
     *     ),
     * @OA\RequestBody(
     *     required=true,
     * @OA\MediaType(
     *     mediaType="multipart/form-data",
     * @OA\JsonContent(
     * @OA\Property(
     *     property="order_id",
     *     type="number"
     *     ),
     *    )
     *   ),
     *  ),
     * @OA\Response(
     *     response=200,
     *     description="User response",@OA\JsonContent
     *     (ref="#/components/schemas/SuccessResponse")
     * ),
     * @OA\Response(
     *     response="400",
     *     description="Validation error",@OA\JsonContent
     *     (ref="#/components/schemas/ErrorResponse")
     * ),
     * @OA\Response(
     *     response="403",
     *     description="Not Authorized Invalid or missing Authorization header",@OA\
     *     JsonContent(ref="#/components/schemas/ErrorResponse")
     * ),
     * @OA\Response(
     *     response=500,
     *     description="Unexpected error",@OA\JsonContent
     *     (ref="#/components/schemas/ErrorResponse")
     * ),
     * security={
     *     {"API-Key": {}}
     * }
     * )
     */
    public function OrderHistory(Request $request)
    {
        try {
            $order = $this->orderRepository->find($request->order_id);

            return $this->sendResponse($order, ('Order History fetch successfully.'));
        } catch (Exception $ex) {
            return $this->sendError($ex);
        }
    }

    /**
     * Swagger defination Get Order
     *
     * @OA\Post(
     *     tags={"Driver Order"},
     *     path="/orders",
     *     description="Get Orders",
     *     summary="Get Orders",
     *     operationId="orders",
     * @OA\Parameter(
     *     name="Content-Language",
     *     in="header",
     *     description="Content-Language",
     *     required=false,@OA\Schema(type="string")
     *     ),
     * @OA\RequestBody(
     *     required=true,
     * @OA\MediaType(
     *     mediaType="multipart/form-data",
     * @OA\JsonContent(
     *    )
     *   ),
     *  ),
     * @OA\Response(
     *     response=200,
     *     description="User response",@OA\JsonContent
     *     (ref="#/components/schemas/SuccessResponse")
     * ),
     * @OA\Response(
     *     response="400",
     *     description="Validation error",@OA\JsonContent
     *     (ref="#/components/schemas/ErrorResponse")
     * ),
     * @OA\Response(
     *     response="403",
     *     description="Not Authorized Invalid or missing Authorization header",@OA\
     *     JsonContent(ref="#/components/schemas/ErrorResponse")
     * ),
     * @OA\Response(
     *     response=500,
     *     description="Unexpected error",@OA\JsonContent
     *     (ref="#/components/schemas/ErrorResponse")
     * ),
     * security={
     *     {"API-Key": {}}
     * }
     * )
     */
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function driverOrder(Request $request)
    {
        try {
            $orders = Order::all();

            return $this->sendResponse($orders, ('Order retrieved successfully'));
        } catch (Exception $ex) {
            return $this->sendError($ex);
        }
    }

    /**
     * Swagger defination get Accept order
     *
     * @OA\Post(
     *     tags={"Driver accept order"},
     *     path="/accept-order",
     *     summary="Accept Order",
     *     operationId="acceptOrder",
     * @OA\Parameter(
     *     name="Content-Language",
     *     in="header",
     *     description="Content-Language",
     *     required=false,@OA\Schema(type="string")
     *     ),
     * @OA\RequestBody(
     *     required=true,
     * @OA\MediaType(
     *     mediaType="multipart/form-data",
     * @OA\JsonContent(
     * @OA\Property(
     *     property="order_id",
     *     type="number"
     *     ),
     *    )
     *   ),
     *  ),
     * @OA\Response(
     *     response=200,
     *     description="User response",@OA\JsonContent
     *     (ref="#/components/schemas/SuccessResponse")
     * ),
     * @OA\Response(
     *     response="400",
     *     description="Validation error",@OA\JsonContent
     *     (ref="#/components/schemas/ErrorResponse")
     * ),
     * @OA\Response(
     *     response="403",
     *     description="Not Authorized Invalid or missing Authorization header",@OA\
     *     JsonContent(ref="#/components/schemas/ErrorResponse")
     * ),
     * @OA\Response(
     *     response=500,
     *     description="Unexpected error",@OA\JsonContent
     *     (ref="#/components/schemas/ErrorResponse")
     * ),
     * security={
     *     {"API-Key": {}}
     * }
     * )
     */
    public function acceptOrder(Request $request)
    {
        try {
            $order = $this->orderRepository->find($request->order_id);
            if (!$order){
                return response()->json(['status' => 'false', 'messages' => array('Order Not Found')]);
            }
            $order->driver_id = Auth::id();
            $order->save();

            Status::create([
                'order_id' => $order->id,
                'status' => '1',
            ]);

            return $this->sendResponse($order, ('Order Accepted'));
        } catch (Exception $ex) {
            return $this->sendError($ex);
        }
    }
}

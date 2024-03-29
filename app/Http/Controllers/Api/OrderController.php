<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\AppBaseController;
use App\Mail\orderConfirmMail;
use App\Models\Order;
use App\Models\PaymentStatus;
use App\Models\Status;
use App\Repositories\OrderRepository;
use App\Traits\ResponseTrait;
use App\Traits\UtilityTrait;
use Auth;
use Carbon\Carbon;
use DateTime;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OrderController extends AppBaseController
{
    use ResponseTrait, UtilityTrait;
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
                $order->where('status', $request->status);
            }
            $orders= $order->orderBy('id','DESC')->get();

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
     *   Pass quantity,type and product_id comma seprated.
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
     *     property="address_book_id",
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
     *     property="total",
     *     type="number"
     *     ),
     * @OA\Property(
     *     property="driver_tip",
     *     type="number"
     *     ),
     * @OA\Property(
     *     property="customer_id",
     *     type="number"
     *     ),
     * @OA\Property(
     *     property="payment_method",
     *     type="string"
     *     ),
     * @OA\Property(
     *     property="product",
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
    public function store(Request $request)
    {
        try {
            $order = $this->orderRepository->store($request->all());

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
    public function storeOrderHistory(Request $request)
    {
        try {
            $order = $this->orderRepository->find($request->order_id);
            if (!$order){
                return response()->json(['status' => false, 'messages' => array('Order Not Found.')]);
            }
            $order->status = $request->status;
            $order->save();

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
            if (!$order){
                return response()->json(['status' => false, 'messages' => array('Order Not Found.')]);
            }

            return $this->sendResponse($order, ('Order History fetch successfully.'));
        } catch (Exception $ex) {
            return $this->sendError($ex);
        }
    }

    /**
     * Swagger definition for Products
     *
     * @OA\Get(
     *     tags={"Order"},
     *     path="/customer-order-history",
     *     description="Order History",
     *     summary="Order History",
     *     operationId="customerOrderHistory",
     * @OA\Parameter(
     *     name="Content-Language",
     *     in="header",
     *     description="Content-Language",
     *     required=false,@OA\Schema(type="string")
     *     ),
     * @OA\Response(
     *     response=200,
     *     description="Succuess response"
     *     ,@OA\JsonContent(ref="#/components/schemas/SuccessResponse")
     *     ),
     * @OA\Response(
     *     response="400",
     *     description="Validation error"
     *     ,@OA\JsonContent(ref="#/components/schemas/ErrorResponse")
     * ),
     * @OA\Response(
     *     response="401",
     *     description="Not Authorized Invalid or missing Authorization header"
     *     ,@OA\JsonContent
     *     (ref="#/components/schemas/ErrorResponse")
     * ),
     * @OA\Response(
     *     response=500,
     *     description="Unexpected error"
     *     ,@OA\JsonContent(ref="#/components/schemas/ErrorResponse")
     *  ),
     * security={
     *     {"API-Key": {}}
     * }
     * )
     */
    public function customerOrderHistory(Request $request)
    {
        try {
            $order = Order::where('customer_id',Auth::id())->orWhere('status','4')->Where('status','5')->get();
            if (!$order){
                return response()->json(['status' => false, 'messages' => array('Order Not Found.')]);
            }

            return $this->sendResponse($order, ('Order History fetch successfully.'));
        } catch (Exception $ex) {
            return $this->sendError($ex);
        }
    }

    /**
     * Swagger definition for Products
     *
     * @OA\Get(
     *     tags={"Order"},
     *     path="/home-order-history",
     *     description="Order History",
     *     summary="Order History",
     *     operationId="homeOrderHistory",
     * @OA\Parameter(
     *     name="Content-Language",
     *     in="header",
     *     description="Content-Language",
     *     required=false,@OA\Schema(type="string")
     *     ),
     * @OA\Response(
     *     response=200,
     *     description="Succuess response"
     *     ,@OA\JsonContent(ref="#/components/schemas/SuccessResponse")
     *     ),
     * @OA\Response(
     *     response="400",
     *     description="Validation error"
     *     ,@OA\JsonContent(ref="#/components/schemas/ErrorResponse")
     * ),
     * @OA\Response(
     *     response="401",
     *     description="Not Authorized Invalid or missing Authorization header"
     *     ,@OA\JsonContent
     *     (ref="#/components/schemas/ErrorResponse")
     * ),
     * @OA\Response(
     *     response=500,
     *     description="Unexpected error"
     *     ,@OA\JsonContent(ref="#/components/schemas/ErrorResponse")
     *  ),
     * security={
     *     {"API-Key": {}}
     * }
     * )
     */
    public function homeOrderHistory(Request $request)
    {
        try {
            $order = Order::where('customer_id',Auth::id())->WhereIn('status',['0','1','2'])->get();
            if (!$order){
                return response()->json(['status' => false, 'messages' => array('Order Not Found.')]);
            }

            return $this->sendResponse($order, ('Order History fetch successfully.'));
        } catch (Exception $ex) {
            return $this->sendError($ex);
        }
    }

    /**
     * Swagger definition for Products
     *
     * @OA\Get(
     *     tags={"Order"},
     *     path="/last-order",
     *     description="Last Order",
     *     summary="Last Order",
     *     operationId="lastOrder",
     * @OA\Parameter(
     *     name="Content-Language",
     *     in="header",
     *     description="Content-Language",
     *     required=false,@OA\Schema(type="string")
     *     ),
     * @OA\Response(
     *     response=200,
     *     description="Succuess response"
     *     ,@OA\JsonContent(ref="#/components/schemas/SuccessResponse")
     *     ),
     * @OA\Response(
     *     response="400",
     *     description="Validation error"
     *     ,@OA\JsonContent(ref="#/components/schemas/ErrorResponse")
     * ),
     * @OA\Response(
     *     response="401",
     *     description="Not Authorized Invalid or missing Authorization header"
     *     ,@OA\JsonContent
     *     (ref="#/components/schemas/ErrorResponse")
     * ),
     * @OA\Response(
     *     response=500,
     *     description="Unexpected error"
     *     ,@OA\JsonContent(ref="#/components/schemas/ErrorResponse")
     *  ),
     * security={
     *     {"API-Key": {}}
     * }
     * )
     */
    /**
     * @return JsonResponse
     */
    public function order(){
        try {
            $Order = Order::where('customer_id', Auth::id())->latest('id')->first();

            return $this->sendResponse($Order, ('Order retrieved successfully'));
        } catch (Exception $ex) {
            return $this->sendError($ex);
        }
    }

    /**
     * Swagger defination Get All Orders
     *
     * @OA\Post(
     *     tags={"Driver"},
     *     path="/orders",
     *     description="Get All Orders",
     *     summary="Get All Orders",
     *     operationId="orders",
     * @OA\Parameter(
     *     name="Content-Language",
     *     in="header",
     *     description="Content-Language",
     *     required=false,@OA\Schema(type="string")
     *     ),
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
     * @return JsonResponse
     */
    public function driverOrder()
    {
        try {
            $orders = Order::where('status', '0')->where('driver_id',null)->orderBy('id','DESC')->get();

            return $this->sendResponse($orders, ('Order retrieved successfully'));
        } catch (Exception $ex) {
            return $this->sendError($ex);
        }
    }

    /**
     * Swagger defination Get Order
     *
     * @OA\Post(
     *     tags={"Driver"},
     *     path="/driver-orders",
     *     description="Get Orders",
     *     summary="Get Orders",
     *     operationId="driverAcceptedOrder",
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
     *   property="status",
     *   type="string"
     *  ),
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
    public function driverAcceptedOrder(Request $request)
    {
        try {
            $order = Order::where('driver_id',Auth::id());
            if ($request->status!=null){
                $order->where('status', $request->status);
            }
            $orders= $order->orderBy('id','DESC')->get();

            return $this->sendResponse($orders, ('Order retrieved successfully'));
        } catch (Exception $ex) {
            return $this->sendError($ex);
        }
    }

    /**
     * Swagger defination get Accept order
     *
     * @OA\Post(
     *     tags={"Driver"},
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
    public function acceptOrder(Request $request)
    {
        try {
            $order = $this->orderRepository->find($request->order_id);
            if (!$order){
                return response()->json(['status' => false, 'messages' => array('Order Not Found')]);
            }
            if ($request->status=='1'){
                $msg = 'Your Order Is Assigned';
            }elseif($request->status=='2'){
                $msg = 'Your Order is Out For Delivery';
            }elseif($request->status=='4'){
                $msg = 'Your Order Is Delivered';
            }
            $message = [
                'title' => 'Order',
                'body' => $msg,
                'sound' => 'default'
            ];
            $user_device_token = $order->customer->device_token;

            $fcm_token = config('app.firebase_customer_key');
            $this->sendSingle($user_device_token, $message,$fcm_token);

            $order->driver_id = Auth::id();
            $order->status = $request->status;
            $order->save();

            return $this->sendResponse($order, ('Order Accepted'));
        } catch (Exception $ex) {
            return $this->sendError($ex);
        }
    }

    /**
     * Swagger defination get Accept order
     *
     * @OA\Post(
     *     tags={"Driver"},
     *     path="/cancel-order",
     *     summary="Cancel Order",
     *     operationId="cancelOrder",
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
     * @OA\Property(
     *     property="status",
     *     type="string"
     *     ),
     * @OA\Property(
     *     property="cancel_reason",
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
    public function cancelOrder(Request $request)
    {
        try {
            $order = $this->orderRepository->find($request->order_id);
            if (!$order){
                return response()->json(['status' => false, 'messages' => array('Order Not Found.')]);
            }
            $order->status = $request->status;
            $order->cancel_reason = $request->cancel_reason;
            $order->save();

            return $this->sendResponse($order, ('Order canceled'));
        } catch (Exception $ex) {
            return $this->sendError($ex);
        }
    }

    /**
     * Swagger defination get Accept order
     *
     * @OA\Post(
     *     tags={"Customer"},
     *     path="/cancel-customer-order",
     *     summary="Cancel Order",
     *     operationId="cancelCustomerOrder",
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
    public function cancelCustomerOrder(Request $request)
    {
        try {
            $order = $this->orderRepository->find($request->order_id);
            if (!$order){
                return response()->json(['status' => false, 'messages' => array('Order Not Found.')]);
            }
            $order->status = $request->status;
            $order->cancel_reason = 'Order Canceled By Customer';
            $order->save();

            return $this->sendResponse($order, ('Order canceled'));
        } catch (Exception $ex) {
            return $this->sendError($ex);
        }
    }

    /**
     * Swagger defination get Accept order
     *
     * @OA\Post(
     *     tags={"Customer"},
     *     path="/payment",
     *     summary="Payment",
     *     operationId="payment",
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
     * @OA\Property(
     *     property="customer_id",
     *     type="string"
     *     ),
     * @OA\Property(
     *     property="invoice_id",
     *     type="string"
     *     ),
     * @OA\Property(
     *     property="total_amount",
     *     type="string"
     *     ),
     * @OA\Property(
     *     property="payment_mode",
     *     type="string"
     *     ),
     * @OA\Property(
     *     property="payment_status",
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
    public function paymentStatus(Request $request){
        try {
            $order = $this->orderRepository->find($request->order_id);
            if (!$order){
                return response()->json(['status' => false, 'messages' => array('Order Not Found.')]);
            }
            $orderPayment = PaymentStatus::where('order_id',$request->order_id)->first();
            if ($orderPayment){
                $orderPayment->payment_status=$request->payment_status;
                $orderPayment->save();
                $payment = PaymentStatus::where('order_id',$request->order_id)->first();;
            } else {
                $payment = PaymentStatus::create([
                    'order_id'=>$request->order_id,
                    'customer_id'=>$request->customer_id,
                    'invoice_id'=>$request->invoice_id,
                    'total_amount'=>$request->total_amount,
                    'payment_mode'=>$request->payment_mode,
                    'payment_status'=>$request->payment_status,
                ]);
            }

        if ($payment) {
            $paymentStatus = PaymentStatus::where('id',$payment->id)->with('order')->first();
            if ($paymentStatus->payment_status=='paid') {
                $email = $paymentStatus->order->customer->email;
                $details = [
                    'username' => $paymentStatus->order->customer->name,
                    'invoice_id' => $paymentStatus->order->invoice_id,
                    'address' => $paymentStatus->order->address->location,
                    'order_date' => $paymentStatus->order->created_at,
                    'payment_method' => $paymentStatus->order->payment_method,
                    'products' => $paymentStatus->order->orderHistory,
                    'total' => $paymentStatus->order->total,
                ];

                \Mail::to($email)->send(new orderConfirmMail($details));
            }

            return $this->sendResponse($payment, ('Payment Done'));
        }
        } catch (Exception $ex) {
            return $this->sendError($ex);
        }
    }



    /**
     * Swagger definition for Products
     *
     * @OA\Get(
     *     tags={"Driver"},
     *     path="/ongoing-orders",
     *     description="Ongoing Orders",
     *     summary="Ongoing Orders",
     *     operationId="ongoingOrders",
     * @OA\Parameter(
     *     name="Content-Language",
     *     in="header",
     *     description="Content-Language",
     *     required=false,@OA\Schema(type="string")
     *     ),
     * @OA\Response(
     *     response=200,
     *     description="Succuess response"
     *     ,@OA\JsonContent(ref="#/components/schemas/SuccessResponse")
     *     ),
     * @OA\Response(
     *     response="400",
     *     description="Validation error"
     *     ,@OA\JsonContent(ref="#/components/schemas/ErrorResponse")
     * ),
     * @OA\Response(
     *     response="401",
     *     description="Not Authorized Invalid or missing Authorization header"
     *     ,@OA\JsonContent
     *     (ref="#/components/schemas/ErrorResponse")
     * ),
     * @OA\Response(
     *     response=500,
     *     description="Unexpected error"
     *     ,@OA\JsonContent(ref="#/components/schemas/ErrorResponse")
     *  ),
     * security={
     *     {"API-Key": {}}
     * }
     * )
     */
    public function ongoingOrders(Request $request)
    {
        try {
            $order = Order::where('driver_id',Auth::id())->where('status','!=','4')->Where('status','!=','5')->get();
            if (!$order){
                return response()->json(['status' => false, 'messages' => array('Order Not Found.')]);
            }

            return $this->sendResponse($order, ('Ongoing Orders fetch successfully.'));
        } catch (Exception $ex) {
            return $this->sendError($ex);
        }
    }

    /**
     * Swagger definition for Products
     *
     * @OA\Get(
     *     tags={"Customer"},
     *     path="/time-slots",
     *     description="Time Slots",
     *     summary="Time Slots",
     *     operationId="timeSlots",
     * @OA\Parameter(
     *     name="Content-Language",
     *     in="header",
     *     description="Content-Language",
     *     required=false,@OA\Schema(type="string")
     *     ),
     * @OA\Response(
     *     response=200,
     *     description="Succuess response"
     *     ,@OA\JsonContent(ref="#/components/schemas/SuccessResponse")
     *     ),
     * @OA\Response(
     *     response="400",
     *     description="Validation error"
     *     ,@OA\JsonContent(ref="#/components/schemas/ErrorResponse")
     * ),
     * @OA\Response(
     *     response="401",
     *     description="Not Authorized Invalid or missing Authorization header"
     *     ,@OA\JsonContent
     *     (ref="#/components/schemas/ErrorResponse")
     * ),
     * @OA\Response(
     *     response=500,
     *     description="Unexpected error"
     *     ,@OA\JsonContent(ref="#/components/schemas/ErrorResponse")
     *  ),
     * security={
     *     {"API-Key": {}}
     * }
     * )
     */
    public function timeSlots(Request $request)
    {
        try {
            date_default_timezone_set("Asia/Muscat");
            $duration=60;
            $startToday =Carbon::now()->minute(0)->second(0);
            $end='08:00PM';
            $startTommorow =Carbon::tomorrow()->hour(9)->minute(0)->second(0);

            $start = new DateTime($startToday);
            $tommorow = new DateTime($startTommorow);
            $end = new DateTime($end);

            $start_time = $start->format('H:i');
            $start_time_tommorow = $tommorow->format('H:i');
            $end_time = $end->format('H:i');
            $i=0;
            while(strtotime($start_time) <= strtotime($end_time)){
                $start = $start_time;
                $end = date('H:i',strtotime('+'.$duration.' minutes',strtotime($start_time)));
                $start_time = date('H:i',strtotime('+'.$duration.' minutes',strtotime($start_time)));
                $i++;
                if(strtotime($start_time) <= strtotime($end_time)){
                    $time[$i] = date('h:i a',strtotime($start)).'-'.date('h:i a',strtotime($end));
                }
            }
            $j=0;
            while(strtotime($start_time_tommorow) <= strtotime($end_time)){
                $tommorow = $start_time_tommorow;
                $end = date('H:i',strtotime('+'.$duration.' minutes',strtotime($start_time_tommorow)));
                $start_time_tommorow = date('H:i',strtotime('+'.$duration.' minutes',strtotime($start_time_tommorow)));
                $j++;
                if(strtotime($start_time_tommorow) <= strtotime($end_time)){
                    $timeto[$j] = date('h:i a',strtotime($tommorow)).'-'.date('h:i a',strtotime($end));
                }
            }
            $data['today'] = $time;
            $data['tommorow'] = $timeto;

            return $this->sendResponse($data, ('Time Slots fetch successfully.'));
        } catch (Exception $ex) {
            return $this->sendError($ex);
        }
    }
}

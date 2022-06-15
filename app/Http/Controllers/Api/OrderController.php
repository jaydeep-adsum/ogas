<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\AppBaseController;
use App\Repositories\OrderRepository;
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
     *     property="quantity",
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
     *     property="type",
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
     *     property="product_id",
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
                'order_id'=>$order->id,
            ]);

            return $this->sendResponse($order, ('Order created successfully'));
        } catch (Exception $ex) {
            return $this->sendError($ex);
        }
    }
}

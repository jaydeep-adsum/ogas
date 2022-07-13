<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\AppBaseController;
use App\Repositories\ProductRepository;
use Exception;
use Illuminate\Http\JsonResponse;

class ProductController extends AppBaseController
{
    /**
     * @var ProductRepository
     */
    private ProductRepository $productRepository;

    /**
     * ProductController constructor.
     * @param ProductRepository $productRepository
     */
    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    /**
     * Swagger definition for Products
     *
     * @OA\Get(
     *     tags={"Products"},
     *     path="/products",
     *     description="Products",
     *     summary="Products",
     *     operationId="products",
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
    public function index(){
        try {
            $data = [];
            $products = $this->productRepository->all()->toArray();

            foreach ($products as $product){
                $product['quantity']= 0;
                $data[] =$product;
            }
            collect($data);

            return $this->sendResponse($data, ('Products retrieved successfully'));
        } catch (Exception $ex) {
            return $this->sendError($ex);
        }
    }
}

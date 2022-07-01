<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\AppBaseController;
use App\Repositories\FaqRepository;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FaqController extends AppBaseController
{
    private FaqRepository $faqRepository;

    /**
     * @param FaqRepository $faqRepository
     */
    public function __construct(FaqRepository $faqRepository){
        $this->faqRepository = $faqRepository;
    }

    /**
     * Swagger definition for Products
     *
     * @OA\Get(
     *     tags={"Faq"},
     *     path="/faq",
     *     description="Faq",
     *     summary="Faq",
     *     operationId="faq",
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
            $faq = $this->faqRepository->paginate(10);

            return $this->sendResponse($faq, ('faq retrieved successfully'));
        } catch (Exception $ex) {
            return $this->sendError($ex);
        }
    }
}

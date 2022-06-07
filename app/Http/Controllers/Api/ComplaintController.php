<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\AppBaseController;
use App\Http\Controllers\Controller;
use App\Repositories\ComplaintRepository;
use Auth;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ComplaintController extends AppBaseController
{
    /**
     * @var ComplaintRepository
     */
    private ComplaintRepository $complaintRepository;

    /**
     * ComplaintController constructor.
     * @param ComplaintRepository $complaintRepository
     */
    public function __construct(ComplaintRepository $complaintRepository){
        $this->complaintRepository = $complaintRepository;
    }

    /**
     * Swagger defination Complaint
     *
     * @OA\Post(
     *     tags={"Complaint"},
     *     path="/complaint",
     *     description="Add Complaint",
     *     summary="Add Complaint",
     *     operationId="Complaint",
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
     *     property="customer_id",
     *     type="number"
     *     ),
     * @OA\Property(
     *     property="feedback",
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
    public function store(Request $request): JsonResponse
    {
        try {
            if($request->customer_id != Auth::user()->id)
            {
                return $this->sendError('Unauthorized access');
            }

            $complaint = $this->complaintRepository->create($request->all());

            return $this->sendResponse($complaint, ('Complaint created successfully'));
        } catch (Exception $ex) {
            return $this->sendError($ex);
        }
    }
}

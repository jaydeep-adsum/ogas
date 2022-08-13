<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\AppBaseController;
use App\Http\Controllers\Controller;
use App\Models\AddressBook;
use App\Repositories\AddressBookRepository;
use Auth;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AddressBookController extends AppBaseController
{
    public function __construct(AddressBookRepository $addressBookRepository){
        $this->addressBookRepository = $addressBookRepository;
    }

    /**
     * Swagger definition for Products
     *
     * @OA\Get(
     *     tags={"Address"},
     *     path="/address",
     *     description="Address",
     *     summary="Address",
     *     operationId="address",
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
    public function index(){
        try {
            $address = AddressBook::where('customer_id', Auth::id())->get();

            return $this->sendResponse($address, ('Address retrieved successfully'));
        } catch (Exception $ex) {
            return $this->sendError($ex);
        }
    }

    /**
     * Swagger defination Complaint
     *
     * @OA\Post(
     *     tags={"Address"},
     *     path="/store-address",
     *     description="Store Address",
     *     summary="Store Address",
     *     operationId="storeAddress",
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
            $address = $this->addressBookRepository->create($request->all());

            return $this->sendResponse($address, ('Complaint created successfully'));
        } catch (Exception $ex) {
            return $this->sendError($ex);
        }
    }

    /**
     * Swagger defination create order History
     *
     * @OA\Post(
     *     tags={"Address"},
     *     path="/delete-address",
     *     summary="Delete Address",
     *     operationId="deleteAddress",
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
    public function destroy(Request $request){
        try {
            $address = $this->addressBookRepository->find($request->address_book_id);
            $address->delete();

            return $this->sendSuccess('Address Deleted successfully');
        } catch (Exception $ex) {
            return $this->sendError($ex);
        }
    }
}

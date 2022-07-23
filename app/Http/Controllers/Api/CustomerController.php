<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\AppBaseController;
use App\Models\Authenticator;
use App\Models\Customer;
use App\Repositories\CustomerRepository;
use Auth;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Validator;

class CustomerController extends AppBaseController
{
    private Authenticator $authenticator;
    private CustomerRepository $customerRepository;

    /**
     * CustomerController constructor.
     * @param CustomerRepository $customerRepository
     * @param Authenticator $authenticator
     */
    public function __construct(CustomerRepository $customerRepository, Authenticator $authenticator)
    {
        $this->customerRepository = $customerRepository;
        $this->authenticator = $authenticator;
    }

    /**
     * Swagger defination Signup
     *
     * @OA\Post(
     *     tags={"Customer"},
     *     path="/signup",
     *     description="Sign Un Customer",
     *     summary="Sign Un Customer",
     *     operationId="signup",
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
     *     property="mobile",
     *     type="string"
     *     ),
     * @OA\Property(
     *     property="name",
     *     type="string"
     *     ),
     * @OA\Property(
     *     property="payment_customer_id",
     *     type="string"
     *     ),
     * @OA\Property(
     *     property="email",
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
     * )
     */
    public function signup(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'mobile' => 'required|numeric|unique:customers',
                'name' => 'required',
                'payment_customer_id' => 'required',
                'email' => 'required',
            ]);

            $error = (object)[];
            if ($validator->fails()) {

                return response()->json(['status' => "false", 'data' => $error, 'message' => implode(', ', $validator->errors()->all())]);
            }
            $input = $request->all();
            $customer = Customer::create($input);

            if ($customer) {
                $credentials['mobile'] = $customer->mobile;
                $credentials['name'] = $customer->name;
                if ($customer = $this->authenticator->attemptSignUp($credentials)) {
                    $update = Customer::where('id', $customer->id)->update(['device_token' => $request->device_token, 'device_type' => $request->device_type]);
                    $tokenResult = $customer->createToken('ogas');
                    $token = $tokenResult->token;
                    $token->save();
                    $success['token'] = 'Bearer ' . $tokenResult->accessToken;
                    $success['expires_at'] = Carbon::parse(
                        $tokenResult->token->expires_at
                    )->toDateTimeString();
                    $success['user'] = $customer;

                    return $this->sendResponse(
                        $success, 'You Have Successfully Logged in to ogas.'
                    );
                } else {
                    return response()->json(['success' => false, 'data' => $error, 'message' => 'These credentials do not match our records']);
                }
            }
        } catch (Exception $e) {
            return $this->sendError($e);
        }
    }

    /**
     * Swagger defination Login
     *
     * @OA\Post(
     *     tags={"Customer"},
     *     path="/login",
     *     description="Log In Customer",
     *     summary="Log In Customer",
     *     operationId="login",
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
     *     property="mobile",
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
     * )
     */
    public function login(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'mobile' => 'required',
            ]);

            $error = (object)[];
            if ($validator->fails()) {

                return response()->json(['status' => "false", 'data' => $error, 'message' => implode(', ', $validator->errors()->all())]);
            }
            $credentials['mobile'] = $request->mobile;

            if ($customer = $this->authenticator->attemptLogin($credentials)) {
                $update = Customer::where('id', $customer->id)->update(['device_token' => $request->device_token, 'device_type' => $request->device_type]);
                $customer = Customer::find($customer->id);
                $tokenResult = $customer->createToken('ogas');
                $token = $tokenResult->token;
                $token->save();
                $success['token'] = 'Bearer ' . $tokenResult->accessToken;
                $success['expires_at'] = Carbon::parse(
                    $tokenResult->token->expires_at
                )->toDateTimeString();
                $success['user'] = $customer;

                return $this->sendResponse(
                    $success, 'You Have Successfully Logged in to ogas.'
                );
            } else {
                return response()->json(['success' => false, 'data' => $error, 'message' => 'These credentials do not match our records']);
            }
        } catch (Exception $e) {
            return $this->sendError($e);
        }
    }

    /**
     * Swagger defination Customer profile edit
     *
     * @OA\Post(
     *     tags={"Customer"},
     *     path="/edit",
     *     description="Edit Profile",
     *     summary="Edit Profile",
     *     operationId="edit",
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
     *     property="name",
     *     type="string"
     *     ),
     * @OA\Property(
     *     property="mobile",
     *     type="string"
     *     ),
     * @OA\Property(
     *     property="address",
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
    public function edit(Request $request){
        try {
            if (Auth::user()->id != $request->customer_id) {
                return $this->sendError('Unauthorized');
            }
            $customer = Customer::find($request->customer_id);
            if (!$customer) {
                return $this->sendError('User does not exist');
            }
            if (isset($request->name) && $request->name!='') {
                $customer->name = $request->name;
            }
            if (isset($request->mobile) && $request->mobile!='') {
                $customer->mobile = $request->mobile;
            }
            if (isset($request->address) && $request->address!='') {
                $customer->address = $request->address;
            }
            $customer->save();

            return $this->sendResponse($customer->toArray(), ('Your profile updated successfully'));
        } catch (\Exception $ex) {
            return $this->sendResponse($ex);
        }
    }
}

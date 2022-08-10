<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\AppBaseController;
use App\Models\Authenticator;
use App\Models\Driver;
use App\Repositories\DriverRepository;
use Auth;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Validator;

class DriverController extends AppBaseController
{
    private DriverRepository $driverRepository;
    private Authenticator $authenticator;

    /**
     * @param DriverRepository $driverRepository
     * @param Authenticator $authenticator
     */
    public function __construct(DriverRepository $driverRepository, Authenticator $authenticator){
        $this->driverRepository =$driverRepository;
        $this->authenticator =$authenticator;
    }

    /**
     * Swagger defination Signup
     *
     * @OA\Post(
     *     tags={"Driver"},
     *     path="/driver-signup",
     *     description="Sign Un Driver",
     *     summary="Sign Un Driver",
     *     operationId="driverSignup",
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
     *     property="email",
     *     type="string"
     *     ),
     * @OA\Property(
     *     property="licence_no",
     *     type="string"
     *     ),
     * @OA\Property(
     *     property="vehicle_no",
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
                'mobile' => 'required|numeric|unique:drivers|digits:10',
                'name' => 'required',
                'email' => 'required|email|unique:drivers',
                'licence_no' => 'required',
                'vehicle_no' => 'required',
            ]);

            $error = (object)[];
            if ($validator->fails()) {
                return response()->json(['status' => false, 'data' => $error, 'message' => implode(', ', $validator->errors()->all())]);
            }
            $input = $request->all();
            $driver = Driver::create($input);

            if ($driver) {
                $credentials['mobile'] = $driver->mobile;
                $credentials['name'] = $driver->name;
                if ($driver = $this->authenticator->attemptDriverSignUp($credentials)) {
                    $update = Driver::where('id', $driver->id)->update(['device_token' => $request->device_token, 'device_type' => $request->device_type]);
                    $tokenResult = $driver->createToken('driver-token');
                    $token = $tokenResult->token;
                    $token->save();
                    $success['token'] = 'Bearer ' . $tokenResult->accessToken;
                    $success['expires_at'] = Carbon::parse(
                        $tokenResult->token->expires_at
                    )->toDateTimeString();
                    $success['user'] = $driver;

                    return $this->sendResponse(
                        $success, 'You Have Successfully Signup in to ogas.'
                    );
                }else {
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
     *     tags={"Driver"},
     *     path="/driver-login",
     *     description="Log In Driver",
     *     summary="Log In Driver",
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

                return response()->json(['status' => false, 'data' => $error, 'message' => implode(', ', $validator->errors()->all())]);
            }
            $credentials['mobile'] = $request->mobile;
            $checkDriver = Driver::where('mobile',$request->mobile)->first();
            if ($checkDriver)
            {
                if ($checkDriver->status==null){
                    return $this->sendError( 'Contact Admin For Accept Your Request.',200);
                } elseif ($checkDriver->status==0){
                    return $this->sendError( 'Your Request Is Rejected By Admin.',200);
                }
            }
            if ($driverLogin = $this->authenticator->attemptDriverLogin($credentials)) {
                $update = Driver::where('id', $driverLogin->id)->update(['device_token' => $request->device_token, 'device_type' => $request->device_type]);
                $tokenResult = $driverLogin->createToken('driver-token');
                $token = $tokenResult->token;
                $token->save();
                $success['token'] = 'Bearer ' . $tokenResult->accessToken;
                $success['expires_at'] = Carbon::parse(
                    $tokenResult->token->expires_at
                )->toDateTimeString();
                $success['user'] = $driverLogin;

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
     * Swagger defination Driver profile edit
     *
     * @OA\Post(
     *     tags={"Driver"},
     *     path="/driver-edit",
     *     description="Edit Profile",
     *     summary="Edit Profile",
     *     operationId="driverEdit",
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
     *     property="driver_id",
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
     *     property="email",
     *     type="string"
     *     ),
     * @OA\Property(
     *     property="licence_no",
     *     type="string"
     *     ),
     * @OA\Property(
     *     property="vehicle_no",
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
    public function edit(Request $request){
        try {
            if (Auth::user()->id != $request->driver_id) {
                return $this->sendError('Unauthorized');
            }
            $driver = Driver::find($request->driver_id);
            if (!$driver) {
                return $this->sendError('User does not exist');
            }
            if (isset($request->name) && $request->name!='') {
                $driver->name = $request->name;
            }
            if (isset($request->mobile) && $request->mobile!='') {
                $driver->mobile = $request->mobile;
            }
            if (isset($request->email) && $request->email!='') {
                $driver->email = $request->email;
            }
            if (isset($request->licence_no) && $request->licence_no!='') {
                $driver->licence_no = $request->licence_no;
            }
            if (isset($request->vehicle_no) && $request->vehicle_no!='') {
                $driver->vehicle_no = $request->vehicle_no;
            }
            $driver->save();

            return $this->sendResponse($driver->toArray(), ('Your profile updated successfully'));
        } catch (\Exception $ex) {
            return $this->sendResponse($ex);
        }
    }

    /**
     * Swagger defination Driver profile edit
     *
     * @OA\Post(
     *     tags={"Driver"},
     *     path="/check-driver",
     *     description="Check Driver",
     *     summary="Check Driver",
     *     operationId="checkDriver",
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
    public function checkDriver(Request $request){
        $driver = Driver::where('mobile',$request->mobile)->first();
        if ($driver){
           return $this->sendError('Mobile no already taken.',200);
        }
        return $this->sendSuccess('success.');
    }
}

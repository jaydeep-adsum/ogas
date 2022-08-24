<?php

namespace App\Http\Controllers;

use App\Datatable\NotificationDatatable;
use App\Models\Customer;
use App\Models\Driver;
use App\Models\Notification;
use App\Repositories\NotificationRepository;
use App\Traits\ResponseTrait;
use App\Traits\UtilityTrait;
use DataTables;
use Exception;
use Flash;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;

class NotificationController extends AppBaseController
{
    use ResponseTrait, UtilityTrait;
    private NotificationRepository $notificationRepository;

    /**
     * @param NotificationRepository $notificationRepository
     */
    public function __construct(NotificationRepository $notificationRepository)
    {
        $this->notificationRepository = $notificationRepository;
    }

    /**
     * @param Request $request
     * @return Application|Factory|View
     */
    public function index(Request $request)
    {

        if ($request->ajax()) {
            return Datatables::of((new NotificationDatatable())->get())->make(true);
        }

        return view('notification.index');
    }

    /**
     * @param Request $request
     * @return Application|RedirectResponse|Redirector
     */
    public function store(Request $request)
    {
        try {
            if ($request->user == '0') {
                $user_device_token = Customer::pluck('device_token');
                $fcm_token = config('app.firebase_customer_key');
            } elseif ($request->user == '1') {
                $user_device_token = Driver::pluck('device_token');
                $fcm_token = config('app.firebase_driver_key');
            }

            $message = array(
                'title' => $request->title,
                'body' => $request->description,
                'sound' => 'default'
            );

            $this->sendMultiple($user_device_token, $message,$fcm_token);

            $this->notificationRepository->create($request->all());

            Flash::success('Notification Sent successfully.');

            return redirect(route('notification'));
        } catch (Exception $e) {
            return;
        }
    }

    /**
     * @param Notification $notification
     * @return JsonResponse
     */
    public function destroy(Notification $notification)
    {
        $notification->delete();

        return $this->sendSuccess('Notification deleted successfully.');
    }
}

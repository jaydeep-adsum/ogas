<?php

namespace App\Http\Controllers;

use App\Datatable\DriverDatatable;
use App\Exports\DriverExport;
use App\Models\Driver;
use App\Repositories\DriverRepository;
use DataTables;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class DriverController extends AppBaseController
{
    private DriverRepository $driverRepository;

    /**
     * @param DriverRepository $driverRepository
     */
    public function __construct(DriverRepository $driverRepository){
        $this->driverRepository = $driverRepository;
    }

    /**
     * @param Request $request
     * @return Application|Factory|View
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return Datatables::of((new DriverDatatable())->get())->make(true);
        }
        return view('driver.index');
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function edit($id)
    {
        $driver = $this->driverRepository->find($id);
        return $this->sendResponse($driver, 'Driver Retrieved Successfully.');
    }

    /**+
     * @param Request $request
     * @param $id
     * @return JsonResponse
     */
    public function update(Request $request,$id){
        $this->driverRepository->update($request->all(), $id);

        return $this->sendSuccess('Driver updated successfully.');
    }

    /**
     * @param Driver $driver
     * @return JsonResponse
     */
    public function destroy(Driver $driver)
    {
        $driver->delete();

        return $this->sendSuccess('Driver deleted successfully.');
    }

    /**
     * @param Driver $driver
     * @return JsonResponse
     */
    public function accept(Driver $driver)
    {
        $driver->status='1';
        $driver->save();

        return $this->sendSuccess('Driver Accepted.');
    }

    /**
     * @param Driver $driver
     * @return JsonResponse
     */
    public function reject(Driver $driver)
    {
        $driver->status='0';
        $driver->save();

        return $this->sendSuccess('Driver Rejected.');
    }

    /**
     * @return BinaryFileResponse
     */
    public function export()
    {
        return Excel::download(new DriverExport(), 'driver.xlsx');
    }
}

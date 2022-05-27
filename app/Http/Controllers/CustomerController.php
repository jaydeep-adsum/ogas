<?php

namespace App\Http\Controllers;

use App\Datatable\CustomerDatatable;
use App\Models\Customer;
use App\Repositories\CustomerRepository;
use DataTables;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CustomerController extends AppBaseController
{
    /**
     * CustomerController constructor.
     * @param CustomerRepository $customerRepository
     */
    public function __construct(CustomerRepository $customerRepository)
    {
        $this->customerRepository = $customerRepository;
    }

    /**
     * @param Request $request
     * @return Application|Factory|View
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return Datatables::of((new CustomerDatatable())->get())->make(true);
        }
        return view('customer.index');
    }

    /**
     * @param Customer $customer
     * @return JsonResponse
     */
    public function destroy(Customer $customer)
    {
        $customer->delete();
        $customer->media()->delete();

        return $this->sendSuccess('Customer deleted successfully.');
    }
}

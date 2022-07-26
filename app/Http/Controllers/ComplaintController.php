<?php

namespace App\Http\Controllers;

use App\Datatable\ComplaintDatatable;
use App\Models\Complaint;
use App\Repositories\ComplaintRepository;
use DataTables;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
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
     * @param Request $request
     * @return Application|Factory|View
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return Datatables::of((new ComplaintDatatable())->get())->make(true);
        }
        return view('complaint.index');
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        $complaint = $this->complaintRepository->find($id);
        $complaint->delete();

        return $this->sendSuccess('Complaint deleted successfully.');
    }
}

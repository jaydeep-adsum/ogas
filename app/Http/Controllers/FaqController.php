<?php

namespace App\Http\Controllers;

use App\Datatable\FaqDatatable;
use App\Repositories\FaqRepository;
use DataTables;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class FaqController extends AppBaseController
{
    private FaqRepository $faqRepository;

    /**+
     * @param FaqRepository $faqRepository
     */
    public function __construct(FaqRepository $faqRepository){
        $this->faqRepository = $faqRepository;
    }

    /**
     * @param Request $request
     * @return Application|Factory|View
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return Datatables::of((new FaqDatatable())->get())->make(true);
        }
        return view('faq.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        $faq = $this->faqRepository->create($request->all());

        return $this->sendResponse($faq, 'Faq saved successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function edit($id)
    {
        $faq = $this->faqRepository->find($id);
        return $this->sendResponse($faq, 'Faq Retrieved Successfully.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int  $id
     * @return JsonResponse
     */
    public function update(Request $request, $id)
    {
        $this->faqRepository->update($request->all(), $id);

        return $this->sendSuccess('Faq updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy($id)
    {
        $this->faqRepository->delete($id);

        return $this->sendSuccess('Faq deleted successfully.');
    }
}

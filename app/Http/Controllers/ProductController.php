<?php

namespace App\Http\Controllers;

use App\Datatable\ProductDatatable;
use App\Models\Category;
use App\Models\Product;
use App\Repositories\ProductRepository;
use DataTables;
use Flash;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;

class ProductController extends AppBaseController
{
    /**
     * ProductController constructor.
     * @param ProductRepository $productRepository
     */
    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    /**
     * @param Request $request
     * @return Application|Factory|View
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return Datatables::of((new ProductDatatable())->get())->make(true);
        }
        return view('product.index');
    }

    /**
     * @return Application|Factory|View
     */
    public function create()
    {
        $category = Category::pluck('category', 'id');
        return view('product.create', compact('category'));
    }

    /**
     * @param Request $request
     * @return Application|RedirectResponse|Redirector
     */
    public function store(Request $request)
    {
        $product = $this->productRepository->create($request->all());

        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $product->addMedia($request->image)->toMediaCollection(Product::PATH);
        }

        Flash::success('Product added successfully.');

        return redirect(route('products'));
    }

    /**
     * @param $id
     * @return Application|Factory|View
     */
    public function edit($id)
    {
        $category = Category::pluck('category', 'id');
        $product = Product::find($id);

        return view('product.edit', compact('product', 'category'));
    }

    /**
     * @param Request $request
     * @param $id
     * @return Application|RedirectResponse|Redirector
     */
    public function update(Request $request, $id)
    {
        $product = $this->productRepository->update($request->all(), $id);

        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $product->clearMediaCollection(Product::PATH);
            $product->addMedia($request->image)->toMediaCollection(Product::PATH);
        }
        Flash::success('Product updated successfully.');

        return redirect(route('products'));
    }

    /**
     * @param Product $product
     * @return JsonResponse
     */
    public function destroy(Product $product)
    {
        $product->delete();
        $product->media()->delete();

        return $this->sendSuccess('Product deleted successfully.');
    }
}

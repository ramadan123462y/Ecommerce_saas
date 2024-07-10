<?php

namespace App\Http\Controllers\Saller;

use App\Exports\ProductsExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Http\Traits\FileTrait;
use App\Imports\ProductsImport;
use App\Jobs\ImportProducts;
use App\Models\Categorie;
use App\Models\Product;
use App\Repository\ProductRepo;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

use function App\Http\Helpers\store_saller;
use function PHPUnit\Framework\returnSelf;

class ProductController extends Controller
{
    public $productrepo;

    public function __construct(ProductRepo $productrepo)
    {

        $this->productrepo = $productrepo;
    }

    public function index()
    {
        $products = $this->productrepo->get();

        return view('Backend.Saller.Products.index', compact('products'));
    }

    public function create()
    {

        $categories = Categorie::get();

        return view('Backend.Saller.Products.add', compact('categories'));
    }

    public function store(ProductRequest $request)
    {

        $status = $this->check_status($request);

        if ($request->hasFile('file_name')) {
            $this->store_product($request, $status);
            $file = FileTrait::save_file("file_name", $request, 'Products', 'Image');

            flash()->addSuccess('Data   Sucessfully');
        } else {


            flash()->addError('Please Choose File');
        }

        return redirect('saller/dashboard/product/');
    }

    public function edit($id)
    {

        $categories = Categorie::get();
        $product = $this->productrepo->find($id);;

        return view('Backend.Saller.Products.edit', compact('categories', 'product'));
    }

    public function export()
    {
        flash()->addSuccess('Data Export Sucessfully');
        return  Excel::download(new ProductsExport(), 'products.csv', \Maatwebsite\Excel\Excel::CSV);
    }

    public  function import(Request $request)
    {
        $path = $request->file('file_excel')->store('temp');
        $path= storage_path("app/$path");
        ImportProducts::dispatch($path);
        flash()->addSuccess('Data Imported  Sucessfully');
        return redirect()->back();
    }


    public function update(Request $request)
    {

        $this->validation($request);
        $status = $this->check_status($request);

        $product = $this->productrepo->find($request->id);
        if ($request->hasFile('file_name')) {

            $file = FileTrait::save_file("file_name", $request, 'Products', 'Image');
            $file = $request->file('file_name');
            $file = $file->getClientOriginalName();
        } else {
            $file = $product->file_name;
        }
        $this->productrepo->update($request, $status, $file);

        flash()->addSuccess('Data   Sucessfully');

        return redirect('saller/dashboard/product/');
    }

    public function delete($id)
    {


        $this->productrepo->delete($id);
        flash()->addSuccess('Data Deleted Sucessfully');
        return redirect()->back();
    }

    private function store_product($request, $status)
    {
        $file = $request->file('file_name');
        $file =  $file->getClientOriginalName();

        $this->productrepo->store(
            $request,
            $status,
            $file
        );
    }
    private function check_status($request)
    {


        if (isset($request->status)) {


            $status = true;
        } else {

            $status = false;
        }

        return $status;
    }

    private function validation($request)
    {


        $request->validate([

            'name' => "required|unique:products,name,$request->id",
            'quantity' => 'required',
            'slug' => 'required',
            'original_price' => 'required',
            'selling_price' => 'required',
            'categorie_id' => 'required',
        ]);
    }
}

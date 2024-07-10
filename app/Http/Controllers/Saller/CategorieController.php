<?php

namespace App\Http\Controllers\Saller;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategorieRequest;
use App\Http\Traits\FileTrait;
use App\Models\Categorie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\File;

use function App\Http\Helpers\store_saller;

class CategorieController extends Controller
{

    // use FileTrait;

    public function index()
    {

        $categories = Categorie::get();


        return view('Backend.Saller.Categories.index', compact('categories'));
    }

    public function store(CategorieRequest $request)
    {

        if (!$request->hasFile('file_name')) {
            return redirect()->back()->withErrors('Please Choose File ');
        }
        $status = $this->check_status($request);

        $file = $request->file('file_name');
        // ___________________store Categorie______________
        $this->store_categorie($request, $status, $file);
        // ___________________store Image__________________

        FileTrait::save_file('file_name', $request, 'Categories', 'Images');
        flash()->addSuccess('Data Aded Sucessfully');
        return redirect()->back();
    }

    public function update(CategorieRequest $request)
    {


        $status = $this->check_status($request);

        $categorie = $this->categorie($request->id);

        if ($request->hasFile("file_name")) {
            $file = $request->file('file_name');
            $file = $file->getClientOriginalName();
            FileTrait::delete_file(public_path("storage/Images/Categories/$categorie->file_name"));
            FileTrait::save_file('file_name', $request, 'Categories', 'Images');
        } else {
            $file = $categorie->file_name;
        }
        // ___________________Update Categorie______________
        $this->update_categorie($categorie, $request, $status, $file);

        flash()->addSuccess('Data Updated  Sucessfully');


        return redirect()->back();
    }

    private function update_categorie($categorie, $request, $status, $file)
    {
        $categorie->update([
            'name' => $request->name,
            'status' => $status,
            'file_name' => $file,
        ]);
    }

    public  function delete($id)
    {

        $categorie = $this->categorie($id);
        $categorie->delete();
        flash()->addError('Data Deleted  Sucessfully');
        return redirect()->back();
    }


    private function store_categorie($request, $status, $file)
    {

        $categorie = Categorie::create([

            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
            'status' => $status,
            'file_name' => $file->getClientOriginalName(),
            'store_id' => store_saller()->id,
            'meta_title' => $request->meta_title,
            'meta_descrip' => $request->meta_descrip,
            'meta_keywords' => $request->meta_keywords,

        ]);
    }







    private function categorie($id)
    {


        return Categorie::find($id);
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
    // _________________________________________  Archive   ____________________



    public function archive()
    {

        $categories = Categorie::onlyTrashed()->get();

        return view('Backend.Saller.Categories.Archive', compact('categories'));
    }

    public function retrive_archive($id)
    {

        Categorie::onlyTrashed()->find($id)->restore();

        notyf()
            ->position('x', 'center')
            ->position('y', 'top')
            ->addSuccess('Your feedback has been Retrive.');
        return  redirect()->back();
    }
    public function force_delete_archive($id)
    {
        // $objext =new ()->
        $categorie = Categorie::onlyTrashed()->find($id);


        // $result = FileTrait::delete_file(public_path("storage/Images/Categories/$categorie->file_name"));
        $result =  $categorie->forceDelete();
        if ($result) {
            notyf()
                ->position('x', 'center')
                ->position('y', 'top')
                ->addSuccess('Your feedback has been Deleteed.');
        } else {
            notyf()
                ->position('x', 'center')
                ->position('y', 'top')
                ->addError('Your feedback has been archived.');
        }

        return  redirect()->back();
    }
}

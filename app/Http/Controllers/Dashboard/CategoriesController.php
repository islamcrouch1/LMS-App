<?php

namespace App\Http\Controllers\Dashboard;

use App\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use Intervention\Image\ImageManagerStatic as Image;

class CategoriesController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth');
        $this->middleware('role:superadministrator|administrator');

        $this->middleware('permission:categories-read')->only('index' , 'show');
        $this->middleware('permission:categories-create')->only('create' , 'store');
        $this->middleware('permission:categories-update')->only('edit' , 'update');
        $this->middleware('permission:categories-delete')->only('destroy' , 'trashed');
        $this->middleware('permission:categories-restore')->only('restore');
    }


    public function index()
    {
        $categories = Category::whenSearch(request()->search)
        ->paginate(5);

        return view('dashboard.categories.index')->with('categories' , $categories);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('dashboard.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {


        $request->validate([

            'name_ar' => "required|string|max:255|unique:categories",
            'name_en' => "required|string|max:255|unique:categories",
            'image' => "required|image",
            'description_ar' => "required|string",
            'description_en' => "required|string",

            ]);


            Image::make($request['image'])->resize(300, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save(public_path('storage/images/categories/' . $request['image']->hashName()) , 60);

            $Category = Category::create([
                'name_ar' => $request['name_ar'],
                'name_en' => $request['name_en'],
                'description_ar' => $request['description_ar'],
                'description_en' => $request['description_en'],
                'image' => $request['image']->hashName()

            ]);


            session()->flash('success' , 'Category created successfully');



            $categories = Category::whenSearch(request()->search)
            ->paginate(5);

            return view('dashboard.categories.index')->with('categories' , $categories);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($lang , $Category)
    {

        $Category = Category::find($Category);
        return view('dashboard.categories.edit ')->with('category', $Category);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($lang ,Request $request, Category $Category)
    {

        $request->validate([

            'name_ar' => "required|string|max:255|unique:categories,name_ar," .$Category->id,
            'name_en' => "required|string|max:255|unique:categories,name_en," .$Category->id,
            'image' => "image",
            'description_ar' => "required|string",
            'description_en' => "required|string",


            ]);

            if($request->hasFile('image')){

                Storage::disk('public')->delete('/images/categories/' . $Category->image);


                Image::make($request['image'])->resize(300, null, function ($constraint) {
                    $constraint->aspectRatio();
                })->save(public_path('storage/images/categories/' . $request['image']->hashName()) , 60);

                $Category->update([
                    'image' => $request['image']->hashName(),
                ]);
            }



            $Category->update([
                'name_ar' => $request['name_ar'],
                'name_en' => $request['name_en'],
                'description_ar' => $request['description_ar'],
                'description_en' => $request['description_en'],

            ]);







            session()->flash('success' , 'Category updated successfully');

            $categories = Category::whenSearch(request()->search)
            ->paginate(5);

            return view('dashboard.categories.index')->with('categories' , $categories);


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($lang , $Category)
    {

        $Category = Category::withTrashed()->where('id' , $Category)->first();

        if($Category->trashed()){

            if(auth()->user()->hasPermission('categories-delete')){


                Storage::disk('public')->delete('/images/categories/' . $Category->image);
                $Category->forceDelete();


                session()->flash('success' , 'Category Deleted successfully');

                $categories = Category::onlyTrashed()->paginate(5);
                return view('dashboard.categories.index' , ['categories' => $categories]);
            }else{
                session()->flash('success' , 'Sorry.. you do not have permission to make this action');

                $categories = Category::onlyTrashed()->paginate(5);
                return view('dashboard.categories.index' , ['categories' => $categories]);
            }



        }else{

            if(auth()->user()->hasPermission('categories-trash')){
                $Category->delete();

                session()->flash('success' , 'Category trashed successfully');

                $categories = Category::whenSearch(request()->search)
                ->paginate(5);

                return view('dashboard.categories.index')->with('categories' , $categories);
            }else{
                session()->flash('success' , 'Sorry.. you do not have permission to make this action');

                $categories = Category::whenSearch(request()->search)
                ->paginate(5);

                return view('dashboard.categories.index')->with('categories' , $categories);
            }

        }


    }


    public function trashed()
    {

        $categories = Category::onlyTrashed()->paginate(5);
        return view('dashboard.categories.index' , ['categories' => $categories]);

    }

    public function restore( $lang , $Category)
    {

        $Category = Category::withTrashed()->where('id' , $Category)->first()->restore();

        session()->flash('success' , 'Category restored successfully');

        $categories = Category::whenSearch(request()->search)
        ->paginate(5);

        return view('dashboard.categories.index')->with('categories' , $categories);
    }

}

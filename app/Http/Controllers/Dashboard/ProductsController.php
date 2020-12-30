<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Product;
use App\Category;
use App\Country;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Storage;

use Intervention\Image\ImageManagerStatic as Image;

class ProductsController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth');
        $this->middleware('role:superadministrator|administrator');

        $this->middleware('permission:products-read')->only('index' , 'show');
        $this->middleware('permission:products-create')->only('create' , 'store');
        $this->middleware('permission:products-update')->only('edit' , 'update');
        $this->middleware('permission:products-delete')->only('destroy' , 'trashed');
        $this->middleware('permission:products-restore')->only('restore');
    }


    public function index()
    {
        $categories = Category::all();
        $countries = Country::all();
        $products = Product::whenSearch(request()->search)
        ->whenCategory(request()->category_id)
        ->whenCountry(request()->country_id)
        ->paginate(5);

        return view('dashboard.products.index')->with('products' , $products)->with('categories' , $categories)->with('countries' , $countries);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        $countries = Country::all();
        return view('dashboard.products.create')->with('categories' , $categories)->with('countries' , $countries);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {


        if($request['type'] == 'downloaded_product'){

            $request->validate([

                'down_link' => 'required|mimes:pdf,xlx,csv|max:6000',

                ]);

        }

        $request->validate([

            'name_ar' => "required|string|max:255|unique:products",
            'name_en' => "required|string|max:255|unique:products",
            'image' => "required|image",
            'description_ar' => "required|string",
            'description_en' => "required|string",
            'purchase_price' => "required|string",
            'sale_price' => "required|string",
            'stock' => "required|string",
            'type' => "required|string",
            'category_id' => "required",
            'country' => "required",


            ]);


            Image::make($request['image'])->resize(300, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save(public_path('storage/images/products/' . $request['image']->hashName()) , 60);


            if($request['type'] == 'downloaded_product'){

                $fileName = time(). '-' .  $request['name_en'] . '-' . $request['name_ar'] . '.'.$request['down_link']->extension();

                $request['down_link']->move(public_path('storage/products/files'), $fileName);
            }else{
                $fileName = '#';

            }



            $Product = Product::create([
                'name_ar' => $request['name_ar'],
                'name_en' => $request['name_en'],
                'description_ar' => $request['description_ar'],
                'description_en' => $request['description_en'],
                'image' => $request['image']->hashName(),
                'purchase_price' => $request['purchase_price'],
                'sale_price' => $request['sale_price'],
                'stock' => $request['stock'],
                'down_link' => $fileName,
                'category_id' => $request['category_id'],
                'type' => $request['type'],
                'country_id' => $request['country'],


            ]);


            session()->flash('success' , 'Product created successfully');
            return redirect()->route('products.index' , app()->getLocale());
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
    public function edit($lang , $Product)
    {
        $categories = Category::all();
        $countries = Country::all();
        $Product = Product::find($Product);
        return view('dashboard.products.edit ')->with('Product', $Product)->with('categories' , $categories)->with('countries' , $countries);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($lang ,Request $request, Product $Product)
    {

        // dd($request);


        if($request['type'] == 'downloaded_product'){

            $request->validate([

                'down_link' => 'mimes:pdf,xlx,csv|max:6000',

                ]);

        }

        $request->validate([

            'name_ar' => "required|string|max:255|unique:products,name_ar," .$Product->id,
            'name_en' => "required|string|max:255|unique:products,name_en," .$Product->id,
            'image' => "image",
            'description_ar' => "required|string",
            'description_en' => "required|string",
            'purchase_price' => "required|string",
            'sale_price' => "required|string",
            'stock' => "required|string",
            'type' => "required|string",
            'category_id' => "required",
            'country' => "required",


            ]);

            if($request->hasFile('image')){

                Storage::disk('public')->delete('/images/products/' . $Product->image);


                Image::make($request['image'])->resize(300, null, function ($constraint) {
                    $constraint->aspectRatio();
                })->save(public_path('storage/images/products/' . $request['image']->hashName()) , 60);

                $Product->update([
                    'image' => $request['image']->hashName(),
                ]);
            }

            if($request->hasFile('down_link')){


                if($Product->down_link == '#'){

                    if($request['type'] == 'downloaded_product'){

                        $fileName = time(). '-' .  $request['name_en'] . '-' . $request['name_ar'] . '.'.$request['down_link']->extension();

                        $request['down_link']->move(public_path('storage/products/files'), $fileName);
                    }else{
                        $fileName = '#';

                    }

                }else{

                    if($request['type'] == 'downloaded_product'){

                        Storage::disk('public')->delete('/products/files/' . $Product->down_link);


                        $fileName = time(). '-' .  $request['name_en'] . '-' . $request['name_ar'] . '.'.$request['down_link']->extension();

                        $request['down_link']->move(public_path('storage/products/files'), $fileName);
                    }else{
                        $fileName = '#';

                    }

                }
            }else{
                if($Product->down_link == '#'){
                    $fileName = '#';
                }else{

                    if($request['type'] == 'downloaded_product'){
                        $fileName = $Product->down_link ;
                    }else{

                        Storage::disk('public')->delete('/products/files/' . $Product->down_link);
                        $fileName = '#';
                    }
                }
            }



            $Product->update([
                'name_ar' => $request['name_ar'],
                'name_en' => $request['name_en'],
                'description_ar' => $request['description_ar'],
                'description_en' => $request['description_en'],
                'purchase_price' => $request['purchase_price'],
                'sale_price' => $request['sale_price'],
                'stock' => $request['stock'],
                'down_link' => $fileName,
                'category_id' => $request['category_id'],
                'type' => $request['type'],
                'country_id' => $request['country'],


            ]);







            session()->flash('success' , 'Product updated successfully');
            return redirect()->route('products.index' , app()->getLocale());


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($lang , $Product)
    {

        $Product = Product::withTrashed()->where('id' , $Product)->first();

        if($Product->trashed()){

            if(auth()->user()->hasPermission('products-delete')){


                Storage::disk('public')->delete('/images/products/' . $Product->image);
                $Product->forceDelete();


                session()->flash('success' , 'Product Deleted successfully');

                $countries = Country::all();
                $products = Product::onlyTrashed()
                ->whenSearch(request()->search)
                ->whenCategory(request()->category_id)
                ->whenCountry(request()->country_id)
                ->paginate(5);
                return view('dashboard.products.index')->with('products' , $products)->with('categories' , $categories)->with('countries' , $countries);

            }else{

                session()->flash('success' , 'Sorry.. you do not have permission to make this action');
                $countries = Country::all();
                $products = Product::onlyTrashed()
                ->whenSearch(request()->search)
                ->whenCategory(request()->category_id)
                ->whenCountry(request()->country_id)
                ->paginate(5);
                return view('dashboard.products.index')->with('products' , $products)->with('categories' , $categories)->with('countries' , $countries);
            }



        }else{



            if(auth()->user()->hasPermission('products-trash')){

                if($Product->orders > '0'){
                    session()->flash('success' , 'you can not delete this product because it is related with some users orders');
                    return redirect()->route('products.index' , app()->getLocale());
                }

                $Product->delete();

                session()->flash('success' , 'Product trashed successfully');
                return redirect()->route('products.index' , app()->getLocale());

            }else{

                session()->flash('success' , 'Sorry.. you do not have permission to make this action');
                return redirect()->route('products.index' , app()->getLocale());

            }

        }


    }


    public function trashed()
    {
        $categories = Category::all();
        $countries = Country::all();
        $products = Product::onlyTrashed()
        ->whenSearch(request()->search)
        ->whenCategory(request()->category_id)
        ->whenCountry(request()->country_id)
        ->paginate(5);
        return view('dashboard.products.index')->with('products' , $products)->with('categories' , $categories)->with('countries' , $countries);

    }

    public function restore( $lang , $Product)
    {
        $categories = Category::all();

        $Product = Product::withTrashed()->where('id' , $Product)->first()->restore();

        session()->flash('success' , 'Product restored successfully');
        return redirect()->route('products.index' , app()->getLocale());

    }
}

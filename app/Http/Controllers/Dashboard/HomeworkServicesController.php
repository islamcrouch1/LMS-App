<?php

namespace App\Http\Controllers\dashboard;

use App\Country;
use App\HomeworkService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeworkServicesController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth');
        $this->middleware('role:superadministrator|administrator');

        $this->middleware('permission:homework_services-read')->only('index' , 'show');
        $this->middleware('permission:homework_services-create')->only('create' , 'store');
        $this->middleware('permission:homework_services-update')->only('edit' , 'update');
        $this->middleware('permission:homework_services-delete')->only('destroy' , 'trashed');
        $this->middleware('permission:homework_services-restore')->only('restore');
    }


    public function index()
    {

        $countries = Country::all();

        $homework_services = HomeworkService::whenSearch(request()->search)
        ->whenCountry(request()->country_id)
        ->paginate(5);

        return view('dashboard.homework_services.index' , compact('homework_services' , 'countries'));

    }


    public function create()
    {

        $countries = Country::all();
        return view('dashboard.homework_services.create')->with('countries' , $countries);

    }


    public function store(Request $request)
    {
        $request->validate([

            'name_ar' => "required|string|max:255",
            'name_en' => "required|string|max:255",
            'description_ar' => "string",
            'description_en' => "string",
            'country' => "string",
            'price'=> "required|string",
            'teacher_commission'=> "required|string"

            ]);



            $homework_service = HomeworkService::create([
                'name_ar' => $request['name_ar'],
                'name_en' => $request['name_en'],
                'description_ar' => $request['description_ar'],
                'description_en' => $request['description_en'],
                'country_id' => $request['country'],
                'price' => $request['price'],
                'teacher_commission' => $request['teacher_commission'],
            ]);




            session()->flash('success' , 'Homework Service created successfully');

            return redirect()->route('homework_services.index' , ['lang'=>app()->getLocale()]);


    }


    public function edit($lang , $homework_service ,Request $request)
    {
        $homework_service = HomeworkService::find($homework_service);
        $countries = Country::all();
        return view('dashboard.homework_services.edit ')->with('homework_service', $homework_service)->with('countries' , $countries);
    }



    public function update($lang ,Request $request, HomeworkService $homework_service)
    {

        $request->validate([

            'name_ar' => "required|string|max:255",
            'name_en' => "required|string|max:255",
            'description_ar' => "string",
            'description_en' => "string",
            'country' => "string",
            'price'=> "required|string",
            'teacher_commission'=> "required|string"


            ]);



            $homework_service->update([

                'name_ar' => $request['name_ar'],
                'name_en' => $request['name_en'],
                'description_ar' => $request['description_ar'],
                'description_en' => $request['description_en'],
                'country_id' => $request['country'],
                'price' => $request['price'],
                'teacher_commission' => $request['teacher_commission'],

            ]);




            session()->flash('success' , 'Homework Service updated successfully');
            return redirect()->route('homework_services.index' , ['lang'=>app()->getLocale()]);



    }

    public function destroy($lang , $homework_service ,Request $request)
    {

        $homework_service = HomeworkService::withTrashed()->where('id' , $homework_service)->first();

        if($homework_service->trashed()){

            if(auth()->user()->hasPermission('homework_services-delete')){
                $homework_service->forceDelete();

                session()->flash('success' , 'Homework Service Deleted successfully');
                $countries = Country::all();
                $homework_services = HomeworkService::onlyTrashed()
                ->whenSearch(request()->search)
                ->whenCountry(request()->country_id)
                ->paginate(5);
                return view('dashboard.homework_services.index')->with('homework_services' , $homework_services)->with('countries' , $countries);

            }else{

                session()->flash('success' , 'Sorry.. you do not have permission to make this action');
                $countries = Country::all();
                $homework_services = HomeworkService::onlyTrashed()
                ->whenSearch(request()->search)
                ->whenCountry(request()->country_id)
                ->paginate(5);
                return view('dashboard.homework_services.index')->with('homework_services' , $homework_services)->with('countries' , $countries);

            }



        }else{

            if(auth()->user()->hasPermission('homework_services-trash')){

                $homework_service->delete();
                session()->flash('success' , 'Homework Service trashed successfully');
                return redirect()->route('homework_services.index' , ['lang'=>app()->getLocale()]);


            }else{

                session()->flash('success' , 'Sorry.. you do not have permission to make this action');
                return redirect()->route('homework_services.index' , ['lang'=>app()->getLocale()]);


            }

        }


    }


    public function trashed(Request $request)
    {

        $countries = Country::all();
        $homework_services = HomeworkService::onlyTrashed()
        ->whenSearch(request()->search)
        ->whenCountry(request()->country_id)
        ->paginate(5);
        return view('dashboard.homework_services.index')->with('homework_services' , $homework_services)->with('countries' , $countries);

    }

    public function restore( $lang , $homework_service , Request $request)
    {

        $homework_service = HomeworkService::withTrashed()->where('id' , $homework_service)->first()->restore();
        session()->flash('success' , 'Homework Service restored successfully');
        return redirect()->route('homework_services.index' , ['lang'=>app()->getLocale()]);


    }

}

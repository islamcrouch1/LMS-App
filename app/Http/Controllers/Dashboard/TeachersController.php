<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\User;
use App\Role;
use App\Country;
use App\Cart;
use App\Monitor;
use App\Teacher;
use App\Course;
use App\BankInformation;
use Carbon\Traits\Timestamp;
use Illuminate\Support\Facades\Hash;


use App\Wallet;


use Illuminate\Support\Facades\Storage;

use Intervention\Image\ImageManagerStatic as Image;

class TeachersController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth');
        $this->middleware('role:superadministrator|administrator');

        $this->middleware('permission:teachers-read')->only('index' , 'show');
        $this->middleware('permission:teachers-create')->only('create' , 'store');
        $this->middleware('permission:teachers-update')->only('edit' , 'update');
        $this->middleware('permission:teachers-delete')->only('destroy' , 'trashed');
        $this->middleware('permission:teachers-restore')->only('restore');
    }


    public function index()
    {
        $countries = Country::all();
        $courses = Course::all();
        $roles = Role::WhereRoleNot('superadministrator')->get();
        $users = User::whereRoleNot('superadministrator')
        ->whenSearch(request()->search)
        ->whenRole(request()->role_id)
        ->whenCountry(request()->country_id)
        ->whenType(request()->type)
        ->with('roles')
        ->latest()
        ->paginate(5);
        return view('dashboard.teachers.index' , compact('users' , 'roles' , 'countries','courses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $countries = Country::all();
        $roles = Role::WhereRoleNot(['superadministrator' , 'administrator'])->get();
        return view('dashboard.teachers.create')->with('roles' , $roles)->with('countries' , $countries);
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

            'name' => "required|string|max:255",
            'email' => "required|string|email|max:255|unique:users",
            'password' => "required|string|min:8|confirmed",
            'country' => "required",
            'phone' => "required|string",
            'parent_phone' => "string",
            'gender' => "required",
            'profile' => "image",
            'type' => "required|string",
            'role' => "required|string"


            ]);

            if($request['profile'] == ''){
                if($request['gender'] == 'male'){
                    $request['profile'] = 'avatarmale.png' ;
                }else{
                    $request['profile'] = 'avatarfemale.png' ;
                }
            }else{


                Image::make($request['profile'])->resize(300, null, function ($constraint) {
                    $constraint->aspectRatio();
                })->save(public_path('storage/images/users/' . $request['profile']->hashName()) , 60);
            }



            if($request['profile'] == 'avatarmale.png' || $request['profile'] == 'avatarfemale.png'){
                $image = $request['profile'];
            }else{
                $image = $request['profile']->hashName();
            }


            $request->phone = str_replace(' ', '', $request->phone);
            $request->phone = $request->phone_hide . $request->phone;
            $request->merge(['phone' => $request->phone]);

            $request->parent_phone = str_replace(' ', '', $request->parent_phone);
            $request->parent_phone = $request->parent_phone_hide . $request->parent_phone;
            $request->merge(['parent_phone' => $request->parent_phone]);

            $user = User::create([
                'name' => $request['name'],
                'email' => $request['email'],
                'password' => Hash::make($request['password']),
                'country_id' => $request['country'],
                'phone' => $request->phone,
                'gender' => $request['gender'],
                'profile' => $image,
                'type' => $request['type'],
                'parent_phone' => $request['parent_phone'],
            ]);

                if($request['role'] == '3'){
                    $user->attachRole($request['role']);
                }else{
                    $user->attachRoles(['administrator' , $request['role']]);

                    $monitor = Monitor::create([
                        'user_id'=>$user->id
                    ]);

                }


                if($user->type == 'teacher'){
                    Teacher::create([
                        'user_id' => $user->id,
                    ]);

                    BankInformation::create([
                        'user_id' => $user->id,
                    ]);

                }


                Cart::create([
                    'user_id' => $user->id,
                ]);

                Wallet::create([
                    'user_id' => $user->id,
                ]);


            session()->flash('success' , 'user created successfully');

            $user->callToVerifyAdmin();


            return redirect()->route('teachers.index' , app()->getLocale());


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show( $lang , User $teacher)
    {

        $user = $teacher;
        return view('dashboard.teachers.show')->with('user' , $user);
    }

    public function activate( $lang , User $user)
    {

        $user->markPhoneAsVerified();

        return redirect()->route('teachers.index' , app()->getLocale());



    }


    public function deactivate( $lang , User $user)
    {

        $user->forceFill([
            'phone_verified_at' => NULL ,

        ])->save();


        return redirect()->route('teachers.index' , app()->getLocale());


    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($lang , $teacher)
    {

        $countries = Country::all();
        $roles = Role::WhereRoleNot(['superadministrator' , 'administrator'])->get();
        $user = User::find($teacher);
        return view('dashboard.teachers.edit ' , compact('user' , 'roles' , 'countries'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($lang ,Request $request, User $teacher)
    {
        $user = $teacher;

        $request->validate([

            'name' => "required|string|max:255",
            'email' => "required|string|email|max:255|unique:users,email," . $user->id,
            'country' => "required",
            'phone' => "required|string|unique:users,phone," . $user->id,
            'gender' => "required",
            'profile' => "image",
            'type' => "required|string",
            'role' => "required|string",
            'parent_phone' => "string",


            ]);


            if($request->hasFile('profile')){

                if($user->profile == 'avatarmale.png' || $user->profile == 'avatarfemale.png'){

                    Image::make($request['profile'])->resize(300, null, function ($constraint) {
                        $constraint->aspectRatio();
                    })->save(public_path('storage/images/users/' . $request['profile']->hashName()) , 60);

                }else{
                    Storage::disk('public')->delete('/images/users/' . $user->profile);

                    Image::make($request['profile'])->resize(300, null, function ($constraint) {
                        $constraint->aspectRatio();
                    })->save(public_path('storage/images/users/' . $request['profile']->hashName()) , 60);

                }


                $user->update([
                    'profile' => $request['profile']->hashName(),
                ]);
            }

            if($user->type == 'student' && $request['type'] == 'teacher'){

                Teacher::create([
                    'user_id' => $user->id,
                ]);

            }elseif($user->type == 'teacher' && $request['type'] == 'student'){

                Teacher::where('user_id', $user->id)->delete();

            }

            $request->phone = str_replace(' ', '', $request->phone);
            $request->phone = $request->phone_hide . $request->phone;
            $request->merge(['phone' => $request->phone]);

            $request->parent_phone = str_replace(' ', '', $request->parent_phone);
            $request->parent_phone = $request->parent_phone_hide . $request->parent_phone;
            $request->merge(['parent_phone' => $request->parent_phone]);

            if($request->password == NULL){


                $user->update([
                    'name' => $request['name'],
                    'email' => $request['email'],
                    'country_id' => $request['country'],
                    'phone' => $request->phone,
                    'gender' => $request['gender'],
                    'type' => $request['type'],
                    'parent_phone' => $request['parent_phone'],
                ]);


            }else{
                $user->update([
                    'name' => $request['name'],
                    'email' => $request['email'],
                    'country_id' => $request['country'],
                    'phone' => $request->phone,
                    'gender' => $request['gender'],
                    'password' => Hash::make($request['password']),
                    'type' => $request['type'],
                    'parent_phone' => $request['parent_phone'],
                ]);

            }






            if($request['role'] == '3'){
                $user->detachRoles($user->roles);
                $user->attachRole($request['role']);
            }else{
                $user->detachRoles($user->roles);
                $user->attachRoles(['administrator' , $request['role']]);

            }

            session()->flash('success' , 'user updated successfully');

            return redirect()->route('teachers.index' , app()->getLocale());

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($lang , $teacher)
    {

        $user = User::withTrashed()->where('id' , $teacher)->first();

        if($user->trashed()){

            if(auth()->user()->hasPermission('teachers-delete')){


                Storage::disk('public')->delete('/images/users/' . $user->profile);

                $user->forceDelete();

                session()->flash('success' , 'user Deleted successfully');
                $countries = Country::all();
                $courses = Course::all();
                $roles = Role::WhereRoleNot('superadministrator')->get();
                $users = User::onlyTrashed()
                ->whereRoleNot('superadministrator')
                ->whenSearch(request()->search)
                ->whenRole(request()->role_id)
                ->whenCountry(request()->country_id)
                ->whenType(request()->type)
                ->with('roles')
                ->latest()
                ->paginate(5);


            return view('dashboard.teachers.index' , compact('users' , 'roles' , 'countries' ,'courses'));
            }else{
                session()->flash('success' , 'Sorry.. you do not have permission to make this action');
                $countries = Country::all();
                $courses = Course::all();
                $roles = Role::WhereRoleNot('superadministrator')->get();
                $users = User::onlyTrashed()
                ->whereRoleNot('superadministrator')
                ->whenSearch(request()->search)
                ->whenRole(request()->role_id)
                ->whenCountry(request()->country_id)
                ->whenType(request()->type)
                ->with('roles')
                ->latest()
                ->paginate(5);


            return view('dashboard.teachers.index' , compact('users' , 'roles' , 'countries' ,'courses'));
            }


        }else{
            if(auth()->user()->hasPermission('teachers-trash')){
                $user->delete();

                session()->flash('success' , 'user trashed successfully');
                return redirect()->route('teachers.index' , app()->getLocale());

            }else{
                session()->flash('success' , 'Sorry.. you do not have permission to make this action');
                return redirect()->route('teachers.index' , app()->getLocale());

            }

        }


    }



    public function trashed()
    {
        $countries = Country::all();
        $courses = Course::all();
        $roles = Role::WhereRoleNot('superadministrator')->get();
            $users = User::onlyTrashed()
            ->whereRoleNot('superadministrator')
            ->whenSearch(request()->search)
            ->whenRole(request()->role_id)
            ->whenCountry(request()->country_id)
            ->whenType(request()->type)
            ->with('roles')
            ->latest()
            ->paginate(5);


        return view('dashboard.teachers.index' , compact('users' , 'roles' , 'countries' ,'courses'));

    }

    public function restore( $lang , $teacher)
    {

        $user = User::withTrashed()->where('id' , $teacher)->first()->restore();

        session()->flash('success' , 'user restored successfully');
        return redirect()->route('teachers.index' , app()->getLocale());

    }


}

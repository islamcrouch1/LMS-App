<?php

namespace App\Http\Controllers\Dashboard;
use App\Http\Controllers\Controller;
use App\User;
use App\Role;
use App\Country;
use App\Cart;

use Illuminate\Support\Facades\Hash;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use Intervention\Image\ImageManagerStatic as Image;

class AdminUsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function __construct()
    {
        // $this->middleware('auth');
        $this->middleware('role:superadministrator|administrator');

        $this->middleware('permission:users-read')->only('index' , 'show');
        $this->middleware('permission:users-create')->only('create' , 'store');
        $this->middleware('permission:users-update')->only('edit' , 'update');
        $this->middleware('permission:users-delete')->only('destroy' , 'trashed');
        $this->middleware('permission:users-restore')->only('restore');
    }


    public function index()
    {
        $countries = Country::all();
        $roles = Role::WhereRoleNot('superadministrator')->get();
        $users = User::whereRoleNot('superadministrator')
        ->whenSearch(request()->search)
        ->whenRole(request()->role_id)
        ->whenCountry(request()->country_id)
        ->with('roles')
        ->paginate(5);
        return view('dashboard.users.index' , compact('users' , 'roles' , 'countries'));
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
        return view('dashboard.users.create')->with('roles' , $roles)->with('countries' , $countries);
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




            $user = User::create([
                'name' => $request['name'],
                'email' => $request['email'],
                'password' => Hash::make($request['password']),
                'country_id' => $request['country'],
                'phone' => $request['phone'],
                'gender' => $request['gender'],
                'profile' => $image,
                'type' => $request['type']
            ]);

                if($request['role'] == '3'){
                    $user->attachRole($request['role']);
                }else{
                    $user->attachRoles(['administrator' , $request['role']]);

                }



                Cart::create([
                    'user_id' => $user->id,
                ]);


            session()->flash('success' , 'user created successfully');

            $countries = Country::all();
            $roles = Role::WhereRoleNot('superadministrator')->get();
            $users = User::whereRoleNot('superadministrator')
            ->whenSearch(request()->search)
            ->whenRole(request()->role_id)
            ->whenCountry(request()->country_id)
            ->with('roles')
            ->paginate(5);
            return view('dashboard.users.index' , compact('users' , 'roles' , 'countries'));


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show( $lang , User $user)
    {

        return view('dashboard.users.show')->with('user' , $user);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($lang , $user)
    {

        $countries = Country::all();
        $roles = Role::WhereRoleNot(['superadministrator' , 'administrator'])->get();
        $user = User::find($user);
        return view('dashboard.users.edit ' , compact('user' , 'roles' , 'countries'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($lang ,Request $request, User $user)
    {
        $request->validate([

            'name' => "required|string|max:255",
            'email' => "required|string|email|max:255|unique:users,email," . $user->id,
            'country' => "required",
            'phone' => "required|string|unique:users,phone," . $user->id,
            'gender' => "required",
            'profile' => "image",
            'type' => "required|string",
            'role' => "required|string"

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


                Storage::disk('public')->delete('/images/use/' . $user->profile);


                Storage::disk('public')->delete($user->profile);
                $user->update([
                    'profile' => $request['profile']->hashName(),
                ]);
            }

            if($request->password == NULL){


                $user->update([
                    'name' => $request['name'],
                    'email' => $request['email'],
                    'country_id' => $request['country'],
                    'phone' => $request['phone'],
                    'gender' => $request['gender'],
                    'type' => $request['type']
                ]);


            }else{
                $user->update([
                    'name' => $request['name'],
                    'email' => $request['email'],
                    'country_id' => $request['country'],
                    'phone' => $request['phone'],
                    'gender' => $request['gender'],
                    'password' => Hash::make($request['password']),
                    'type' => $request['type']
                ]);

            }






            $user->syncRoles(['administrator' , $request['role']]);

            session()->flash('success' , 'user updated successfully');

            $countries = Country::all();
            $roles = Role::WhereRoleNot('superadministrator')->get();
            $users = User::whereRoleNot('superadministrator')
            ->whenSearch(request()->search)
            ->whenRole(request()->role_id)
            ->whenCountry(request()->country_id)
            ->with('roles')
            ->paginate(5);
            return view('dashboard.users.index' , compact('users' , 'roles' , 'countries'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($lang , $user)
    {

        $user = User::withTrashed()->where('id' , $user)->first();

        if($user->trashed()){

            if(auth()->user()->hasPermission('users-delete')){


                Storage::disk('public')->delete('/images/users/' . $user->profile);

                $user->forceDelete();

                session()->flash('success' , 'user Deleted successfully');
                $countries = Country::all();
                $roles = Role::WhereRoleNot('superadministrator')->get();
                $users = User::onlyTrashed()
                ->whereRoleNot('superadministrator')
                ->whenSearch(request()->search)
                ->whenRole(request()->role_id)
                ->whenCountry(request()->country_id)
                ->with('roles')
                ->paginate(5);


            return view('dashboard.users.index' , compact('users' , 'roles' , 'countries'));
            }else{
                session()->flash('success' , 'Sorry.. you do not have permission to make this action');
                $countries = Country::all();
                $roles = Role::WhereRoleNot('superadministrator')->get();
                $users = User::onlyTrashed()
                ->whereRoleNot('superadministrator')
                ->whenSearch(request()->search)
                ->whenRole(request()->role_id)
                ->whenCountry(request()->country_id)
                ->with('roles')
                ->paginate(5);


            return view('dashboard.users.index' , compact('users' , 'roles' , 'countries'));
            }


        }else{
            if(auth()->user()->hasPermission('users-trash')){
                $user->delete();

                session()->flash('success' , 'user trashed successfully');
                $countries = Country::all();
                $roles = Role::WhereRoleNot('superadministrator')->get();
                $users = User::whereRoleNot('superadministrator')
                ->whenSearch(request()->search)
                ->whenRole(request()->role_id)
                ->whenCountry(request()->country_id)
                ->with('roles')
                ->paginate(5);
                return view('dashboard.users.index' , compact('users' , 'roles' , 'countries'));
            }else{
                session()->flash('success' , 'Sorry.. you do not have permission to make this action');
                $countries = Country::all();
                $roles = Role::WhereRoleNot('superadministrator')->get();
                $users = User::whereRoleNot('superadministrator')
                ->whenSearch(request()->search)
                ->whenRole(request()->role_id)
                ->whenCountry(request()->country_id)
                ->with('roles')
                ->paginate(5);
                return view('dashboard.users.index' , compact('users' , 'roles' , 'countries'));
            }

        }


    }



    public function trashed()
    {
        $countries = Country::all();
        $roles = Role::WhereRoleNot('superadministrator')->get();
            $users = User::onlyTrashed()
            ->whereRoleNot('superadministrator')
            ->whenSearch(request()->search)
            ->whenRole(request()->role_id)
            ->whenCountry(request()->country_id)
            ->with('roles')
            ->paginate(5);


        return view('dashboard.users.index' , compact('users' , 'roles' , 'countries'));

    }

    public function restore( $lang , $user)
    {

        $user = User::withTrashed()->where('id' , $user)->first()->restore();

        session()->flash('success' , 'user restored successfully');
        $countries = Country::all();
        $roles = Role::WhereRoleNot('superadministrator')->get();
            $users = User::whereRoleNot('superadministrator')
            ->whenSearch(request()->search)
            ->whenRole(request()->role_id)
            ->whenCountry(request()->country_id)
            ->with('roles')
            ->paginate(5);
            return view('dashboard.users.index' , compact('users' , 'roles' , 'countries'));
    }
}

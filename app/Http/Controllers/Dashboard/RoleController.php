<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Role;

class RoleController extends Controller
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

        $this->middleware('permission:roles-read')->only('index' , 'show');
        $this->middleware('permission:roles-create')->only('create' , 'store');
        $this->middleware('permission:roles-update')->only('edit' , 'update');
        $this->middleware('permission:roles-delete')->only('destroy' , 'trashed');
        $this->middleware('permission:roles-restore')->only('restore');
    }


    public function index()
    {
        $roles = Role::WhereRoleNot(['superadministrator' , 'Administrator' , 'user'])
        ->whenSearch(request()->search)
        ->with('permissions')
        ->withCount('users')
        ->paginate(5);
        return view('dashboard.roles.index')->with('roles' , $roles);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.roles.create');
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

            'name' => "required|string|unique:roles,name",
            'description' => "string",
            'permissions' => "required|array|min:1",

            ]);


            $role = Role::create($request->all());
            $role->attachPermissions($request->permissions);


            
            session()->flash('success' , 'Role created successfully');

            $roles = Role::WhereRoleNot(['superadministrator' , 'Administrator' , 'user'])->whenSearch(request()->search)->paginate(5);
            return view('dashboard.roles.index')->with('roles' , $roles);


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
    public function edit($lang , $role)
    {
        $role = Role::find($role);
        return view('dashboard.roles.edit ')->with('role', $role);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($lang ,Request $request, Role $role)
    {
        $request->validate([

            'name' => "required|string|unique:roles,name," .$role->id ,
            'description' => "string",
            'permissions' => "required|array|min:1",

            ]);


            $role->update($request->all());
            $role->syncPermissions($request->permissions);


            
            session()->flash('success' , 'Role updated successfully');

            $roles = Role::WhereRoleNot(['superadministrator' , 'Administrator' , 'user'])->whenSearch(request()->search)->paginate(5);
            return view('dashboard.roles.index')->with('roles' , $roles);


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($lang , $role)
    {
        
        $role = Role::withTrashed()->where('id' , $role)->first();

        if($role->trashed()){

            if(auth()->user()->hasPermission('roles-delete')){
                $role->forceDelete();

                session()->flash('success' , 'Role Deleted successfully');
    
                $roles = Role::onlyTrashed()->paginate(5);
                return view('dashboard.roles.index' , ['roles' => $roles]);
            }else{
                session()->flash('success' , 'Sorry.. you do not have permission to make this action');
    
                $roles = Role::onlyTrashed()->paginate(5);
                return view('dashboard.roles.index' , ['roles' => $roles]);
            }



        }else{

            if(auth()->user()->hasPermission('roles-trash')){
                $role->delete();

                session()->flash('success' , 'Role trashed successfully');
        
                $roles = Role::WhereRoleNot(['superadministrator' , 'Administrator' , 'user'])->whenSearch(request()->search)->paginate(5);
                return view('dashboard.roles.index')->with('roles' , $roles);
            }else{
                session()->flash('success' , 'Sorry.. you do not have permission to make this action');
        
                $roles = Role::WhereRoleNot(['superadministrator' , 'Administrator' , 'user'])->whenSearch(request()->search)->paginate(5);
                return view('dashboard.roles.index')->with('roles' , $roles);
            }
 
        }


    }



    public function trashed()
    {
       
        $roles = Role::onlyTrashed()->paginate(5);
        return view('dashboard.roles.index' , ['roles' => $roles]);
        
    }

    public function restore( $lang , $role)
    {

        $role = Role::withTrashed()->where('id' , $role)->first()->restore();

        session()->flash('success' , 'Role restored successfully');
    
        $roles = Role::WhereRoleNot(['superadministrator' , 'Administrator' , 'user'])->whenSearch(request()->search)->paginate(5);
        return view('dashboard.roles.index')->with('roles' , $roles);
    }
}

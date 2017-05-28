<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


use Illuminate\Support\Facades\Auth;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use Illuminate\Support\Facades\Session;

class PermissionController extends Controller
{

    public function __construct(){
        $this->middleware(['auth', 'isAdmin']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $permissions = Permission::all();

        return view('layouts.permissions.index', compact('permissions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::get();

        return view('layouts.permissions.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //validation
        $this->validate($request, [
            'name' => 'required|max:40'
        ]);

        $name = $request['name'];
        $permission = new Permission();
        $permission->name = $name;

        $roles = $request['roles'];

        $permission->save();

        //if one or more roles is selected
        if(!empty($roles)){
            foreach($roles as $role) {
                $r = Role::where('id', '=', $role)->firstOrFail();

                $permission = Permission::where('name', '=', $name)->first();
                $r->givePermissionTo($permission);
            }

        }

        return redirect()->route('permissions.index')
            ->with('flash_message', 'Permission ' .$name. ' added!');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $permission = Permission::findOrFail($id);

        return view('layouts.permissions.show', compact('permission'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $permission = Permission::findOrFail($id);
        $roles = Role::all();
        return view('layouts.permissions.edit', compact('permission', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $permission = Permission::findOrFail($id);

        //validation
        $this->validate($request, [
            'name' => 'required|max:40',
            'roles' => 'required'
        ]);


        $inputWo = $request->except(['roles']);
        $roles = $request['roles'];
        $permission->fill($inputWo)->save();



        //remove all permissions associated with role

        //re-assign given roles

        foreach($roles as $role){
            //permission in db
            $role = Permission::where('id', '=', $role)->firstOrFail();
            //Assign permission to role
            $permission->assignRole($role);
        }

        return redirect()->route('roles.index')
            ->with('flash_message', 'Role ' .$role->name. ' updated');



        return redirect()->route('permissions.index')
            ->with('flash_message', 'Permission ' .$permission->name. ' updated');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $permission = Permission::findOrFail($id);

        if($permission->name == "Administer roles & permissions") {
            return redirect()->route('permissions.index')
                ->with('flash_message', 'Cannot delete this permission!');
        }

        $permission->delete();

        return redirect()->route('permissions.index')
            ->with('flash_message', 'Permission ' .$permission->name. ' deleted!');
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use Illuminate\Support\Facades\Session;

class RoleController extends Controller
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
        $roles = Role::all();

        return view('roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $permissions = Permission::all();

        return view('roles.create', compact('permissions'));
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
            'name' => 'required|unique:roles|max:20',
            'permissions' => 'required',
        ]);

        $name = $request['name'];
        $role = new Role();
        $role->name = $name;

        $permissions = $request['permissions'];

        $role->save();

        foreach($permissions as $permission) {
            $p = Permission::where('id', '=', $permission);
            $role = Role::where('name', '=', $name);
            $role->givePermissionTo($p);
        }

        return redirect()->route('roles.index')
            ->with('flash_message', 'Role ' .$role->name. ' added');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $roles = Role::all();

        return view('roles.show', compact('roles'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $role = Role::findOrFail($id);
        $permissions = Permission::all();

        return view('roles.edit', compact('role', 'permissions'));
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
        //get the role with given id
        $role = Role::findOrFail($id);

        //validation
        $this->validate($request, [
            'name' => 'required|max:20|unique:roles,name,'.$id,
            'permissions' => 'required',
        ]);

        //seperate permissions into another variable from request for later use
        $input = $request->except(['permissions']);
        $permissions = $request['permissions'];
        $role->fill($input)->save();

        //get all permissions
        $p_all = Permission::all();

        //remove all permissions associated with role
        foreach($p_all as $p){
            $role->revokePermissionTo($p);
        }
        //re-assign given roles
        foreach($permissions as $permission){
            //permission in db
            $permission = Permission::where('id', '=', $permission)->firstOrFail();
            //Assign permission to role
            $role->givePermissionTo($permission);
        }

        return redirect()->route('roles.index')
            ->with('flash_message', 'Role ' .$role->name. 'updated');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $role = Role::findOrFail($id);
        $role->delete();

        return redirect()->route('roles.index')
            ->with('flash_message', 'Role ' .$role->name. ' deleted');
    }
}

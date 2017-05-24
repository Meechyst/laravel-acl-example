<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;

//Importing laravel-permission models
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserController extends Controller
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
        $users = User::all();

        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::get();

        return view('users.create', ['roles' => $roles]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Validation
        $this->validate($request, [
          'name' => 'required|max:100',
          'email' => 'required|email|unique:users',
          'password' => 'required|min:6|confirmed'
        ]);
        //create the user
        $user = User::create($request->only('name', 'email', 'password'));

        //get roles field
        $roles = $request['roles'];

        //check if a role was selected
        if(isset($roles)){
          foreach($roles as $role){
            $role_r = Role::where('id', '=', $role)->firstOrFail();
            $user->assignRole($role_r); //assign that role to user
          }
        }

        return redirect()->route('users.index')
          ->with('flash_message', 'User successfully created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::findOrFail($id);

        return view('users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        $roles = Role::get();

        return view('users.edit', compact('user', 'roles'));
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
        //get the user
        $user = User::findOrFail($id);

        //validation
        $this->validate($request, [
          'name' => 'required|max:100',
          'email' => 'required|email|unique:users,email,'.$id,
          'password' => 'required|min:6|confirmed'
        ]);

        $input = $request->only(['name', 'email', 'password']);
        $roles = $request['roles'];
        //using fill here because we already got an instance of the user
        $user->fill($input)->save();

        if(isset($roles)){
          $user->roles()->sync($roles);
        }else{
          $user->roles()->detach();
        }

        return redirect()->route('users.index')
        ->with('flash_message', 'User successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('users.index')
          ->with('flash_message', 'User successfully deleted');
    }
}

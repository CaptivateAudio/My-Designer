<?php

namespace MyDesigner\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use MyDesigner\Http\Controllers\Controller;

use MyDesigner\Http\Requests\StoreUserRequest;

use MyDesigner\Models\User;
use MyDesigner\Models\Role;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:admin');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$users = User::all();
        $users = User::where('id', '!=', Auth::id())->get();

        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::all();
        return view('admin.users.create', [ 'roles' => $roles ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request)
    {
        //$user = User::create($request->all());

        $role = Role::findOrFail($request->role);
        $user = User::create($request->all());
        $user
           ->roles()
           ->attach(Role::where('id', $request->role)->first());

        return redirect()->route('admin.users.create')->with('success', 'User added successfully.');
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
    public function edit($id)
    {
        $user = User::findOrFail($id);
        $roles = Role::all();
        $user_role_id = $user->roles()->where('user_id', $user->id)->first();
        return view('admin.users.edit', compact('user', 'roles', 'user_role_id'));
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
        $user = User::findOrFail($id);
        $role = Role::findOrFail($request->role);
        
        //$user->save($request->all());
        if($user->email != $request->email) {
            $validator = $request->validate([
                'email' => 'required|email|max:255|unique:users'
            ]);

            $user->email = request('email');
        }

        if( ! empty($request->password) ) {

            $validator = $request->validate([
                'password'     => 'min:8|confirmed',
            ]);

            $user->password = Hash::make($request->password);
        }

        $validator = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'credits' => 'required|integer',
        ]);

        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->credits = $request->credits;

        $user->save();

        $user->roles()->detach();

        $user
           ->roles()
           ->attach(Role::where('id', $request->role)->first());

        return redirect()->route('admin.users.edit', $user->id)->with('success', 'User updated successfully.');
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
        return redirect()->route('admin.users.index')->with(['message' => 'User deleted successfully']);
    }
}

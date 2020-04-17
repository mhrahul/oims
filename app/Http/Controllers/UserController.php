<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Validator;

class UserController extends Controller
{
    public function index()
    {
        $data = User::with('roles')->get();
        return view('users')->with('data', $data);
    }

    public function createUsers()
    {
        $data = Role::get();
        return view('create-users')->with('roles', $data);
    }

    public function createUserProcess(Request $request)
    {        
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'role' => 'required'
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        $username = $request->input('username');
        $email = str_replace(' ', '', $username) . "@rblbd.com";
        $role = $request->input('role');
        $password = Hash::make($request->input('password'));
        if (!isset($password)) {
            $password = Hash::make("123456");
        }

        $nuser = new User;
        $nuser->name = $username;
        $nuser->email = $email;
        $nuser->password = $password;
        $nuser->save();

        $uid = $nuser->id;
        $user = User::find($uid);
        $user->assignRole($role);
        return redirect('users');
    }

    public function deleteUser(Request $request)
    {
        $id = $request->input('id');
        $deleteU = User::findOrFail($id);
        $deleteU->delete();
        return redirect('users');
    }

    public function assignRoles($id)
    {
        $roledata = Role::get();
        $data = array('roledata' => $roledata, 'uid' => $id);
        return view('assign-role')->with($data);
    }

    public function assignRolesProcess(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'uid' => 'required',
            'role' => 'required'
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        $user = User::find($request->input('uid'));
        $user->assignRole($request->input('role'));

        return redirect('users')->with('success', 'User created successfully.');
    }
}

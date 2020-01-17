<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Validator;

class UserController extends Controller
{
    public function index()
    {
        $data = User::with('roles')->get();
        return view('users')->with('data', $data);
        // return response()->json(['data' => $data], 200);
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

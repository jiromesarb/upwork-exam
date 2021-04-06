<?php

namespace App\Http\Controllers;

use Validator;

use App\Models\Department;
use App\Models\Position;
use App\Models\User;
use App\Models\UserDepartment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('index-users');
        $users = User::orderBy('id', 'desc')->with(['position', 'departments'])->paginate(10);

        return view('pages.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create-users');
        $positions = Position::latest()->get();
        $departments = Department::latest()->get();
        return view('pages.users.create', compact('positions', 'departments'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('store-users');
        $v = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|unique:users,name',
            'position_id' => 'required',
            'departments' => 'required',
        ]);
        if ($v->fails()) return back()->withInput()->withErrors($v->errors());

        // Store Employee
        $request->request->set('password', Hash::make('P@ssword123'));
        $user = User::create($request->all());
        if ($user) {
            // Store User Departments
            $userDepartments = [];
            foreach($request->departments as $department){
                $userDepartments[] = [
                    'user_id' => $user->id,
                    'department_id' => $department,
                ];
            }

            if(UserDepartment::insert($userDepartments)){
                return back()->with([
                    'notif.style' => 'success',
                    'notif.icon' => 'plus-circle',
                    'notif.message' => 'Insert successfully!',
                ]);
            } else {
                return back()->withInput()->with([
                    'notif.style' => 'danger',
                    'notif.icon' => 'times-circle',
                    'notif.message' => 'Failed to Insert',
                ]);
            }
        }
        else {
            return back()->withInput()->with([
                'notif.style' => 'danger',
                'notif.icon' => 'times-circle',
                'notif.message' => 'Failed to Insert',
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $this->authorize('edit-users');
        $positions = Position::latest()->get();
        $departments = Department::latest()->get();
        return view('pages.users.edit', compact('user', 'positions', 'departments'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(User $user, Request $request)
    {
        $this->authorize('update-users');
        $v = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|unique:users,name',
            'position_id' => 'required',
            'departments' => 'required',
        ]);
        if ($v->fails()) return back()->withInput()->withErrors($v->errors());

        if($user->update($request->except('departments', '_token', '_method'))){
            UserDepartment::where('user_id', $user->id)->delete();

            $userDepartments = [];
            foreach($request->departments as $departmentId){
                $userDepartments[] = [
                    'user_id' => $user->id,
                    'department_id' => $departmentId,
                ];
            }
            UserDepartment::insert($userDepartments);

            return back()->with([
                'notif.style' => 'success',
                'notif.icon' => 'plus-circle',
                'notif.message' => 'Updated!',
            ]);
        } else {
            return back()->withInput()->with([
                'notif.style' => 'danger',
                'notif.icon' => 'times-circle',
                'notif.message' => 'Failed to Update',
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $this->authorize('destroy-users');
        if ($user->delete()) {
            return back()->with([
                'notif.style' => 'success',
                'notif.icon' => 'plus-circle',
                'notif.message' => 'Deleted successful!',
            ]);
        }
        else {
            return back()->with([
                'notif.style' => 'danger',
                'notif.icon' => 'times-circle',
                'notif.message' => 'Failed to Delete',
            ]);
        }
    }
}

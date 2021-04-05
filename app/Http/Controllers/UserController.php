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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

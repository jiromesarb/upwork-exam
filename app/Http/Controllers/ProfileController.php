<?php

namespace App\Http\Controllers;

use Validator;

use App\Models\Department;
use App\Models\Position;
use App\Models\User;
use App\Models\UserDepartment;
use Illuminate\Http\Request;
use Image;
use Storage;

class ProfileController extends Controller
{
    public function show(){
        $user = User::with(['position', 'departments'])->first();
        return view('pages.profile.show', compact('user'));
    }

    public function edit(){
        $positions = Position::latest()->get();
        $departments = Department::latest()->get();
        $user = User::with(['position', 'departments'])->first();
        return view('pages.profile.edit', compact('user', 'positions', 'departments'));
    }

    public function update($id, Request $request){
        $v = Validator::make($request->all(), [
            'picture' => 'mimes:jpeg,jpg,png,bmp,tiff',
            'name' => 'required',
            'email' => 'required|unique:users,email,' . $id,
            'position_id' => 'required',
            'departments' => 'required',
        ]);
        if ($v->fails()) return back()->withInput()->withErrors($v->errors());

        $user = User::with(['departments'])->where('id', $id)->first();

        if($request->hasFile('profile')) {
            $image = $request->file('profile');
            $getFileName = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);

            $fileName = $getFileName . '-' . time() . '.' . $image->getClientOriginalExtension();

            $img = Image::make($image->getRealPath());
            $img->stream(); // <-- Key point
            if($user->profile){

                $profilePicturePath = public_path() . '/assets/images/users/' . $user->profile;
                if(file_exists($profilePicturePath)){
                    unlink($profilePicturePath);
                }
            }
            Storage::disk('public')->put('assets/images/users/'.'/'.$fileName, $img, 'public');
            $user->update(['profile' => $fileName]);
        }

        if($user->update($request->except('departments', '_token', '_method', 'profile'))){
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
}

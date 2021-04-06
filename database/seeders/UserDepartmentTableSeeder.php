<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\User;
use App\Models\UserDepartment;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class UserDepartmentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        $users = User::get();
        $departments = Department::get();

        $userDepartments = [];
        foreach($users as $user){
            $selectDepartments = $faker->randomElements($departments);
            foreach($selectDepartments as $selectDepartment){
                $userDepartments[] = [
                    'user_id' => $user->id,
                    'department_id' => $selectDepartment->id,
                ];
            }
        }

        UserDepartment::insert($userDepartments);
    }
}

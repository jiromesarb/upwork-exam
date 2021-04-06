<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Seeder;

class DepartmentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $departments = [
            ['name' => 'IT Department'],
            ['name' => 'HR Department'],
            ['name' => 'Finance Department'],
        ];

        Department::insert($departments);
    }
}

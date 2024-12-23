<?php

namespace Database\Seeders;

use App\Models\Designation;
use Illuminate\Database\Seeder;

class DesignationSeeder extends Seeder
{

    public function run()
    {
        // Corporate Division =1
        Designation::create([
            'division_id' => 1,
            'name' => 'Executive Director'
        ]);
        Designation::create([
            'division_id' => 1,
            'name' => 'Senior General Manager'
        ]);
        Designation::create([
            'division_id' => 1,
            'name' => 'Deputy General Manager'
        ]);
        Designation::create([
            'division_id' => 1,
            'name' => 'Assistant General Manager'
        ]);
        Designation::create([
            'division_id' => 1,
            'name' => 'Senior Manager'
        ]);
        Designation::create([
            'division_id' => 1,
            'name' => 'Manager'
        ]);
        Designation::create([
            'division_id' => 1,
            'name' => 'Deputy Manager'
        ]);
        Designation::create([
            'division_id' => 1,
            'name' => 'Assistant  Manager'
        ]);
        Designation::create([
            'division_id' => 1,
            'name' => 'Senior Executive'
        ]);
        Designation::create([
            'division_id' => 1,
            'name' => 'Executive'
        ]);
        Designation::create([
            'division_id' => 1,
            'name' => 'Junior Executive'
        ]);
        Designation::create([
            'division_id' => 1,
            'name' => 'Management Trainee'
        ]);

        // Factory Division =2

        Designation::create([
            'division_id' => 2,
            'name' => 'Executive Director'
        ]);
        Designation::create([
            'division_id' => 2,
            'name' => 'Senior General Manager'
        ]);
        Designation::create([
            'division_id' => 2,
            'name' => 'Deputy General Manager'
        ]);
        Designation::create([
            'division_id' => 2,
            'name' => 'Assistant General Manager'
        ]);
        Designation::create([
            'division_id' => 2,
            'name' => 'Senior Manager'
        ]);
        Designation::create([
            'division_id' => 2,
            'name' => 'Manager'
        ]);
        Designation::create([
            'division_id' => 2,
            'name' => 'Deputy Manager'
        ]);
        Designation::create([
            'division_id' => 2,
            'name' => 'Assistant  Manager'
        ]);
        Designation::create([
            'division_id' => 2,
            'name' => 'Senior Executive'
        ]);
        Designation::create([
            'division_id' => 2,
            'name' => 'Production Officer'
        ]);
        Designation::create([
            'division_id' => 2,
            'name' => 'Executive'
        ]);
        Designation::create([
            'division_id' => 2,
            'name' => 'APO'
        ]);
        Designation::create([
            'division_id' => 2,
            'name' => 'Junior Executive'
        ]);
        Designation::create([
            'division_id' => 2,
            'name' => 'Management Trainee'
        ]);

        // Fabric Division =3

        Designation::create([
            'division_id' => 3,
            'name' => 'Executive Director'
        ]);
        Designation::create([
            'division_id' => 3,
            'name' => 'Senior General Manager'
        ]);
        Designation::create([
            'division_id' => 3,
            'name' => 'Deputy General Manager'
        ]);
        Designation::create([
            'division_id' => 3,
            'name' => 'Assistant General Manager'
        ]);
        Designation::create([
            'division_id' => 3,
            'name' => 'Senior Manager'
        ]);
        Designation::create([
            'division_id' => 3,
            'name' => 'Manager'
        ]);
        Designation::create([
            'division_id' => 3,
            'name' => 'Deputy Manager'
        ]);
        Designation::create([
            'division_id' => 3,
            'name' => 'Assistant  Manager'
        ]);
        Designation::create([
            'division_id' => 3,
            'name' => 'Senior Executive'
        ]);
        Designation::create([
            'division_id' => 3,
            'name' => 'Production Officer'
        ]);
        Designation::create([
            'division_id' => 3,
            'name' => 'Executive'
        ]);
        Designation::create([
            'division_id' => 3,
            'name' => 'APO'
        ]);
        Designation::create([
            'division_id' => 3,
            'name' => 'Junior Executive'
        ]);
        Designation::create([
            'division_id' => 3,
            'name' => 'Management Trainee'
        ]);
    }
}

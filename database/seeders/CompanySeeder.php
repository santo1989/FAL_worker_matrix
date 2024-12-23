<?php

namespace Database\Seeders;

use App\Models\Company;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // division 1 = Corporate
        // division 2 = Factory
        // division 3 = Fabric 
        //1
        Company::create([
            'division_id' => 1,
            'name' => 'Common Office'
        ]);
        //2
        Company::create([
            'division_id' => 2,
            'name' => 'TIL - Factory'
        ]);

        //3
        Company::create([
            'division_id' => 2,
            'name' => 'FAL - Factory'
        ]);
        //4
        Company::create([
            'division_id' => 2,
            'name' => 'NCL - Factory'
        ]);
        //5
        Company::create([
            'division_id' => 3,
            'name' => 'TIL - Fabric'
        ]);
        //6
        Company::create([
            'division_id' => 3,
            'name' => 'NCL - Fabric'
        ]);
       
    }
}

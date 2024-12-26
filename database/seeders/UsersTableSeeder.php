<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;


class UsersTableSeeder extends Seeder
{

    public function run()
    {
        User::create([
            'role_id' => 1,
            'name' => 'Admin',
            'emp_id' => '01',
            'email' => 'admin@ntg.com.bd',
            'email_verified_at' => now(),
            'picture' => 'avatar.png',
            'dob' => '1989-02-03',
            'joining_date' => '2019-02-03',
            'division_id' => '1',
            'company_id' => '1',
            'department_id' => '9',
            'designation_id' => '10',
            'password' => bcrypt('12345678'),
            'password_text' => '12345678', // This is for the user to login with password
            'remember_token' => Str::random(10),
        ]);
        User::create([
            'role_id' => 3,
            'name' => 'Nahid Hasan',
            'emp_id' => '00422',
            'email' => 'nahidhasan@ntg.com.bd',
            'email_verified_at' => now(),
            'picture' => 'avatar.png',
            'dob' => '1984-02-03',
            'joining_date' => '2019-02-03',
            'division_id' => '1',
            'company_id' => '1',
            'department_id' => '15',
            'designation_id' => '6',
            'mobile' => '01810157700',
            'password' => bcrypt('nahid@422'),
            'password_text' => 'nahid@422', // This is for the user to login with password
            'remember_token' => Str::random(10),
        ]);

        User::create([
            'role_id' => 2,
            'name' => 'Md. Mehedi Hasan Shakib',
            'emp_id' => '000002',
            'email' => 'shakib@ntg.com.bd',
            'email_verified_at' => now(),
            'picture' => 'avatar.png',
            'dob' => '1989-02-03',
            'joining_date' => '2019-02-03',
            'division_id' => '1',
            'company_id' => '1',
            'department_id' => '9',
            'designation_id' => '10',
            'password' => bcrypt('12345678'),
            'password_text' => '12345678', // This is for the user to login with password
            'remember_token' => Str::random(10),
        ]);

        User::create([
            'role_id' => 2,
            'name' => 'Maruf',
            'emp_id' => '000003',
            'email' => 'maruf@ntg.com.bd',
            'email_verified_at' => now(),
            'picture' => 'avatar.png',
            'dob' => '1989-02-03',
            'joining_date' => '2019-02-03',
            'division_id' => '1',
            'company_id' => '1',
            'department_id' => '9',
            'designation_id' => '10',
            'password' => bcrypt('12345678'),
            'password_text' => '12345678', // This is for the user to login with password
            'remember_token' => Str::random(10),
        ]);


        User::create([
            'role_id' => 2,
            'name' => 'Sunny',
            'emp_id' => '000001',
            'email' => 'sunny@ntg.com.bd',
            'email_verified_at' => now(),
            'picture' => 'avatar.png',
            'dob' => '1989-02-03',
            'joining_date' => '2019-02-03',
            'division_id' => '1',
            'company_id' => '1',
            'department_id' => '9',
            'designation_id' => '10',
            'password' => bcrypt('sun678'),
            'password_text' => 'sun678', // This is for the user to login with password
            'remember_token' => Str::random(10),
        ]);
        
    }
}

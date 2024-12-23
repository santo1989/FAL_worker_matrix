<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //************************************************************

        // division 1 = Corporate => Company 1 = Common Office

        // division 2 = Factory => Company 2 = TIL // Company 3 = FAL 
        // Company 4 = NCL

        // division 3 = Fabric => Company 5 = TIL 
        // Company 6 = NCL

        //********************************************************************

        // Corporate Division =1
        //1
        Department::create([
            'company_id' => 1,
            'name' => 'Accounts - FAL'
        ]);
        //2
        Department::create([
            'company_id' => 1,
            'name' => 'Accounts - NCL'
        ]);
        //3
        Department::create([
            'company_id' => 1,
            'name' => 'Accounts - TIL'
        ]);
        //4
        Department::create([
            'company_id' => 1,
            'name' => 'Audit'
        ]);
        //5
        Department::create([
            'company_id' => 1,
            'name' => 'Commercial'
        ]);
        //6
        Department::create([
            'company_id' => 1,
            'name' => 'Compliance'
        ]);
        //7
        Department::create([
            'company_id' => 1,
            'name' => 'Corporate Affairs'
        ]);
        //8
        Department::create([
            'company_id' => 1,
            'name' => 'Cost Control'
        ]);
        //9
        Department::create([
            'company_id' => 1,
            'name' => 'Human Resource Management'
        ]);
        //10
        Department::create([
            'company_id' => 1,
            'name' => 'IT'
        ]);
        //11
        Department::create([
            'company_id' => 1,
            'name' => 'Legal Affairs'
        ]);
        //12
        Department::create([
            'company_id' => 1,
            'name' => 'Merchandising - FAL'
        ]);
        //13
        Department::create([
            'company_id' => 1,
            'name' => 'Merchandising - NCL'
        ]);
        //14
        Department::create([
            'company_id' => 1,
            'name' => 'Merchandising - TIL'
        ]);
        //15
        Department::create([
            'company_id' => 1,
            'name' => 'MIS'
        ]);
        //16
        Department::create([
            'company_id' => 1,
            'name' => 'Product Design'
        ]);
        //17
        Department::create([
            'company_id' => 1,
            'name' => 'Supply Chain Management'
        ]);
        //********************************************************************
        // Factory Division => Company 2 = TIL 
        //17
        Department::create([
            'company_id' => 2,
            'name' => 'Accounts'
        ]);
        //18
        Department::create([
            'company_id' => 2,
            'name' => 'CAD'
        ]);
        //19
        Department::create([
            'company_id' => 2,
            'name' => 'Compliance'
        ]);
        //20
        Department::create([
            'company_id' => 2,
            'name' => 'Cutting'
        ]);
        //21

        Department::create([
            'company_id' => 2,
            'name' => 'Finishing'
        ]);
        //22
        Department::create([
            'company_id' => 2,
            'name' => 'HR, Admin & Welfare'
        ]);
        //23
        Department::create([
            'company_id' => 2,
            'name' => 'IE'
        ]);
        //24
        Department::create([
            'company_id' => 2,
            'name' => 'IT & MIS'
        ]);
        //25
        Department::create([
            'company_id' => 2,
            'name' => 'Lab'
        ]);
        //26
        Department::create([
            'company_id' => 2,
            'name' => 'Maintenance'
        ]);
        //27
        Department::create([
            'company_id' => 2,
            'name' => 'MCD/ Store'
        ]);
        //28
        Department::create([
            'company_id' => 2,
            'name' => 'Planning'
        ]);
        //29
        Department::create([
            'company_id' => 2,
            'name' => 'Quality'
        ]);
        //30
        Department::create([
            'company_id' => 2,
            'name' => 'Sample'
        ]);
        //31
        Department::create([
            'company_id' => 2,
            'name' => 'Sewing'
        ]);

        //********************************************************************

        // Factory Division => Company 2 = FAL 
        //32
        Department::create([
            'company_id' => 3,
            'name' => 'Accounts'
        ]);
        //33
        Department::create([
            'company_id' => 3,
            'name' => 'CAD'
        ]);
        //34
        Department::create([
            'company_id' => 3,
            'name' => 'Compliance'
        ]);
        //35
        Department::create([
            'company_id' => 3,
            'name' => 'Cutting'
        ]);
        //36

        Department::create([
            'company_id' => 3,
            'name' => 'Fabric Merchandising'
        ]);
        //37

        Department::create([
            'company_id' => 3,
            'name' => 'Finishing'
        ]);
        //38
        Department::create([
            'company_id' => 3,
            'name' => 'HR, Admin & Welfare'
        ]);
        //39
        Department::create([
            'company_id' => 3,
            'name' => 'IE'
        ]);
        //40
        Department::create([
            'company_id' => 3,
            'name' => 'IT & MIS'
        ]);
        //41
        Department::create([
            'company_id' => 3,
            'name' => 'Lab'
        ]);
        //42
        Department::create([
            'company_id' => 3,
            'name' => 'Maintenance'
        ]);
        //43
        Department::create([
            'company_id' => 3,
            'name' => 'MCD/ Store'
        ]);
        //44
        Department::create([
            'company_id' => 3,
            'name' => 'Planning'
        ]);
        //45
        Department::create([
            'company_id' => 3,
            'name' => 'Quality'
        ]);
        //46
        Department::create([
            'company_id' => 3,
            'name' => 'Sample'
        ]);
        //47
        Department::create([
            'company_id' => 3,
            'name' => 'Sewing'
        ]);

        //********************************************************************
        // Factory Division => Company 4 = NCL
        //********************************************************************
        //48
        Department::create([
            'company_id' => 4,
            'name' => 'IE'
        ]);
        //49
        Department::create([
            'company_id' => 4,
            'name' => 'Planning'
        ]);
        //50
        Department::create([
            'company_id' => 4,
            'name' => 'Maintenance'
        ]);
        //51
        Department::create([
            'company_id' => 4,
            'name' => 'Cutting'
        ]);
        //52
        Department::create([
            'company_id' => 4,
            'name' => 'Audit'
        ]);
        //53
        Department::create([
            'company_id' => 4,
            'name' => 'Finishing'
        ]);
        //54
        Department::create([
            'company_id' => 4,
            'name' => 'IT & MIS'
        ]);
        //55
        Department::create([
            'company_id' => 4,
            'name' => 'Merchandising'
        ]);
        //56
        Department::create([
            'company_id' => 4,
            'name' => 'Production'
        ]);
        //57
        Department::create([
            'company_id' => 4,
            'name' => 'Quality'
        ]);
        //58
        Department::create([
            'company_id' => 4,
            'name' => 'Store'
        ]);
        //59
        Department::create([
            'company_id' => 4,
            'name' => 'Technical'
        ]);
        //60
        Department::create([
            'company_id' => 4,
            'name' => 'HR, Admin & Welfare'
        ]);
        //61
        Department::create([
            'company_id' => 4,
            'name' => 'Compliance'
        ]);


        //********************************************************************
        // Fabric Division => Company 5 = TIL
        //********************************************************************
        //62
        Department::create([
            'company_id' => 5,
            'name' => 'Accounts'
        ]);
        //63
        Department::create([
            'company_id' => 5,
            'name' => 'AOP'
        ]);
        //64
        Department::create([
            'company_id' => 5,
            'name' => 'Batch'
        ]);
        //65
        Department::create([
            'company_id' => 5,
            'name' => 'Circular knitting'
        ]);

        //66
        Department::create([
            'company_id' => 5,
            'name' => 'Dyeing'
        ]);
        //67
        Department::create([
            'company_id' => 5,
            'name' => 'Fabric Merchandiser'
        ]);
        //68
        Department::create([
            'company_id' => 5,
            'name' => 'Knitting'
        ]);
        //69
        Department::create([
            'company_id' => 5,
            'name' => 'Garments Wash'
        ]);
        //70
        Department::create([
            'company_id' => 5,
            'name' => 'IT & MIS'
        ]);
        //71
        Department::create([
            'company_id' => 5,
            'name' => 'Maintenance'
        ]);
        //72
        Department::create([
            'company_id' => 5,
            'name' => 'Mechanical Finishing'
        ]);
        //73
        Department::create([
            'company_id' => 5,
            'name' => 'Physical Lab'
        ]);
        //74
        Department::create([
            'company_id' => 5,
            'name' => 'Planning'
        ]);
        //75
        Department::create([
            'company_id' => 5,
            'name' => 'Pretreatment'
        ]);
        //76
        Department::create([
            'company_id' => 5,
            'name' => 'Quality'
        ]);
        //77
        Department::create([
            'company_id' => 5,
            'name' => 'Sample'
        ]);
        //78
        Department::create([
            'company_id' => 5,
            'name' => 'Store'
        ]);

        //********************************************************************
        // Fabric Division => Company 6 = NCL BSCIC
        //********************************************************************
        //79
        Department::create([
            'company_id' => 6,
            'name' => 'HR, Admin & Accounts'
        ]);
        //80
        Department::create([
            'company_id' => 6,
            'name' => 'Dyeing Finishing'
        ]);
        //81
        Department::create([
            'company_id' => 6,
            'name' => 'Dyeing'
        ]);
        //82
        Department::create([
            'company_id' => 6,
            'name' => 'knitting'
        ]);
        //83
        Department::create([
            'company_id' => 6,
            'name' => 'Labratory'
        ]);
    }
}

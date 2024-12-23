<?php

namespace Database\Seeders;

use App\Models\SewingProcessList;
use Illuminate\Database\Seeder;

class SewingProcessListSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //normal
        SewingProcessList::create(['process_type' => 'normal', 'machine_type' => 'OL', 'process_name' => 'Shoulder Join & Scissoring', 'standard_capacity' => '133.33', 'standard_time_sec' => '27.00', 'smv' => '0.45',]);
        SewingProcessList::create(['process_type' => 'normal', 'machine_type' => 'OL', 'process_name' => 'Back Rise Join', 'standard_capacity' => '250.00', 'standard_time_sec' => '14.40', 'smv' => '0.24',]);
        SewingProcessList::create(['process_type' => 'normal', 'machine_type' => 'OL', 'process_name' => 'Front Rise Join', 'standard_capacity' => '250.00', 'standard_time_sec' => '14.40', 'smv' => '0.24',]);
        SewingProcessList::create(['process_type' => 'normal', 'machine_type' => 'OL', 'process_name' => 'PANAL SERVICE', 'standard_capacity' => '230.77', 'standard_time_sec' => '15.60', 'smv' => '0.26',]);
        SewingProcessList::create(['process_type' => 'normal', 'machine_type' => 'F/L', 'process_name' => 'Shoulder T/S', 'standard_capacity' => '272.73', 'standard_time_sec' => '13.20', 'smv' => '0.22',]);
        SewingProcessList::create(['process_type' => 'normal', 'machine_type' => 'F/L', 'process_name' => 'Back Rise T/S', 'standard_capacity' => '272.73', 'standard_time_sec' => '13.20', 'smv' => '0.22',]);
        SewingProcessList::create(['process_type' => 'normal', 'machine_type' => 'F/L', 'process_name' => 'Neck top stitch', 'standard_capacity' => '272.73', 'standard_time_sec' => '13.20', 'smv' => '0.22',]);
        SewingProcessList::create(['process_type' => 'normal', 'machine_type' => 'SND', 'process_name' => 'TACK ( RIB / CUFF /OTHERES)', 'standard_capacity' => '250.00', 'standard_time_sec' => '14.40', 'smv' => '0.24',]);
        SewingProcessList::create(['process_type' => 'normal', 'machine_type' => 'SND', 'process_name' => '1/4 tuck(Chap+Khara)', 'standard_capacity' => '157.89', 'standard_time_sec' => '22.80', 'smv' => '0.38',]);
        SewingProcessList::create(['process_type' => 'normal', 'machine_type' => 'SND', 'process_name' => 'Neck Rib Make', 'standard_capacity' => '250.00', 'standard_time_sec' => '14.40', 'smv' => '0.24',]);
        SewingProcessList::create(['process_type' => 'normal', 'machine_type' => 'SND', 'process_name' => 'Neck Rib Run Stitch', 'standard_capacity' => '300.00', 'standard_time_sec' => '12.00', 'smv' => '0.20',]);
        SewingProcessList::create(['process_type' => 'normal', 'machine_type' => 'SND', 'process_name' => 'Label make', 'standard_capacity' => '272.73', 'standard_time_sec' => '13.20', 'smv' => '0.22',]);
        SewingProcessList::create(['process_type' => 'normal', 'machine_type' => 'SND', 'process_name' => 'Label Attach', 'standard_capacity' => '300.00', 'standard_time_sec' => '12.00', 'smv' => '0.20',]);
        SewingProcessList::create(['process_type' => 'normal', 'machine_type' => 'SND', 'process_name' => 'Side Band Tuck', 'standard_capacity' => '230.77', 'standard_time_sec' => '15.60', 'smv' => '0.26',]);
        SewingProcessList::create(['process_type' => 'normal', 'machine_type' => 'SND', 'process_name' => 'Hood Tuck', 'standard_capacity' => '250.00', 'standard_time_sec' => '14.40', 'smv' => '0.24',]);
        SewingProcessList::create(['process_type' => 'normal', 'machine_type' => 'SND', 'process_name' => 'Collar1/4 T/S', 'standard_capacity' => '150.00', 'standard_time_sec' => '24.00', 'smv' => '0.40',]);
        SewingProcessList::create(['process_type' => 'normal', 'machine_type' => 'SND', 'process_name' => 'Cuff Make shirt', 'standard_capacity' => '133.33', 'standard_time_sec' => '27.00', 'smv' => '0.45',]);
        SewingProcessList::create(['process_type' => 'normal', 'machine_type' => 'SND', 'process_name' => 'Placket Rulling', 'standard_capacity' => '272.73', 'standard_time_sec' => '13.20', 'smv' => '0.22',]);
        SewingProcessList::create(['process_type' => 'normal', 'machine_type' => 'SND', 'process_name' => 'Main Label Attach', 'standard_capacity' => '214.29', 'standard_time_sec' => '16.80', 'smv' => '0.28',]);
        SewingProcessList::create(['process_type' => 'normal', 'machine_type' => 'BH', 'process_name' => '2-Button Hole', 'standard_capacity' => '600.00', 'standard_time_sec' => '6.00', 'smv' => '0.10',]);
        SewingProcessList::create(['process_type' => 'normal', 'machine_type' => 'BS', 'process_name' => '2-Button Attach', 'standard_capacity' => '428.57', 'standard_time_sec' => '8.40', 'smv' => '0.14',]);
        SewingProcessList::create(['process_type' => 'normal', 'machine_type' => 'BTK', 'process_name' => '2-Body bartuck', 'standard_capacity' => '375.00', 'standard_time_sec' => '9.60', 'smv' => '0.16',]);
        SewingProcessList::create(['process_type' => 'normal', 'machine_type' => 'F/L', 'process_name' => 'Pannel top Stitch', 'standard_capacity' => '214.29', 'standard_time_sec' => '16.80', 'smv' => '0.28',]);

        //semi-critical

        SewingProcessList::create(['process_type' => 'semi-critical', 'machine_type' => 'OL', 'process_name' => 'Side Join', 'standard_capacity' => '100.00', 'standard_time_sec' => '36.00', 'smv' => '0.60',]);
        SewingProcessList::create(['process_type' => 'semi-critical', 'machine_type' => 'OL', 'process_name' => 'Bottom Join', 'standard_capacity' => '120.00', 'standard_time_sec' => '30.00', 'smv' => '0.50',]);
        SewingProcessList::create(['process_type' => 'semi-critical', 'machine_type' => 'OL', 'process_name' => 'Side Pkt Bag Close', 'standard_capacity' => '133.33', 'standard_time_sec' => '27.00', 'smv' => '0.45',]);
        SewingProcessList::create(['process_type' => 'semi-critical', 'machine_type' => 'OL', 'process_name' => 'Hood Join', 'standard_capacity' => '200.00', 'standard_time_sec' => '18.00', 'smv' => '0.30',]);
        SewingProcessList::create(['process_type' => 'semi-critical', 'machine_type' => 'OL', 'process_name' => 'Collar Join Polo', 'standard_capacity' => '171.43', 'standard_time_sec' => '21.00', 'smv' => '0.35',]);
        SewingProcessList::create(['process_type' => 'semi-critical', 'machine_type' => 'OL', 'process_name' => 'Front Pocket Bone Join 2 bone', 'standard_capacity' => '120.00', 'standard_time_sec' => '30.00', 'smv' => '0.50',]);
        SewingProcessList::create(['process_type' => 'semi-critical', 'machine_type' => 'F/L', 'process_name' => 'Hood Hem', 'standard_capacity' => '187.50', 'standard_time_sec' => '19.20', 'smv' => '0.32',]);
        SewingProcessList::create(['process_type' => 'semi-critical', 'machine_type' => 'F/L', 'process_name' => 'Neck piping', 'standard_capacity' => '250.00', 'standard_time_sec' => '14.40', 'smv' => '0.24',]);
        SewingProcessList::create(['process_type' => 'semi-critical', 'machine_type' => 'F/L', 'process_name' => 'Side T/S Pant', 'standard_capacity' => '100.00', 'standard_time_sec' => '36.00', 'smv' => '0.60',]);
        SewingProcessList::create(['process_type' => 'semi-critical', 'machine_type' => 'F/L', 'process_name' => 'Armhole T/S', 'standard_capacity' => '150.00', 'standard_time_sec' => '24.00', 'smv' => '0.40',]);
        SewingProcessList::create(['process_type' => 'semi-critical', 'machine_type' => 'F/L', 'process_name' => 'Cuff Top Stitch', 'standard_capacity' => '150.00', 'standard_time_sec' => '24.00', 'smv' => '0.40',]);
        SewingProcessList::create(['process_type' => 'semi-critical', 'machine_type' => 'F/L', 'process_name' => 'Bottom T/S (Pant)', 'standard_capacity' => '187.50', 'standard_time_sec' => '19.20', 'smv' => '0.32',]);
        SewingProcessList::create(['process_type' => 'semi-critical', 'machine_type' => 'F/L', 'process_name' => 'J-Stitch', 'standard_capacity' => '272.73', 'standard_time_sec' => '13.20', 'smv' => '0.22',]);
        SewingProcessList::create(['process_type' => 'semi-critical', 'machine_type' => 'F/L', 'process_name' => 'West best T/S', 'standard_capacity' => '157.89', 'standard_time_sec' => '22.80', 'smv' => '0.38',]);
        SewingProcessList::create(['process_type' => 'semi-critical', 'machine_type' => 'DNL', 'process_name' => '2 NIDDLE(Falp join & Top Stitch)', 'standard_capacity' => '150.00', 'standard_time_sec' => '24.00', 'smv' => '0.40',]);
        SewingProcessList::create(['process_type' => 'semi-critical', 'machine_type' => 'SND', 'process_name' => 'Back Tape Attach', 'standard_capacity' => '200.00', 'standard_time_sec' => '18.00', 'smv' => '0.30',]);
        SewingProcessList::create(['process_type' => 'semi-critical', 'machine_type' => 'SND', 'process_name' => 'Label Top Stitch', 'standard_capacity' => '157.89', 'standard_time_sec' => '22.80', 'smv' => '0.38',]);
        SewingProcessList::create(['process_type' => 'semi-critical', 'machine_type' => 'SND', 'process_name' => 'Side Band Join', 'standard_capacity' => '103.45', 'standard_time_sec' => '34.80', 'smv' => '0.58',]);
        SewingProcessList::create(['process_type' => 'semi-critical', 'machine_type' => 'SND', 'process_name' => 'nose tack', 'standard_capacity' => '272.73', 'standard_time_sec' => '13.20', 'smv' => '0.22',]);
        SewingProcessList::create(['process_type' => 'semi-critical', 'machine_type' => 'SND', 'process_name' => 'Collar Tuck Polo', 'standard_capacity' => '214.29', 'standard_time_sec' => '16.80', 'smv' => '0.28',]);
        SewingProcessList::create(['process_type' => 'semi-critical', 'machine_type' => 'SND', 'process_name' => 'Collar-1/16 T/S', 'standard_capacity' => '150.00', 'standard_time_sec' => '24.00', 'smv' => '0.40',]);
        SewingProcessList::create(['process_type' => 'semi-critical', 'machine_type' => 'SND', 'process_name' => 'Collar band Rulling', 'standard_capacity' => '187.50', 'standard_time_sec' => '19.20', 'smv' => '0.32',]);
        SewingProcessList::create(['process_type' => 'semi-critical', 'machine_type' => 'SND', 'process_name' => 'POCKKET JOIN', 'standard_capacity' => '100.00', 'standard_time_sec' => '36.00', 'smv' => '0.60',]);
        SewingProcessList::create(['process_type' => 'semi-critical', 'machine_type' => 'SND', 'process_name' => 'Placket Under Close', 'standard_capacity' => '133.33', 'standard_time_sec' => '27.00', 'smv' => '0.45',]);
        SewingProcessList::create(['process_type' => 'semi-critical', 'machine_type' => 'SND', 'process_name' => 'Placket 1/16 T/S', 'standard_capacity' => '214.29', 'standard_time_sec' => '16.80', 'smv' => '0.28',]);
        SewingProcessList::create(['process_type' => 'semi-critical', 'machine_type' => 'SND', 'process_name' => 'Box Tuck', 'standard_capacity' => '187.50', 'standard_time_sec' => '19.20', 'smv' => '0.32',]);
        SewingProcessList::create(['process_type' => 'semi-critical', 'machine_type' => 'SND', 'process_name' => 'Front Pocket Attach', 'standard_capacity' => '150.00', 'standard_time_sec' => '24.00', 'smv' => '0.40',]);
        SewingProcessList::create(['process_type' => 'semi-critical', 'machine_type' => 'SND', 'process_name' => 'Side Pocket Attach', 'standard_capacity' => '150.00', 'standard_time_sec' => '24.00', 'smv' => '0.40',]);
        SewingProcessList::create(['process_type' => 'semi-critical', 'machine_type' => 'SND', 'process_name' => 'Side PKT T/S', 'standard_capacity' => '157.89', 'standard_time_sec' => '22.80', 'smv' => '0.38',]);
        SewingProcessList::create(['process_type' => 'semi-critical', 'machine_type' => 'SND', 'process_name' => 'Moon Join', 'standard_capacity' => '133.33', 'standard_time_sec' => '27.00', 'smv' => '0.45',]);
        SewingProcessList::create(['process_type' => 'semi-critical', 'machine_type' => 'SND', 'process_name' => 'V-Join', 'standard_capacity' => '171.43', 'standard_time_sec' => '21.00', 'smv' => '0.35',]);
        SewingProcessList::create(['process_type' => 'semi-critical', 'machine_type' => 'SND', 'process_name' => 'Side band T/S', 'standard_capacity' => '109.09', 'standard_time_sec' => '33.00', 'smv' => '0.55',]);

        //critical

        SewingProcessList::create(['process_type' => 'critical', 'machine_type' => 'OL', 'process_name' => 'Neck Join(Hand)', 'standard_capacity' => '250.00', 'standard_time_sec' => '14.40', 'smv' => '0.24',]);
        SewingProcessList::create(['process_type' => 'critical', 'machine_type' => 'OL', 'process_name' => 'Inseam Join', 'standard_capacity' => '133.33', 'standard_time_sec' => '27.00', 'smv' => '0.45',]);
        SewingProcessList::create(['process_type' => 'critical', 'machine_type' => 'OL', 'process_name' => 'Cuff Join', 'standard_capacity' => '120.00', 'standard_time_sec' => '30.00', 'smv' => '0.50',]);
        SewingProcessList::create(['process_type' => 'critical', 'machine_type' => 'F/L', 'process_name' => 'SLV Round Hem', 'standard_capacity' => '150.00', 'standard_time_sec' => '24.00', 'smv' => '0.40',]);
        SewingProcessList::create(['process_type' => 'critical', 'machine_type' => 'F/L', 'process_name' => 'Body Hem', 'standard_capacity' => '200.00', 'standard_time_sec' => '18.00', 'smv' => '0.30',]);
        SewingProcessList::create(['process_type' => 'critical', 'machine_type' => 'F/L', 'process_name' => 'Body Hem Khara', 'standard_capacity' => '157.89', 'standard_time_sec' => '22.80', 'smv' => '0.38',]);
        SewingProcessList::create(['process_type' => 'critical', 'machine_type' => 'F/L/KNS', 'process_name' => 'S.S Back Tape attach', 'standard_capacity' => '187.50', 'standard_time_sec' => '19.20', 'smv' => '0.32',]);
        SewingProcessList::create(['process_type' => 'critical', 'machine_type' => 'SND', 'process_name' => 'velcro Attach 1p', 'standard_capacity' => '120.00', 'standard_time_sec' => '30.00', 'smv' => '0.50',]);
        SewingProcessList::create(['process_type' => 'critical', 'machine_type' => 'SND', 'process_name' => 'Collar Join Shirt', 'standard_capacity' => '83.33', 'standard_time_sec' => '43.20', 'smv' => '0.72',]);
        SewingProcessList::create(['process_type' => 'critical', 'machine_type' => 'SND', 'process_name' => 'Collar band join', 'standard_capacity' => '70.59', 'standard_time_sec' => '51.00', 'smv' => '0.85',]);
        SewingProcessList::create(['process_type' => 'critical', 'machine_type' => 'SND', 'process_name' => 'Collar Top Stitch', 'standard_capacity' => '76.92', 'standard_time_sec' => '46.80', 'smv' => '0.78',]);
        SewingProcessList::create(['process_type' => 'critical', 'machine_type' => 'SND', 'process_name' => 'Placket Under Close', 'standard_capacity' => '150.00', 'standard_time_sec' => '24.00', 'smv' => '0.40',]);
        SewingProcessList::create(['process_type' => 'critical', 'machine_type' => 'SND', 'process_name' => 'Box Make', 'standard_capacity' => '120.00', 'standard_time_sec' => '30.00', 'smv' => '0.50',]);
        SewingProcessList::create(['process_type' => 'critical', 'machine_type' => 'SND', 'process_name' => 'Bone T/S', 'standard_capacity' => '83.33', 'standard_time_sec' => '43.20', 'smv' => '0.72',]);
        SewingProcessList::create(['process_type' => 'critical', 'machine_type' => 'SND', 'process_name' => 'Pattern T/S', 'standard_capacity' => '187.50', 'standard_time_sec' => '19.20', 'smv' => '0.32',]);
        SewingProcessList::create(['process_type' => 'critical', 'machine_type' => 'SND', 'process_name' => 'Patch Label Attach', 'standard_capacity' => '150.00', 'standard_time_sec' => '24.00', 'smv' => '0.40',]);
        SewingProcessList::create(['process_type' => 'critical', 'machine_type' => 'SND', 'process_name' => 'Zipper join', 'standard_capacity' => '92.31', 'standard_time_sec' => '39.00', 'smv' => '0.65',]);
        SewingProcessList::create(['process_type' => 'critical', 'machine_type' => 'SND', 'process_name' => 'Zipper T/S', 'standard_capacity' => '103.45', 'standard_time_sec' => '34.80', 'smv' => '0.58',]);
        SewingProcessList::create(['process_type' => 'critical', 'machine_type' => 'SND', 'process_name' => 'Body hem Shirt(Folder)', 'standard_capacity' => '88.24', 'standard_time_sec' => '40.80', 'smv' => '0.68',]);
        SewingProcessList::create(['process_type' => 'critical', 'machine_type' => 'KNS', 'process_name' => 'Plaket box make (Folder)', 'standard_capacity' => '150.00', 'standard_time_sec' => '24.00', 'smv' => '0.40',]);
        SewingProcessList::create(['process_type' => 'critical', 'machine_type' => 'KNS', 'process_name' => 'West belt T/S', 'standard_capacity' => '150.00', 'standard_time_sec' => '24.00', 'smv' => '0.40',]);
        SewingProcessList::create(['process_type' => 'critical', 'machine_type' => 'OL', 'process_name' => 'SLV Join', 'standard_capacity' => '120.00', 'standard_time_sec' => '30.00', 'smv' => '0.50',]);

        //SPECIAL  MACHINES
        SewingProcessList::create(['process_type' => 'critical', 'machine_type' => 'OL', 'process_name' => 'Blind Hem', 'standard_capacity' => '93', 'standard_time_sec' => '39', 'smv' => '0.65',]);
        SewingProcessList::create(['process_type' => 'critical', 'machine_type' => 'OL', 'process_name' => 'Mora Sleeve join', 'standard_capacity' => '86', 'standard_time_sec' => '42', 'smv' => '0.70',]);
    }
}

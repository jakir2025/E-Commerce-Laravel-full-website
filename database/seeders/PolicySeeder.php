<?php

namespace Database\Seeders;

use App\Models\Policy;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PolicySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $policies = [
            [
            'privacy_policy'=> 'Lorem ipsum dolor sit amet consectetur adipisicing elit-1',
            'terms_conditions'=> 'Lorem ipsum dolor sit amet consectetur adipisicing elit-2',
            'refund_policy'=> 'Lorem ipsum dolor sit amet consectetur adipisicing elit-3',
            'payment_policy'=> 'Lorem ipsum dolor sit amet consectetur adipisicing elit-4',
            'about_us'=> 'Lorem ipsum dolor sit amet consectetur adipisicing elit-5',
            ]
        ];
        Policy::insert($policies);
    }
}

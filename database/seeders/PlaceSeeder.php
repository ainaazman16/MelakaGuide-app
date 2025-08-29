<?php

namespace Database\Seeders;
use App\Models\Place;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PlaceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Place::create(['name'=>'Kopi Hutan','category'=>'Cafe','address'=>'Georgetown','description'=>'Hidden gem for coffee.']);
        Place::create(['name'=>'City Library','category'=>'Library','address'=>'Downtown','description'=>'Quiet study area with AC.']);
        Place::create(['name'=>'Lake Park','category'=>'Park','address'=>'Lakeside','description'=>'Nice jogging track.']);
    }
}

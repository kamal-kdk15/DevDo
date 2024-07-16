<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Factories\PostFactory;
class PostSeeder extends Seeder
{ /**
    * Run the database seeds.
    *
    * @return void
    */
   public function run()
   {
       // Use the PostFactory to create posts
       PostFactory::new()->count(10)->create();
   }
}

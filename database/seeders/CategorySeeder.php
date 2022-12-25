<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CategorySeeder extends Seeder
{
    public $categories;

    public function __construct() {
        $this->categories = [
            ['name' => 'Arts & Entertainment'],
            ['name' => 'Autos & Vehicles'],
            ['name' => 'Beauty & Fitness'],
            ['name' => 'Books & Literature'],
            ['name' => 'Business & Industrial'],
            ['name' => 'Computers & Electronics'],
            ['name' => 'Finance'],
            ['name' => 'Food & Drink'],
            ['name' => 'Games'],
            ['name' => 'Health'],
            ['name' => 'Hobbies & Leisure'],
            ['name' => 'Home & Garden'],
            ['name' => 'Internet & Telecom'],
            ['name' => 'Jobs & Education'],
            ['name' => 'Law & Government'],
            ['name' => 'News'],
            ['name' => 'Online Communities'],
            ['name' => 'People & Society'],
            ['name' => 'Pets & Animals'],
            ['name' => 'Real Estate'],
            ['name' => 'Reference'],
            ['name' => 'Science'],
            ['name' => 'Shopping'],
            ['name' => 'Sports'],
            ['name' => 'Travel'],
            ['name' => 'Other'],
        ];
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::insert($this->categories);
    }
}

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
            ['name' => 'Technology'],
            ['name' => 'Financial'],
            ['name' => 'Religion'],
            ['name' => 'Food & Drink'],
            ['name' => 'Health'],
            ['name' => 'Business'],
            ['name' => 'Relationships'],
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

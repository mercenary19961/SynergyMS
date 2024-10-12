<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProjectManager;

class ProjectManagerSeeder extends Seeder
{
    public function run(): void
    {
        $managers = [
            ['user_id' => 3, 'department_id' => 1, 'experience_years' => 8, 'contact_number' => '+962788757481'],
            ['user_id' => 11, 'department_id' => 2, 'experience_years' => 5, 'contact_number' => '+962782751231'],
            ['user_id' => 12, 'department_id' => 3, 'experience_years' => 10, 'contact_number' => '+962788758681'],
            ['user_id' => 13, 'department_id' => 4, 'experience_years' => 7, 'contact_number' => '+962798759681'],
            ['user_id' => 14, 'department_id' => 5, 'experience_years' => 6, 'contact_number' => '+962778758881'],
            ['user_id' => 15, 'department_id' => 6, 'experience_years' => 9, 'contact_number' => '+962791754481'],
        ];

        foreach ($managers as $manager) {
            ProjectManager::create($manager);
        }
    }
}











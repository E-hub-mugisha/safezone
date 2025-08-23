<?php

namespace Database\Seeders;

use App\Models\Evidence;
use App\Models\SafeZoneCase;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SafeZoneCaseTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();
        $agents = $users->where('role', 'agent')->values();
        $medicalStaff = $users->where('role', 'medical')->values();
        $reporters = $users->where('role', 'user')->values();

        $realCases = [
            [
                'user' => $reporters[0],
                'type' => 'physical',
                'description' => 'The survivor reported being physically assaulted by a neighbor. Bruises were sustained on the arms and back. Immediate medical attention is required.',
                'location' => 'Kigali, Kimironko',
            ],
            [
                'user' => $reporters[1],
                'type' => 'psychological',
                'description' => 'The survivor reported continuous verbal harassment and threats from a former partner causing severe anxiety and emotional distress.',
                'location' => 'Huye, Downtown',
            ],
            [
                'user' => $reporters[0],
                'type' => 'sexual',
                'description' => 'The survivor reported unwanted sexual advances and harassment by a colleague at the workplace. The incident occurred during office hours in Kigali.',
                'location' => 'Kigali, Nyarutarama',
            ],
            [
                'user' => $reporters[1],
                'type' => 'physical',
                'description' => 'The survivor suffered physical abuse from a family member over a property dispute. Injuries include cuts on the hands and arms.',
                'location' => 'Ruhango, Sector Center',
            ],
            [
                'user' => $reporters[0],
                'type' => 'psychological',
                'description' => 'The survivor is experiencing emotional abuse and isolation from a family member, causing severe stress and insomnia.',
                'location' => 'Gisenyi, Rubavu',
            ],
        ];

        foreach ($realCases as $index => $rcase) {
            $case = SafeZoneCase::create([
                'user_id' => $rcase['user']->id,
                'agent_id' => $agents[$index % $agents->count()]->id,      // assign agents in round-robin
                'medical_id' => $medicalStaff[$index % $medicalStaff->count()]->id, // assign medical staff in round-robin
                'type' => $rcase['type'],
                'description' => $rcase['description'],
                'location' => $rcase['location'],
                'status' => 'in_progress', // set as assigned/in-progress
            ]);
        }
    }
}

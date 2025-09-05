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
        // Get agents and medical staff IDs
        $agents = User::where('role', 'agent')->pluck('id')->toArray();
        $medicals = User::where('role', 'medical')->pluck('id')->toArray();

        // Example Rwanda survivor data
        $cases = [
            [
                'survivor_name' => 'Jean Bosco',
                'phone' => '0788123456',
                'email' => 'jean.bosco@example.rw',
                'type' => 'physical',
                'description' => 'Survivor was physically assaulted in Nyamirambo.',
                'location' => 'Nyamirambo',
                'status' => 'pending',
            ],
            [
                'survivor_name' => 'Aline Uwimana',
                'phone' => '0788234567',
                'email' => 'aline.uwimana@example.rw',
                'type' => 'sexual',
                'description' => 'Reported sexual harassment incident in Kigali City.',
                'location' => 'Kigali City',
                'status' => 'verified',
            ],
            [
                'survivor_name' => 'Eric Habimana',
                'phone' => '0788345678',
                'email' => 'eric.habimana@example.rw',
                'type' => 'psychological',
                'description' => 'Experiencing severe trauma after domestic violence.',
                'location' => 'Butare',
                'status' => 'in_progress',
            ],
            [
                'survivor_name' => 'Marie Mukamana',
                'phone' => '0788456789',
                'email' => 'marie.mukamana@example.rw',
                'type' => 'physical',
                'description' => 'Assaulted during community conflict in Huye district.',
                'location' => 'Huye',
                'status' => 'resolved',
            ],
            [
                'survivor_name' => 'Claude Niyonsaba',
                'phone' => '0788567890',
                'email' => 'claude.niyonsaba@example.rw',
                'type' => 'sexual',
                'description' => 'Survivor reports sexual abuse in Musanze.',
                'location' => 'Musanze',
                'status' => 'pending',
            ],
            [
                'survivor_name' => 'Jeanne Mukeshimana',
                'phone' => '0788678901',
                'email' => 'jeanne.mukeshimana@example.rw',
                'type' => 'psychological',
                'description' => 'Psychological trauma due to family abuse.',
                'location' => 'Ruhango',
                'status' => 'in_progress',
            ],
            [
                'survivor_name' => 'Fabrice Nshimiyimana',
                'phone' => '0788789012',
                'email' => 'fabrice.nshimiyimana@example.rw',
                'type' => 'physical',
                'description' => 'Injured during a road accident in Kigali.',
                'location' => 'Kigali',
                'status' => 'verified',
            ],
            [
                'survivor_name' => 'Sandrine Ingabire',
                'phone' => '0788890123',
                'email' => 'sandrine.ingabire@example.rw',
                'type' => 'sexual',
                'description' => 'Victim of harassment in Nyagatare district.',
                'location' => 'Nyagatare',
                'status' => 'resolved',
            ],
            [
                'survivor_name' => 'Emmanuel Uwizeyimana',
                'phone' => '0788901234',
                'email' => 'emmanuel.uwizeyimana@example.rw',
                'type' => 'psychological',
                'description' => 'Experiencing stress and trauma after local dispute.',
                'location' => 'Gisenyi',
                'status' => 'pending',
            ],
        ];

        foreach ($cases as $index => $caseData) {
            // Generate unique case number
            $number = $index + 1;
            $case_number = 'SZC-' . date('Y') . '-' . str_pad($number, 3, '0', STR_PAD_LEFT);

            SafeZoneCase::create([
                'agent_id' => $agents[$index % count($agents)],
                'medical_id' => $medicals[$index % count($medicals)],
                'case_number' => $case_number,
                'survivor_name' => $caseData['survivor_name'],
                'phone' => $caseData['phone'],
                'email' => $caseData['email'],
                'type' => $caseData['type'],
                'description' => $caseData['description'],
                'location' => $caseData['location'],
                'status' => $caseData['status'],
            ]);
        }
    }
}

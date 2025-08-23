<?php

namespace Database\Seeders;

use App\Models\Evidence;
use App\Models\SafeZoneCase;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EvidenceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cases = SafeZoneCase::all();

        $realisticEvidence = [
            1 => [
                ['file_path' => 'evidences/physical_bruiess.jpg', 'description' => 'Photo showing bruises on arms and back.'],
                ['file_path' => 'evidences/physical_report.pdf', 'description' => 'Medical report confirming injuries.']
            ],
            2 => [
                ['file_path' => 'evidences/psychological_messages.mp3', 'description' => 'Audio recording of verbal threats.'],
                ['file_path' => 'evidences/psychological_diary.pdf', 'description' => 'Diary documenting harassment incidents.']
            ],
            3 => [
                ['file_path' => 'evidences/sexual_screenshot.jpg', 'description' => 'Screenshot of threatening messages.']
            ],
            4 => [
                ['file_path' => 'evidences/family_abuse.jpg', 'description' => 'Photo showing minor cuts on hands.'],
                ['file_path' => 'evidences/family_report.pdf', 'description' => 'Police report of the incident.']
            ],
            5 => [
                ['file_path' => 'evidences/emotional_abuse.pdf', 'description' => 'Diary documenting emotional abuse over time.']
            ],
        ];

        foreach ($cases as $case) {
            if(isset($realisticEvidence[$case->id])) {
                foreach($realisticEvidence[$case->id] as $evidence) {
                    Evidence::create([
                        'case_id' => $case->id,
                        'file_path' => $evidence['file_path'],
                        'description' => $evidence['description'],
                    ]);
                }
            }
        }
    }
}

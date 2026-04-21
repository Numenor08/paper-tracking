<?php

namespace Database\Seeders;

use App\Models\Contributor;
use App\Models\Paper;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ContributorPaperSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $paperContributors = [
            'Explainable Deep Learning for Retinal Disease Screening' => [
                ['email' => 'dimas.prasetyo@its.ac.id', 'role' => 'LEAD-AUTHOR'],
                ['email' => 'nadia.rahman@ui.ac.id', 'role' => 'CORRESPONDING-AUTHOR'],
                ['email' => 'arif.kurniawan@ugm.ac.id', 'role' => 'CO-AUTHOR'],
            ],
            'A Lightweight Transformer for Indonesian Legal Document Classification' => [
                ['email' => 'siti.nurhaliza@binus.ac.id', 'role' => 'LEAD-AUTHOR'],
                ['email' => 'reza.ramadhan@telkomuniversity.ac.id', 'role' => 'CO-AUTHOR'],
                ['email' => 'lina.maharani@itb.ac.id', 'role' => 'CORRESPONDING-AUTHOR'],
            ],
            'Energy-Aware Scheduling for Kubernetes at University Data Centers' => [
                ['email' => 'rifki.saputra@unej.ac.id', 'role' => 'LEAD-AUTHOR'],
                ['email' => 'maya.alviana@unair.ac.id', 'role' => 'CO-AUTHOR'],
                ['email' => 'dimas.prasetyo@its.ac.id', 'role' => 'CO-AUTHOR'],
            ],
            'Privacy-Preserving Contact Tracing with Federated Graph Learning' => [
                ['email' => 'nadia.rahman@ui.ac.id', 'role' => 'LEAD-AUTHOR'],
                ['email' => 'arif.kurniawan@ugm.ac.id', 'role' => 'CORRESPONDING-AUTHOR'],
                ['email' => 'siti.nurhaliza@binus.ac.id', 'role' => 'CO-AUTHOR'],
            ],
            'Cross-Campus Knowledge Graph for Lecturer Expertise Discovery' => [
                ['email' => 'lina.maharani@itb.ac.id', 'role' => 'LEAD-AUTHOR'],
                ['email' => 'maya.alviana@unair.ac.id', 'role' => 'CO-AUTHOR'],
                ['email' => 'reza.ramadhan@telkomuniversity.ac.id', 'role' => 'CO-AUTHOR'],
            ],
            'Benchmarking OCR Pipelines for Historical Indonesian Manuscripts' => [
                ['email' => 'rifki.saputra@unej.ac.id', 'role' => 'LEAD-AUTHOR'],
                ['email' => 'dimas.prasetyo@its.ac.id', 'role' => 'CORRESPONDING-AUTHOR'],
            ],
        ];

        foreach ($paperContributors as $paperTitle => $contributors) {
            $paperId = Paper::query()->where('title', $paperTitle)->value('id');

            if (! $paperId) {
                continue;
            }

            DB::table('contributor_paper')->where('paper_id', $paperId)->delete();

            foreach ($contributors as $contributorData) {
                $contributorId = Contributor::query()
                    ->where('email', $contributorData['email'])
                    ->value('id');

                if (! $contributorId) {
                    continue;
                }

                DB::table('contributor_paper')->insert([
                    'contributor_id' => $contributorId,
                    'paper_id' => $paperId,
                    'role' => $contributorData['role'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}

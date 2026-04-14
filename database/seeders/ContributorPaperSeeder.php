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
                ['email' => 'dimas.prasetyo@its.ac.id', 'role' => 'First Author'],
                ['email' => 'nadia.rahman@ui.ac.id', 'role' => 'Corresponding Author'],
                ['email' => 'arif.kurniawan@ugm.ac.id', 'role' => 'Co-Author'],
            ],
            'A Lightweight Transformer for Indonesian Legal Document Classification' => [
                ['email' => 'siti.nurhaliza@binus.ac.id', 'role' => 'First Author'],
                ['email' => 'reza.ramadhan@telkomuniversity.ac.id', 'role' => 'Co-Author'],
                ['email' => 'lina.maharani@itb.ac.id', 'role' => 'Corresponding Author'],
            ],
            'Energy-Aware Scheduling for Kubernetes at University Data Centers' => [
                ['email' => 'rifki.saputra@unej.ac.id', 'role' => 'First Author'],
                ['email' => 'maya.alviana@unair.ac.id', 'role' => 'Co-Author'],
                ['email' => 'dimas.prasetyo@its.ac.id', 'role' => 'Co-Author'],
            ],
            'Privacy-Preserving Contact Tracing with Federated Graph Learning' => [
                ['email' => 'nadia.rahman@ui.ac.id', 'role' => 'First Author'],
                ['email' => 'arif.kurniawan@ugm.ac.id', 'role' => 'Corresponding Author'],
                ['email' => 'siti.nurhaliza@binus.ac.id', 'role' => 'Co-Author'],
            ],
            'Cross-Campus Knowledge Graph for Lecturer Expertise Discovery' => [
                ['email' => 'lina.maharani@itb.ac.id', 'role' => 'First Author'],
                ['email' => 'maya.alviana@unair.ac.id', 'role' => 'Co-Author'],
                ['email' => 'reza.ramadhan@telkomuniversity.ac.id', 'role' => 'Co-Author'],
            ],
            'Benchmarking OCR Pipelines for Historical Indonesian Manuscripts' => [
                ['email' => 'rifki.saputra@unej.ac.id', 'role' => 'First Author'],
                ['email' => 'dimas.prasetyo@its.ac.id', 'role' => 'Corresponding Author'],
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

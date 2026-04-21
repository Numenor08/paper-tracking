<?php

namespace Database\Seeders;

use App\Models\Paper;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PaperSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Razan Alhamdani',
                'email' => 'razan@paper-tracking.test',
                'role' => 'ADMIN',
            ],
            [
                'name' => 'Nabila Sari',
                'email' => 'nabila@paper-tracking.test',
                'role' => 'USER',
            ],
            [
                'name' => 'Fikri Hidayat',
                'email' => 'fikri@paper-tracking.test',
                'role' => 'USER',
            ],
        ];

        foreach ($users as $userData) {
            User::query()->firstOrCreate(
                ['email' => $userData['email']],
                [
                    'name' => $userData['name'],
                    'role' => $userData['role'],
                    'password' => Hash::make('password'),
                    'email_verified_at' => now(),
                ]
            );

            User::query()
                ->where('email', $userData['email'])
                ->update(['role' => $userData['role']]);
        }

        $publicationIndexes = DB::table('publication_indexes')->pluck('id', 'name');
        $fallbackPublicationIndexId = DB::table('publication_indexes')->value('id');

        $papers = [
            [
                'title' => 'Explainable Deep Learning for Retinal Disease Screening',
                'status' => 'UNDER-REVIEW',
                'abstract' => 'This study proposes an explainable convolutional model for retinal disease screening and evaluates saliency consistency across five public datasets.',
                'publication' => 'Journal of Biomedical Informatics',
                'note' => 'Waiting second round response from reviewer 2.',
                'publication_index_name' => 'Scopus Q1',
                'created_by_email' => 'razan@paper-tracking.test',
            ],
            [
                'title' => 'A Lightweight Transformer for Indonesian Legal Document Classification',
                'status' => 'REVISION-REQUESTED',
                'abstract' => 'We introduce a compact transformer variant that improves legal text classification under low-resource constraints with competitive macro-F1.',
                'publication' => 'Information Processing and Management',
                'note' => 'Major revision due in 21 days.',
                'publication_index_name' => 'Scopus Q1',
                'created_by_email' => 'nabila@paper-tracking.test',
            ],
            [
                'title' => 'Energy-Aware Scheduling for Kubernetes at University Data Centers',
                'status' => 'SUBMITTED',
                'abstract' => 'An adaptive scheduler that balances latency and power usage by combining workload prediction with thermal-aware node selection.',
                'publication' => 'Sustainable Computing: Informatics and Systems',
                'note' => 'Submission completed through editorial manager.',
                'publication_index_name' => 'Scopus Q2',
                'created_by_email' => 'fikri@paper-tracking.test',
            ],
            [
                'title' => 'Privacy-Preserving Contact Tracing with Federated Graph Learning',
                'status' => 'ACCEPTED',
                'abstract' => 'The paper presents a federated graph learning approach for contact tracing with formal privacy guarantees and robust performance on mobility data.',
                'publication' => 'IEEE Internet of Things Journal',
                'note' => 'Accepted, camera-ready in progress.',
                'publication_index_name' => 'IEEE Xplore',
                'created_by_email' => 'razan@paper-tracking.test',
            ],
            [
                'title' => 'Cross-Campus Knowledge Graph for Lecturer Expertise Discovery',
                'status' => 'PUBLISHED',
                'abstract' => 'This work integrates institutional repositories into a unified knowledge graph to support expertise search and collaboration discovery.',
                'publication' => 'International Journal of Advanced Computer Science and Applications',
                'note' => 'Published in volume 16 issue 1.',
                'publication_index_name' => 'SINTA 2',
                'created_by_email' => 'nabila@paper-tracking.test',
            ],
            [
                'title' => 'Benchmarking OCR Pipelines for Historical Indonesian Manuscripts',
                'status' => 'DRAFT',
                'abstract' => 'We benchmark open-source OCR pipelines on digitized historical manuscripts and analyze error patterns in old spelling variants.',
                'publication' => 'Pattern Recognition Letters',
                'note' => 'Need one more baseline experiment.',
                'publication_index_name' => 'Scopus Q2',
                'created_by_email' => 'fikri@paper-tracking.test',
            ],
        ];

        foreach ($papers as $paperData) {
            $createdById = User::query()->where('email', $paperData['created_by_email'])->value('id');

            $publicationIndexId = $publicationIndexes[$paperData['publication_index_name']]
                ?? $fallbackPublicationIndexId;

            Paper::query()->updateOrCreate(
                ['title' => $paperData['title']],
                [
                    'status' => $paperData['status'],
                    'abstract' => $paperData['abstract'],
                    'publication' => $paperData['publication'],
                    'note' => $paperData['note'],
                    'created_by' => $createdById,
                    'publication_index_id' => $publicationIndexId,
                ]
            );
        }
    }
}

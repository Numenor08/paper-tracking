<?php

namespace Database\Seeders;

use App\Models\Paper;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UrlAttachmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $paperAttachments = [
            'Explainable Deep Learning for Retinal Disease Screening' => [
                ['label' => 'DOI', 'url' => 'https://doi.org/10.1016/j.jbi.2026.104921'],
                ['label' => 'Preprint', 'url' => 'https://osf.io/retina-xai-preprint'],
            ],
            'A Lightweight Transformer for Indonesian Legal Document Classification' => [
                ['label' => 'ArXiv', 'url' => 'https://arxiv.org/abs/2602.12014'],
                ['label' => 'Repository', 'url' => 'https://github.com/paper-tracking/legal-transformer-id'],
            ],
            'Energy-Aware Scheduling for Kubernetes at University Data Centers' => [
                ['label' => 'Repository', 'url' => 'https://github.com/paper-tracking/green-k8s-scheduler'],
            ],
            'Privacy-Preserving Contact Tracing with Federated Graph Learning' => [
                ['label' => 'DOI', 'url' => 'https://doi.org/10.1109/JIOT.2026.3382104'],
                ['label' => 'Dataset', 'url' => 'https://zenodo.org/records/11223344'],
            ],
            'Cross-Campus Knowledge Graph for Lecturer Expertise Discovery' => [
                ['label' => 'DOI', 'url' => 'https://doi.org/10.14569/IJACSA.2026.0160134'],
            ],
            'Benchmarking OCR Pipelines for Historical Indonesian Manuscripts' => [
                ['label' => 'Repository', 'url' => 'https://github.com/paper-tracking/manuscript-ocr-benchmark'],
            ],
        ];

        foreach ($paperAttachments as $paperTitle => $urls) {
            $paperId = Paper::query()->where('title', $paperTitle)->value('id');

            if (! $paperId) {
                continue;
            }

            DB::table('url_attachments')->where('paper_id', $paperId)->delete();

            foreach ($urls as $attachment) {
                DB::table('url_attachments')->insert([
                    'label' => $attachment['label'],
                    'url' => $attachment['url'],
                    'paper_id' => $paperId,
                ]);
            }
        }
    }
}

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
                'https://doi.org/10.1016/j.jbi.2026.104921',
                'https://osf.io/retina-xai-preprint',
            ],
            'A Lightweight Transformer for Indonesian Legal Document Classification' => [
                'https://arxiv.org/abs/2602.12014',
                'https://github.com/paper-tracking/legal-transformer-id',
            ],
            'Energy-Aware Scheduling for Kubernetes at University Data Centers' => [
                'https://github.com/paper-tracking/green-k8s-scheduler',
            ],
            'Privacy-Preserving Contact Tracing with Federated Graph Learning' => [
                'https://doi.org/10.1109/JIOT.2026.3382104',
                'https://zenodo.org/records/11223344',
            ],
            'Cross-Campus Knowledge Graph for Lecturer Expertise Discovery' => [
                'https://doi.org/10.14569/IJACSA.2026.0160134',
            ],
            'Benchmarking OCR Pipelines for Historical Indonesian Manuscripts' => [
                'https://github.com/paper-tracking/manuscript-ocr-benchmark',
            ],
        ];

        foreach ($paperAttachments as $paperTitle => $urls) {
            $paperId = Paper::query()->where('title', $paperTitle)->value('id');

            if (! $paperId) {
                continue;
            }

            DB::table('url_attachments')->where('paper_id', $paperId)->delete();

            foreach ($urls as $url) {
                DB::table('url_attachments')->insert([
                    'url' => $url,
                    'paper_id' => $paperId,
                ]);
            }
        }
    }
}

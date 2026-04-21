<?php

namespace Database\Seeders;

use App\Models\Paper;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaperStatusHistorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('paper_status_histories')->truncate();

        $order = [
            'DRAFT',
            'READY-TO-SUBMITTED',
            'SUBMITTED',
            'UNDER-REVIEW',
            'REVISION-REQUESTED',
            'ACCEPTED',
            'REJECTED',
            'PUBLISHED',
        ];

        $papers = Paper::query()->with('User')->get();

        foreach ($papers as $paper) {
            $currentIndex = array_search($paper->status, $order, true);

            if (! is_int($currentIndex) || $currentIndex === 0) {
                continue;
            }

            $changedBy = User::query()->find($paper->created_by);
            if ($changedBy === null) {
                continue;
            }

            $historyRows = [];
            $baseTimestamp = now()->subDays(rand(1, 45));

            for ($i = 1; $i <= $currentIndex; $i++) {
                $historyRows[] = [
                    'paper_id' => $paper->id,
                    'old_status' => $order[$i - 1],
                    'new_status' => $order[$i],
                    'changed_by' => $changedBy->id,
                    'changed_at' => $baseTimestamp->copy()->addDays($i),
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            DB::table('paper_status_histories')->insert($historyRows);
        }
    }
}

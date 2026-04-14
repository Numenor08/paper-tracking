<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PublicationIndexSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $publicationIndexes = [
            'Scopus Q1',
            'Scopus Q2',
            'Scopus Q3',
            'Scopus Q4',
            'Web of Science - ESCI',
            'Web of Science - SCI',
            'SINTA 2',
            'IEEE Xplore',
        ];

        foreach ($publicationIndexes as $indexName) {
            DB::table('publication_indexes')->updateOrInsert(
                ['name' => $indexName],
                ['name' => $indexName]
            );
        }
    }
}

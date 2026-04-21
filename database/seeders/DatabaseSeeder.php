<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            PublicationIndexSeeder::class,
            ContributorSeeder::class,
            PaperSeeder::class,
            UrlAttachmentSeeder::class,
            ContributorPaperSeeder::class,
            PaperStatusHistorySeeder::class,
        ]);
    }
}

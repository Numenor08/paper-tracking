<?php

namespace Database\Seeders;

use App\Models\Contributor;
use Illuminate\Database\Seeder;

class ContributorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $contributors = [
            [
                'full_name' => 'Dimas Prasetyo',
                'email' => 'dimas.prasetyo@its.ac.id',
                'affiliation' => 'Institut Teknologi Sepuluh Nopember',
                'phone_number' => '081234560001',
                'address' => 'Surabaya, East Java, Indonesia',
            ],
            [
                'full_name' => 'Nadia Rahman',
                'email' => 'nadia.rahman@ui.ac.id',
                'affiliation' => 'Universitas Indonesia',
                'phone_number' => '081234560002',
                'address' => 'Depok, West Java, Indonesia',
            ],
            [
                'full_name' => 'Arif Kurniawan',
                'email' => 'arif.kurniawan@ugm.ac.id',
                'affiliation' => 'Universitas Gadjah Mada',
                'phone_number' => '081234560003',
                'address' => 'Sleman, Yogyakarta, Indonesia',
            ],
            [
                'full_name' => 'Lina Maharani',
                'email' => 'lina.maharani@itb.ac.id',
                'affiliation' => 'Institut Teknologi Bandung',
                'phone_number' => '081234560004',
                'address' => 'Bandung, West Java, Indonesia',
            ],
            [
                'full_name' => 'Reza Ramadhan',
                'email' => 'reza.ramadhan@telkomuniversity.ac.id',
                'affiliation' => 'Telkom University',
                'phone_number' => '081234560005',
                'address' => 'Bandung, West Java, Indonesia',
            ],
            [
                'full_name' => 'Maya Alviana',
                'email' => 'maya.alviana@unair.ac.id',
                'affiliation' => 'Universitas Airlangga',
                'phone_number' => '081234560006',
                'address' => 'Surabaya, East Java, Indonesia',
            ],
            [
                'full_name' => 'Rifki Saputra',
                'email' => 'rifki.saputra@unej.ac.id',
                'affiliation' => 'Universitas Jember',
                'phone_number' => '081234560007',
                'address' => 'Jember, East Java, Indonesia',
            ],
            [
                'full_name' => 'Siti Nurhaliza',
                'email' => 'siti.nurhaliza@binus.ac.id',
                'affiliation' => 'BINUS University',
                'phone_number' => '081234560008',
                'address' => 'Jakarta, Indonesia',
            ],
        ];

        foreach ($contributors as $contributorData) {
            Contributor::query()->updateOrCreate(
                ['email' => $contributorData['email']],
                $contributorData
            );
        }

        $minimumContributorCount = 20;
        $missingContributors = max(0, $minimumContributorCount - Contributor::query()->count());

        if ($missingContributors > 0) {
            Contributor::factory()->count($missingContributors)->create();
        }
    }
}

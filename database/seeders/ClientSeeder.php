<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Client;

class ClientSeeder extends Seeder
{
    public function run(): void
    {
        $clients = [
            [
                'user_id' => 2,
                'company_name' => 'Tech Innovators Inc.',
                'industry' => 'Technology',
                'contact_number' => '+962791122345',
                'address' => 'Amman, Jordan',
                'website' => 'https://www.techinnovators.com',
            ],
            [
                'user_id' => 16,
                'company_name' => 'Creative Media Solutions',
                'industry' => 'Media & Entertainment',
                'contact_number' => '+962791122346',
                'address' => 'Cairo, Egypt',
                'website' => 'https://www.creativemediasolutions.com',
            ],
            [
                'user_id' => 17,
                'company_name' => 'Global Healthcare Partners',
                'industry' => 'Healthcare',
                'contact_number' => '+962791122347',
                'address' => 'Dubai, UAE',
                'website' => 'https://www.globalhealthcarepartners.com',
            ],
            [
                'user_id' => 18,
                'company_name' => 'Finance & More Ltd.',
                'industry' => 'Finance',
                'contact_number' => '+962791122348',
                'address' => 'Riyadh, Saudi Arabia',
                'website' => 'https://www.financeandmore.com',
            ],
            [
                'user_id' => 19,
                'company_name' => 'Green Energy Corp.',
                'industry' => 'Renewable Energy',
                'contact_number' => '+962791122349',
                'address' => 'Berlin, Germany',
                'website' => 'https://www.greenenergycorp.com',
            ],
            [
                'user_id' => 20,
                'company_name' => 'EduSmart Technologies',
                'industry' => 'Education Technology',
                'contact_number' => '+962791122350',
                'address' => 'New York, USA',
                'website' => 'https://www.edusmarttech.com',
            ],
        ];

        foreach ($clients as $clientData) {
            Client::create($clientData);
        }
    }
}


<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class MotherTongueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tongues = [
            'Hindi', 'English', 'Gujarati', 'Marathi', 'Tamil', 'Telugu', 'Punjabi',
            'Bengali', 'Kannada', 'Urdu', 'Assamese', 'Odia', 'Malayalam', 'Maithili',
            'Santali', 'Konkani', 'Dogri', 'Sindhi', 'Manipuri', 'Bodo', 'Rajasthani',
            'Haryanvi', 'Chhattisgarhi', 'Tulu', 'Garhwali', 'Kumaoni', 'Bhili', 'Gondi',
            'Ladakhi', 'Mizo', 'Khasi', 'Mundari', 'Angika', 'Magahi', 'Nagpuri',
            'Bhojpuri', 'Lepcha', 'Kokborok', 'Mishing', 'Ao', 'Nyishi', 'Pahari',
            'Saurashtra', 'Mewari', 'Marwari', 'Ahirani', 'Halbi', 'Bagheli', 'Chinali',
            'Tibetan', 'Toda', 'Irula', 'Kodava', 'Nepali', 'Bhutia', 'Garo', 'Sema',
            'Rengma', 'Dimasa', 'Zeliang', 'Tangkhul', 'Chang', 'Phom', 'Yimchunger',
            'Lotha', 'Wancho', 'Konyak', 'Nocte', 'Adi', 'Apatani', 'Tagin', 'Memba',
            'Sherdukpen', 'Bugun', 'Aka', 'Hruso', 'Miji', 'Tani', 'Raji', 'Jaunsari',
            'Malto', 'Kurukh', 'Savara', 'Korku', 'Kolami', 'Naiki', 'Parji', 'Kui',
            'Koya', 'Pengo', 'Gadaba', 'Kuvi', 'Paite', 'Hmar', 'Vaiphei', 'Thadou',
            'Simte', 'Zou', 'Gangte', 'Mizo (Lushai)', 'Bhatri', 'Desia', 'Kisan',
            'Saora', 'Nagamese', 'Sherpa', 'Juang', 'Bharia'
        ];

        foreach ($tongues as $tongue) {
            DB::table('mother_tongues')->insert([
                'name' => $tongue,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SuratSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $surat = [
            ['nama_surat' => 'Al-Fatihah (الفاتحة)', 'ayat' => 7],
            ['nama_surat' => 'Al-Baqarah (البقرة)', 'ayat' => 286],
            ['nama_surat' => 'Al-Imran (آل عمران)', 'ayat' => 200],
            ['nama_surat' => "An-Nisa' (النساء)", 'ayat' => 176],
            ['nama_surat' => 'Al-Ma\'idah (المائدة)', 'ayat' => 120],
            ['nama_surat' => 'Al-An’am (الأنعام)', 'ayat' => 165],
            ['nama_surat' => 'Al-A\'raf (الأعراف)', 'ayat' => 206],
            ['nama_surat' => 'Al-Anfal (الأنفال)', 'ayat' => 75],
            ['nama_surat' => 'At-Taubah (التوبة)', 'ayat' => 129],
            ['nama_surat' => 'Yunus (يونس)', 'ayat' => 109],
            ['nama_surat' => 'Hud (هود)', 'ayat' => 123],
            ['nama_surat' => 'Yusuf (يوسف)', 'ayat' => 111],
            ['nama_surat' => 'Ar-Ra’d (الرعد)', 'ayat' => 43],
            ['nama_surat' => 'Ibrahim (إبراهيم)', 'ayat' => 52],
            ['nama_surat' => 'Al-Hijr (الحجر)', 'ayat' => 99],
            ['nama_surat' => 'An-Nahl (النحل)', 'ayat' => 128],
            ['nama_surat' => 'Al-Isra\' (الإسراء)', 'ayat' => 111],
            ['nama_surat' => 'Al-Kahfi (الكهف)', 'ayat' => 110],
            ['nama_surat' => 'Maryam (مريم)', 'ayat' => 98],
            ['nama_surat' => 'Ta Ha (طه)', 'ayat' => 135],
            ['nama_surat' => 'Al-Anbiya\' (الأنبياء)', 'ayat' => 112],
            ['nama_surat' => 'Al-Hajj (الحج)', 'ayat' => 78],
            ['nama_surat' => 'Al-Mu\'minun (المؤمنون)', 'ayat' => 118],
            ['nama_surat' => 'An-Nur (النور)', 'ayat' => 64],
            ['nama_surat' => 'Al-Furqan (الفرقان)', 'ayat' => 77],
            ['nama_surat' => 'Asy-Syu\'ara\' (الشعراء)', 'ayat' => 227],
            ['nama_surat' => 'An-Naml (النمل)', 'ayat' => 93],
            ['nama_surat' => 'Al-Qasas (القصص)', 'ayat' => 88],
            ['nama_surat' => 'Al-Ankabut (العنكبوت)', 'ayat' => 69],
            ['nama_surat' => 'Ar-Rum (الروم)', 'ayat' => 60],
            ['nama_surat' => 'Luqman (لقمان)', 'ayat' => 34],
            ['nama_surat' => 'As-Sajdah (السجدة)', 'ayat' => 30],
            ['nama_surat' => 'Al-Ahzab (الأحزاب)', 'ayat' => 73],
            ['nama_surat' => 'Saba\' (سبأ)', 'ayat' => 54],
            ['nama_surat' => 'Fatir (فاطر)', 'ayat' => 45],
            ['nama_surat' => 'Ya Sin (يس)', 'ayat' => 83],
            ['nama_surat' => 'Ash-Shaaffat (الصافات)', 'ayat' => 182],
            ['nama_surat' => 'Shad (ص)', 'ayat' => 88],
            ['nama_surat' => 'Az-Zumar (الزمر)', 'ayat' => 75],
            ['nama_surat' => 'Al-Mu\'min (المؤمن)', 'ayat' => 85],
            ['nama_surat' => 'Fushshilat (فصلت)', 'ayat' => 54],
            ['nama_surat' => 'Asy-Syura (الشورى)', 'ayat' => 53],
            ['nama_surat' => 'Az-Zukhruf (الزخرف)', 'ayat' => 89],
            ['nama_surat' => 'Ad-Dukhan (الدخان)', 'ayat' => 59],
            ['nama_surat' => 'Al-Jaatsiyah (الجاثية)', 'ayat' => 37],
            ['nama_surat' => 'Al-Ahqaf (الأحقاف)', 'ayat' => 35],
            ['nama_surat' => 'Muhammad (محمد)', 'ayat' => 38],
            ['nama_surat' => 'Al-Fath (الفتح)', 'ayat' => 29],
            ['nama_surat' => 'Al-Hujurat (الحجرات)', 'ayat' => 18],
            ['nama_surat' => 'Qaaf (ق)', 'ayat' => 45],
            ['nama_surat' => 'Adz-dzariyat (الذاريات)', 'ayat' => 60],
            ['nama_surat' => 'Ath-Thuur (الطور)', 'ayat' => 49],
            ['nama_surat' => 'An-Najm (النجم)', 'ayat' => 62],
            ['nama_surat' => 'Al-Qamar (القمر)', 'ayat' => 55],
            ['nama_surat' => 'Ar-Rahman (الرحمن)', 'ayat' => 78],
            ['nama_surat' => 'Al-Waqi\'ah (الواقعة)', 'ayat' => 96],
            ['nama_surat' => 'Al-Hadid (الحديد)', 'ayat' => 29],
            ['nama_surat' => 'Al-Mujadilah (المجادلة)', 'ayat' => 22],
            ['nama_surat' => 'Al-Hasyr (الحشر)', 'ayat' => 24],
            ['nama_surat' => 'Al-Mumtahanah (الممتحنة)', 'ayat' => 13],
            ['nama_surat' => 'Ash-shaf (الصف)', 'ayat' => 14],
            ['nama_surat' => 'Al-Jumu\'ah (الجمعة)', 'ayat' => 11],
            ['nama_surat' => 'Al-Munafiqun (المنافقون)', 'ayat' => 11],
            ['nama_surat' => 'At-taghabun (التغابن)', 'ayat' => 18],
            ['nama_surat' => 'Ath-Thalaq (الطلاق)', 'ayat' => 12],
            ['nama_surat' => 'At-Tahrim (التحريم)', 'ayat' => 12],
            ['nama_surat' => 'Al-Mulk (الملك)', 'ayat' => 30],
            ['nama_surat' => 'Al-Qalam (القلم)', 'ayat' => 52],
            ['nama_surat' => 'Al-Haqqah (الحاقة)', 'ayat' => 52],
            ['nama_surat' => 'Al-Ma\'arij (المعارج)', 'ayat' => 44],
            ['nama_surat' => 'Nuh (نوح)', 'ayat' => 28],
            ['nama_surat' => 'Al-Jin (الجن)', 'ayat' => 28],
            ['nama_surat' => 'Al-Muzammil (المزمل)', 'ayat' => 20],
            ['nama_surat' => 'Al-Muddatstsir (المدثر)', 'ayat' => 56],
            ['nama_surat' => 'Al-Qiyamah (القيامة)', 'ayat' => 40],
            ['nama_surat' => 'Al-Insan (الإنسان)', 'ayat' => 31],
            ['nama_surat' => 'Al-Mursalat (المرسلات)', 'ayat' => 50],
            ['nama_surat' => 'An-Naba\' (النبأ)', 'ayat' => 40],
            ['nama_surat' => 'An-Nazi\'at (النازعات)', 'ayat' => 46],
            ['nama_surat' => '\'Abasa (عبس)', 'ayat' => 42],
            ['nama_surat' => 'At-Takwir (التكوير)', 'ayat' => 29],
            ['nama_surat' => 'Al-Infithar (الإنفطار)', 'ayat' => 19],
            ['nama_surat' => 'Al-Muthaffifin (المطففين)', 'ayat' => 36],
            ['nama_surat' => 'Al-Insyiqaq (الإنشقاق)', 'ayat' => 25],
            ['nama_surat' => 'Al-Buruj (البروج)', 'ayat' => 22],
            ['nama_surat' => 'Ath-Thariq (الطارق)', 'ayat' => 17],
            ['nama_surat' => 'Al-A’laa (الأعلى)', 'ayat' => 19],
            ['nama_surat' => 'Al-Ghasyiyah (الغاشية)', 'ayat' => 26],
            ['nama_surat' => 'Al-Fajr (الفجر)', 'ayat' => 30],
            ['nama_surat' => 'Al-Balad (البلد)', 'ayat' => 20],
            ['nama_surat' => 'Asy-Syams (الشمس)', 'ayat' => 15],
            ['nama_surat' => 'Al-Lail (الليل)', 'ayat' => 21],
            ['nama_surat' => 'Adh-Dhuha (الضحى)', 'ayat' => 11],
            ['nama_surat' => 'Al-Insyirah (الشرح)', 'ayat' => 8],
            ['nama_surat' => 'At-Tin (التين)', 'ayat' => 8],
            ['nama_surat' => 'Al-Alaq (العلق)', 'ayat' => 19],
            ['nama_surat' => 'Al-Qadr (القدر)', 'ayat' => 5],
            ['nama_surat' => 'Al-Bayyinah (البينة)', 'ayat' => 8],
            ['nama_surat' => 'Al-Zalzalah (الزلزلة)', 'ayat' => 8],
            ['nama_surat' => 'Al-Adiyat (العاديات)', 'ayat' => 11],
            ['nama_surat' => 'Al-Qari\'ah (القارعة)', 'ayat' => 11],
            ['nama_surat' => 'At-Takatsur (التكاثر)', 'ayat' => 8],
            ['nama_surat' => 'Al-\'Ashr (العصر)', 'ayat' => 3],
            ['nama_surat' => 'Al-Humazah (الهمزة)', 'ayat' => 9],
            ['nama_surat' => 'Al-Fil (الفيل)', 'ayat' => 5],
            ['nama_surat' => 'Quraysh (قريش)', 'ayat' => 4],
            ['nama_surat' => 'Al-Ma\'un (الماعون)', 'ayat' => 7],
            ['nama_surat' => 'Al-Kautsar (الكوثر)', 'ayat' => 3],
            ['nama_surat' => 'Al-Kafirun (الكافرون)', 'ayat' => 6],
            ['nama_surat' => 'An-Nashr (النصر)', 'ayat' => 3],
            ['nama_surat' => 'Al-Lahab (اللهب)', 'ayat' => 5],
            ['nama_surat' => 'Al-Ikhlas (الإخلاص)', 'ayat' => 4],
            ['nama_surat' => 'Al-Falaq (الفلق)', 'ayat' => 5],
            ['nama_surat' => 'An-Nas (الناس)', 'ayat' => 6],
        ];
        

        foreach ($surat as $item) {
            DB::table('surat')->insert([
                'nama_surat' => $item['nama_surat'],
                'ayat' => $item['ayat'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
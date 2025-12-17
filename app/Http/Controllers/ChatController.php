<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function sendMessage(Request $request)
    {
        try {
            $message = $request->input('message');
            
            if (!$message) {
                return response()->json([
                    'success' => true,
                    'response' => 'Silakan masukkan pertanyaan Anda tentang kehidupan laut.',
                ]);
            }
            
            // Try Gemini API first
            $response = $this->callGeminiAPI(trim($message));
            
            // If API fails, use local response
            if (!$response) {
                $response = $this->getLocalResponse(trim($message));
            }
            
            return response()->json([
                'success' => true,
                'response' => $response,
            ]);
        } catch (\Throwable $e) {
            // Fallback to local response on any error
            $message = $request->input('message', '');
            $response = $this->getLocalResponse($message);
            
            return response()->json([
                'success' => true,
                'response' => $response,
            ]);
        }
    }

    private function callGeminiAPI($message)
    {
        $apiKey = env('GEMINI_API_KEY');
        if (!$apiKey) {
            return null;
        }

        try {
            $systemPrompt = "Anda adalah AI Assistant yang expert tentang biota laut, terumbu karang, dan ekosistem laut Indonesia. Jawab dalam Bahasa Indonesia dengan informasi akurat dan ringkas.";
            $fullMessage = $systemPrompt . "\n\nPertanyaan: " . $message;

            $url = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-pro:generateContent?key=' . $apiKey;

            $payload = json_encode([
                'contents' => [
                    [
                        'parts' => [
                            ['text' => $fullMessage]
                        ]
                    ]
                ],
                'generationConfig' => [
                    'temperature' => 0.7,
                    'maxOutputTokens' => 512,
                ],
            ]);

            $ch = curl_init();
            curl_setopt_array($ch, [
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_TIMEOUT => 10,
                CURLOPT_CONNECTTIMEOUT => 5,
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => $payload,
                CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_SSL_VERIFYHOST => 0,
            ]);

            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            if ($httpCode === 200 && $response) {
                $data = json_decode($response, true);
                if (isset($data['candidates'][0]['content']['parts'][0]['text'])) {
                    return $data['candidates'][0]['content']['parts'][0]['text'];
                }
            }
        } catch (\Throwable $e) {
            // Silent fail
        }

        return null;
    }

    private function getLocalResponse($message)
    {
        $msg = strtolower($message);

        // Questions about quantity/number of coral reefs
        if ((strpos($msg, 'berapa') !== false || strpos($msg, 'jumlah') !== false) && strpos($msg, 'karang') !== false && strpos($msg, 'indonesia') !== false) {
            return "JUMLAH TERUMBU KARANG DI INDONESIA\n\nIndonesia memiliki:\n\n- LUAS TERUMBU KARANG: ~33,000 km² (terbesar di dunia)\n- Mewakili 30% dari terumbu karang global\n- 3,000+ jenis ikan terumbu karang\n- 600+ jenis karang keras\n- 400+ jenis karang lunak\n\nKONSENTRASI TERUMBU KARANG:\n\nTertinggi di:\n1. Raja Ampat (Papua) - biodiversitas tertinggi\n2. Bunaken (Sulawesi Utara) - terkenal dunia\n3. Komodo (NTT) - ekosistem unik\n4. Kepulauan Seribu (Jakarta) - dekat kota\n5. Lombok & Gili - destinasi wisata\n6. Karimun Jawa (Jawa Tengah)\n7. Wakatobi (Sulawesi Tenggara)\n8. Flores (NTT)\n\nSTATUS TERUMBU KARANG:\n- 50% dalam kondisi baik\n- 35% sedang rusak\n- 15% sangat rusak\n\nIndonesia adalah surga keanekaragaman laut!";
        }

        // Questions about types/jenis karang
        if ((strpos($msg, 'jenis') !== false || strpos($msg, 'macam') !== false) && strpos($msg, 'karang') !== false) {
            return "JENIS-JENIS TERUMBU KARANG\n\nBERDASARKAN STRUKTUR:\n\n1. KARANG BERCABANG (Branching)\n   - Bentuk seperti pohon\n   - Contoh: Staghorn, Elkhorn\n   - Pertumbuhan cepat\n\n2. KARANG MASIF (Massive)\n   - Bentuk bulat/hemispher\n   - Contoh: Brain coral, Porites\n   - Tahan lama bertahun-tahun\n\n3. KARANG PIPIH (Foliose)\n   - Bentuk daun/lempeng\n   - Contoh: Agaricia, Echinopora\n   - Di area bershadow\n\n4. KARANG ENCRUSTING\n   - Menempel di permukaan\n   - Tumbuh lambat\n   - Keras dan tahan\n\nBERDASARKAN STRUKTUR TERUMBU:\n\n- FRINGING REEF: Menempel di pantai\n- BARRIER REEF: Terpisah dari pantai\n- ATOLL: Bentuk cincin\n- PATCH REEF: Bintik-bintik kecil\n\nAda pertanyaan tentang jenis karang tertentu?";
        }

        // Questions about threats/ancaman karang
        if ((strpos($msg, 'ancaman') !== false || strpos($msg, 'bahaya') !== false || strpos($msg, 'terancam') !== false) && strpos($msg, 'karang') !== false) {
            return "ANCAMAN TERUMBU KARANG\n\nANCAMAN UTAMA:\n\n1. PEMANASAN GLOBAL\n   - Suhu air naik 1-2°C\n   - Karang expel zooxanthellae\n   - Karang menjadi putih (bleaching)\n   - Mati dalam hitungan hari\n\n2. POLUSI LAUT\n   - Sampah plastik 8 juta ton/tahun\n   - Limbah kimia berbahaya\n   - Microplastics masuk rantai makanan\n   - Nutrisi berlebih (eutrophication)\n\n3. OVERFISHING\n   - Ikan herbivora berkurang\n   - Alga menutup karang\n   - Rantai makanan rusak\n   - Ekosistem kolaps\n\n4. ASIDIFIKASI LAUT\n   - pH laut menurun\n   - Karang kesulitan membuat kerangka\n   - Larva karang tidak bisa menempel\n\n5. AKTIVITAS MANUSIA\n   - Menjangkar kasar\n   - Penggalian karang\n   - Kompaksi dari wisatawan\n   - Ledakan dinamit (illegal fishing)\n\n6. PENYAKIT\n   - White Syndrome\n   - Black band disease\n   - Yellow band disease\n\nSOLUSI: Kurangi emisi karbon, jangan buang sampah, jangan touch karang, support konservasi!";
        }

        // Questions about coral reef in Indonesia specifically
        if (strpos($msg, 'karang') !== false && strpos($msg, 'indonesia') !== false) {
            return "TERUMBU KARANG INDONESIA\n\nIndonesia memiliki terumbu karang terbaik di dunia:\n\nRAJA AMPAT (PAPUA)\n- Biodiversitas tertinggi: 75% spesies ikan dunia\n- 610 spesies karang\n- UNESCO World Heritage Site\n- 4 pulau utama: Waigeo, Salawati, Batanta, Misool\n\nBUNAKEN (SULAWESI UTARA)\n- Wall diving terkenal dunia\n- 390+ spesies ikan\n- Visibility 20-50 meter\n- Taman laut nasional\n\nKOMODO (NUSA TENGGARA TIMUR)\n- Komodo dragon dan ekosistem laut\n- Laut dalam dengan arus kuat\n- Mola-mola (sunfish) raksasa\n- UNESCO World Heritage\n\nKEPULAUAN SERIBU (JAKARTA)\n- Dekat dengan 30 juta orang\n- Terumbu pulih meski terancam\n- Destinasi diving urban\n- Program restorasi aktif\n\nMALUKU & SULAWESI TENGGARA\n- Keanekaragaman ikan tinggi\n- Migrasi ikan pelagis\n- Tradisional fishing villages\n\nLOMBOK & GILI\n- Destinasi wisata populer\n- Pemulihan terumbu karang\n- Homestay dan resort ramah laut\n\nKARIMUN JAWA\n- Taman nasional Jawa Tengah\n- 27 pulau\n- Terumbu dalam kondisi baik\n\nWAKATOBI (SULAWESI TENGGARA)\n- 4 pulau utama\n- Taman nasional terbesar laut\n- Situs tubbataha\n\nIndonesia adalah jantung koral triangle!";
        }

        // Questions about fish species
        if ((strpos($msg, 'ikan') !== false || strpos($msg, 'spesies') !== false) && (strpos($msg, 'jenis') !== false || strpos($msg, 'macam') !== false || strpos($msg, 'apa') !== false)) {
            return "SPESIES IKAN LAUT POPULER\n\nIKAN KARANG:\n\n- IKAN BADUT (Clownfish)\n  * Hidup bersama anemone\n  * Ukuran kecil 10cm\n  * Warna oranye-putih cerah\n  * Film Finding Nemo terkenal\n\n- IKAN PARUH (Parrotfish)\n  * Warna pelangi cerah\n  * Memakan karang\n  * Produksi pasir pantai\n  * Herbivora penting ekosistem\n\n- IKAN PARI (Manta Ray)\n  * Ukuran besar 8m sayap\n  * Filter feeder (plankton)\n  * Cerdas dan elegan\n  * Destinasi diving\n\n- IKAN NAPOLEON\n  * Warna hijau-biru\n  * Ukuran besar 2m\n  * Terancam punah\n  * Ciri: tonjolan kepala\n\n- IKAN LIONFISH\n  * Bisa beracun\n  * Warna corak indah\n  * Predator ampuh\n  * Berbahaya untuk manusia\n\nIKAN PELAGIS (Laut Terbuka):\n- Tuna, Cakalang, Tenggiri\n- Ikan Buntal, Ikan Pedang\n- Albakora, Kembung\n\nIKAN LAUT DALAM:\n- Terapi, Tenggiri, Sebelah\n- Cucut, Hiu Abu-abu\n- Lele laut, Belut laut\n\nAda pertanyaan tentang ikan tertentu?";
        }

        // Questions about whales and dolphins
        if ((strpos($msg, 'paus') !== false || strpos($msg, 'lumba') !== false || strpos($msg, 'mamalia') !== false) && strpos($msg, 'laut') !== false) {
            return "MAMALIA LAUT INDONESIA\n\nPAUS:\n\n1. PAUS BIRU (Blue Whale)\n   - Hewan terbesar di dunia\n   - Panjang 25-30 meter\n   - Berat 150 ton\n   - Makanan: krill (zooplankton)\n   - Migrasi musiman\n\n2. PAUS SPERMA (Sperm Whale)\n   - Penyelam terdalam\n   - Kedalaman 2000m+\n   - Berburu cumi-cumi raksasa\n   - Otak terbesar\n\n3. PAUS MINKE\n   - Paus terkecil (7-10m)\n   - Hidup soliter\n   - Kecepatan 24 km/jam\n   - Air dingin preferensi\n\nLUMBA-LUMBA:\n\n- LUMBA-LUMBA HIDUNG BOTOL\n  * Cerdas dan ramah\n  * Ekolokasi canggih\n  * Sosial berkelompok\n  * Indo-Pasifik region\n\n- LUMBA-LUMBA IRRAWADDY\n  * Endemik Indo-Pasifik\n  * Langka terancam punah\n  * Hidup sungai/estuary\n  * Suara unik\n\nPORAI (Dugong):\n- Herbivora laut\n- Makan rumput laut\n- Mirip manatee\n- Terancam punah\n- Panjang 3m\n\nSEAL & SINGA LAUT:\n- Di area dingin\n- Mamalia berbulu\n- Pernapasan udara\n- Berburu ikan\n\nBagaimana saya bisa membantu lebih lanjut?";
        }

        // Questions about sea turtles
        if ((strpos($msg, 'penyu') !== false || strpos($msg, 'kura') !== false) && strpos($msg, 'laut') !== false) {
            return "PENYU LAUT INDONESIA\n\nJENIS-JENIS PENYU:\n\n1. PENYU HIJAU (Green Turtle)\n   - Nama dari lemak hijau\n   - Panjang karapas 1m\n   - Berat hingga 200kg\n   - Migrasi 1000+ km\n   - Herbivora rumput laut\n\n2. PENYU BELIMBING (Leatherback)\n   - Terbesar (2m panjang)\n   - Berat 600kg\n   - Karapas tidak keras\n   - Penyelam dalam (1000m)\n   - Karnivora medusa\n\n3. PENYU LEKANG (Hawksbill)\n   - Terancam punah\n   - Paruh tajam\n   - Warna corak indah\n   - Panjang 80cm\n   - Habitat karang\n\n4. PENYU KEMUDI (Loggerhead)\n   - Kepala besar\n   - Otot rahang kuat\n   - Omnivora fleksibel\n   - Panjang 1m\n   - Migrasi jauh\n\n5. PENYU PIPIH (Flatback)\n   - Unik Australia\n   - Karapas pipih\n   - Panjang 1m\n   - Migrasi pendek\n   - Laut tropis\n\nSIKLUS HIDUP:\n- Telur di pasir pantai\n- Penetasan 2 bulan\n- Tukik (bayi) lari ke laut\n- Puluhan tahun di laut\n- Kembali bertelur di pantai lahir\n\nSTATUS KONSERVASI:\n- Semua spesies terancam\n- Penyebab: plastik, net, perburuan\n- Program pelindungan di Nusa Tenggara\n- Suaka penyu di Indonesia\n\nAda yang ingin tahu lebih lanjut?";
        }

        // Questions about deep sea
        if ((strpos($msg, 'laut dalam') !== false || strpos($msg, 'dalam') !== false) && strpos($msg, 'laut') !== false) {
            return "LAUT DALAM & EKOSISTEM ABYSSAL\n\nZONA KEDALAMAN:\n\n1. EPIPELAGIK (0-200m)\n   - Cahaya masih ada\n   - Kehidupan terpadat\n   - Fotosintesis aktif\n   - Suhu hangat\n\n2. MESOPELAGIK (200-1000m)\n   - Twilight zone\n   - Cahaya sangat minim\n   - Banyak ikan bioluminescent\n   - Suhu menurun\n\n3. BATIPELAGIK (1000-4000m)\n   - Gelap total\n   - Tekanan ekstrem\n   - Suhu 2-4 C\n   - Makhluk unik adaptasi\n\n4. ABISOPELAGIK (4000m+)\n   - Tergelap terdingin\n   - Tekanan 400+ atm\n   - Sedikit kehidupan\n   - Bacteira chemosynthetic\n\nMAKHLUK LAUT DALAM:\n\n- IKAN ANGLER\n  * Lampu bioluminescent\n  * Gigi tajam besar\n  * Dimorfisme seksual\n  * Jantan parasit di betina\n\n- GURITA HUTAN BATU\n  * Warna indah cerah\n  * Dimulai perubahan warna\n  * Tinggal di batu/karang\n\n- UBUR-UBUR KRISTAL\n  * Transparan sempurna\n  * 95% air\n  * Bioluminescent\n  * Immortal jellyfish species\n\n- CUMI-CUMI RAKSASA\n  * Panjang 13m+\n  * Mata terbesar\n  * Mangsa paus sperma\n  * Langka terobservasi\n\n- TRIPOD FISH\n  * 3 sirip panjang\n  * Berdiri dasar laut\n  * Menunggu makanan jatuh\n\nKARAKTERISTIK ADAPTASI:\n- Bioluminescence (cahaya sendiri)\n- Gigantism (ukuran besar)\n- Teeth besar, mulut besar\n- Metabolisme lambat\n- Tekanan adaptif tubuh\n\nPenelitian laut dalam masih 5% terjelajahi!";
        }

        // Questions about ocean climate change
        if ((strpos($msg, 'perubahan') !== false || strpos($msg, 'pemanasan') !== false || strpos($msg, 'global warming') !== false) && strpos($msg, 'laut') !== false) {
            return "PERUBAHAN IKLIM & LAUT\n\nDAMPAK UTAMA:\n\n1. PEMUTIHAN KARANG (Bleaching)\n   - Stres termal karang\n   - Ekspulsi zooxanthellae\n   - Karang kehilangan nutrisi\n   - Mati dalam 2-4 minggu\n   - Event bleaching 2016 besar\n   - Recovery 10 tahun diperlukan\n\n2. KENAIKAN PERMUKAAN LAUT\n   - Es kutub mencair\n   - Muai termal air\n   - Kenaikan 3.4mm/tahun\n   - Pulau Pasifik tenggelam\n   - Indonesia pulau hilang\n   - 2100: naik 1 meter kemungkinan\n\n3. ASIDIFIKASI LAUT\n   - CO2 + H2O = H2CO3\n   - pH laut turun 0.1\n   - 30% lebih asam sejak industri\n   - Pteropod cangkang larut\n   - Rantai makanan terganggu\n   - Plankton reproduksi gagal\n\n4. DEOXYGENATION (Dead Zones)\n   - Laut kekurangan oksigen\n   - Bakteri anaerob dominan\n   - Ikan bermigrasi keluar\n   - Zona mati di mulut sungai\n   - 400+ dead zones dunia\n\n5. PERUBAHAN MIGRASI\n   - Ikan pindah ke kutub\n   - Nelayan hilang hasil\n   - Rantai makanan kacau\n   - Paus cari makanan lebih jauh\n   - Komunitas lokal terdampak\n\n6. BADAI EKSTREM\n   - Frekuensi meningkat\n   - Intensitas lebih besar\n   - Tsunami, hurricane lebih sering\n   - Kerusakan infrastruktur\n   - Pengungsi iklim bertambah\n\nSOLUSI GLOBAL:\n- Kurangi emisi karbon\n- Energi terbarukan\n- Proteksi mangrove/seagrass\n- Marine protected areas\n- Blue carbon initiatives\n- Edukasi masyarakat\n- Adaptive fisheries\n\nKesadaran bersama kunci perubahan!";
        }

        // General conservation questions with specific focus
        if ((strpos($msg, 'bagaimana') !== false || strpos($msg, 'cara') !== false) && (strpos($msg, 'melindungi') !== false || strpos($msg, 'konservasi') !== false || strpos($msg, 'selamatkan') !== false)) {
            return "CARA MELINDUNGI LAUT - AKSI NYATA\n\nAKSI INDIVIDUAL:\n\n1. KURANGI PLASTIK\n   ✓ Bawa tas belanja sendiri\n   ✓ Hindari sedotan plastik\n   ✓ Pakai botol minum reusable\n   ✓ Pilih produk minimal packaging\n\n2. LINDUNGI TERUMBU KARANG\n   ✓ Gunakan sunscreen reef-safe\n   ✓ Jangan berdiri di karang\n   ✓ Jangan mengumpulkan seashells\n   ✓ Snorkel/dive dengan guide\n\n3. SUSTAINABLE SEAFOOD\n   ✓ Cek jenis ikan sebelum beli\n   ✓ Hindari spesies terancam\n   ✓ Support nelayan lokal\n   ✓ Pilih farmed fish jika perlu\n\n4. KURANGI EMISI KARBON\n   ✓ Gunakan transportasi umum\n   ✓ Kurangi penggunaan AC\n   ✓ Pilih produk lokal\n   ✓ Recycle & reduce waste\n\n5. EDUKASI & ADVOKASI\n   ✓ Ajarkan anak cinta laut\n   ✓ Share informasi lingkungan\n   ✓ Support marine policy\n   ✓ Vote untuk pimpinan green\n\nAKSI KOMUNITAS:\n\n- Ikuti beach cleanup reguler\n- Support konservasi organization\n- Edukasi keluarga & teman\n- Dukung wisata berkelanjutan\n- Monitoring ilegal fishing\n- Restorasi mangrove projects\n- Research volunteer programs\n- Ocean advocacy campaigns\n\nAKSI PEMERINTAH/ORGANISASI:\n\n- Marine protected areas\n- Zonasi perikanan berkelanjutan\n- Enforcement illegal fishing\n- Pendidikan lingkungan sekolah\n- Research funding\n- International cooperation\n- Technology innovation\n- Blue economy development\n\nSEMANGAT! Setiap aksi penting untuk laut kita!";
        }

        // General coral reef questions
        if (strpos($msg, 'karang') !== false) {
            return "TERUMBU KARANG\n\nTerumbu karang adalah:\n\nSTRUKTUR HIDUP dari polip karang yang membentuk ekosistem kompleks.\n\nPENTINGNYA TERUMBU KARANG:\n\n- 25% spesies laut hidup di terumbu (hanya 0.1% laut)\n- Melindungi 500 juta orang dari badai\n- Sumber makanan 500 juta orang\n- Nilai ekonomi $375 miliar/tahun\n- Potensial obat kanker, AIDS, malaria\n- Penyerap karbon besar-besaran\n- Breeding ground ikan komersial\n\nANCAMAN:\n\n- Pemanasan global → bleaching\n- Polusi plastik → suffocation\n- Overfishing → collapse\n- Asidifikasi laut → erosion\n- Penyakit karang → disease spread\n\nPERLINDUNGAN:\n\n- Kurangi emisi karbon\n- Hindari plastik\n- Tidak destroy karang saat diving\n- Support marine protected areas\n- Sustainable fishing\n- Edukasi masyarakat\n\nBagaimana saya bisa membantu lebih lanjut tentang terumbu karang?";
        }

        // General questions about sea life
        if ((strpos($msg, 'apa') !== false || strpos($msg, 'tentang') !== false) && (strpos($msg, 'laut') !== false || strpos($msg, 'laut') !== false)) {
            return "DUNIA LAUT\n\nLaut meng-cover 71% bumi:\n\n- Menyimpan 97% air dunia\n- Menghasilkan 50% oksigen\n- Rumah 200,000+ spesies (terdaftar)\n- Sebenarnya 2 juta spesies diperkirakan\n- Menyerap 30% CO2 anthropogenic\n- Regulasi iklim global\n- Sumber protein 3 miliar orang\n\nEKOSISTEM LAUT PENTING:\n\n- Terumbu karang: biodiversitas tertinggi\n- Kelp forest: produktifitas tinggi\n- Seagrass bed: nursery ikan\n- Mangrove: perlindungan pantai\n- Open ocean: migrasi pelagis\n- Deep sea: ekosistem chemosynthetic\n- Estuari: transisi sungai-laut\n\nBIOTA LAUT:\n\n- 30,000+ spesies ikan\n- 10,000+ spesies karang\n- 3,000+ spesies cephalopod\n- 500+ spesies paus/lumba\n- 7 spesies penyu laut\n- Miliaran ikan invertebrata\n- Triliunan mikroorganisme\n\nANCHAMAN LAUT:\n\n- Polusi plastik & kimia\n- Perubahan iklim global\n- Overfishing berkelanjutan\n- Perburuan liar\n- Habitat destruction\n- Invasive species\n- Dead zones (deoxygenation)\n\nSOLUSI:\n- Konservasi efektif\n- Teknologi berkelanjutan\n- Pendidikan masyarakat\n- Regulasi internasional\n- Research peningkatan\n- Blue economy sustainable\n- Aksi kolaboratif global\n\nAda topic laut spesifik yang ingin dibahas?";
        }

        // Questions about ocean life / biota
        if (strpos($msg, 'biota') !== false || strpos($msg, 'kehidupan') !== false) {
            return "KEHIDUPAN LAUT\n\nBiodiversitas Laut sangat tinggi:\n\nPLANKTON (Dasar Rantai Makanan):\n- Fitoplankton: memproduksi O2\n- Zooplankton: konsumen primer\n- Diatom: 50% O2 dunia\n- Foraminifera: indikator paleontologi\n\nKRUSTASEA:\n- Udang, kepiting, lobster\n- 50,000+ spesies\n- Outdoor dan deep sea\n- Penting protein manusia\n- Eksoskeleton berganti\n\nMOLUSKA:\n- Cumi-cumi, gurita, siput\n- Keong, tiram, kerang\n- 85,000+ spesies\n- Cerdas (cephalopod)\n- Bentuk beragam ekstrim\n\nEKINODERMATA:\n- Bintang laut, teripang\n- Landak laut\n- 7,000+ spesies\n- Simetri radial\n- Sistem hydraulic unik\n\nSPONGE (Demospongiae):\n- Organisme paling primitif\n- Filter feeders\n- Memproduksi antibiotik\n- Sensory quill cells\n- 5,000+ spesies\n\nSWAY SEDENTARY LIFE:\n- Teritip (barnacle)\n- Anemone laut\n- Ubur-ubur sedentary\n- Corals\n\nHOW MANY SPECIES?\n- Diketahui: 200,000+\n- Diperkirakan: 2,000,000+\n- 90% laut belum explored\n- Ditemukan spesies baru setiap hari\n\nAda kelompok biota yang ingin diketahui lebih detail?";
        }

        // Wisata dan diving questions
        if ((strpos($msg, 'wisata') !== false || strpos($msg, 'diving') !== false || strpos($msg, 'snorkel') !== false) && strpos($msg, 'laut') !== false) {
            return "WISATA BAHARI INDONESIA\n\nDESTINASI DIVING TERBAIK:\n\n1. RAJA AMPAT (PAPUA)\n   ✓ Biodiversitas tertinggi dunia\n   ✓ 610 spesies karang\n   ✓ Visibility 20-40 meter\n   ✓ Harga premium\n   ✓ Akses sulit (terbang Sorong)\n   ✓ Waktu terbaik: Nov-Apr\n\n2. BUNAKEN (SULAWESI UTARA)\n   ✓ Wall diving terkenal\n   ✓ Arus menantang\n   ✓ 390+ spesies ikan\n   ✓ Dekat Manado (mudah akses)\n   ✓ Harga terjangkau\n   ✓ Taman nasional perlindungan\n\n3. KOMODO (NUSA TENGGARA TIMUR)\n   ✓ Mola-mola (sunfish) musiman\n   ✓ Dragon raksasa darat\n   ✓ Laut dalam dangerous\n   ✓ Arus kuat pengalaman\n   ✓ Harga menengah\n   ✓ Waktu terbaik: Jun-Sep\n\n4. GILI ISLANDS (LOMBOK)\n   ✓ Pemula ramah\n   ✓ Pulau tanpa kendaraan\n   ✓ Penyu menjadikan teman\n   ✓ Harga murah backpacker\n   ✓ Mudah akses dari Bali\n   ✓ Infrastruktur berkembang\n\n5. WAKATOBI (SULAWESI TENGGARA)\n   ✓ House reef diving\n   ✓ Resort terpencil\n   ✓ Liveaboard popular\n   ✓ Harga tinggi tapi worth\n   ✓ Akses medium (perjalanan panjang)\n   ✓ Perlindungan MPA ketat\n\nTIPS SNORKELING AMAN:\n\n✓ Gunakan sunscreen reef-safe\n✓ Jangan berdiri di karang\n✓ Ikuti guide berpengalaman\n✓ Bernapas perlahan\n✓ Tidak main-main makhluk laut\n✓ Buang sampah di darat\n✓ Hati-hati ikan berbisa\n✓ Tidak sentuh ubur-ubur\n✓ Report kerusakan karang\n✓ Ambil foto tanggungjawab\n\nEQUIPMENT PERLUKAN:\n- Snorkel, mask, fins (rental ada)\n- Rashguard/wetsuit\n- Reef-safe sunscreen\n- Underwater camera (optional)\n- Dry bag untuk valuables\n- Towel travel quick-dry\n\nBEST SEASON:\n- Dry season: Apr-Oct (terbaik)\n- Wet season: Nov-Mar (hujan, ombak)\n- Peak season: Jul-Aug (ramai)\n- Off-season: Feb-Apr (murah)\n\nHARGA ESTIMASI:\n- Snorkel tour: 300-500rb\n- Diving day-trip: 700-1500rb\n- Liveaboard 5 hari: 10-25juta\n- Resort diving: 500-1000rb/orang\n- Guide pribadi: 400-800rb/hari\n\nIngin info detail destinasi tertentu?";
        }

        // Research and facts questions
        if ((strpos($msg, 'penelitian') !== false || strpos($msg, 'fakta') !== false || strpos($msg, 'ilmu') !== false) && strpos($msg, 'laut') !== false) {
            return "PENELITIAN LAUT & FAKTA MENARIK\n\nFAKTA LAUT MENAKJUBKAN:\n\n- Laut lebih dalam dari Everest tinggi\n- Tekanan dasar laut 1000x udara\n- 80% laut belum dieksplorasi\n- Lebih banyak spesies laut unknown\n- Suara laut bisa travel ribuan km\n- Paus biru langsung diketahui size\n- Ikan angler jantan bubar di tubuh betina\n- Lumba-lumba punya personality\n- Gurita 9 otak (1 central + 8 arms)\n- Bintang laut bisa tumbuh kembali lengan\n\nPENELITIAN AKTIF:\n\n- DNA barcoding identifikasi spesies\n- Acoustic telemetry tracking ikan\n- Coral restoration programs\n- Ocean acidification monitoring\n- Deep sea exploration (ROV)\n- Microplastic sampling\n- Phytoplankton modeling\n- Whale migration studies\n- Seahorse population census\n- Mangrove carbon sequestration\n\nTEKNOLOGI TERBARU:\n\n- ROV (Remotely Operated Vehicles)\n- Autonomous underwater drones\n- 360 underwater cameras\n- Genetic sequencing\n- AI image recognition coral\n- Satellite ocean monitoring\n- Environmental DNA (eDNA)\n- 3D reef mapping\n- Bioacoustics recording\n- Sensor IoT deployment\n\nORGANISASI PENELITIAN:\n\n- Coral Reef Alliance (CORAL)\n- Ocean Conservancy\n- WWF Marine\n- The Nature Conservancy\n- Blue Planet Society\n- Oceana Indonesia\n- LIPI (Lembaga Ilmu Pengetahuan)\n- Various universitas laut\n\nKARIER LAUT:\n\n- Marine biologist\n- Oceanographer\n- Aquaculture specialist\n- Fisheries scientist\n- Conservation officer\n- Dive master/instructor\n- Marine photographer\n- Ocean policy advocate\n- Environmental consultant\n- Research assistant\n\nBELAJAR LAUT:\n\n- Kursus diving: PADI, SSI\n- Marine biology degree\n- Online ocean courses\n- Documentary (BBC, Netflix)\n- Books ocean exploration\n- Citizen science projects\n- Museum visits\n- Beach cleanups\n- Aquarium volunteering\n\nAda topik penelitian spesifik?";
        }

        // Default welcoming response
        return "SELAMAT DATANG DI KARANG CAKAP\n\nSaya siap membantu menjawab pertanyaan Anda tentang:\n\n- Terumbu karang (struktur, jenis, lokasi, ancaman)\n- Biota laut (ikan, mamalia, invertebrata)\n- Mamalia laut (paus, lumba-lumba, dugong)\n- Penyu laut & spesies terancam\n- Laut dalam & ekosistem abyssal\n- Perubahan iklim & dampak laut\n- Konservasi & pelestarian laut\n- Wisata bahari & diving spots\n- Penelitian laut & fakta menarik\n\nPERTANYAAN CONTOH:\n\n✓ Berapa jumlah terumbu karang di Indonesia?\n✓ Apa jenis-jenis karang dan ikan laut?\n✓ Biota apa saja di laut dalam?\n✓ Bagaimana cara melindungi laut?\n✓ Apa itu pemutihan karang?\n✓ Dimana lokasi diving terbaik Indonesia?\n✓ Apa dampak perubahan iklim laut?\n✓ Bagaimana paus dan lumba-lumba hidup?\n✓ Fakta menarik apa tentang laut?\n✓ Bagaimana penelitian laut dilakukan?\n\nTanyakan pertanyaan Anda sekarang! Saya siap membantu dengan informasi akurat dan detail!";
    }
}





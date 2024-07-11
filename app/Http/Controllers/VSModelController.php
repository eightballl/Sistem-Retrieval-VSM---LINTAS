<?php

namespace App\Http\Controllers;

use App\Models\ArsipDokumen;
use Illuminate\Http\Request;

class VSModelController extends Controller
{
    // Deklarasi sample dokumen
    static function dokumen()
    {
        $dokumen = ArsipDokumen::select('id', 'keyword', 'nama_dokumen', 'deskripsi')->get()->toArray();
        return $dokumen;
    }

    // Melakukan index istilah yang ada disemua tabel/dokumen
    // TERMS (t)
    static function terms($dokumen)
    {
        $istilah = array();
        $stopwords = ['di', 'ke', 'dari', 'dan', 'atau', 'yang']; // Kata hubung yang tidak akan dihapus

        foreach ($dokumen as $item) {
            // Ubah keyword menjadi huruf kecil dan hapus simbol serta angka
            $cleaned_text = preg_replace('/[^a-z\s]/i', '', strtolower($item['keyword']));

            // Pisahkan teks menjadi kata-kata
            $istilah_dokumen = explode(" ", $cleaned_text);

            // Filter kata-kata yang terdiri dari dua huruf kecuali kata hubung
            $filtered_terms = array_filter($istilah_dokumen, function ($term) use ($stopwords) {
                return strlen($term) > 2 || in_array($term, $stopwords);
            });

            // Gabungkan istilah ke array utama
            $istilah = array_merge($istilah, $filtered_terms);
        }
        $istilah = array_unique($istilah);

        // echo "<h2>DAFTAR ISTILAH</h2>";
        // echo "<pre>";
        // print_r($istilah);
        // echo "</pre>";
        return $istilah;
    }

    // 1. Perhitungan Term Frequency (tf)
    static function tf($terms, $dokumen)
    {
        $jml_dokumen = count($dokumen);
        $matrik_tf = array();

        foreach ($terms as $item) {
            if (!empty($item)) { // Periksa apakah $item tidak kosong
                for ($i = 0; $i < $jml_dokumen; $i++) {
                    $jml = substr_count(strtolower($dokumen[$i]['keyword']), $item);
                    $matrik_tf[$item][$i] = $jml;
                }
            }
        }

        // echo "<h2>MATRIK Perhitungan Term Frequency (tf)</h2>";
        // echo "<pre>";
        // print_r($matrik_tf);
        // echo "</pre>";
        return $matrik_tf;
    }

    // 2. Perhitungan Inverse Document Frequency (idf)
    static function idf($matrik_tf, $dokumen)
    {
        $N = count($dokumen);
        $matrik_df = array();
        $matrik_idf = array();

        foreach ($matrik_tf as $key => $item) {
            $matrik_df[$key] = 0;
            foreach ($item as $value) {
                if ($value > 0) {
                    $matrik_df[$key]++;
                }
            }
        }

        // echo "<h2>Matrik df adalah banyaknya dokumen dalam koleksi dimana term/istilah muncul di dalamnya</h2>";
        // echo "<pre>";
        // print_r($matrik_df);
        // echo "</pre>";

        foreach ($matrik_df as $key => $value) {
            if ($value == 0) {
                // Menangani kasus DF = 0 untuk menghindari pembagian dengan nol
                $matrik_idf[$key] = 0;
            } else {
                $matrik_idf[$key] = log10($N / $value); // Perbaikan perhitungan IDF sesuai dengan permintaan
            }
        }


        // echo "<h2>Matrik Inverse Document Frequency (idf)</h2>";
        // echo "<pre>";
        // print_r($matrik_idf);
        // echo "</pre>";
        return $matrik_idf;
    }

    // 3. Perhitungan Term Frequency Inverse Document Frequency (tfidf)
    static function tfidf($matrik_tf, $matrik_idf)
    {
        $matrik_tfidf = array();

        foreach ($matrik_tf as $key => $item) {
            foreach ($item as $keyItem => $itemValue) {
                $matrik_tfidf[$key][$keyItem] = $itemValue * $matrik_idf[$key];
            }
        }

        // echo "<h2>Matrik Term Frequency Inverse Document Frequency (tfidf)</h2>";
        // echo "<pre>";
        // print_r($matrik_tfidf);
        // echo "</pre>";
        return $matrik_tfidf;
    }

    // 4. Perhitungan Jarak Dokumen ( |dj| )
    static function dj($matrik_tfidf, $dokumen)
    {
        $matrik_w = array();
        $matrik_dj = array();

        $jml_dokumen = count($dokumen);

        for ($keyItem = 0; $keyItem < $jml_dokumen; $keyItem++) {
            $matrik_w[$keyItem] = 0;
        }

        foreach ($matrik_tfidf as $item) {
            foreach ($item as $keyItem => $itemValue) {
                $kuadrat = $itemValue * $itemValue;
                $matrik_w[$keyItem] += $kuadrat;
            }
        }

        foreach ($matrik_w as $key => $item) {
            $matrik_dj[$key] = sqrt($item);
        }

        // echo "<h2>Perhitungan Jarak Dokumen ( |dj| )</h2>";
        // echo "<pre>";
        // print_r($matrik_dj);
        // echo "</pre>";

        return $matrik_dj;
    }

    // 5. Perhitungan Query/Kata Kunci
    // 5.a menghitung pembobotan nilai Term Frequency Inverse Document Frequency (tfidf)
    static function tfidf_query($kata_kunci, $terms, $matrik_idf)
    {
        $matrik_tf_query = array();
        $frequensi_max = 0;

        foreach ($terms as $item) {
            // Pastikan $item tidak kosong sebelum menggunakan substr_count
            if (!empty($item)) {
                $jml = substr_count(strtolower($kata_kunci), $item);
                $matrik_tf_query[$item] = $jml;
                if ($jml > $frequensi_max) {
                    $frequensi_max = $jml;
                }
            }
        }

        // echo "<h2>Matrik tf dari query/kata kunci</h2>";
        // echo "<pre>";
        // print_r($matrik_tf_query);
        // echo "</pre>";
        // echo "Jumlah Frequensi Maksimum = " . $frequensi_max;

        $matrik_tfidf_query = array();
        foreach ($matrik_tf_query as $key => $item) {
            $matrik_tfidf_query[$key] = ($item / $frequensi_max) * $matrik_idf[$key];
        }

        // echo "<h2>Matrik tfidf dari query/kata kunci</h2>";
        // echo "<pre>";
        // print_r($matrik_tfidf_query);
        // echo "</pre>";

        return $matrik_tfidf_query;
    }

    // 5.b Perhitungan Jarak Query ( |q| )
    static function q($matrik_tfidf_query)
    {
        $w_query = 0;

        foreach ($matrik_tfidf_query as $item) {
            $kuadrat = $item * $item;
            $w_query += $kuadrat;
        }

        $q = sqrt($w_query);

        // echo "<h2>Perhitungan Jarak Query ( |q| )</h2>";
        // echo "q = " . $q;

        return $q;
    }

    // 6. Perhitungan pengukuran similaritas query document
    // 6.a Menghitung sum dari (tfidf * tfidf_query) atau dj.q
    static function sum_dj_q($matrik_tfidf, $matrik_tfidf_query, $dokumen)
    {
        $matrik_sum_dj_q = array();

        $jml_dokumen = count($dokumen);

        for ($keyItem = 0; $keyItem < $jml_dokumen; $keyItem++) {
            $matrik_sum_dj_q[$keyItem] = 0;
        }

        foreach ($matrik_tfidf as $key => $item) {
            foreach ($item as $keyItem => $itemValue) {
                $WiqXqij = $itemValue * $matrik_tfidf_query[$key];
                $matrik_sum_dj_q[$keyItem] += $WiqXqij;
            }
        }

        // echo "<h2>Perhitungan Sum (tfidf * tfidf_query) atau dj.q </h2>";
        // echo "<pre>";
        // print_r($matrik_sum_dj_q);
        // echo "</pre>";

        return $matrik_sum_dj_q;
    }

    // 6.b Menghitung dari |dj|.|q| (jarak dokumen * jarak query)
    static function djq($matrik_dj, $q)
    {
        $matrik_djq = array();

        foreach ($matrik_dj as $key => $item) {
            $matrik_djq[$key] = $item * $q;
        }

        // echo "<h2>Perhitungan |dj|.|q| (jarak dokumen * jarak query)</h2>";
        // echo "<pre>";
        // print_r($matrik_djq);
        // echo "</pre>";

        return $matrik_djq;
    }

    // 6.c Menghitung dj.q / |dj|.|q|
    static function sim($matrik_sum_dj_q, $matrik_djq)
    {
        $matrik_sim = array();

        foreach ($matrik_sum_dj_q as $key => $item) {
            $matrik_sim[$key] = $item / $matrik_djq[$key];
        }

        // echo "<h2>Perhitungan dj.q / |dj|.|q|</h2>";
        // echo "<pre>";
        // print_r($matrik_sim);
        // echo "</pre>";

        return $matrik_sim;
    }

    // Menyimpulkan
    static function kesimpulan($dokumen, $matrik_sim)
    {
        $matrik_kesimpulan = array();
        foreach ($dokumen as $key => $item) {
            $matrik_kesimpulan[$key]['data'] = $item['keyword'];
            $matrik_kesimpulan[$key]['similaritas'] = $matrik_sim[$key];
        }

        // echo "<h2>Kesimpulan SEBELUM diurutkan</h2>";
        // echo "<pre>";
        // print_r($matrik_kesimpulan);
        // echo "</pre>";

        // Mengurutkan kesimpulan
        $similaritas = array_column($matrik_kesimpulan, 'similaritas');
        array_multisort($similaritas, SORT_DESC, $matrik_kesimpulan);

        // echo "<h2>KESIMPULAN SETELAH DIURUTKAN</h2>";
        // echo "<pre>";
        // print_r($matrik_kesimpulan);
        // echo "</pre>";

        return $matrik_kesimpulan; // Pastikan mengembalikan matrik_kesimpulan
    }

    public function proses(Request $request)
    {
        //PERHITUNGAN DOKUMEN
        $dokumen = $this->dokumen();
        $terms = $this->terms($dokumen);
        $matrik_tf = $this->tf($terms, $dokumen);
        $matrik_idf = $this->idf($matrik_tf, $dokumen);
        $matrik_tfidf = $this->tfidf($matrik_tf, $matrik_idf);
        $matrik_dj = $this->dj($matrik_tfidf, $dokumen);
        //PERHITUNGAN QUERY/KATA KUNCI
        $kata_kunci = $request->input('keyword');
        $matrik_tfidf_query = $this->tfidf_query($kata_kunci, $terms, $matrik_idf);
        $q = $this->q($matrik_tfidf_query);
        //PERHITUNGAN KESIMPULAN
        $matrik_sum_dj_q = $this->sum_dj_q($matrik_tfidf, $matrik_tfidf_query, $dokumen);
        $matrik_djq = $this->djq($matrik_dj, $q);
        $matrik_sim = $this->sim($matrik_sum_dj_q, $matrik_djq);
        $matrik_kesimpulan = $this->kesimpulan($dokumen, $matrik_sim);
        // $this->kesimpulan($dokumen, $matrik_sim);

        // Mengirim data ke view
        return view('hasil', compact('matrik_kesimpulan', 'dokumen', 'matrik_sum_dj_q', 'matrik_djq', 'matrik_sim', 'q', 'matrik_dj', 'kata_kunci'));
    }
}

<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ReportModel;
use App\Models\ShiftModel;

class Home extends BaseController
{
	

	function __construct()
    {
        $this->reportModel = new ReportModel();
		$this->ShiftsModel = new ShiftModel();
    }
	public function index() {
        // Load model
        
        // Ambil data produksi per jam per barang
		$data = array_merge($this->data, [
			'title'         => 'Dashboard Page'
		]);
       

        // Load view dan kirim data ke view
       return view('dashboard/dashboardlist', $data);
    }

	public function getGrafikData() {
		// Ambil data dari request POST
		$tanggal = $this->request->getPost('tanggal');
		$tampilan = $this->request->getPost('tampilan'); // Ambil tampilan (per jam, shift, atau hari)
	
		// Validasi input tanggal
		if (!$tanggal) {
			return json_encode([
				'error' => 'Tanggal tidak valid'
			]);
		}
	
		// Tentukan data berdasarkan tampilan
		if ($tampilan === 'shift') {
			// Ambil data produksi berdasarkan shift
			$shifts = $this->ShiftsModel->getShifts(); // Ambil semua shift dari database
			$shiftLabels = []; // Untuk menyimpan label shift
			foreach ($shifts as $shift) {
				$shiftLabels[$shift['id']] = $shift['shift_name']; // Simpan shift dengan id sebagai kunci
			}
	
			// Ambil data produksi berdasarkan shift
			$dataProduksi = $this->reportModel->get_produksi_per_shift($tanggal);
			$labels = array_values($shiftLabels); // Misal ada 3 shift
		} elseif ($tampilan === 'hari') {
			// Ambil data produksi berdasarkan hari
			$dataProduksi = $this->reportModel->get_produksi_per_hari($tanggal);
			$labels = range(1, cal_days_in_month(CAL_GREGORIAN, date('m', strtotime($tanggal)), date('Y', strtotime($tanggal))));
			foreach ($labels as &$day) {
				$day = str_pad($day, 2, '0', STR_PAD_LEFT) . '-' . date('m-Y', strtotime($tanggal)); // Format tanggal dd-mm-yyyy
			}
		} else {
			// Ambil data produksi per jam (default)
			$dataProduksi = $this->reportModel->get_produksi_per_jam_per_barang($tanggal);
			$labels = [];
			for ($i = 0; $i < 24; $i++) {
				$labels[] = str_pad($i, 2, '0', STR_PAD_LEFT) . ':00'; // Format jam sebagai 'HH:00'
			}
		}
	
		// Cek jika tidak ada data yang ditemukan
		if (empty($dataProduksi)) {
			return json_encode([
				'error' => 'Tidak ada data produksi untuk tanggal yang dipilih.'
			]);
		}
	
		// Siapkan array untuk data produksi per barang
		$produksiPerBarang = [];
	
		// Mengelompokkan data produksi berdasarkan barang (untuk per shift dan per hari juga)
		foreach ($dataProduksi as $produksi) {
			if ($tampilan === 'shift') {
$index = array_search($shiftLabels[$produksi['shift']], $labels); // Shift: 1, 2, 3
} elseif ($tampilan === 'hari') {
$index = date('d', strtotime($produksi['tanggal'])) - 1; // Hari berdasarkan tanggal
} else {
$index = $produksi['jam']; // Untuk per jam
}

// Jika barang belum ada di array produksiPerBarang, inisialisasi
if (!isset($produksiPerBarang[$produksi['nama_barang']])) {
$produksiPerBarang[$produksi['nama_barang']] = array_fill(0, count($labels), 0);
}

// Update jumlah produksi pada jam/shift/hari tertentu untuk barang terkait
$produksiPerBarang[$produksi['nama_barang']][$index] = $produksi['total_produksi'];
}

// Siapkan array untuk data grafik
$datasets = [];
foreach ($produksiPerBarang as $barang => $produksi) {
$datasets[] = [
'label' => $barang, // Nama barang sebagai label dataset
'data' => $produksi, // Data produksi per jam/shift/hari
'borderColor' => $this->getRandomColor(), // Warna garis untuk tiap barang (opsional)
'fill' => false // Tidak mengisi area bawah grafik
];
}

// Kirim data dalam bentuk JSON
return json_encode([
'labels' => $labels,
'datasets' => $datasets
]);
}

// Fungsi untuk menghasilkan warna acak
private function getRandomColor() {
$letters = '0123456789ABCDEF';
$color = '#';
for ($i = 0; $i < 6; $i++) { $color .=$letters[rand(0, 15)]; } return $color; } }
<?php

namespace App\Models;

use CodeIgniter\Model;

class ReportModel extends Model
{

    // public function getShifts($ShiftsID = false)
    // {
    //     if ($ShiftsID) {
    //         return $this->db->table('shifts')
    //         ->where(['shifts.id' => $ShiftsID])
    //         ->get()->getRowArray();
    //     } else {
    //         return $this->db->table('shifts')
    //         ->get()->getResultArray();
    //     }
    // }
        
    public function createReport($data)
    {
        return $this->db->table('reports')->insert([
            'produksi_id' => $data['produksi_id'],
            'jam_produksi' => $data['jam_produksi'],
            'jumlah_produksi' => $data['inputReportJumlahProduksi'],
            'created_by' => $data['created_by'],
            'report_data' => json_encode(['note' => 'Laporan produksi telah dibuat']), // Bisa menambahkan data tambahan
            'created_at' => date('Y-m-d H:i:s')
        ]);
    }
    // public function get_produksi_per_jam_per_barang() {
    //     $builder = $this->db->table('reports')
    //         ->select('barang.nama_barang, HOUR(reports.jam_produksi) AS jam, SUM(produksi.jumlah_produksi) AS total_produksi')
    //         ->join('produksi', 'reports.produksi_id = produksi.id')
    //         ->join('barang', 'produksi.barang_id = barang.id')
    //         ->groupBy('barang.nama_barang, HOUR(reports.jam_produksi)') // Group by barang and hour
    //         ->orderBy('jam', 'ASC'); // Sort by hour
        
    //     return $builder->get()->getResultArray();
    // }
    
    public function get_produksi_per_jam_per_barang($tanggal) {
        $builder = $this->db->table('reports')
            ->select('HOUR(reports.jam_produksi) AS jam, barang.nama_barang AS nama_barang, SUM(reports.jumlah_produksi) AS total_produksi')
            ->join('produksi', 'reports.produksi_id = produksi.id')
            ->join('barang', 'produksi.barang_id = barang.id')
            ->where('DATE(produksi.tanggal_produksi)', $tanggal) // Filter by date
            ->groupBy('HOUR(jam_produksi), barang.id') // Group by hour and item
            ->orderBy('jam', 'ASC')
            ->orderBy('barang.id', 'ASC'); // Sort by hour and item
        
        return $builder->get()->getResultArray();
    }

    public function get_produksi_per_shift($tanggal) {
        $builder = $this->db->table('reports')
            ->select('shifts.id AS shift, barang.nama_barang AS nama_barang, SUM(reports.jumlah_produksi) AS total_produksi')
            ->join('produksi', 'reports.produksi_id = produksi.id')
            ->join('barang', 'produksi.barang_id = barang.id')
            ->join('shifts', 'produksi.shift_id = shifts.id')
            ->where('DATE(produksi.tanggal_produksi)', $tanggal)
            ->groupBy('produksi.shift_id, barang.id')
            ->orderBy('shifts.start_time', 'ASC');
    
        return $builder->get()->getResultArray();
    }
    
    public function get_produksi_per_hari($tanggalBulan) {
        $builder = $this->db->table('reports')
            ->select('DATE(produksi.tanggal_produksi) AS tanggal, barang.nama_barang AS nama_barang, SUM(reports.jumlah_produksi) AS total_produksi')
            ->join('produksi', 'reports.produksi_id = produksi.id')
            ->join('barang', 'produksi.barang_id = barang.id')
            ->where('DATE_FORMAT(produksi.tanggal_produksi, "%Y-%m")', date('Y-m', strtotime($tanggalBulan)))
            ->groupBy('DATE(produksi.tanggal_produksi), barang.id')
            ->orderBy('tanggal', 'ASC');
    
        return $builder->get()->getResultArray();
    }

    public function getReportsByProduksiId($produksi_id)
    {
        return $this->where('produksi_id', $produksi_id)->findAll(); // Mencari semua laporan berdasarkan produksi_id
    }
    
    
    

}  
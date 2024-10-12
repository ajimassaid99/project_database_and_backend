<?php

namespace App\Models;

use CodeIgniter\Model;

class ProduksiModel extends Model
{
    
    protected $table = 'produksi';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nama_barang', 'shift_name', 'jumlah_produksi', 'barcode', 'tanggal_produksi', 'status', 'created_at', 'updated_at'];

    public function getProduksi($ProduksiID = false)
    {
        $builder = $this->db->table('produksi')
            ->select('produksi.*, barang.nama_barang, shifts.shift_name')
            ->join('barang', 'produksi.barang_id = barang.id')
            ->join('shifts', 'produksi.shift_id = shifts.id');
    
        if ($ProduksiID) {
            return $builder->where(['produksi.id' => $ProduksiID])
                ->get()->getRowArray();
        } else {
            return $builder->get()->getResultArray();
        }
    }
    public function getProduksiOp()
    {
        $builder = $this->db->table('produksi')
            ->select('produksi.*, barang.nama AS nama_barang, shifts.shift_name')
            ->join('barang', 'produksi.barang_id = barang.id')
            ->join('shifts', 'produksi.shift_id = shifts.id');
    
        
            // Tambahkan kondisi untuk memfilter berdasarkan tanggal hari ini
            return $builder->where('DATE(produksi.tanggal_produksi)', date('Y-m-d')) // Filter hari ini
                ->get()->getResultArray();
        
    }
    

    public function cekBarcode($barcode)
    {
        $builder = $this->db->table('produksi')
            ->select('produksi.*');
    
            return $builder->where(['produksi.barcode' => $barcode])
                ->get()->getRowArray();
        
    }
          
                
    public function createProduksi($dataProduksi)
    {
        return $this->db->table('produksi')->insert([
          'barang_id'     	=> $dataProduksi['inputBarangId'],
          'shift_id'     	=> $dataProduksi['inputShiftId'],
          'barcode'     	=> $dataProduksi['inputBarcode'],
          'tanggal_produksi'     	=> $dataProduksi['inputTanggalProduksi']
        ]);
    }
                    
                
    public function updateProduksi($dataProduksi)
    {
        return $this->db->table('produksi')->update([
          'barang_id'     	=> $dataProduksi['inputBarangId'],
          'shift_id'     	=> $dataProduksi['inputShiftId'],
          'barcode'     	=> $dataProduksi['inputBarcode'],
          'tanggal_produksi'     	=> $dataProduksi['inputTanggalProduksi'],
            ], ['id' => $dataProduksi['inputProduksiID']]);
    }
          
                

    public function deleteProduksi($ProduksiID)
	{
		return $this->db->table('produksi')->delete(['id' => $ProduksiID]);
	}

                
                
}
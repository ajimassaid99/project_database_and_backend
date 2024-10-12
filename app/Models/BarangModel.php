<?php

namespace App\Models;

use CodeIgniter\Model;

class BarangModel extends Model
{

    public function getBarang($BarangID = false)
    {
        if ($BarangID) {
            return $this->db->table('barang')
            ->where(['barang.id' => $BarangID])
            ->get()->getRowArray();
        } else {
            return $this->db->table('barang')
            ->get()->getResultArray();
        }
    }

    
    public function createBarang($dataBarang)
    {
        return $this->db->table('barang')->insert([
          'nama_barang'     	=> $dataBarang['inputNamaBarang'],
          'kode_barang'     	=> $dataBarang['inputKodeBarang']
        ]);
    }

    public function updateBarang($dataBarang)
    {
        return $this->db->table('barang')->update([
          'nama_barang'     	=> $dataBarang['inputNamaBarang'],
          'kode_barang'     	=> $dataBarang['inputKodeBarang']
            ], ['id' => $dataBarang['inputBarangID']]);
    }

    public function deleteBarang($BarangID)
	{
		return $this->db->table('barang')->delete(['id' => $BarangID]);
	}
}
<?php
namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\BarangModel;
use App\Models\ProduksiModel;
use App\Models\ShiftModel;
class Produksi extends BaseController
{
                           
    function __construct()
    {
        $this->produksiModel = new ProduksiModel();
        $this->barangModel = new BarangModel();
        $this->shiftsModel = new ShiftModel();
    }
                      
    public function index()
    {
        $data = array_merge($this->data, [
            'title'     => $this,
            'Produksi'    => $this->produksiModel->getProduksi(),
            'Barang'=> $this->barangModel->getBarang(),
            'Shift' => $this->shiftsModel->getShifts()
        ]);
        return view('produksi/produksilist', $data);
    }

    public function getIndex()
    {
        $data = array_merge($this->data, [
            'title'     => $this,
            'Produksi'    => $this->produksiModel->getProduksi(),
            'Barang'=> $this->barangModel->getBarang(),
            'Shift' => $this->shiftsModel->getShifts()
        ]);
        return view('report_operator/reportOperator', $data);
    }
                
                
    public function createProduksi()
    {
        $createProduksi = $this->produksiModel->createProduksi($this->request->getPost(null, FILTER_UNSAFE_RAW));
        if ($createProduksi) {
            session()->setFlashdata('notif_success', '<b>Successfully added new Produksi</b>');
            return redirect()->to(base_url('produksi'));
        } else {
            session()->setFlashdata('notif_error', '<b>Failed to add new Produksi</b>');
            return redirect()->to(base_url('produksi'));
        }
    }
                
                
        public function updateProduksi()
        {
            $updateProduksi = $this->produksiModel->updateProduksi($this->request->getPost(null, FILTER_UNSAFE_RAW));
            if ($updateProduksi) {
                session()->setFlashdata('notif_success', '<b>Successfully update Produksi</b>');
                return redirect()->to(base_url('produksi'));
            } else {
                session()->setFlashdata('notif_error', '<b>Failed to update Produksi</b>');
                return redirect()->to(base_url('produksi'));
            }
        }
                
                

        public function deleteProduksi($ProduksiID)
        {
            if (!$ProduksiID) {
                return redirect()->to(base_url('produksi'));
            }
            $deleteProduksi = $this->produksiModel->deleteProduksi($ProduksiID);
            if ($deleteProduksi) {
                session()->setFlashdata('notif_success', '<b>Successfully delete Produksi</b>');
                return redirect()->to(base_url('produksi'));
            } else {
                session()->setFlashdata('notif_error', '<b>Failed to delete Produksi</b>');
                return redirect()->to(base_url('produksi'));
            }
        }
      
        public function checkBarcode()
        {
            // Ambil barcode dari request POST
            $barcode = $this->request->getPost('barcode');
    
            // Inisialisasi model Produksi
            $produksiModel = new ProduksiModel();
    
            // Panggil metode cekBarcode untuk mencari barcode di database
            $produksi = $produksiModel->cekBarcode($barcode);
    
            // Cek apakah produksi ditemukan
            if ($produksi) {
                return $this->response->setJSON([
                    'found' => true,
                    'produksi' => $produksi
                ]);
            } else {
                return $this->response->setJSON(['found' => false]);
            }
        }


                
public function updateStatusProduksi()
    {
        $produksiId = $this->request->getPost('produksi_id');
        $status = $this->request->getPost('status');

        // Update status produksi
        $this->produksiModel->update($produksiId, ['status' => $status]);

        // Redirect ke halaman utama atau ke tempat yang sesuai
        return redirect()->to(base_url('/reportOperator'))->with('status', 'Produksi telah dimulai.');
    }
}
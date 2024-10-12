<?php
namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\BarangModel;

class Barang extends BaseController
{
              
    function __construct()
    {
        $this->barangModel = new BarangModel();
    }
                
                
    public function index()
    {
        $data = array_merge($this->data, [
            'title'     => $this,
            'Barang'    => $this->barangModel->getBarang()
        ]);
        return view('barang/baranglist', $data);
    }
                
                
    public function createBarang()
    {
        $createBarang = $this->barangModel->createBarang($this->request->getPost(null, FILTER_UNSAFE_RAW));
        if ($createBarang) {
            session()->setFlashdata('notif_success', '<b>Successfully added new Barang</b>');
            return redirect()->to(base_url('barang'));
        } else {
            session()->setFlashdata('notif_error', '<b>Failed to add new Barang</b>');
            return redirect()->to(base_url('barang'));
        }
    }
                    

                
        public function updateBarang()
        {
            $updateBarang = $this->barangModel->updateBarang($this->request->getPost(null, FILTER_UNSAFE_RAW));
            if ($updateBarang) {
                session()->setFlashdata('notif_success', '<b>Successfully update Barang</b>');
                return redirect()->to(base_url('barang'));
            } else {
                session()->setFlashdata('notif_error', '<b>Failed to update Barang</b>');
                return redirect()->to(base_url('barang'));
            }
        }
                
                

        public function deleteBarang($BarangID)
        {
            if (!$BarangID) {
                return redirect()->to(base_url('barang'));
            }
            $deleteBarang = $this->barangModel->deleteBarang($BarangID);
            if ($deleteBarang) {
                session()->setFlashdata('notif_success', '<b>Successfully delete Barang</b>');
                return redirect()->to(base_url('barang'));
            } else {
                session()->setFlashdata('notif_error', '<b>Failed to delete Barang</b>');
                return redirect()->to(base_url('barang'));
            }
        }

        public function getBarangData($id)
        {
            $barang = $this->barangModel->getBarang($id);
            return json_encode($barang);
        }
}
<?php
namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ReportModel;

class Report extends BaseController
{
              
    function __construct()
    {
        $this->reportModel = new ReportModel();
    }
                
                
    // public function index()
    // {
    //     $data = array_merge($this->data, [
    //         'title'     => $this,
    //         'Barang'    => $this->barangModel->getBarang()
    //     ]);
    //     return view('barang/baranglist', $data);
    // }
                
                
    public function createReport()
    {
        $createBarang = $this->reportModel->createReport($this->request->getPost(null, FILTER_UNSAFE_RAW));
        if ($createBarang) {
            session()->setFlashdata('notif_success', '<b>Successfully added new Report</b>');
            return redirect()->to(base_url('reportOperator'));
        } else {
            session()->setFlashdata('notif_error', '<b>Failed to add new Report</b>');
            return redirect()->to(base_url('reportOperator'));
        }
    }

    public function getReportByProduksiId($produksi_id)
    {
        // Gunakan model untuk mendapatkan data laporan berdasarkan produksi_id
        $reports = $this->reportModel->getReportsByProduksiId($produksi_id);

        if ($reports) {
            // Mengirimkan respons dalam format JSON jika laporan ditemukan
            return $this->response->setJSON([
                'status' => 'success',
                'reports' => $reports
            ]);
        } else {
            // Mengirimkan respons kosong jika laporan tidak ditemukan
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'No reports found'
            ]);
        }
    }  
                    
}
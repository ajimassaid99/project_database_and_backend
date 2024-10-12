<?php
namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ShiftModel;

class Shift extends BaseController
{
    function __construct()
    {
        $this->ShiftsModel = new ShiftModel();
    }

    public function index()
    {
        $data = array_merge($this->data, [
            'title' => $this,
            'Shifts' => $this->ShiftsModel->getShifts()
        ]);
        return view('shift/shiftlist.php', $data);
    }

    public function createShifts()
    {
        $createShifts = $this->ShiftsModel->createShifts($this->request->getPost(null, FILTER_UNSAFE_RAW));
        if ($createShifts) {
            session()->setFlashdata('notif_success', '<b>Successfully added new Shifts</b>');
            return redirect()->to(base_url('shift'));
        } else {
            session()->setFlashdata('notif_error', '<b>Failed to add new Shifts</b>');
            return redirect()->to(base_url('shift'));
        }
    }

    public function updateShifts()
    {
        $updateShifts = $this->ShiftsModel->updateShifts($this->request->getPost(null, FILTER_UNSAFE_RAW));
        if ($updateShifts) {
            session()->setFlashdata('notif_success', '<b>Successfully updated Shifts</b>');
            return redirect()->to(base_url('shift'));
        } else {
            session()->setFlashdata('notif_error', '<b>Failed to update Shifts</b>');
            return redirect()->to(base_url('shift'));
        }
    }

    public function deleteShifts($ShiftsID)
    {
        if (!$ShiftsID) {
            return redirect()->to(base_url('shift'));
        }
        $deleteShifts = $this->ShiftsModel->deleteShifts($ShiftsID);
        if ($deleteShifts) {
            session()->setFlashdata('notif_success', '<b>Successfully deleted Shifts</b>');
            return redirect()->to(base_url('shift'));
        } else {
            session()->setFlashdata('notif_error', '<b>Failed to delete Shifts</b>');
            return redirect()->to(base_url('shift'));
        }
    }

    public function getShiftData($id)
    {
        $shift = $this->ShiftsModel->getShifts($id);
        return json_encode($shift);
    }
}
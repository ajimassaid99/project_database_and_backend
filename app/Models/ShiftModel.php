<?php

namespace App\Models;

use CodeIgniter\Model;

class ShiftModel extends Model
{

    public function getShifts($ShiftsID = false)
    {
        if ($ShiftsID) {
            return $this->db->table('shifts')
            ->where(['shifts.id' => $ShiftsID])
            ->get()->getRowArray();
        } else {
            return $this->db->table('shifts')
            ->orderBy('start_time')
            ->get()->getResultArray();
        }
    }
        
    public function createShifts($dataShifts)
    {
        return $this->db->table('shifts')->insert([
          'shift_name'     	=> $dataShifts['inputShiftName'],
          'start_time'     	=> $dataShifts['inputStartTime'],
          'end_time'     	=> $dataShifts['inputEndTime'],
          'created_by'     	=> $dataShifts['inputCreatedBy'],
          'created_at'     	=> $dataShifts['inputCreatedAt'],
          'updated_at'     	=> $dataShifts['inputUpdatedAt'], 
        ]);
    }

    public function  updateShifts($dataShifts)
    {
        return $this->db->table('shifts')->update([
          'shift_name'     	=> $dataShifts['inputShiftName'],
          'start_time'     	=> $dataShifts['inputStartTime'],
          'end_time'     	=> $dataShifts['inputEndTime'],
          'created_by'     	=> $dataShifts['inputCreatedBy'],
          'created_at'     	=> $dataShifts['inputCreatedAt'],
          'updated_at'     	=> $dataShifts['inputUpdatedAt'], 
            ], ['id' => $dataShifts['inputShiftsID']]);
    }

    public function deleteShifts($ShiftsID)
	{
		return $this->db->table('shifts')->delete(['id' => $ShiftsID]);
	}
}
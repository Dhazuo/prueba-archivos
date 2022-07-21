<?php

namespace App\Imports;

use App\Models\Participant;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class ParticipantsImport implements ToModel, WithStartRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function startRow(): int
    {
        return 2;
    }

    public function model(array $row)
    {
        return new Participant([
            'id' => $row[0],
            'name' => $row[1],
            'restaurant_number' => $row[2],
            'leader_name' => $row[3],
            'members_number' => $row[4],
            'custom_id' => $row[5],
            'status' => $row[6],
            'location' => $row[7],
            'file_name' => $row[8],
            'accepted_tos' => $row[9] == 1 ? true : false,

        ]);
    }
}

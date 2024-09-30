<?php

namespace App\Models;

use CodeIgniter\Model;

class RecycledMaterialsModel extends Model {

    protected $table = 'recycled_materials'; // Make sure this matches the table name
    protected $primaryKey = 'Recycle_ID';
    protected $allowedFields = ['Material_Type', 'Material', 'generated_mass', 'mass_unit', 'recycled_at', 'batch_id'];

    public function getMonthlyRecycledSummary($year, $month) {
        $query = $this->db->query("SELECT batch_id, Material_Type, Material, SUM(generated_mass) as total_mass, mass_unit, recycled_at
                                FROM `recycled_materials`
                                WHERE YEAR(recycled_at) = ?
                                AND MONTH(recycled_at) = ?
                                GROUP BY batch_id, Material_Type", [$year, $month]);

        $result = $query->getResultArray();

        // Convert grams to kilograms if necessary
        foreach ($result as $key => $row) {
            if ($row['mass_unit'] === 'g') {
                $result[$key]['total_mass'] = $row['total_mass'] / 1000;
                $result[$key]['mass_unit'] = 'kg';
            }
        }

        return $result;
    }

}

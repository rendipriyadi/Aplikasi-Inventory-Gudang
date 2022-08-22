<?php

namespace App\Models;

use CodeIgniter\Model;

class Modelbarangmasuk extends Model
{
    protected $table            = 'barangmasuk';
    protected $primaryKey       = 'faktur';
    protected $allowedFields    = [
        'faktur', 'tglfaktur', 'totalharga'
    ];

    public function cekFaktur($faktur){
        return $this->table('barangmasuk')->getWhere([
            'sha1(faktur)' => $faktur
        ]);
    }

    public function laporanPerPeriode($tglawal, $tglakhir){
        return $this->table('barangmasuk')->where('tglfaktur >=', $tglawal)->where('tglfaktur <=', $tglakhir)->get();
    }
}


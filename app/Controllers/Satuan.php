<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Modelsatuan;

class Satuan extends BaseController
{
    public function __construct()
    {
        $this->satuan = new Modelsatuan();
    }

    public function index()
    {
        $data = [
            'datasatuan' => $this->satuan->findAll()
        ];
        return view('satuan/viewsatuan', $data);
    }

    public function formtambah()
    {
        return view('satuan/formtambah');
    }

    public function simpandata()
    {
        if ($this->request->isAJAX()){
            $namasatuan = $this->request->getVar('namasatuan');

            $validation = \Config\Services::validation();

            $valid = $this->validate([
                'namasatuan' => [
                    'rules' => 'required',
                    'label' => 'Nama Satuan',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong'
                    ]
                ]
            ]);

            if (!$valid) {
                $msg = [
                    'error' => [
                        'errorNamaSatuan' => $validation->getError('namasatuan'),
                    ]
                ];
            }else{
                $this->satuan->insert([
                    'satnama' => $namasatuan
                ]);

                $msg = [
                    'sukses' => 'Nama Satuan berhasil ditambahkan'
                ];
            }   
            echo json_encode($msg); 
        }
    }

    public function edit($id)
    {
        $row = $this->satuan->find($id);

        if($row){
            $data = [
                'id' => $row['satid'],
                'nama' => $row['satnama'],
            ];
            return view('satuan/formedit', $data);
        }else{
            exit('Data Tidak Ditemukan');
        }
    }

    public function updatedata()
    {
        if ($this->request->isAJAX()){
            $idsatuan = $this->request->getVar('idsatuan');
            $namasatuan = $this->request->getVar('namasatuan');

            $validation = \Config\Services::validation();

            $valid = $this->validate([
                'namasatuan' => [
                    'rules' => 'required',
                    'label' => 'Nama Satuan',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong'
                    ]
                ]
            ]);

            if (!$valid) {
                $msg = [
                    'error' => [
                        'errorNamaSatuan' => $validation->getError('namasatuan'),
                    ]
                ];
            }else{
                $this->satuan->update($idsatuan, [
                    'satnama' => $namasatuan
                ]);

                $msg = [
                    'sukses' => 'Nama Satuan berhasil diupdate'
                ];
            }   
            echo json_encode($msg); 
        }
    }

    public function hapus()
    {
        if ($this->request->isAJAX()) {
            $idsatuan = $this->request->getVar('idsatuan');

            $this->satuan->delete($idsatuan);

            $msg = [
                'sukses' => 'Data Satuan berhasil dihapus'
            ];
            echo json_encode($msg);
        }
    }

}

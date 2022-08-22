<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Modelbarang;
use App\Models\Modelbarangmasuk;
use App\Models\Modeltempbarangmasuk;
use App\Models\Modeldetailbarangmasuk;

class Barangmasuk extends BaseController
{
    public function index()
    {
        return view('barangmasuk/forminput');
    }

    public function dataTemp()
    {
        if ($this->request->isAjax()){
            $faktur = $this->request->getPost('faktur');

            $modelTemp = new Modeltempbarangmasuk();
            $data = [
                'datatemp' => $modelTemp->tampilDataTemp($faktur)
            ];

            $json = [
                'data' => view('barangmasuk/datatemp', $data)
            ];
            echo json_encode($json);
        }else{
            exit('Maaf tidak bisa diproses');
        }
    }

    public function ambilDataBarang()
    {
        if ($this->request->isAjax()){
            $kodebarang = $this->request->getPost('kodebarang');

            $modelBarang = new Modelbarang();
            $ambilData = $modelBarang->find($kodebarang);

            if ($ambilData == NULL){
                $json = [
                    'error' => 'Data barang tidak ditemukan'
                ];
            }else{
                $data = [
                    'namabarang' => $ambilData['brgnama'],
                    'hargajual' => $ambilData['brgharga'],
                ];
    
                $json = [
                    'sukses' => $data
                ];
            }

            echo json_encode($json);
        }else{
            exit('Maaf tidak bisa diproses');
        }
    }

    public function simpanTemp()
    {
        if ($this->request->isAjax()){
            $faktur = $this->request->getPost('faktur');
            $hargajual = $this->request->getPost('hargajual');
            $hargabeli = $this->request->getPost('hargabeli');
            $kodebarang = $this->request->getPost('kodebarang');
            $jumlah = $this->request->getPost('jumlah');

            $modelTempBarang = new Modeltempbarangmasuk();
            $modelTempBarang->insert([
                'detfaktur' => $faktur,
                'detbrgkode' => $kodebarang,
                'dethargamasuk' => $hargabeli,
                'dethargajual' => $hargajual,
                'detjml' => $jumlah,
                'detsubtotal' => intval($jumlah) * intval($hargabeli)
            ]);

            $json = [
                'sukses' => 'Item berhasil ditambahkan'
            ];
            echo json_encode($json);
        }else{
            exit('Maaf tidak bisa diproses');
        }
    }

    public function hapus()
    {
        if ($this->request->isAjax()){
            $id = $this->request->getPost('id');

            $modelTempBarang = new Modeltempbarangmasuk();
            $modelTempBarang->delete($id);

            $json = [
                'sukses' => 'Item berhasil dihapus'
            ];

            echo json_encode($json);
        }else{
            exit('Maaf tidak bisa diproses');
        }
    }

    public function cariDataBarang()
    {
        if ($this->request->isAjax()){
            $json = [
                'data' => view('barangmasuk/modalcaribarang')
            ];

            echo json_encode($json);
        }else{
            exit('Maaf tidak bisa diproses');
        }
    }

    public function detailCariBarang()
    {
        if ($this->request->isAjax()){
            $cari = $this->request->getPost('cari');

            $modelBarang = new Modelbarang();
            
            $data = $modelBarang->tampildata_cari($cari)->get();

            if ($data != null){
                $json = [
                        'data' => view('barangmasuk/detaildatabarang', [
                            'tampildata' => $data
                        ])
                ];

                echo json_encode($json);
            }
        }else{
            exit('Maaf tidak bisa diproses');
        }
    }

    public function selesaiTransaksi()
    {
        if ($this->request->isAjax()){
            $faktur = $this->request->getPost('faktur');
            $tglfaktur = $this->request->getPost('tglfaktur');

            $modelTemp = new Modeltempbarangmasuk();
            $dataTemp = $modelTemp->getWhere(['detfaktur' => $faktur]);

            if ($dataTemp->getNumRows() == 0){
                $json = [
                    'error' => 'Maaf, data item untuk faktur ini belum ada'
                ];
            }else{
                // simpan ke tabel barang masuk
                $modelBarangMasuk = new Modelbarangmasuk();
                $totalSubTotal = 0;

                foreach($dataTemp->getResultArray() as $total):
                    $totalSubTotal += intval($total['detsubtotal']);
                endforeach;

                $modelBarangMasuk->insert([
                    'faktur' => $faktur,
                    'tglfaktur' => $tglfaktur,
                    'totalharga' => $totalSubTotal
                ]);

                // simpan ke tabel detail barang masuk
                $modelDetailBarangMasuk = new Modeldetailbarangmasuk();
                foreach($dataTemp->getResultArray() as $row):
                    $modelDetailBarangMasuk->insert([
                        'detfaktur' => $row['detfaktur'],
                        'detbrgkode' => $row['detbrgkode'],
                        'dethargamasuk' => $row['dethargamasuk'],
                        'dethargajual' => $row['dethargajual'],
                        'detjml' => $row['detjml'],
                        'detsubtotal' => $row['detsubtotal']
                    ]);
                endforeach;

                // hapus data di tabel temporari
                $modelTemp->emptyTable();

                $json = [
                    'sukses' => 'Transaksi berhasil disimpan'
                ];
            }

            echo json_encode($json);
        }else{
            exit('Maaf tidak bisa diproses');
        }
    }

    public function data()
    {
        $dataBarang = new Modelbarangmasuk();
        $data = [
            'databarang' => $dataBarang->findAll()
        ];
        return view('barangmasuk/viewdata', $data);
    }

    public function detailItem()
    {
        if ($this->request->isAjax()){
            $faktur = $this->request->getPost('faktur');
            $modelDetail = new Modeldetailbarangmasuk();

            $data = [
                'tampildatadetail' => $modelDetail->dataDetail($faktur)
            ];

            $json = [
                'data' => view('barangmasuk/modaldetailitem', $data)
            ];
            echo json_encode($json);

        }else{
            exit('Maaf tidak bisa diproses');
        }
    }

    public function edit($faktur)
    {
        $modelBarangMasuk = new Modelbarangmasuk();
        $cekFaktur = $modelBarangMasuk->cekFaktur($faktur);

        if ($cekFaktur->getNumRows() > 0){
            $row = $cekFaktur->getRowArray();

            $data = [
                'nofaktur' => $row['faktur'],
                'tanggal' => $row['tglfaktur']
            ];

            return view('barangmasuk/formedit', $data);
        }else{
            exit('Data tidak ditemukan');
        }
    }

    public function dataDetail()
    {
        if ($this->request->isAjax()){
            $faktur = $this->request->getPost('faktur');

            $modelDetail = new Modeldetailbarangmasuk();
            $data = [
                'datadetail' => $modelDetail->dataDetail($faktur),
            ];

            $totalHargaFaktur = number_format($modelDetail->ambilTotalHarga($faktur),0,",",".");
            $json = [
                'data' => view('barangmasuk/datadetail', $data),
                'totalharga' => $totalHargaFaktur
            ];
            echo json_encode($json);
        }else{
            exit('Maaf tidak bisa diproses');
        }
    }

    public function editItem()
    {
        if ($this->request->isAJAX()){
            $iddetail = $this->request->getPost('iddetail');
            
            $modelDetail = new Modeldetailbarangmasuk();
            $ambilData = $modelDetail->ambilDetailBerdasarkanID($iddetail);

            $row = $ambilData->getRowArray();

            $data = [
                'kodebarang' => $row['detbrgkode'],
                'namabarang' => $row['brgnama'],
                'hargajual' => $row['dethargajual'],
                'hargabeli' => $row['dethargamasuk'],
                'jumlah' => $row['detjml']
            ];

            $json = [
                'sukses' => $data
            ];
            echo json_encode($json);
        }
    }

    public function simpanDetail()
    {
        if ($this->request->isAjax()){
            $faktur = $this->request->getPost('faktur');
            $hargajual = $this->request->getPost('hargajual');
            $hargabeli = $this->request->getPost('hargabeli');
            $kodebarang = $this->request->getPost('kodebarang');
            $jumlah = $this->request->getPost('jumlah');

            $modelDetail = new Modeldetailbarangmasuk();
            $modelBarangMasuk = new Modelbarangmasuk();

            $modelDetail->insert([
                'detfaktur' => $faktur,
                'detbrgkode' => $kodebarang,
                'dethargamasuk' => $hargabeli,
                'dethargajual' => $hargajual,
                'detjml' => $jumlah,
                'detsubtotal' => intval($jumlah) * intval($hargabeli)
            ]);

            $ambilTotalHarga = $modelDetail->ambilTotalHarga($faktur);

            $modelBarangMasuk->update($faktur, [
                'totalharga' => $ambilTotalHarga
            ]);

            $json = [
                'sukses' => 'Item berhasil ditambahkan'
            ];
            echo json_encode($json);
        }else{
            exit('Maaf tidak bisa diproses');
        }
    }

    public function updateItem()
    {
        if ($this->request->isAjax()){
            $iddetail = $this->request->getPost('iddetail');
            $faktur = $this->request->getPost('faktur');
            $hargajual = $this->request->getPost('hargajual');
            $hargabeli = $this->request->getPost('hargabeli');
            $kodebarang = $this->request->getPost('kodebarang');
            $jumlah = $this->request->getPost('jumlah');

            $modelDetail = new Modeldetailbarangmasuk();
            $modelBarangMasuk = new Modelbarangmasuk();

            $modelDetail->update($iddetail,[
                'dethargamasuk' => $hargabeli,
                'dethargajual' => $hargajual,
                'detjml' => $jumlah,
                'detsubtotal' => intval($jumlah) * intval($hargabeli)
            ]);

            $ambilTotalHarga = $modelDetail->ambilTotalHarga($faktur);

            $modelBarangMasuk->update($faktur, [
                'totalharga' => $ambilTotalHarga
            ]);

            $json = [
                'sukses' => 'Item berhasil diupdate'
            ];
            echo json_encode($json);
        }else{
            exit('Maaf tidak bisa diproses');
        }
    }

    public function hapusItemDetail()
    {
        if ($this->request->isAjax()){
            $id = $this->request->getPost('id');
            $faktur = $this->request->getPost('faktur');

            $modelDetail = new Modeldetailbarangmasuk();
            $modelBarangMasuk = new Modelbarangmasuk();

            $modelDetail->delete($id);

            $ambilTotalHarga = $modelDetail->ambilTotalHarga($faktur);

            $modelBarangMasuk->update($faktur, [
                'totalharga' => $ambilTotalHarga
            ]);

            $json = [
                'sukses' => 'Item berhasil dihapus'
            ];

            echo json_encode($json);
        }else{
            exit('Maaf tidak bisa diproses');
        }
    }

    public function hapusTransaksi()
    {
        $faktur = $this->request->getPost('faktur');

        $db = \Config\Database::connect();
        $modelBarangMasuk = new Modelbarangmasuk();

        $db->table('detail_barangmasuk')->delete(['detfaktur' => $faktur]);
        $modelBarangMasuk->delete($faktur);

        $json = [
            'sukses' => 'Data transaksi berhasil dihapus'
        ];

        echo json_encode($json);
    }
}

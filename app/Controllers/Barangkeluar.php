<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Modelbarang;
use App\Models\ModelBarangKeluar;
use App\Models\ModelDataBarang;
use App\Models\ModelDataBarangKeluar;
use App\Models\ModelDetailBarangKeluar;
use App\Models\ModelPelanggan;
use App\Models\ModelTempBarangKeluar;
use Config\Services;

class Barangkeluar extends BaseController
{
    private function buatFaktur()
    {
        $tanggalSekarang = date('Y-m-d');
        $modelBarangKeluar = new ModelBarangKeluar();

        $hasil = $modelBarangKeluar->noFakturOtomatis($tanggalSekarang)->getRowArray();
        $data = $hasil['nofaktur'];

        $lastNoUrut = substr($data, -4);
        // nomor urut ditambah 1
        $nextNoUrut = intval($lastNoUrut) + 1;
        // membuat format nomor transaksi berikutnya
        $noFaktur = date('dmy', strtotime($tanggalSekarang)) . sprintf('%04s', $nextNoUrut);
        return $noFaktur;
    }
    public function buatNoFaktur()
    {
        $tanggalSekarang = $this->request->getPost('tanggal');
        $modelBarangKeluar = new ModelBarangKeluar();

        $hasil = $modelBarangKeluar->noFakturOtomatis($tanggalSekarang)->getRowArray();
        $data = $hasil['nofaktur'];

        $lastNoUrut = substr($data, -4);
        // nomor urut ditambah 1
        $nextNoUrut = intval($lastNoUrut) + 1;
        // membuat format nomor transaksi berikutnya
        $noFaktur = date('dmy', strtotime($tanggalSekarang)) . sprintf('%04s', $nextNoUrut);

        $json = [
            'nofaktur' => $noFaktur
        ];

        echo json_encode($json);
    }

    public function data()
    {
        return view('barangkeluar/viewdata');
    }

    public function listData()
    {
        $tglawal = $this->request->getPost('tglawal');
        $tglakhir = $this->request->getPost('tglakhir');

        $request = Services::request();
        $datamodel = new ModelDataBarangKeluar($request);
        if ($request->getMethod(true) == 'POST') {
            $lists = $datamodel->get_datatables($tglawal, $tglakhir);
            $data = [];
            $no = $request->getPost("start");
            foreach ($lists as $list) {
                $no++;
                $row = [];

                $tombolCetak = "<button type=\"button\" class=\"btn btn-sm btn-info\" onclick=\"cetak('" . $list->faktur . "')\"><i class=\"fa fa-print\"></i></button>";

                if ($list->transaction_status == 'settlement') {
                    $tombolHapus = '';
                } else {
                    $tombolHapus = "<button type=\"button\" class=\"btn btn-sm btn-danger\" onclick=\"hapus('" . $list->faktur . "')\"><i class=\"fa fa-trash-alt\"></i></button>";
                }

                if ($list->payment_method == 'M') {
                    $tombolEdit = "<button type=\"button\" class=\"btn btn-sm bg-purple\" onclick=\"cektransaksi('" . $list->faktur . "')\"><i class=\"fa fa-eye\"></i></button>";
                } else {
                    $tombolEdit = "<button type=\"button\" class=\"btn btn-sm btn-primary\" onclick=\"edit('" . $list->faktur . "')\"><i class=\"fa fa-pencil-alt\"></i></button>";
                }


                $row[] = $no;
                $row[] = $list->faktur;
                $row[] = $list->tglfaktur;
                $row[] = $list->pelnama;

                $row[] = ($list->payment_method == 'M') ? "<span class=\"badge badge-info\">Midtrans</span>" : "<span class=\"badge bg-purple\">Cash</span>";

                // Menampilkan status Transaksi 
                if ($list->payment_method == 'M') {
                    if ($list->transaction_status == 'pending') {
                        $row[] = "<span class=\"badge bg-gray\">Pending</span>";
                    } else if ($list->transaction_status == 'settlement') {
                        $row[] = "<span class=\"badge bg-success\">Success</span>";
                    } else {
                        $row[] = "<span class=\"badge bg-danger\">Expired</span>";
                    }
                } else {
                    $row[] = "<span class=\"badge badge-warning\"><i class=\"fa fa-check\"></i></span>";
                }

                $row[] = number_format($list->totalharga, 0, ",", ".");
                $row[] = $tombolCetak . " " . $tombolHapus . " " . $tombolEdit;
                $row[] = '';
                $data[] = $row;
            }
            $output = [
                "draw" => $request->getPost('draw'),
                "recordsTotal" => $datamodel->count_all($tglawal, $tglakhir),
                "recordsFiltered" => $datamodel->count_filtered($tglawal, $tglakhir),
                "data" => $data
            ];
            echo json_encode($output);
        }
    }

    public function input()
    {
        $data = [
            'nofaktur' => $this->buatFaktur()
        ];
        return view('barangkeluar/forminput', $data);
    }

    public function tampilDataTemp()
    {
        if ($this->request->isAJAX()) {
            $nofaktur = $this->request->getPost('nofaktur');

            $modalTempBarangKeluar = new ModelTempBarangKeluar();
            $dataTemp = $modalTempBarangKeluar->tampilDataTemp($nofaktur);
            $data = [
                'tampildata' => $dataTemp
            ];

            $json = [
                'data' => view('barangkeluar/datatemp', $data)
            ];

            echo json_encode($json);
        }
    }

    public function ambilDataBarang()
    {
        if ($this->request->isAJAX()) {
            $kodebarang = $this->request->getPost('kodebarang');

            $modelBarang = new Modelbarang();

            $cekData = $modelBarang->find($kodebarang);
            if ($cekData == null) {
                $json = [
                    'error' => 'Maaf data barang tidak ditemukan'
                ];
            } else {
                $data = [
                    'namabarang' => $cekData['brgnama'],
                    'hargajual' => $cekData['brgharga']
                ];

                $json = [
                    'sukses' => $data
                ];
            }

            echo json_encode($json);
        }
    }

    public function simpanItem()
    {
        if ($this->request->isAJAX()) {
            $nofaktur = $this->request->getPost('nofaktur');
            $kodebarang = $this->request->getPost('kodebarang');
            $namabarang = $this->request->getPost('namabarang');
            $jml = $this->request->getPost('jml');
            $hargajual = $this->request->getPost('hargajual');

            $modelTempBarangKeluar = new ModelTempBarangKeluar();
            $modelBarang = new Modelbarang();

            $ambilDataBarang = $modelBarang->find($kodebarang);
            $stokBarang = $ambilDataBarang['brgstok'];

            if ($jml > intval($stokBarang)) {
                $json = [
                    'error' => 'Stok tidak mencukupi'
                ];
            } else {
                $modelTempBarangKeluar->insert([
                    'detfaktur' => $nofaktur,
                    'detbrgkode' => $kodebarang,
                    'dethargajual' => $hargajual,
                    'detjml' => $jml,
                    'detsubtotal' => intval($jml) * intval($hargajual)
                ]);

                $json = [
                    'sukses' => 'Item Berhasil ditambahkan'
                ];
            }


            echo json_encode($json);
        }
    }

    public function hapusItem()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getPost('id');

            $modelTempBarangKeluar = new ModelTempBarangKeluar();
            $modelTempBarangKeluar->delete($id);

            $json = [
                'sukses' => 'Item Berhasil dihapus'
            ];

            echo json_encode($json);
        }
    }

    public function modalCariBarang()
    {
        if ($this->request->isAJAX()) {
            $json = [
                'data' => view('barangkeluar/modalcaribarang')
            ];

            echo json_encode($json);
        }
    }

    public function listDataBarang()
    {
        $request = Services::request();
        $datamodel = new ModelDataBarang($request);
        if ($request->getMethod(true) == 'POST') {
            $lists = $datamodel->get_datatables();
            $data = [];
            $no = $request->getPost("start");
            foreach ($lists as $list) {
                $no++;
                $row = [];

                $tombolPilih = "<button type=\"button\" class=\"btn btn-sm btn-info\" onclick=\"pilih('" . $list->brgkode . "')\">Pilih</button>";

                $row[] = $no;
                $row[] = $list->brgkode;
                $row[] = $list->brgnama;
                $row[] = number_format($list->brgharga, 0, ",", ".");
                $row[] = number_format($list->brgstok, 0, ",", ".");
                $row[] = $tombolPilih;
                $data[] = $row;
            }
            $output = [
                "draw" => $request->getPost('draw'),
                "recordsTotal" => $datamodel->count_all(),
                "recordsFiltered" => $datamodel->count_filtered(),
                "data" => $data
            ];
            echo json_encode($output);
        }
    }

    public function modalPembayaran()
    {
        $nofaktur =  $this->request->getPost('nofaktur');
        $tglfaktur =  $this->request->getPost('tglfaktur');
        $idpelanggan =  $this->request->getPost('idpelanggan');
        $totalharga =  $this->request->getPost('totalharga');

        $modelTemp =  new ModelTempBarangKeluar();
        $cekData = $modelTemp->tampilDataTemp($nofaktur);

        if ($cekData->getNumRows() > 0) {
            $data = [
                'nofaktur' => $nofaktur,
                'totalharga' => $totalharga,
                'tglfaktur' => $tglfaktur,
                'idpelanggan' => $idpelanggan
            ];

            $json = [
                'data' => view('barangkeluar/modalpembayaran', $data)
            ];
        } else {
            $json = [
                'error' => 'Maaf item belum ada'
            ];
        }

        echo json_encode($json);
    }

    public function simpanPembayaran()
    {
        if ($this->request->isAJAX()) {
            $nofaktur = $this->request->getPost('nofaktur');
            $tglfaktur = $this->request->getPost('tglfaktur');
            $idpelanggan = $this->request->getPost('idpelanggan');
            $totalbayar = str_replace(".", "", $this->request->getPost('totalbayar'));
            $jumlahuang = str_replace(".", "", $this->request->getPost('jumlahuang'));
            $sisauang = str_replace(".", "", $this->request->getPost('sisauang'));

            $modelBarangKeluar =  new ModelBarangKeluar();

            $modelBarangKeluar->insert([
                'faktur' => $nofaktur,
                'tglfaktur' => $tglfaktur,
                'idpel' => $idpelanggan,
                'totalharga' => $totalbayar,
                'jumlahuang' => $jumlahuang,
                'sisauang' => $sisauang,
                'payment_method' => 'C',
            ]);

            $modelTemp = new ModelTempBarangKeluar();
            $dataTemp = $modelTemp->getWhere(['detfaktur' => $nofaktur]);

            $fieldDetail = [];
            foreach ($dataTemp->getResultArray() as $row) {
                $fieldDetail[] = [
                    'detfaktur' => $row['detfaktur'],
                    'detbrgkode' => $row['detbrgkode'],
                    'dethargajual' => $row['dethargajual'],
                    'detjml' => $row['detjml'],
                    'detsubtotal' => $row['detsubtotal'],
                ];
            }

            $modelDetail = new ModelDetailBarangKeluar();
            $modelDetail->insertBatch($fieldDetail);

            $modelTemp->hapusData($nofaktur);

            $json = [
                'sukses' => 'Transaksi berhasil disimpan',
                'cetakfaktur' => site_url('barangkeluar/cetakfaktur/' . $nofaktur)
            ];

            echo json_encode($json);
        }
    }

    public function payMidtrans()
    {
        if ($this->request->isAJAX()) {
            $nofaktur =  $this->request->getPost('nofaktur');
            $tglfaktur =  $this->request->getPost('tglfaktur');
            $idpelanggan =  $this->request->getPost('idpelanggan');
            $totalharga =  $this->request->getPost('totalharga');

            $modelTemp =  new ModelTempBarangKeluar();
            $cekData = $modelTemp->tampilDataTemp($nofaktur);

            if ($cekData->getNumRows() > 0) {
                $modelPelanggan = new ModelPelanggan();
                $rowPel = $modelPelanggan->find($idpelanggan);
                $namaPelanggan = $rowPel['pelnama'];
                $telpPelanggan = $rowPel['peltelp'];

                // Set your Merchant Server Key
                \Midtrans\Config::$serverKey = 'SB-Mid-server-K5H0XsWr8DnRAjxqvlbqrtE-';
                // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
                \Midtrans\Config::$isProduction = false;
                // Set sanitization on (default)
                \Midtrans\Config::$isSanitized = true;
                // Set 3DS transaction for credit card to true
                \Midtrans\Config::$is3ds = true;

                $dataTempBarangKeluar = [];
                foreach ($cekData->getResultArray() as $x) :
                    $dataTempBarangKeluar[] = [
                        'id'       => $x['detbrgkode'],
                        'price'    => $x['dethargajual'],
                        'quantity' => $x['detjml'],
                        'name'     => $x['brgnama']
                    ];
                endforeach;

                // $items = array(
                //     array(
                //         'id'       => 'item1',
                //         'price'    => 100000,
                //         'quantity' => 1,
                //         'name'     => 'Adidas f50'
                //     ),
                //     array(
                //         'id'       => 'item2',
                //         'price'    => 50000,
                //         'quantity' => 2,
                //         'name'     => 'Nike N90'
                //     )
                // );

                $customer_details = array(
                    'first_name' => $namaPelanggan,
                    'phone'      => $telpPelanggan,
                    'email'      => 'rendipriyadi0410@gmail.com'
                );

                $params = [
                    'transaction_details' => array(
                        'order_id' => rand(),
                        'gross_amount' => 500000,
                    ),
                    'item_details' => $dataTempBarangKeluar,
                    'customer_details' => $customer_details,
                ];

                $json = [
                    'nofaktur' => $nofaktur,
                    'tglfaktur' => $tglfaktur,
                    'idpelanggan' => $idpelanggan,
                    'totalharga' => $totalharga,
                    'snapToken' => \Midtrans\Snap::getSnapToken($params)
                ];
            } else {
                $json = [
                    'error' => 'Maaf item belum ada'
                ];
            }

            echo json_encode($json);
        }
    }

    public function finishMidtrans()
    {
        if ($this->request->isAJAX()) {
            $nofaktur = $this->request->getPost('nofaktur');
            $idpelanggan = $this->request->getPost('idpelanggan');
            $tglfaktur = $this->request->getPost('tglfaktur');
            $totalharga = $this->request->getPost('totalharga');
            $order_id = $this->request->getPost('order_id');
            $payment_type = $this->request->getPost('payment_type');
            $transaction_status = $this->request->getPost('transaction_status');

            $modelBarangKeluar = new ModelBarangKeluar();
            $modelBarangKeluar->insert([
                'faktur' => $nofaktur,
                'tglfaktur' => $tglfaktur,
                'idpel' => $idpelanggan,
                'totalharga' => $totalharga,
                'payment_method' => 'M',
                'order_id' => $order_id,
                'payment_type' => $payment_type,
                'transaction_status' => $transaction_status,
            ]);

            $modelTemp = new ModelTempBarangKeluar();
            $dataTemp = $modelTemp->getWhere(['detfaktur' => $nofaktur]);

            $fieldDetail = [];
            foreach ($dataTemp->getResultArray() as $row) {
                $fieldDetail[] = [
                    'detfaktur' => $row['detfaktur'],
                    'detbrgkode' => $row['detbrgkode'],
                    'dethargajual' => $row['dethargajual'],
                    'detjml' => $row['detjml'],
                    'detsubtotal' => $row['detsubtotal'],
                ];
            }

            $modelDetail = new ModelDetailBarangKeluar();
            $modelDetail->insertBatch($fieldDetail);

            $modelTemp->hapusData($nofaktur);

            $json = [
                'sukses' => 'Transaksi Berhasil, Silahkan Lakukan Pembayaran'
            ];

            echo json_encode($json);
        }
    }

    public function cektransaksi($faktur)
    {
        $modelBarangKeluar = new ModelBarangKeluar();
        $cekData = $modelBarangKeluar->find($faktur);

        if ($cekData) {
            // Set your Merchant Server Key
            \Midtrans\Config::$serverKey = 'SB-Mid-server-K5H0XsWr8DnRAjxqvlbqrtE-';
            // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
            \Midtrans\Config::$isProduction = false;
            // Set sanitization on (default)
            \Midtrans\Config::$isSanitized = true;
            // Set 3DS transaction for credit card to true
            \Midtrans\Config::$is3ds = true;

            $idpel = $cekData['idpel'];
            $modelPelanggan = new ModelPelanggan();
            $dataPel = $modelPelanggan->find($idpel);

            $namaPelanggan = $dataPel['pelnama'];
            $telp = $dataPel['peltelp'];

            // update status transaksi
            $status = \Midtrans\Transaction::status($cekData['order_id']);
            $modelBarangKeluar->update($faktur, [
                'transaction_status' => $status->transaction_status
            ]);

            $data = [
                'nofaktur' => $faktur,
                'tglfaktur' => $cekData['tglfaktur'],
                'namapelanggan' => $namaPelanggan,
                'telp' => $telp,
                'orderid' => $cekData['order_id'],
                'status_transaksi' => $status->transaction_status
            ];

            return view('barangkeluar/cektransaksimidtrans', $data);
        } else {
            exit('Data tidak ditemukan');
        }
    }

    public function cetakfaktur($faktur)
    {
        $modelBarangKeluar = new ModelBarangKeluar();
        $modelDetail = new ModelDetailBarangKeluar();
        $modelPelanggan = new ModelPelanggan();

        $cekData = $modelBarangKeluar->find($faktur);
        $dataPelanggan = $modelPelanggan->find($cekData['idpel']);

        $namaPelanggan = ($dataPelanggan != null) ? $dataPelanggan['pelnama'] : '-';

        if ($cekData != null) {
            $data = [
                'faktur' => $faktur,
                'tanggal' => $cekData['tglfaktur'],
                'namapelanggan' => $namaPelanggan,
                'detailbarang' => $modelDetail->tampilDataTemp($faktur),
                'jumlahuang' => $cekData['jumlahuang'],
                'sisauang' => $cekData['sisauang']
            ];

            return view('barangkeluar/cetakfaktur', $data);
        } else {
            return redirect()->to(site_url('barangkeluar/input'));
        }
    }

    public function hapusTransaksi()
    {
        if ($this->request->isAJAX()) {
            // Set your Merchant Server Key
            \Midtrans\Config::$serverKey = 'SB-Mid-server-K5H0XsWr8DnRAjxqvlbqrtE-';
            // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
            \Midtrans\Config::$isProduction = false;
            // Set sanitization on (default)
            \Midtrans\Config::$isSanitized = true;
            // Set 3DS transaction for credit card to true
            \Midtrans\Config::$is3ds = true;

            $faktur = $this->request->getPost('faktur');

            $modelBarangKeluar = new ModelBarangKeluar();
            $dataBarangKeluar = $modelBarangKeluar->find($faktur);
            // hapus detail
            $db = \Config\Database::connect();

            // \Midtrans\Transaction::cancel($dataBarangKeluar['order_id']);

            $db->table('detail_barangkeluar')->delete(['detfaktur' => $faktur]);
            $modelBarangKeluar->delete($faktur);

            $json = [
                'sukses' => 'Transaksi berhasil dihapus'
            ];

            echo json_encode($json);
        }
    }

    public function edit($faktur)
    {
        $modelBarangKeluar = new ModelBarangKeluar();
        $modelPelanggan = new ModelPelanggan();
        $rowData = $modelBarangKeluar->find($faktur);
        $rowPelnggan = $modelPelanggan->find($rowData['idpel']);

        $data = [
            'nofaktur' => $faktur,
            'tanggal' => $rowData['tglfaktur'],
            'namapelanggan' => $rowPelnggan['pelnama']
        ];

        return view('barangkeluar/formedit', $data);
    }

    public function ambilTotalHarga()
    {
        if ($this->request->isAJAX()) {
            $nofakur = $this->request->getPost('nofaktur');

            $modelDetail = new ModelDetailBarangKeluar();
            $totalHarga = $modelDetail->ambilTotalHarga($nofakur);

            $json = [
                'totalharga' => "Rp." . " " . number_format($totalHarga, 0, ",", ".")
            ];

            echo json_encode($json);
        }
    }

    public function tampilDataDetail()
    {

        if ($this->request->isAJAX()) {
            $nofaktur = $this->request->getPost('nofaktur');

            $modelDetail = new ModelDetailBarangKeluar();
            $dataTemp = $modelDetail->tampilDataTemp($nofaktur);
            $data = [
                'tampildata' => $dataTemp
            ];

            $json = [
                'data' => view('barangkeluar/datadetail', $data)
            ];

            echo json_encode($json);
        }
    }

    public function hapusItemDetail()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getPost('id');

            $modelDetail = new ModelDetailBarangKeluar();
            $modelBarangKeluar = new ModelBarangKeluar();

            $rowData = $modelDetail->find($id);
            $noFaktur = $rowData['detfaktur'];

            $modelDetail->delete($id);

            $totalHarga =  $modelDetail->ambilTotalHarga($noFaktur);

            // Lakukan update total harga ditabel barang keluar

            $modelBarangKeluar->update($noFaktur, [
                'totalharga' => $totalHarga
            ]);

            $json = [
                'sukses' => 'Item Berhasil dihapus'
            ];

            echo json_encode($json);
        }
    }

    public function editItem()
    {
        if ($this->request->isAJAX()) {
            $iddetail = $this->request->getPost('iddetail');
            $jml = $this->request->getPost('jml');

            $modelDetail = new ModelDetailBarangKeluar();
            $modelBarangKeluar = new ModelBarangKeluar();

            $rowData = $modelDetail->find($iddetail);
            $noFaktur = $rowData['detfaktur'];
            $hargajual = $rowData['dethargajual'];

            // update pada data tabel detail

            $modelDetail->update($iddetail, [
                'detjml' => $jml,
                'detsubtotal' => intval($hargajual) * $jml
            ]);

            // ambil total hargga
            $totalHarga = $modelDetail->ambilTotalHarga($noFaktur);
            // update barang keluar
            $modelBarangKeluar->update($noFaktur, [
                'totalharga' => $totalHarga
            ]);

            $json = [
                'sukses' => 'Item Berhasil di update'
            ];

            echo json_encode($json);
        }
    }

    public function simpanItemDetail()
    {
        if ($this->request->isAJAX()) {
            $nofaktur = $this->request->getPost('nofaktur');
            $kodebarang = $this->request->getPost('kodebarang');
            $namabarang = $this->request->getPost('namabarang');
            $jml = $this->request->getPost('jml');
            $hargajual = $this->request->getPost('hargajual');

            $modelTempBarangKeluar = new ModelDetailBarangKeluar();
            $modelBarang = new Modelbarang();

            $ambilDataBarang = $modelBarang->find($kodebarang);
            $stokBarang = $ambilDataBarang['brgstok'];

            if ($jml > intval($stokBarang)) {
                $json = [
                    'error' => 'Stok tidak mencukupi'
                ];
            } else {
                $modelTempBarangKeluar->insert([
                    'detfaktur' => $nofaktur,
                    'detbrgkode' => $kodebarang,
                    'dethargajual' => $hargajual,
                    'detjml' => $jml,
                    'detsubtotal' => $jml * $hargajual
                ]);


                $modelBarangKeluar = new ModelBarangKeluar();

                // ambil total hargga
                $totalHarga = $modelTempBarangKeluar->ambilTotalHarga($nofaktur);
                // update barang keluar
                $modelBarangKeluar->update($nofaktur, [
                    'totalharga' => $totalHarga
                ]);

                $json = [
                    'sukses' => 'Item Berhasil ditambahkan'
                ];
            }


            echo json_encode($json);
        }
    }
}

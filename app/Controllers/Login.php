<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelLogin;

class Login extends BaseController
{
    public function index()
    {
        if (session()->login) {
            return redirect()->to('main');
        }
        return view('login/index');
    }

    public function cekuser()
    {
        if ($this->request->isAjax()) {
            $username = $this->request->getPost('username');
            $password = $this->request->getPost('password');

            $validation = \Config\Services::validation();

            $valid = $this->validate([
                'username' => [
                    'label' => 'Username',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'password' => [
                    'label' => 'Password',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
            ]);

            if (!$valid) {
                $msg = [
                    'error' => [
                        'username' => $validation->getError('username'),
                        'password' => $validation->getError('password'),
                    ]
                ];
            } else {

                $modeldatalogin = new Modellogin();

                $cekUserLogin = $modeldatalogin->where('userid', $username)->first();

                if ($cekUserLogin == null) {
                    $msg = [
                        'error' => [
                            'username' => 'Username tidak terdaftar'
                        ]
                    ];
                } else {
                    if ($cekUserLogin['useraktif'] != '1') {
                        $msg = [
                            'error' => [
                                'username' => 'Maaf user tidak aktif, silahkan hubungi admin untuk atktivasi kembali'
                            ]
                        ];
                    } else {
                        $passwordUser = $cekUserLogin['userpassword'];
                        if (password_verify($password, $passwordUser)) {
                            // simpan session
                            $simpan_session = [
                                'login' => true,
                                'userid' => $username,
                                'usernama' => $cekUserLogin['usernama'],
                                'userlevelid' => $cekUserLogin['userlevelid'],
                            ];

                            session()->set($simpan_session);

                            $msg = [
                                'sukses' => [
                                    'link' => site_url('main/index')
                                ]
                            ];
                        } else {
                            $msg = [
                                'error' => [
                                    'password' => 'Password anda salah'
                                ]
                            ];
                        }
                    }
                }
            }
            echo json_encode($msg);
        }
    }

    public function keluar()
    {
        $this->session->destroy();
        return redirect()->to('login/index');
    }
}

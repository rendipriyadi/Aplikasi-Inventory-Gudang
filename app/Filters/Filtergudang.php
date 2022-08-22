<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class Filtergudang implements FilterInterface
{

    public function before(RequestInterface $request, $arguments = null)
    {
        if (session()->userlevelid == null) {
            return redirect()->to('login/index');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        if (session()->userlevelid == 3) {
            return redirect()->to('main/index');
        }
    }
}

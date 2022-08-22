<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class Filteradmin implements FilterInterface
{

    public function before(RequestInterface $request, $arguments = null)
    {
        if (session()->userlevelid == null) {
            return redirect()->to('login/index');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        if (session()->userlevelid == 1) {
            return redirect()->to('main/index');
        }
    }
}

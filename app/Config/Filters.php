<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;
use CodeIgniter\Filters\CSRF;
use CodeIgniter\Filters\DebugToolbar;
use CodeIgniter\Filters\Honeypot;
use CodeIgniter\Filters\InvalidChars;
use CodeIgniter\Filters\SecureHeaders;

class Filters extends BaseConfig
{
    /**
     * Configures aliases for Filter classes to
     * make reading things nicer and simpler.
     *
     * @var array
     */
    public $aliases = [
        'csrf'          => CSRF::class,
        'toolbar'       => DebugToolbar::class,
        'honeypot'      => Honeypot::class,
        'invalidchars'  => InvalidChars::class,
        'secureheaders' => SecureHeaders::class,
        'filteradmin'   => \App\Filters\Filteradmin::class,
        'filterkasir'   => \App\Filters\Filterkasir::class,
        'filtergudang'  => \App\Filters\Filtergudang::class,
    ];

    /**
     * List of filter aliases that are always
     * applied before and after every request.
     *
     * @var array
     */
    public $globals = [
        'before' => [
            // 'honeypot',
            // 'csrf',
            // 'invalidchars',
            'filteradmin' => [
                'except' => ['login/*', 'login', '/']
            ],
            'filterkasir' => [
                'except' => ['login/*', 'login', '/']
            ],
            'filtergudang' => [
                'except' => ['login/*', 'login', '/']
            ],
        ],
        'after' => [
            'filteradmin' => [
                'except' => [
                    'login', 'login/*',
                    'main', 'main/*',
                    'barang', 'barang/*',
                    'barangkeluar', 'barangkeluar/*',
                    'barangmasuk', 'barangmasuk/*',
                    'kategori', 'kategori/*',
                    'laporan', 'laporan/*',
                    'payment', 'payment/*',
                    'pelanggan', 'pelanggan/*',
                    'satuan', 'satuan/*',
                    'utility', 'utility/*',
                    'users', 'users/*',
                ]
            ],
            'filterkasir' => [
                'except' => [
                    'login', 'login/*',
                    'main', 'main/*',
                    'barangkeluar', 'barangkeluar/*',
                ]
            ],
            'filtergudang' => [
                'except' => [
                    'login', 'login/*',
                    'main', 'main/*',
                    'barangmasuk', 'barangmasuk/*',
                ]
            ],
            'toolbar',
            // 'honeypot',
            // 'secureheaders',
        ],
    ];

    /**
     * List of filter aliases that works on a
     * particular HTTP method (GET, POST, etc.).
     *
     * Example:
     * 'post' => ['csrf', 'throttle']
     *
     * @var array
     */
    public $methods = [];

    /**
     * List of filter aliases that should run on any
     * before or after URI patterns.
     *
     * Example:
     * 'isLoggedIn' => ['before' => ['account/*', 'profiles/*']]
     *
     * @var array
     */
    public $filters = [];
}

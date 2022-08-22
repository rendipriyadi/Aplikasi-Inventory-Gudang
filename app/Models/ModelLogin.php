<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelLogin extends Model
{
    protected $table            = 'users';
    protected $primaryKey       = 'userid';
    protected $allowedFields    = ['userid', 'usernama', 'userpassword', 'userlevelid'];
}

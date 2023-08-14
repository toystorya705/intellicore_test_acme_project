<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use RandomPasswordGenerator\RandomPasswordGenerator;

class RandomPasswordController extends Controller
{
    public function generateRandomPassword()
    {
        $password = RandomPasswordGenerator::generate();
        return view('random-password', ['password' => $password]);
    }
}

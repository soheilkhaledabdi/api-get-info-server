<?php

namespace App\Http\Controllers;


use App\Libraries\Responder\Facades\ResponderFacade;
use Illuminate\Http\Request;
use Symfony\Component\Process\Process;

class UserController extends Controller
{
    public function create(Request $request)
    {
        $username = $request->username; // Replace with desired username
        $password = $request->password; // Replace with desired password

        // Execute the adduser command
        shell_exec("sudo useradd {$username} -p $(openssl passwd -1 {$password})");
        return response()->json(['message' => 'User created successfully.']);
    }
}

<?php

namespace App\Http\Controllers;


use App\Libraries\Responder\Facades\ResponderFacade;
use App\Libraries\Responder\ResponseBuilder;
use Illuminate\Http\Request;
use Symfony\Component\Process\Process;

class UserController extends Controller
{
    public function create(Request $request)
    {
        $Data =  $this->validate($request , [
            'username' => 'required',
            'password' => 'required',
            'date' => 'required',
            'limit' => 'required'
        ]);

        $username = $Data['username'];
        $password = $Data['password'];
        $date = $Data['date'];
        $limit = $Data['limit'];

        // Execute the adduser command
        shell_exec("sudo useradd {$username} -p $(openssl passwd -1 {$password})");
        shell_exec("chage -E {$date} {$username}");
        shell_exec("sudo bash -c echo '{$username} hard maxlogins {$limit}' >> /etc/security/limits.conf");

        $response = new ResponseBuilder();
        return  $response->setMessage('User created successfully')->respond();
    }
}

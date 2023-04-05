<?php

namespace App\Http\Controllers;


use App\Libraries\Responder\Facades\ResponderFacade;
use App\Libraries\Responder\ResponseBuilder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\Process\Process;

class UserController extends Controller
{
    public function create(Request $request): JsonResponse
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

    public function disable(Request $request)
    {
        $data = $this->validate($request , [
           'username' => 'required'
        ]);

        $username = $data['username'];

        shell_exec("usermod -L -e 1 {$username}");

        $response = new ResponseBuilder();
        return  $response->setMessage('User disable successfully')->respond();
    }

    public function enable(Request $request)
    {
        $data = $this->validate($request , [
            'username' => 'required'
        ]);

        $username = $data['username'];

        shell_exec("usermod -e -1 -U {$username}");

        $response = new ResponseBuilder();
        return  $response->setMessage('User enable successfully')->respond();
    }
}

<?php

namespace App\Http\Controllers;

use App\Libraries\Responder\ResponseBuilder;
use Illuminate\Http\JsonResponse;
use PHPUnit\Util\Json;

class monitoringController extends Controller
{
    public function uptime(): JsonResponse
    {
        $uptime = shell_exec('uptime');
        $uptime = str_replace("\n", "", $uptime);
        $response = new ResponseBuilder();
        return  $response->setData(["uptime" => $uptime])->setMessage('It was successful')->respond();
    }

    public function getServerInfo() : JsonResponse
    {
        $uname = shell_exec('uname -rsoi');
        $host = shell_exec('hostname');
        $ip = shell_exec('hostname -I');

        $uname = str_replace("\n", "", $uname);
        $host = str_replace("\n" , "" , $host);
        $ip = str_replace(["\n" , " " ] , "",$ip);

        $response = new ResponseBuilder();
        return  $response->setData(['uName' =>  $uname , 'host' => $host , 'ip' => $ip])->setMessage('It was successful')->respond();
    }

    public function diskUsage() : JsonResponse
    {
        $disktotal = disk_total_space('/'); //DISK usage
        $disktotalsize = $disktotal / 1073741824;

        $diskfree  = disk_free_space('/');
        $used = $disktotal - $diskfree;

        $diskusedize = $used / 1073741824;
        $diskuse1   = round(100 - (($diskusedize / $disktotalsize) * 100));
        $diskuse = round(100 - ($diskuse1)) . '%';

        $response = new ResponseBuilder();
        return  $response->setData(['diskUse' => $diskuse,'diskTotalSize' => $disktotalsize,'diskUsedSize' => $diskusedize])->setMessage('It was successful')->respond();
    }

    public function cpuAndRam() : JsonResponse
    {
        //RAM usage
        $free = shell_exec('free');
        $free = (string) trim($free);
        $free_arr = explode("\n", $free);
        $mem = explode(" ", $free_arr[1]);
        $mem = array_filter($mem);
        $mem = array_merge($mem);
        $usedmem = $mem[2];
        $usedmemInGB = number_format($usedmem / 1048576, 2) . ' GB';
        $memory1 = $mem[2] / $mem[1] * 100;
        $memory = round($memory1) . '%';
        $fh = fopen('/proc/meminfo', 'r');
        $mem = 0;
        while ($line = fgets($fh)) {
            $pieces = array();
            if (preg_match('/^MemTotal:\s+(\d+)\skB$/', $line, $pieces)) {
                $mem = $pieces[1];
                break;
            }
        }
        fclose($fh);
        $totalram = number_format($mem / 1048576, 2) . ' GB';

        //cpu usage
        $cpu_load = sys_getloadavg();
        $load = $cpu_load[0] . '% / 100%';

        $response = new ResponseBuilder();
        return  $response->setData(['memory' => $memory,'totalRAM' => $totalram,'usedMEMInGB' =>$usedmemInGB ,'load' => $load])->setMessage('It was successful')->respond();
    }

    public function onlineUser(): JsonResponse
    {
        $response = new ResponseBuilder();
        $count = shell_exec('ps -aux | grep sshd | grep priv -c');
        $count= (int)str_replace("\n", "", $count);
        return  $response->setData(['count' => $count])->setMessage('It was successful')->respond();
    }

    public function getAllUser(): JsonResponse
    {
        $response = new ResponseBuilder();
        $matches = [];
        $users = shell_exec('ps -aux | grep sshd | grep priv');
         preg_match_all("/sshd: (\w+)/", $users, $matches);

        return  $response->setData(['users' => $matches[1]])->setMessage('It was successful')->respond();

    }

    public function update() : JsonResponse
    {
        shell_exec('apt install update');

        $response = new ResponseBuilder();
        return  $response->setMessage('It was successful')->respond();
    }

    public function reboot() : JsonResponse
    {
        $reboot = shell_exec('reboot');

        $response = new ResponseBuilder();
        return  $response->setData(['reboot' => $reboot])->setMessage('It was successful')->respond();
    }
}

<?php

namespace App\Http\Controllers;

class monitoringController extends Controller
{
    /**
     * @return false|string|null
     */
    public function uptime()
    {
        $uptime = shell_exec('uptime');
        return response()->json(['uptime' => $uptime]);
    }

    public function getServerInfo(){
        $uname = shell_exec('uname -rsoi');
        $host = shell_exec('hostname');
        $ip = shell_exec('hostname -I');

        return response()->json(['uName' =>  $uname , 'host' => $host , 'ip' => $ip]);
    }

    public function diskUsage(){
        $disktotal = disk_total_space('/'); //DISK usage
        $disktotalsize = $disktotal / 1073741824;

        $diskfree  = disk_free_space('/');
        $used = $disktotal - $diskfree;

        $diskusedize = $used / 1073741824;
        $diskuse1   = round(100 - (($diskusedize / $disktotalsize) * 100));
        $diskuse = round(100 - ($diskuse1)) . '%';

        return response()->json(['diskUse' => $diskuse,'diskTotalSize' => $disktotalsize,'diskUsedSize' => $diskusedize]);
    }

    public function cpuAndRam(){
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

        return response()->json(['memory' => $memory,'totalRAM' => $totalram,'usedMEMInGB' =>$usedmemInGB ,'load' => $load]);
    }
}

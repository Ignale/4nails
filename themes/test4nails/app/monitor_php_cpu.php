<?php
                  // Порог загрузки CPU для логирования
$cpuLimit = 25.0; // %
$logFile  = __DIR__ . '/php_cpu_log.txt';

// Получаем список процессов PHP
exec("ps -eo pid,ppid,%cpu,cmd --sort=-%cpu | grep php | grep -v grep", $output);

foreach ($output as $line) {
    $parts = preg_split('/\s+/', trim($line), 4);
    if (count($parts) < 4) {
        continue;
    }

    [$pid, $ppid, $cpu, $cmd] = $parts;

    if ((float) $cpu > $cpuLimit) {
        $scriptPath = getPhpScriptFromPid($pid);
        $log        = date('Y-m-d H:i:s') . " | PID: $pid | CPU: $cpu% | Script: $scriptPath\n";
        file_put_contents($logFile, $log, FILE_APPEND);
    }
}

/**
 * Определяет, какой PHP-скрипт выполняется процессом.
 * Работает для php-fpm и cli.
 */
function getPhpScriptFromPid($pid)
{
    $environFile = "/proc/$pid/environ";
    if (file_exists($environFile) && is_readable($environFile)) {
        $env = file_get_contents($environFile);
        if (preg_match('/SCRIPT_FILENAME=([^\0]+)/', $env, $m)) {
            return $m[1];
        }
    }
    // Если cli-скрипт — пробуем вытащить из команды
    exec("ps -p $pid -o args=", $cmdOut);
    return $cmdOut[0] ?? 'Unknown';
}

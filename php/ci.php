<?php
echo '开始执行';
function doShell ($cmd, $cwd = null) {
    $descriptorspec = array(
        0 => array("pipe", "r"),
        1 => array("pipe", "w"),
        2 => array("pipe", "w"),
    );
    $proc = proc_open($cmd, $descriptorspec, $pipes, $cwd, null);
    if ($proc == false) {
        return false;
    } else {
        $stdout = stream_get_contents($pipes[1]);
        fclose($pipes[1]);
        $stderr = stream_get_contents($pipes[2]);
        fclose($pipes[2]);
        $status = proc_close($proc);
    }
    $data = array(
        'stdout' => $stdout,
        'stderr' => $stderr,
        'retval' => $status,
    );

    return $data;
}
echo 1;
$postArr = json_decode($_POST['payload'],true);
echo 2;
$repoName = $postArr['repository']['name'];
echo 3;
$shell = 'cd /data/wwwroot/'.$repoName.' && sudo git pull';
echo 4;
$res = doShell($shell);
echo 5;
$resText = json_encode($res);
echo 6;
file_put_contents("ci.log", $resText, FILE_APPEND);
echo 7;
echo $resText;
echo 8;
die();

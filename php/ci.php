<?php
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
$postArr = json_decode($_POST['payload'],true);
$repoName = $postArr['repository']['name'];
$shell = 'cd /data/wwwroot/'.$repoName.' && sudo git pull';
$res = doShell($shell);
$resText = json_encode($res);
file_put_contents("ci.log", $resText, FILE_APPEND);
echo $resText;
die();

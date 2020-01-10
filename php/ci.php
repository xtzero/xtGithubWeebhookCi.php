<?php
// 加载执行shell的函数
require_once 'lib/doShell.php';
require_once 'lib/cmdDecode.php';

// 主程序
$resTextArr = [
    date('Y-m-d H:i:s')
];
if (!empty($_POST['payload'])) {
    // github post过来的数据
    $postArr = json_decode($_POST['payload'],true);
    // repo名
    $repoName = $postArr['repository']['name'];

    // 先获取公共脚本数组
    $commonShellArr = include_once('conf/common.cmd.php');

    if (is_file('conf/'.$repoName.'.conf.php')) {
        $cmd = include_once('conf/'.$repoName.'.cmd.php');
        if (!empty($cmd['conf']['no_common']) && $cmd['conf']['no_common'] == 1) {
            $cmdArr = $cmd['cmd'];
        } else {
            $cmdArr = array_merge($commonShellArr, $cmd['cmd']);
        }
    } else {
        $cmdArr = $commonShellArr;
    }
    $cmdStr = cmdDecode($cmdArr);
    $resTextArr[] = "即将执行shell";
    $resTextArr[] = $cmdStr;
    $res = doShell($cmdStr);
    $resTextArr[] = "执行结果";
    $resTextArr[] = json_encode($res);
    
    // 创建日志目录，开始记录日志
    if (!is_dir('log/'.$repoName)) {
        mkdir('log/'.$repoName);
    }
    if (!is_dir('log/'.$repoName.'/'.date('Y-m-d'))) {
        mkdir('log/'.$repoName.'/'.date('Y-m-d'));
    }

    $resText = implode("\n /", $$resTextArr);
    file_put_contents("log/{$repoName}/".date('Y-m-d')."/ci.log", $resText, FILE_APPEND);
} else {
    echo 'nothing to do, no payload.';
}


die();

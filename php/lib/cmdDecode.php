<?php
function cmdDecode($shellArr, $params = [])
{
    $shellStr = implode(' && ', $shellArr);
    
    if (!empty($params['repo_name'])) {
        $shell = str_replace("{{REPO_NAME}}", $params['repo_name'], $shellStr);
    }

    return $shell;
}
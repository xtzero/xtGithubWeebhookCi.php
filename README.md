# xtGithubWeebhookCi.php
使用php配合github webhook进行自动部署

需要安装php运行环境，php版本要求 > 5.6。

在网站根目录部署`ci.php`，让该文件能被ip访问到。

前往repo首页，依次选择`Settings-Webhooks-Add webhook`。在`Payload URL`中填入上述可执行的php的地址，比如`http://127.0.0.1/ci.php`。

添加成功后尝试对repo进行一次push操作，前往服务器查看是否已经自动拉取成功了。

php接收到push事件后会自动前往`web_root/repo_name`并执行`git pull`，相关代码在脚本的第28行。可以根据需要来修改。

# xtGithubWeebhookCi.php
使用php配合github webhook进行自动部署

> 正在进行更新。
> 更新内容是
>> 加入对不同项目的单独配置，比如swoole会重启服务，node项目会重新构建等。

## 环境要求
php > 5.6
git
linux

适用于完全使用github/gitlab/gitee等管理网站代码的服务器。

## 使用方法
### 部署
随便在哪部署这个项目，让它能被ip或域名访问到即可。

### 修改代码
大概28行，这个位置的`/data/wwwroot/`修改为你的网站根目录。
$shell = 'cd /data/wwwroot/'.$repoName.' && sudo git pull';

### 配置github repo
前往repo首页，依次选择`Settings-Webhooks-Add webhook`。在`Payload URL`中填入上述可执行的php的地址，比如`http://127.0.0.1/ci.php`。

## 测试
添加成功后尝试对repo进行一次push操作，前往服务器查看是否已经自动拉取成功了。

php接收到push事件后会自动前往`web_root/repo_name`并执行`git pull`，相关代码在脚本的第28行。可以根据需要来修改。

## 注意事项

+ 脚本原理是`git pull`，所以配置成功后不要直接修改服务器上的web目录，否则会导致`git pull`的时候出现冲突，导致自动部署失败。

+ `git push`操作间隔不宜太短，至少要等待上一个`git pull`结束再进行下一个`git push`。这个问题已经加入待办，但不知道什么时候完成。如果对这个依赖很大，建议使用gitlab+runner。

+ 这个脚本适用于完全使用github/gitlab/gitee等管理网站代码的服务器，push的repo名必须对应服务器的项目文件夹，不然脚本找不到目录，就会pull失败。

+ 总共就33行的脚本不要要求太多。

## 待办
+ 加入队列机制，以实现随意push。

+ 加入对不同项目的单独配置，比如swoole会重启服务，node项目会重新构建等。

+ 对服务器权限配置有要求，但是这次配置过程中我忘记记录过程了，下次移动记录下来。
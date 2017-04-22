# goaccess-easyfrontend

2017-04-21：添加了web端代码

数据库修改mydb.php即可


## 安装

1. `git clone https://github.com/onecer/goaccess-easyfrontend.git`

将源码克隆去根目录

2. 配置网站根目录指向web目录

3. 修改`web/mydb.php`配置数据库信息

将data.sql 导入数据库

4. 修改makelog.sh 让它定时调用goaccess生成html信息。可以修改下

用法`makelog.sh <logpath>` 比如加到nginx日志分割文件

5. 生成的日志文件在 `loghtml/` 只能通过logview.php读取访问，理论安全。

待更新功能：

日志实时更新查看，但是基于我日志同步没做好，这个不是安装在生产环境。所以暂未添加相关处理。

## 注册功能

注册完，请创建reg.lock文件，禁止注册。

## 截图

登录

![login](http://ojz2jzr09.bkt.clouddn.com/blog/goaccess-ft-login.png)

DasdBoard

![dashboard](http://ojz2jzr09.bkt.clouddn.com/blog/goaccess-ft-dashboard.png)

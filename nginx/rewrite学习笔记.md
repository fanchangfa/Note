#### 什么是Nginx Rewrite
Nginx中Rewrite主要实现UR的重写，由于采用PCRE（Perl Compatible Regular Expressions），Per兼容正则表达式的语法进行规则匹配，所以若需要Nginx的Rewrite功能，需要安装Perl库。

Nginx Rewrite规则相关指令有： **if、rewrite、set、return、break**

#### if 指令
语法：
  if(condition){...}
* if不能嵌套
* 不能配合else使用
* 只有可以有一个条件判断，不能用 && || 进行多条件判断

**可以被指定为condition的条件：**
- 变量名，空字符和以0开头的字符串为错误值
2. 变量比较用 = 、 != 表示等于、不等于
3. 正则模式匹配可用 ~（区分大小写）和 ～*（不区分大小写）
4. !~和!~*与 ~和~* 相反
5. -f 和 !-f 判断文件是否存在
6. -d 和 !-d 判断目录是否存在
7. -e 和 !-d 判断文件/目录是否存在
8. -x 和 !-x 判断文件是否可执行

例如：
 ```
 if($request_method = POST){
    return 405;
 }
 
 if(!-f $request_filename){
    break;
    proxy_pass http://127.0.0.12
 }
 
 if($http_user_aget ~ MSIE){
    rewrite ^(.*)$ /msie/$1 last;
 }
 ```
 
#### Return 指令
语法： return code;  
该指令用于结束规则的执并返回状态码给客户端  
状态码可以为：204、400、402-406、408、410、411、413、416和500-504  
非状态码444将以不发送任何Header头的方式结束链接  

例如： 
 ```
 #当访问.sh脚本文件时返回状态码403
 location ~ .*\.(sh | bash)$
 {
    return 403;
 }
```
#### rewrite指令
语法： rewrite regex replacement flat;  
该指令通过表达式来重定向URL或修改字符串，根据配置文件中的顺序来执行  

例如：
```
  #以www开头的请求都指向test.com域名
  rewrite ^www\.(.*) http://www.test.com last;
```
##### rewrite的flag标记：
+ last 表示完成rewrite,和Apache中[L]对应 ，匹配完后对其所在的server重新发送请求
+ breank 匹配完本条规则，终止匹配，不再匹配后面的rewrite
+ redirect 返回302临时重定向，浏览器地址会显示跳转后的url
+ permant 返301重定向，浏览器地址会显示跳转后的url
+ 

如果请求的url有get参数，比如,www.test.com/?id=1  
默认会自动附加到替换串，可以在后面加?来解决  
例如 访问www.test.com/?id=1  
rewrite规则：
```
rewrite ^/(.*)$ http://www.test.com/test  #最终http://www.test.com/test?id=1
rewrite ^/(.*)$ http://www.test.com/test?  #最终http://www.test.com/test
```

花括号 { 、 } 因为他们既可以在配置文件里分割代码块，也可用在正则中，所以若正则包含花括号就要用双/单引号扩起来
```
rewrite "^/post/([0-9]{1,3})" /post/submit.php?id=$1 last;
```

#### set指令
用于定义变量并赋值  
```
if($host ~ www\.(.*)){
  set $var 'www1';  
  #rewrite中可直接用 $var
}
```

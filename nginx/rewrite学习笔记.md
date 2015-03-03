Nginx中Rewrite主要实现UR的重写，由于采用PCRE（Perl Compatible Regular Expressions），Per兼容正则表达式的语法进行规则匹配，所以若需要Nginx的Rewrite功能，需要安装Perl库。

Nginx Rewrite规则相关指令有： if、rewrite、set、return、break

 PHP是一个支持面向对象开发的语言，而不是一个纯面向对象的语言
 PHP5中保留了对var的支持，但会将var自动转换为public
 类型检查函数：
 is_bool()
	is_integer()
	is_double()
	is_string()
	is_object()
	is_array()
	is_resource()
	is_null()

	PHP魔术方法：
	__call()
	__callStatic()     (必须是static属性)
	__set()
	__get()
	__isset()
	__clone()
	__toString()

	字符串"false"在比较操作时会解析为true,因为PHP在测试变量时会转换一个非空字符串值为bool值true

	静态方法是以类作用域的函数。静态方法不能访问这个类中的普通属性，因为那些属性属于一个对象，但可以访问静态属性（不能在静态方法中使用伪变量$this）

	常量属性只包含基本数据类型的值，不能将一个对象指派给常量
	抽象类(abstract class)不能被直接实例化，只定义(或部分实现)子类需要的方法
	抽象类至少包含一个抽象方法
	static类似于self，但它指的是被调用的类而不是包含类
	return new static()

	复制对象：
	    $first = new ClassName();
		    $second = $first;
			    //在php5以后的版本中，$second 和 $fitst指向同一个对象

			    $third = clone $first;          //使用clone进行"值复制"
				    //在php5以后的版本中，$third和$first是两个不同的对象
				    控制复制什么：
					          可以实现一个__clone()方法
							            比如待复制的对象中有个$id=1，可我们希望此id唯一，不希望clone此id，可以在类中自己实现clone方法

										回调、匿名函数：
										is_callable();
										call_user_func($funcName,$param);     //单个参数
										call_user_func_array($funcName,$arrParam);     //参数是数组的形式

										命名空间Namespace:
										命名空间是一个容器，在命名空间之外，必须导入或引用命名空间才能访问它所包含的项。
										namespace com\name\test1;
										class Debug{
											    static function test();
										}

namespace test2;
//调用test1命名空间中的test方法
\com\name\test1\Debug::test();     //最前面必须加上 / 否则会在test2下寻找此命名空间

use com\name\test1;
test1\Debug::test();  

解决类命名冲突：
use com\name\test1\Debug as uDebug;
class Debug{...}
uDebug::test();

__NAMESPACE__     //输出当前的命名空间

命名空间加大括号形式:
namespace com\name\test1{
	    class Debug1{...}
		    class Debug2{...}
}
require()调用文件发生错误时，将会停止整个程序，
调用include()时遇到相同的错误，会生成警告并停止执行包含文件，跳出调用代码然后继续执行。

require()和require_once()用于包含库文件时更加安全，include()和include_once()适用于加载模板等操作
相对require()函数，require_once()需要额外的开销

自动加载autoload:
当PHP引擎遇到试图实例化未知类的操作时，会调用__autoload()方法(需提前定义)，并将类名当作字符串参数传递
例如：
function __autoload($className){
	    //将$className中的下划线转换为目录分割
	    $path = str_replace('_',DIRECTORY_SEPARATOR,$className);
		    require_once("$path.php");
}
__autoload方法是一种根据类和文件的结构，管理类库文件包含的有效方法。

类函数：
class_exists();
get_declared_classes();     //获得脚本进程中定义的所有类的数组
get_class($obj);     //检查对象的类，检查对象所属的类
$obj instalceof className;     //检查对象

get_class_methods();     //获取一个类中所有的方法列表

is_callable()、method_exists()     //检查类方法是否存在且可被调用
#一个方法存在并不以为着可调用，对private、protected、public方法，method_exists()都返回true

	get_class_vars($className);     //获取类中定义的属性
	get_parent_class($classNa,e);     //获取一个类的父类
	is_subclass_of($className , 'classStrName');     //检查类是否是另一个类的派生类
	class_implements($className);      //返回一个由接口名组成的数组

	反射API
	根据到达地找到出发地和来源，反射指在PHP运行状态中扩展分析PHP程序，导出或提取出关于类、方法、属性、参数等的详细信息，包括注释。这种动态获取信息以及动态调用对象方法的功能称为反射API
	使用反射API可以对文件里的类进行扫描，逐个生成描述文件

	面向对象设计的五大原则：
	单一职责原则
	接口隔离原则
	开放-封闭原则
	替换原则
	依赖-倒置原则

	sql优化的10个原则：
	不要在列上进行函数运算，导致索引失败
	使用JOIN时，应用小结果集驱动大结果集。把复杂的JOIN查询拆分为多条sql
	使用like模糊查询时，避免%%，可替换为<= 、 >=
	select后仅列出需要的字段，对速度不会有明显影响，主要考虑节省内存
	使用批量插入语句，比依次执行单个插入节省交互
	limit的技术比较大时考虑使用between
	不要使用rand函数获取多条随机记录
	避免使用NULL
	不要使用count(id)，而是count(*)
	尽可能在索引中完成排序
	缓存的三个要素：
	命中率
	缓存更新策略
	缓存最大数据量
	通常缓存更新策略有：
	FIFO（先进先出）
	LRU（最近最少淘汰策略）
	LFU（最少使用淘汰策略）
	MySQL 的 Query Cache使用的是FIFO策略
	缓存的最大数据量是在缓存中能够处理元素的最大数或所能使用的最大存储空间
	超过缓存机制允许的最大数据量系统会进行相应的处理，一般处理方式有：
	停止缓存服务器，清空所有缓存数据
	拒绝写入，不再对缓存数据进行更新
	根据缓存更新策略清除旧数据
	基于3的方式，对淘汰的数据进行备份
	Opcode缓存：
	    虚拟机把PHP代码编译成一种中间码的结果缓存起来，下次PHP运行此页面时，只要直接解释这些代码就行了。
		eAccelerator工具能起到常驻内存的作用

		客户端缓存、http缓存（待记录）
		H5中的Application Cache:
		用来处理离线应用中的问题，用户不能联网时依然能浏览整个站点
		需要在html中指定页面是否需要此缓存：
		<html manifest="cacheName.mf">

		Memcached
		使用Memcached：
		对数据库的高并发读写
		对海量数据处理
		Memcached是高性能的分布式内存缓存服务器，通过缓存数据库查询结果，减少数据库访问次数。
		Memcached特点：
		协议简单
		基于libevent的事件处理
		内置内存存储方式
		采用不互相通信的分布式
		以守护进程方式运行与一个或多个服务器中
		Memcached使用LRU算法淘汰数据缓存
		不支持数据持久化
		Memcached把数据存储在内存中，所以重启Memcached或者操作系统会导致数据全部消失

		安装memcached：
		apt-get install memcached
		启动memcached:
		memcached -d -m 128 -u root -p 11211
		-d：守护进程方式运行
		-m：设置Memcached可使用的内存大小，单位是MB
		-l：设置监听的IP地址，本机可默认不设置
		-u：指定用户
		-p：设置监听的端口，默认为11211

		安装PHP的memcached扩展：
		 sudo apt-get install php5-memcache

		 memcached扩展的一些方法：
		 Memcache::connect(string $host [, int $port [ , int $timeout]]);     //连接mem服务器
		     $timeout为连接持续时间，默认为1秒。过长的时间会倒置失去所有缓存的优势
			 Memcache::addServer(string $host [ , $port [ , $bool $persistent [ , $weight [, int $timeout [, int $retry_interval [ , bool $status [ , callback $failure_callback]]]]]]]);     //向对象添加一个服务器
			 Memcache::add(string $key,$mixed $var [, int $flag[ , int $expire]]);    //添加缓存数据
			 key长度不能超过250字节，
			 var 值最大为1MB
			 $flag 是否使用ZLib压缩，设置为MEMACHE_COMPRESSED使用压缩
			 $expire缓存过期时间，0表示不过期。设置不能大于2592000（30天）
			 Memcache::replace(string $key, mixed $var [ , int $flag [, int $expire]]);    //替换一个已存在的key
			 Memcache::set(string $key ,mixed $vsar [ , $flag [ , $expire]])    //add和replace的集合体
	Memcache::get(string $key [ , int &flags]);    //获取key的缓存内容
	$flags 如果给定此参数（引用方式传递），该参数会被写入一些与key对应的信息
	Memcache::delete(string $key [ , $timeout]);    //删除key的缓存
	Memcache::flush(void);    //立即使所有已经存在的缓存失效
	不真正释放任何资源，仅标记为失效
	Memcache::getServerStatus(string $host [ , $port]);    //获取一个服务器的在线/离线状态
	Memcache::getStats([ string $type [ , $slabid [ , int $limit = 100]]]);    //获取服务器的统计信息
	Memcache::close(void);    //关闭与Memcache服务器的连接
	Memcached使用多路复用I/O模型（如epoll、select）,传统阻塞IO中 系统可能会因为某个用户连接还没做好IO准备而一直等待，直到这个连接做好准备，如果此时游其他用户连接到服务器，可能会因为系统阻塞而得不到相应。
	多路复用I/O是一种消息通知模式，用户连接做好IO准备后，系统会通知这个连接可进行IO操作，这样就不会阻塞在某个用户连接。
	Memcached使用Slab分配算法保存数据
	Slab分配算法的原理是，把固定大小(mem默认为1M)的内存划分为n块，每1M大小的内存块称为一个slab页，每次向系统申请一个slab页，然后通过分割算法把这个slab页分成若个小块的chunk，然后把这些chunk分配给用户使用。
	Memcached多线程模型：
	主线程：接受客户端连接，并把连接分配给工作线程处理
	工作线程：处理客户端连接的请求
	Memcached分布式布置方案：
	普通Hash分布
	一致性Hash分布
	Redis
	Redis把整个数据库全加载到内存中进行操作，通过异步操作定期把数据库数据flush到硬盘保存
	Reids特点：
	支持丰富的数据类型：String、List、Sort、Sorted Set、Hash
	支持数据持久化方式：内存快照、日志追加
	支持主从复制
	安装Redis:
	http://www.cnblogs.com/fslnet/p/3759284.html
	安装php扩展redis:
	sudo apt-get install php5-redis
	redis默认端口为：6379

	redis配置文件（待整理）

	redis key相关命令：
	exits key     //key是否存在，返回0/1
	del key1 key2..     //删除指定key，返回删除key的数目，0表示key都不存在
	type key     //返回给定key的value类型，none表示不存在key
	types pattern     //返回匹配指定模式的所有key
	expire key seconds     //设置指定key的过期时间
	randomkey     //返回当前数据库中随机的一个key，如果数据库为空，返回空字符串
	rename oldkey newkey     //重命名key
	renamenx oldkey newkey     //重命名key，如果newkey存在返回失败
	ttl key     //返回设置过期时间key的剩余秒数，-1表示key不存在或没有设置过期时间
	move key db-index     //将key从当前数据库移动到指定的数据库，返回1成功，0表示不存在或已在指定数据库

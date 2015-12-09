# wavephp
轻量PHP框架，[Wavephp框架 wiki](http://www.37study.com "Wavephp框架 wiki")

1、框架目录结构

    wavephp
        | Cache
            Cache_File.php
            Cache_Interface.php
            Cache_Memcache.php
            Cache_Memcached.php
            Cache_Redis.php
            File.php
            RedisCluster.php
        | Db
            Db_Abstarct.php
            Mysql.php
        | i18n
            i18n.php
            i18nModel.php
        | Library
            | Captcha
            | Smarty
        | Session
            | Session_Db.php
			| Session_File.php
            | Session_Memcache.php
            | Session_Memcached.php
            | Session_Redis.php
        Controller.php
        Core.php
        Database.php
        Model.php
        Request.php
        Route.php
        View.php
        Wave.php
        WaveBase.php

2、项目目录结构

    helloworld
		| data
			| caches
			| templates
				| compile
					| index
        | protected
            | config
                main.php
            | controllers
                SiteController.php
            | models
                TestModel.php
            | templates
                | site
                    index.html
		define.php
        index.php

3、入口 index.php 内容：

    header('Content-Type:text/html;charset=utf-8');
    error_reporting(0);

    require dirname(__FILE__).'/../../wavephp/Wave.php';
    $config = dirname(__FILE__).'/protected/config/main.php';
    
    $wave = new Wave($config);
    $wave->run();


4、配置文件 config/main.php

    $config = array(
	    'projectName'           => 'protected',
	    'modelName'             => 'protected',
	
	    'import'                => array(
	        'controllers.*'
	    ),
	
	    'defaultController'     => 'site',
	
	    'smarty'                => array(
	        'is_on'             => true,    // 是否使用smarty模板 参考demo下的enterprise2项目
	        'left_delimiter'    => '{%',
	        'right_delimiter'   => '%}',
	        'debugging'         => false,
	        'caching'           => false,
	        'cache_lifetime'    => 120,
	        'compile_check'     => true,
	        'template_dir'      => 'templates',
	        'config_dir'        => 'templates/config',
	        'cache_dir'         => 'data/templates/cache/index',
	        'compile_dir'       => 'data/templates/compile/index'
	    ),
	    
	    'debuger'               => false,       // 显示debug信息
	    
	    'database'              => array(
	        'driver'            => 'mysql',
	        'master'            => array(
	            'dbhost'        => '127.0.0.1',
	            'username'      => 'root',
	            'password'      => '',
	            'dbname'        => 'enterprise',
	            'charset'       => 'utf8',
	            'table_prefix'  => '',
	            'pconnect'      => false
	        ),
	        'slave'             => array(
	            'dbhost'        => '127.0.0.1',
	            'username'      => 'root',
	            'password'      => '',
	            'dbname'        => 'enterprise',
	            'charset'       => 'utf8',
	            'table_prefix'  => '',
	            'pconnect'      => false
	        )
	    ),
	    
	    'session'=>array(
	        'driver'            => 'file',
	        'timeout'           => 86400
	    )
	);

5、默认控制层文件controllers/SiteController.php 调用默认方法actionIndex

    /**
     * 网站默认入口控制层
     */
    class SiteController extends Controller
    {
           
        public function __construct()
        {
            parent::__construct();
        }
    
        /**
         * 默认函数
         */
        public function actionIndex()
        {
            // 多语言使用，要连数据库，表为w_language，参看enterprise数据库
			// 按规定填入数据
			// 使用方式
			i18n::$lang = 'vi-vn';
			echo i18n::get('平台管理');
			// smarty模板使用方式
			// {%i18n var=平台管理%}
			
			// 项目路径
			echo Wave::app()->projectPath;
			//当前域名
			echo Wave::app()->request->hostInfo;
			//除域名外以及index.php
			echo Wave::app()->request->pathInfo;
			//除域名外的地址
			echo Wave::app()->homeUrl;
			//除域名外的根目录地址
			echo Wave::app()->request->baseUrl;
			
			// 关闭自动加载
			spl_autoload_unregister(array('WaveBase','loader'));
			// 开启自动加载
			spl_autoload_register(array('WaveBase','loader'));
			
			$User = new User();
			echo "User model 加载成功！";
			
			$this->username = 'Ellen';
			// 然后查看 templates/site/index.html 文件
			输出 {%$username%}
			
			// mecache使用
			Wave::app()->memcache->set('key', '11111', 30);
			echo "Store data in the cache (data will expire in 30 seconds)";
			$get_result = Wave::app()->memcache->get('key');
			echo " Memcache Data from the cache:$get_result";
			
			// redis使用
			Wave::app()->redis->set('key', '11111', 30);
			echo "Store data in the cache (data will expire in 30 seconds)";
			$get_result = Wave::app()->redis->get('key');
			echo " Redis Data from the cache:$get_result";
        }
    }


6、解析URL 比如解析这样的URL /blog/index.php/site/index

index.php 可以通过rewrite去掉，这里就不讲了。

site指SiteController.php，index指actionIndex

如果是这样的/blog/index.php/site/index/aaa/bbb 那应该写成public function actionIndex($a, $b)

$a 就是 aaa， $b 就是 bbb

7、数据库 仅支持mysql数据库，参看TestModel.php的sql用法，继承Model，有问题可以改Model这个文件
    
    /**
     * 测试模型
     */
    class TestModel
    {
        protected function init() {
            $this->_tableName = self::$_tablePrefix.'articles';
            $this->cache = Wave::app()->memcache;
        }

        public function getList() {
            $like = array();
            $like['content'] = '是';
            $array = $this  ->select('*')
                            ->like($like)
                            ->limit(0, 2)
                            ->group('aid')
                            ->order('aid')
                            ->getAll();

            $where = array('aid'=>2);
            $array = $this  ->select('*')
                            ->where($where)
                            ->getAll();

            $in = array('aid' => '2,3,4');
            $array = $this  ->select('*')
                            ->in($in)
                            ->getAll();

            $array = $this  ->select('*')
                            ->from('articles a')
                            ->join('category c', 'a.cid=c.cid')
                            ->getAll();

            $array = $this ->getAll();

            // 数据缓存
            $array = $this->getAll('*', null, 'articles', 60);


            $data = array('c_name'=>'测试4');
            var_dump($this->insert($data));
            $where = array('cid'=>4);
            $updateCount = $this->update($data, $where);
            echo $updateCount;die;
            
            return $array;
        }
    }

8、session

session 配置
    'session'=>array(
        'driver'            => 'db',
        'timeout'           => 86400
    )

使用如下：

存储：Wave::app()->session->setState('userinfo', $data);

获得：Wave::app()->session->getState('userinfo');

10、memcache

配置文件

    'memcache'=>array(
        array(
            'host'            => 'localhost',
            'port'             => '11211'
        ),
        array(
            'host'             => '192.168.1.1',
            'port'            => '11211'
        )
    )

多个集群最好用memcached

    'memcached'=>array(
        array(
            'host'            => 'localhost',
            'port'             => '11211'
        ),
        array(
            'host'             => '192.168.1.1',
            'port'            => '11211'
        )
    )

调用的时候 

存储：Wave::app()->memcache->set('key', $tmp_object, 30) | Wave::app()->memcached->set('key', $tmp_object, 30)

获得：Wave::app()->memcache->get('key') | Wave::app()->memcached->get('key')

11、redis

配置文件
    
    'redis'=>array(
        'master' => array(
            'host'          => '127.0.0.1',
            'port'          => 6379
        ),
        'slave' => array(
            array(
                'host'          => '127.0.0.1',
                'port'          => 63791
            ),
            array(
                'host'          => '127.0.0.1',
                'port'          => 63792
            )
        )
    )

可以配置一个redis主从服务器。slave可以不填。

调用的时候

存储：Wave::app()->redis->set('key', $tmp_object, 30)

获得：Wave::app()->redis->get('key')

以demos下enterprise为例，nginx配置如下：

    server {
        listen       80;
        server_name  localhost;
        index index.php index.html index.htm;
        root D:/xampp/htdocs/wavephp/demos/enterprise;
    
        # redirect server error pages to the static page /50x.html
        error_page   500 502 503 504  /50x.html;
        location = /50x.html {
            root   html;
        }
             
        location ~ .*\.(gif|jpg|jpeg|png|bmp|swf)$
        {
            expires 30d;
        }
    
        location ~ .*\.(js|css)?$
        {
            expires 24h;
        }
    
        if ($request_filename !~* (\.xml|\.rar|\.html|\.htm|\.php|\.swf|\.css|\.js|\.gif|\.png|\.jpg|\.jpeg|robots\.txt|index\.php|\.jnlp|\.jar|\.eot|\.woff|\.ttf|\.svg)) {
            rewrite ^/(.*)$ /index.php/$1 last;
        }
    
        location ~ .*\.php {
            fastcgi_pass   127.0.0.1:9000;
            fastcgi_param  SCRIPT_FILENAME  $document_root$fastcgi_script_name;
            fastcgi_index  index.php;
            fastcgi_split_path_info ^(.+\.php)(.*)$;                                         
            fastcgi_param   SCRIPT_FILENAME $document_root$fastcgi_script_name;                 
            fastcgi_param   PATH_INFO $fastcgi_path_info;                                       
            fastcgi_param   PATH_TRANSLATED $document_root$fastcgi_path_info;                   
            include fastcgi_params;  
        }
    }

.htaccess如下：

    <IfModule mod_rewrite.c>
      Options +FollowSymlinks
      RewriteEngine On
    
      RewriteCond %{REQUEST_FILENAME} !-d
      RewriteCond %{REQUEST_FILENAME} !-f
      RewriteRule ^(.*)$ index.php?/$1 [QSA,PT,L]
    </IfModule>


网站后台地址：http://127.0.0.1/admin.php 用户名密码自己改数据库

我用惯了YII框架，所以在很多功能上特像YII，虽然wavephp没有YII的功能全，大，但是一些常用的基本功能还是有的。希望大家多多提意见！QQ群：272919485
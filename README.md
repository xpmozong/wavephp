# wavephp
轻量PHP框架

1、框架目录结构

	wavephp
	    | Db
	        Abstarct.class.php
	        Mysql.class.php
	    | Library
	        | Captcha
	        | Smarty
	    | Web
	        Session.class.php
	    Controller.php
	    Core.php
		i18n.php
		i18nModel.php
	    Model.php
	    Route.php
	    Wave.php
	    WaveBase.php

虽然框架的文件少，代码少，新功能可以加嘛，很好加的，就这几个文件。

2、项目目录结构

	helloworld
	    | protected
	        | config
	            main.php
	        | controllers
	            SiteController.php
	        | models
	        | views
	            | layout
	                main.php
	            | site
	                index.php
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
	    'projectName'           =>  'protected',
	    'modelName'             =>'protected',
	
	    'import'=>array(
	        'controllers.*'
	    ),
	
	    'defaultController'     =>'site',
	
	    'smarty'=>array(
	        'isOn'              => true,    // 是否使用smarty模板 参考demo下的enterprise2项目
	        'left_delimiter'    => '{%',
	        'right_delimiter'   => '%}',
	        'debugging'         => false,
	        'caching'           => false,
	        'cache_lifetime'    => 120,
	        'compile_check'     => true,
	        'template_dir'      => 'templates',
	        'cache_dir'         => 'templates/cache',
	        'config_dir'        => 'templates/config',
	        'compile_dir'       => 'templates_c'
	    ),
	    
	    'debuger'=>false,       // 显示debug信息
	    
	    'database'=>array(
	        'db'=>array(
	            'dbhost'        => '127.0.0.1',
	            'dbport'        => '3306',
	            'dbuser'        => 'root',
	            'dbpasswd'      => '',
	            'dbname'        => 'enterprise',
	            'dbpconnect'    => 0,
	            'dbchart'       => 'utf8',
	            'table_prefix'  => ''
	        )
	    ),
	    'session'=>array(
	        'prefix'            => '',
	        'timeout'           => 86400
	    ),
	    
	    'memcache'=>array(
	        'cache1' => array(
	            'host'          => 'localhost',
	            'port'          => 11211
	        )
	    ),
	
	    'redis'=>array(
	        'cache1' => array(
	            'host'          => '127.0.0.1',
	            'port'          => 6379
	        )
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
	        {%i18n var=平台管理%}
	
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
	        // spl_autoload_unregister(array('WaveBase','loader'));
	        // 开启自动加载
	        // spl_autoload_register(array('WaveBase','loader'));
	
	        $User = new User();
	        echo "User model 加载成功！";
	
	        $username = 'Ellen';
	        // 然后查看 views/site/index.php 文件 输出 <?=$username?>
	        $this->render('layout/header');
	        $this->render('site/index', array('username'=>$username));
	        $this->render('layout/footer');
	
	        // mecache使用
	        Wave::app()->memcache->cache1->set('key', '11111', false, 30) 
	        or die ("Failed to save data at the server");
	        echo "Store data in the cache (data will expire in 30 seconds)";
	        $get_result = Wave::app()->memcache->cache1->get('key');
	        echo " Memcache Data from the cache:$get_result";
	
	        // redis使用
	        Wave::app()->redis->cache1->set('key', '11111', 30) 
	        or die ("Failed to save data at the server");
	        echo "Store data in the cache (data will expire in 30 seconds)";
	        $get_result = Wave::app()->redis->cache1->get('key');
	        echo " Redis Data from the cache:$get_result";
	
	    }
	}


6、解析URL 比如说我 要调用 类似这样的URL /blog/index.php/site/index

index.php 可以通过rewrite去掉，这里就不讲了。

site指SiteController.php，index指actionIndex

如果是这样的/blog/index.php/site/index/aaa/bbb 那应该写成public function actionIndex($a, $b)

$a 就是 aaa， $b 就是 bbb

7、数据库 仅支持mysql数据库，参看demos/enterprise/protected/models/TestModel.php的sql用法，继承Model，有问题可以改Model这个文件

	$like = array();
    $like['content'] = '是';
    $array = $this  ->select('*')
                    ->from('articles')
                    ->like($like)
                    ->limit(0, 2)
                    ->group('aid')
                    ->order('aid')
                    ->getAll();

    $where = array('aid'=>2);
    $array = $this  ->select('*')
                    ->from('articles')
                    ->where($where)
                    ->getAll();

    $in = array('aid' => '2,3,4');
    $array = $this  ->select('*')
                    ->from('articles')
                    ->in($in)
                    ->getAll();

    $array = $this  ->select('*')
                    ->from('articles a')
                    ->join('category c', 'a.cid=c.cid')
                    ->getAll();

    $array = $this  ->select('*')
                    ->from('category')
                    ->getAll();

    $data = array('c_name'=>'测试4');
    var_dump($this->insert('category', $data));
    var_dump($this->insertId());die;
    $where = array('cid'=>4);
    $updateCount = $this->update('category', $data, $where);
    echo $updateCount;die;
	
	return $array;

8、session

session 怎么用？

存储：Wave::app()->session->setState('username', 'Ellen Xu');

获得：Wave::app()->session->getState('username');

9、验证码
输出验证码 echo $this->verifyCode(4);<br>
获得session的验证码，5分钟。 Wave::app()->session->getState('verifycode');

10、memcache

配置文件

	'memcache'=>array(
	    'cache1' => array(
	        'host'              => 'localhost',
	        'port'              => '11211'
	    )
	)

可以多个

调用的时候 

存储：Wave::app()->memcache->cache1->set('key', $tmp_object, false, 30)

获得：Wave::app()->memcache->cache1->get('key')

11、redis

配置文件
	
	'redis'=>array(
        'cache1' => array(
            'host'          => '127.0.0.1',
            'port'          => 6379
        )
    )

可以多个

调用的时候

存储：Wave::app()->redis->cache1->set('key', $tmp_object, 30)

获得：Wave::app()->redis->cache1->get('key')

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
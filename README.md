# wavephp
轻量PHP框架

1、框架目录结构
<pre>
wavephp
    | Db
        Abstarct.class.php
        Mysql.class.php
    | Library
        | font
        VerifyCode.class.php
    | Web
        Session.class.php
    Controller.php
    Core.php
    Model.php
    Route.php
    Wave.php
    WaveBase.php
</pre>
虽然框架的文件少，代码少，新功能可以加嘛，很好加的，就这几个文件。

2、项目目录结构
<pre>
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
</pre>

3、入口 index.php
内容：
<pre>
header('Content-Type:text/html;charset=utf-8');
// error_reporting(0);

require dirname(__FILE__).'/../../wavephp/Wave.php';
$config = dirname(__FILE__).'/protected/config/main.php';

$wave = new Wave($config);
$wave->run();
</pre>

4、配置文件
    config/main.php
<pre>
$config = array(
    'projectName'=>'protected',
    'modelName'=>'protected',

    'import'=>array(
        'models.*'
    ),

    'defaultController'=>'site',
    
    'database'=>array(
        'db'=>array(
            'dbhost'        => 'localhost',
            'dbuser'        => 'root',
            'dbpasswd'      => '',
            'dbname'        => 'wordpress',
            'dbpconnect'    => 0,
            'dbchart'       => 'utf8'
        ),
        'db2'=>array(
            'dbhost'        => 'localhost',
            'dbuser'        => 'root',
            'dbpasswd'      => '',
            'dbname'        => 'joke',
            'dbpconnect'    => 0,
            'dbchart'       => 'utf8'
        )
    ),
    'session'=>array(
        'pre'               => 'blog',
        'timeout'           => 86400
    ),
    'memcache'=>array(
        'cache1' => array(
            'host'              => 'localhost',
            'port'              => '11211'
        )
    )
);
</pre>
5、默认控制层文件controllers/SiteController.php
调用默认方法actionIndex
<pre>
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
        // 默认是 $this->layout='main';
        // $this->layout='index';
        // 然后查看 views/site/index.php 文件 输出 <?=$username?>
        $this->render('index', array('username'=>$username));

        // mecache使用
        $tmp_object = new stdClass;
        $tmp_object->str_attr = 'test';
        $tmp_object->int_attr = 123;
        Wave::app()->memcache->cache1->set('key', $tmp_object, false, 30) 
        or die ("Failed to save data at the server");
        echo "Store data in the cache (data will expire in 30 seconds)";
        $get_result = Wave::app()->memcache->cache1->get('key');
        echo "Data from the cache:";
        print_r($get_result);

    }
}
</pre>

6、解析URL 比如说我 要调用 类似这样的URL /blog/index.php/site/index
<br>
index.php 可以通过rewrite去掉，这里就不讲了。<br>
site指SiteController.php，index指actionIndex<br>
如果是这样的/blog/index.php/site/index/aaa/bbb 那应该写成public function actionIndex($a, $b)<br>
$a 就是 aaa， $b 就是 bbb<br>

7、数据库 仅支持mysql数据库，参看demos/enterprise/protected/models/TestModel.php的sql用法，继承Model
<pre>
$like = array();
$like['content'] = '是';
$array = $this  ->select('*')
                ->from('articles')
                ->like($like)
                ->limit(0, 2)
                ->group('aid')
                ->order('aid')
                ->getAll();

$array = $this  ->select('*')
                ->from('articles')
                ->in("aid IN(2,3,4)")
                ->getAll();

$array = $this  ->select('*')
                ->from('articles a')
                ->join('category c', 'a.cid=c.cid')
                ->getAll();

$array = $this  ->select('*')
                ->from('category')
                ->getAll();

$data = array('c_name'=>'测试测试update');
var_dump($this->insert('category', $data));die;
var_dump($this->update('category', $data, "cid=4"));die;

return $array;
</pre>

8、session
session 怎么用？
<br>
存储：Wave::app()->session->setState('username', 'Ellen Xu');
<br>
获得：Wave::app()->session->getState('username');
<br>

9、验证码
输出验证码 echo $this->verifyCode(4);<br>
获得session的验证码，5分钟。 Wave::app()->session->getState('verifycode');

10、memcache
<br>
配置文件
<pre>
'memcache'=>array(
    'cache1' => array(
        'host'              => 'localhost',
        'port'              => '11211'
    )
)
</pre>
可以多个<br>
调用的时候 <br>
存储：Wave::app()->memcache->cache1->set('key', $tmp_object, false, 30)<br>
获得：Wave::app()->memcache->cache1->get('key')

以demos下enterprise为例，nginx配置如下：
<pre>
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
</pre>

.htaccess如下：
<pre>
<IfModule mod_rewrite.c>
  Options +FollowSymlinks
  RewriteEngine On

  RewriteCond %{REQUEST_FILENAME} !-d
  RewriteCond %{REQUEST_FILENAME} !-f
  RewriteRule ^(.*)$ index.php?/$1 [QSA,PT,L]
</IfModule>
</pre>

网站后台地址：http://127.0.0.1/admin.php 用户名：xuping  密码：123456

我用惯了YII框架，所以在很多功能上特像YII，虽然wavephp没有YII的功能全，大，但是一些常用的基本功能还是有的。希望大家多多提意见！QQ群：272919485
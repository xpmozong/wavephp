<?php
/**
 * 微信接口控制层
 */
class WxController extends Controller
{
    protected $gid;             // 公众账号管理ID
    protected $token;           // token
    protected $enaeskey;        // 加密key
    protected $appid;           // 公众账号id
    protected $appsecret;       // 公众账号密钥
    protected $appiseskey;      // 公众账号是否EncodingAESKey加密
    protected $Common;          // 公共类

    public function __construct()
    {
        parent::__construct();

        $this->Common = new Common();
        $data = $this->Common->getFilter($_GET);
        $array = $this->Common->getOneData('gh_manage', '*', 'gh_key', $data['key']);
        if ($array) {
            $this->gid = $array['gid'];
            $this->token = $array['gh_token'];
            $this->enaeskey = $array['gh_enaeskey'];
            $this->appid = $array['gh_appid'];
            $this->appsecret = $array['gh_appsecret'];
            $this->appiseskey = $array['gh_iseskey'];
        }
    }

    /**
     * 默认函数
     */
    public function actionIndex()
    {
        if (isset($_GET["echostr"])) {
            $echoStr = isset($_GET["echostr"]) ? $_GET["echostr"] : 'no echoStr';
            $this->Common->recordLog($this->token);
            if($this->checkSignature()){
                $this->Common->recordLog($echoStr);
                echo $echoStr;die;
            }
        }else{
            $this->responseMsg();
        }
    }


    /**
     * 接收/发送消息
     */
    public function responseMsg()
    {
        $postStr = $GLOBALS["HTTP_RAW_POST_DATA"];
        $this->Common->recordLog($postStr);
        if (!empty($postStr)){
            $signature = $_GET["signature"];
            $timestamp = $_GET["timestamp"];
            $nonce = $_GET["nonce"];
            $this->Common->recordLog('signature='.$signature);
            $this->Common->recordLog('timestamp='.$timestamp);
            $this->Common->recordLog('nonce='.$nonce);
            $msg = '';
            $wxMsgCrypt = new WXBizMsgCrypt($this->token, $this->enaeskey, 
                                        $this->appid);
            if ($this->appiseskey) {
                $errCode = $wxMsgCrypt->decryptMsg($signature, $timestamp, 
                                    $nonce, $postStr, $msg);
            }else{
                if($this->checkSignature()){
                    $errCode = 0;
                    $msg = $postStr;
                }else{
                    $errCode = 110;
                }
            }
            if ($errCode == 0) {
                $WxModel = new WxModel();
                $this->Common->recordLog($msg);
                libxml_disable_entity_loader(true);
                $postObj = simplexml_load_string($msg, 
                            'SimpleXMLElement', LIBXML_NOCDATA);
                $fromUsername = $postObj->FromUserName;
                $toUsername = $postObj->ToUserName;
                $MsgType = $postObj->MsgType;
                $Event = $postObj->Event;
                $this->Common->recordLog('MsgType='.$MsgType.' Event='.$Event);
                $keyword = trim($postObj->Content);
                $resultStr = $WxModel->fix($MsgType, $Event, $keyword, 
                            $fromUsername,$toUsername, $timestamp);
                $this->Common->recordLog($resultStr);
                if ($resultStr) {
                    $encryptMsg = '';
                    if ($this->appiseskey) {
                        $errCode = $wxMsgCrypt->encryptMsg($resultStr, $timestamp, 
                                            $nonce, $encryptMsg);
                    }else{
                        $errCode = 0;
                        $encryptMsg = $resultStr;
                    }
                    if ($errCode == 0) {
                        echo $encryptMsg;
                    } else {
                        $this->Common->recordLog('encryptMsg:errCode='.$errCode);
                    }
                }
            } else {
                $this->Common->recordLog('decryptMsg:errCode='.$errCode);
            }
        }else {
            echo "";
            exit;
        }
    }

    /**
     * 验证
     */
    private function checkSignature()
    {
        // you must define TOKEN by yourself
        if (!$this->token) {
            throw new Exception('TOKEN is not defined!');
        }
        
        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];
                
        $token = $this->token;
        $tmpArr = array($token, $timestamp, $nonce);
        // use SORT_STRING rule
        sort($tmpArr, SORT_STRING);
        $tmpStr = implode( $tmpArr );
        $tmpStr = sha1( $tmpStr );
        
        if( $tmpStr == $signature ){
            return true;
        }else{
            return false;
        }
    }

    /**
     * 自定义菜单
     */
    public function actionMenu()
    {
        $menu = $this->Common->getOneData('gh_menu', '*', 'gid', $this->gid);
        $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".
                $this->appid."&secret=".$this->appsecret."";
        $json = file_get_contents($url);
        $array = json_decode($json, true);
        if (!empty($array['access_token'])) {
            echo $array['access_token']."<br>";
            $url = "https://api.weixin.qq.com/cgi-bin/menu/create?access_token=".$array['access_token'];
            $curlPost = $menu['content'];
            $data = $this->Common->curl($url, $curlPost);
            $arr = json_decode($data, true);
            echo "<pre>";
            print_r($arr);die;
        }else{
            echo "wrong";
        }
    }

}

?>
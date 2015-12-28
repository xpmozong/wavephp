<?php
/**
 * 微信接口控制层
 */
class WxController extends Controller
{
    protected $token;
    protected $enaeskey;
    protected $appid;
    protected $appsecret;

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 默认函数
     */
    public function actionIndex()
    {
        $data = WaveCommon::getFilter($_GET);
        $GhManage = new GhManage();
        $WxModel = new WxModel();
        $array = $GhManage->getOne('*', array('gh_key'=>$data['key']));
        if ($array) {
            $this->token = $array['gh_token'];
            $this->enaeskey = $array['gh_enaeskey'];
            $this->appid = $array['gh_appid'];
            $this->appsecret = $array['gh_appsecret'];
        }

        $echoStr = isset($_GET["echostr"]) ? $_GET["echostr"] : 'no echoStr';
        $WxModel->recordLog($echoStr);
        if($this->checkSignature()){
            $WxModel->recordLog($echoStr);
            echo $echoStr;die;
        }
        die;
        $this->responseMsg();
    }


    public function responseMsg()
    {
        $wxMsgCrypt = new WXBizMsgCrypt($this->token, $this->enaeskey, 
                                        $this->appid);
        $Common = new Common();
        $WxModel = new WxModel();
        $postStr = $GLOBALS["HTTP_RAW_POST_DATA"];
        $WxModel->recordLog($postStr);
        if (!empty($postStr)){
            $signature = $_GET["signature"];
            $timestamp = $_GET["timestamp"];
            $nonce = $_GET["nonce"];
            $WxModel->recordLog('signature='.$signature);
            $WxModel->recordLog('timestamp='.$timestamp);
            $WxModel->recordLog('nonce='.$nonce);
            $msg = '';
            $errCode = $wxMsgCrypt->decryptMsg($signature, $timestamp, 
                                    $nonce, $postStr, $msg);
            if ($errCode == 0) {
                $WxModel = new WxModel();
                $WxModel->recordLog($msg);
                libxml_disable_entity_loader(true);
                $postObj = simplexml_load_string($msg, 
                            'SimpleXMLElement', LIBXML_NOCDATA);
                $fromUsername = $postObj->FromUserName;
                $toUsername = $postObj->ToUserName;
                $MsgType = $postObj->MsgType;
                $Event = $postObj->Event;
                $WxModel->recordLog('MsgType='.$MsgType.' Event='.$Event);
                $keyword = trim($postObj->Content);
                $resultStr = $WxModel->fix($MsgType, $Event, $keyword, 
                            $fromUsername,$toUsername, $timestamp);
                $WxModel->recordLog($resultStr);
                if ($resultStr) {
                    $encryptMsg = '';
                    $errCode = $wxMsgCrypt->encryptMsg($resultStr, $timestamp, 
                                            $nonce, $encryptMsg);
                    if ($errCode == 0) {
                        echo $encryptMsg;
                    } else {
                        $WxModel->recordLog('encryptMsg:errCode='.$errCode);
                    }
                }
            } else {
                $WxModel->recordLog('decryptMsg:errCode='.$errCode);
            }
        }else {
            echo "";
            exit;
        }
    }

    private function checkSignature()
    {
        // you must define TOKEN by yourself
        if (!$this->token) {
            throw new Exception('TOKEN is not defined!');
        }
        
        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];
        
        // $WxModel = new WxModel();
        // $WxModel->recordLog($signature.'_'.$timestamp.'_'.$nonce);

        $token = $this->token;
        $tmpArr = array($token, $timestamp, $nonce);
        // use SORT_STRING rule
        sort($tmpArr, SORT_STRING);

        $tmpStr = implode( $tmpArr );
        $tmpStr = sha1( $tmpStr );
        
        // $WxModel->recordLog($tmpStr);

        if( $tmpStr == $signature ){
            return true;
        }else{
            return false;
        }
    }
}

?>
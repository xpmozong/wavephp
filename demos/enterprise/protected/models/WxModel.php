<?php
class WxModel{

    public function fix($MsgType, $Event, $keyword, $fromUsername, 
                            $toUsername, $timestamp)
    {
        $resultStr = '';
        switch ($MsgType) {
            case 'text':
            {
                $resultStr = $this->fixText($keyword, $fromUsername, 
                            $toUsername, $timestamp);
                break;
            }
            case 'event':
            {
                switch ($Event) {
                    case 'subscribe':
                    {
                        $resultStr = $this->echoWelcome($fromUsername, 
                                    $toUsername, $timestamp);
                        break;
                    }
                    default:
                        break;
                }
                break;
            }
            default:
                break;
        }

        return $resultStr;
    }

    /**
     * 关注欢迎
     */
    public function echoWelcome($fromUsername, $toUsername, $timestamp)
    {
        $textTpl = "<xml>
<ToUserName><![CDATA[%s]]></ToUserName>
<FromUserName><![CDATA[%s]]></FromUserName>
<CreateTime>%s</CreateTime>
<MsgType><![CDATA[%s]]></MsgType>
<Content><![CDATA[%s]]></Content>
</xml>";
        $msgType = "text";
        $contentStr = "谢谢关注！";
        $resultStr = sprintf($textTpl, $fromUsername, 
                            $toUsername, $timestamp, 
                            $msgType, $contentStr);

        return $resultStr;
    }

    public function fixText($keyword, $fromUsername, $toUsername, $timestamp)
    {
        $textTpl = "<xml>
<ToUserName><![CDATA[%s]]></ToUserName>
<FromUserName><![CDATA[%s]]></FromUserName>
<CreateTime>%s</CreateTime>
<MsgType><![CDATA[%s]]></MsgType>
<Content><![CDATA[%s]]></Content>
</xml>";
        $msgType = "text";
        $contentStr = $keyword;
        $resultStr = sprintf($textTpl, $fromUsername, 
                            $toUsername, $timestamp, 
                            $msgType, $contentStr);

        return $resultStr;
    }

    public function fixEvent($MsgType, $fromUsername, $toUsername, $timestamp)
    {
        
    }

}
?>
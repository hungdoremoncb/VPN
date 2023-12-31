<?php

namespace Wechat;

use Wechat\Lib\Common;
use Wechat\Lib\Tools;

class WechatCustom extends Common {

    /** 多cskh相关地址 */
    const CUSTOM_SERVICE_GET_RECORD = '/customservice/getrecord?';
    const CUSTOM_SERVICE_GET_KFLIST = '/customservice/getkflist?';
    const CUSTOM_SERVICE_GET_ONLINEKFLIST = '/customservice/getonlinekflist?';
    const CUSTOM_SESSION_CREATE = '/customservice/kfsession/create?';
    const CUSTOM_SESSION_CLOSE = '/customservice/kfsession/close?';
    const CUSTOM_SESSION_SWITCH = '/customservice/kfsession/switch?';
    const CUSTOM_SESSION_GET = '/customservice/kfsession/getsession?';
    const CUSTOM_SESSION_GET_LIST = '/customservice/kfsession/getsessionlist?';
    const CUSTOM_SESSION_GET_WAIT = '/customservice/kfsession/getwaitcase?';
    const CS_KF_ACCOUNT_ADD_URL = '/customservice/kfaccount/add?';
    const CS_KF_ACCOUNT_UPDATE_URL = '/customservice/kfaccount/update?';
    const CS_KF_ACCOUNT_DEL_URL = '/customservice/kfaccount/del?';
    const CS_KF_ACCOUNT_UPLOAD_HEADIMG_URL = '/customservice/kfaccount/uploadheadimg?';

    /**
     * 获取多cskh会话记录
     * @param array $data 数据结构 {"starttime":123456789,"endtime":987654321,"openid":"OPENID","pagesize":10,"pageindex":1,}
     * @return bool|array
     */
    public function getCustomServiceMessage($data) {
        if (!$this->access_token && !$this->getAccessToken()) {
            return false;
        }
        $result = Tools::httpPost(self::API_URL_PREFIX . self::CUSTOM_SERVICE_GET_RECORD . "access_token={$this->access_token}", Tools::json_encode($data));
        if ($result) {
            $json = json_decode($result, true);
            if (!$json || !empty($json['errcode'])) {
                $this->errCode = $json['errcode'];
                $this->errMsg = $json['errmsg'];
                return false;
            }
            return $json;
        }
        return false;
    }

    /**
     * 获取多cskhcskh基本信息
     *
     * @return bool|array
     */
    public function getCustomServiceKFlist() {
        if (!$this->access_token && !$this->getAccessToken()) {
            return false;
        }
        $result = Tools::httpGet(self::API_URL_PREFIX . self::CUSTOM_SERVICE_GET_KFLIST . "access_token={$this->access_token}");
        if ($result) {
            $json = json_decode($result, true);
            if (!$json || !empty($json['errcode'])) {
                $this->errCode = $json['errcode'];
                $this->errMsg = $json['errmsg'];
                return $this->checkRetry(__FUNCTION__, func_get_args());
            }
            return $json;
        }
        return false;
    }

    /**
     * 获取多cskh在线cskh接待信息
     *
     * @return bool|array
     */
    public function getCustomServiceOnlineKFlist() {
        if (!$this->access_token && !$this->getAccessToken()) {
            return false;
        }
        $result = Tools::httpGet(self::API_URL_PREFIX . self::CUSTOM_SERVICE_GET_ONLINEKFLIST . "access_token={$this->access_token}");
        if ($result) {
            $json = json_decode($result, true);
            if (!$json || !empty($json['errcode'])) {
                $this->errCode = $json['errcode'];
                $this->errMsg = $json['errmsg'];
                return $this->checkRetry(__FUNCTION__, func_get_args());
            }
            return $json;
        }
        return false;
    }

    /**
     * 创建指定多cskh会话
     * @tutorial 当用户已被其他cskh接待或指定cskh不在线则会失败
     * @param string $openid //用户openid
     * @param string $kf_account //cskh账号
     * @param string $text //附加信息，文本会展示在cskh人员的多cskh客户端，可为空
     * @return bool|array
     */
    public function createKFSession($openid, $kf_account, $text = '') {
        $data = array("openid" => $openid, "kf_account" => $kf_account);
        if ($text) {
            $data["text"] = $text;
        }
        if (!$this->access_token && !$this->getAccessToken()) {
            return false;
        }
        $result = Tools::httpPost(self::API_BASE_URL_PREFIX . self::CUSTOM_SESSION_CREATE . "access_token={$this->access_token}", Tools::json_encode($data));
        if ($result) {
            $json = json_decode($result, true);
            if (!$json || !empty($json['errcode'])) {
                $this->errCode = $json['errcode'];
                $this->errMsg = $json['errmsg'];
                return $this->checkRetry(__FUNCTION__, func_get_args());
            }
            return $json;
        }
        return false;
    }

    /**
     * 关闭指定多cskh会话
     * @tutorial 当用户被其他cskh接待时则会失败
     * @param string $openid //用户openid
     * @param string $kf_account //cskh账号
     * @param string $text //附加信息，文本会展示在cskh人员的多cskh客户端，可为空
     * @return bool | array            //成功返回json数组
     * {
     *   "errcode": 0,
     *   "errmsg": "ok",
     * }
     */
    public function closeKFSession($openid, $kf_account, $text = '') {
        $data = array("openid" => $openid, "kf_account" => $kf_account);
        if ($text) {
            $data["text"] = $text;
        }
        if (!$this->access_token && !$this->getAccessToken()) {
            return false;
        }
        $result = Tools::httpPost(self::API_BASE_URL_PREFIX . self::CUSTOM_SESSION_CLOSE . "access_token={$this->access_token}", Tools::json_encode($data));
        if ($result) {
            $json = json_decode($result, true);
            if (!$json || !empty($json['errcode'])) {
                $this->errCode = $json['errcode'];
                $this->errMsg = $json['errmsg'];
                return $this->checkRetry(__FUNCTION__, func_get_args());
            }
            return $json;
        }
        return false;
    }

    /**
     * 获取用户会话状态
     * @param string $openid //用户openid
     * @return bool | array            //成功返回json数组
     * {
     *     "errcode" : 0,
     *     "errmsg" : "ok",
     *     "kf_account" : "test1@test",    //正在接待的cskh
     *     "createtime": 123456789,        //会话接入时间
     *  }
     */
    public function getKFSession($openid) {
        if (!$this->access_token && !$this->getAccessToken()) {
            return false;
        }
        $result = Tools::httpGet(self::API_BASE_URL_PREFIX . self::CUSTOM_SESSION_GET . "access_token={$this->access_token}" . '&openid=' . $openid);
        if ($result) {
            $json = json_decode($result, true);
            if (!$json || !empty($json['errcode'])) {
                $this->errCode = $json['errcode'];
                $this->errMsg = $json['errmsg'];
                return $this->checkRetry(__FUNCTION__, func_get_args());
            }
            return $json;
        }
        return false;
    }

    /**
     * 获取指定cskh的会话列表
     * @param string $kf_account //用户openid
     * @return bool | array            //成功返回json数组
     *  array(
     *     'sessionlist' => array (
     *         array (
     *             'openid'=>'OPENID',             //客户 openid
     *             'createtime'=>123456789,  //会话创建时间，UNIX 时间戳
     *         ),
     *         array (
     *             'openid'=>'OPENID',             //客户 openid
     *             'createtime'=>123456789,  //会话创建时间，UNIX 时间戳
     *         ),
     *     )
     *  )
     */
    public function getKFSessionlist($kf_account) {
        if (!$this->access_token && !$this->getAccessToken()) {
            return false;
        }
        $result = Tools::httpGet(self::API_BASE_URL_PREFIX . self::CUSTOM_SESSION_GET_LIST . "access_token={$this->access_token}" . '&kf_account=' . $kf_account);
        if ($result) {
            $json = json_decode($result, true);
            if (!$json || !empty($json['errcode'])) {
                $this->errCode = $json['errcode'];
                $this->errMsg = $json['errmsg'];
                return $this->checkRetry(__FUNCTION__, func_get_args());
            }
            return $json;
        }
        return false;
    }

    /**
     * 获取未接入会话列表
     * @return bool|array
     */
    public function getKFSessionWait() {
        if (!$this->access_token && !$this->getAccessToken()) {
            return false;
        }
        $result = Tools::httpGet(self::API_BASE_URL_PREFIX . self::CUSTOM_SESSION_GET_WAIT . "access_token={$this->access_token}");
        if ($result) {
            $json = json_decode($result, true);
            if (!$json || !empty($json['errcode'])) {
                $this->errCode = $json['errcode'];
                $this->errMsg = $json['errmsg'];
                return $this->checkRetry(__FUNCTION__, func_get_args());
            }
            return $json;
        }
        return false;
    }

    /**
     * 添加cskh账号
     *
     * @param string $account 完整cskh账号(账号前缀@公众号微信号，账号前缀最多10个字符)
     * @param string $nickname cskh昵称，最长6个汉字或12个英文字符
     * @param string $password cskh账号明文登录密码，会自动加密
     * @return bool|array
     */
    public function addKFAccount($account, $nickname, $password) {
        $data = array("kf_account" => $account, "nickname" => $nickname, "password" => md5($password));
        if (!$this->access_token && !$this->getAccessToken()) {
            return false;
        }
        $result = Tools::httpPost(self::API_BASE_URL_PREFIX . self::CS_KF_ACCOUNT_ADD_URL . "access_token={$this->access_token}", Tools::json_encode($data));
        if ($result) {
            $json = json_decode($result, true);
            if (!$json || !empty($json['errcode'])) {
                $this->errCode = $json['errcode'];
                $this->errMsg = $json['errmsg'];
                return $this->checkRetry(__FUNCTION__, func_get_args());
            }
            return $json;
        }
        return false;
    }

    /**
     * 修改cskh账号信息
     *
     * @param string $account //完整cskh账号，格式为：账号前缀@公众号微信号，账号前缀最多10个字符，必须是英文或者数字字符
     * @param string $nickname //cskh昵称，最长6个汉字或12个英文字符
     * @param string $password //cskh账号明文登录密码，会自动加密
     * @return bool|array
     * 成功返回结果
     * {
     *   "errcode": 0,
     *   "errmsg": "ok",
     * }
     */
    public function updateKFAccount($account, $nickname, $password) {
        $data = array("kf_account" => $account, "nickname" => $nickname, "password" => md5($password));
        if (!$this->access_token && !$this->getAccessToken()) {
            return false;
        }
        $result = Tools::httpPost(self::API_BASE_URL_PREFIX . self::CS_KF_ACCOUNT_UPDATE_URL . "access_token={$this->access_token}", Tools::json_encode($data));
        if ($result) {
            $json = json_decode($result, true);
            if (!$json || !empty($json['errcode'])) {
                $this->errCode = $json['errcode'];
                $this->errMsg = $json['errmsg'];
                return $this->checkRetry(__FUNCTION__, func_get_args());
            }
            return $json;
        }
        return false;
    }

    /**
     * 删除cskh账号
     * @param string $account 完整cskh账号(账号前缀@公众号微信号，账号前缀最多10个字符)
     * @return bool|array
     */
    public function deleteKFAccount($account) {
        if (!$this->access_token && !$this->getAccessToken()) {
            return false;
        }
        $result = Tools::httpGet(self::API_BASE_URL_PREFIX . self::CS_KF_ACCOUNT_DEL_URL . "access_token={$this->access_token}" . '&kf_account=' . $account);
        if ($result) {
            $json = json_decode($result, true);
            if (!$json || !empty($json['errcode'])) {
                $this->errCode = $json['errcode'];
                $this->errMsg = $json['errmsg'];
                return $this->checkRetry(__FUNCTION__, func_get_args());
            }
            return $json;
        }
        return false;
    }

    /**
     * 上传cskh头像
     * @param string $account 完整cskh账号(账号前缀@公众号微信号，账号前缀最多10个字符)
     * @param string $imgfile 头像文件完整路径,如：'D:\user.jpg'。头像文件必须JPG格式，像素建议640*640
     * @return bool|array
     */
    public function setKFHeadImg($account, $imgfile) {
        if (!$this->access_token && !$this->getAccessToken()) {
            return false;
        }
        $result = Tools::httpPost(self::API_BASE_URL_PREFIX . self::CS_KF_ACCOUNT_UPLOAD_HEADIMG_URL . "access_token={$this->access_token}" . '&kf_account=' . $account, array('media' => '@' . $imgfile), true);
        if ($result) {
            $json = json_decode($result, true);
            if (!$json || !empty($json['errcode'])) {
                $this->errCode = $json['errcode'];
                $this->errMsg = $json['errmsg'];
                return $this->checkRetry(__FUNCTION__, func_get_args());
            }
            return $json;
        }
        return false;
    }

}

<?php
/**
 * Created by PhpStorm.
 * User: kindness
 * Date: 2019/3/3
 * Time: 11:29
 * 主动微信公众号请求类
 */
class WeChat{
    const APPID = 'wx6e3834b70a844e94';
    const SECRET = '4abe033c8a145f1c4ccee39e2656af56';

    //接口数组
    private $config = [];

    public function __construct()
    {
        $this->config = include 'apiConfig.php';
    }

    //获取access_token值
    public function getAccessToken(){
        //判断请求中是否有access_token的值
        //如果有,读缓存,没有则请求接口,写入缓存并返回结果

        $url = sprintf($this->config['access_token_url'],self::APPID,self::SECRET);
        //发送请求,获取返回数据
        return $this->myCurl($url);
    }

    //得到memcache对象
    private function mem(){
        $mem = new Memcache();
        $mem->addServer('127.0.0.1',11211);
        return $mem;
    }

    //封装curl请求类
    private function myCurl($url,$is_post = 0){
        //初始化curl
        $ch = curl_init();
        //设置请求地址
        curl_setopt($ch,CURLOPT_URL,$url);
        //设置返回的结果不直接输出
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
        //取消https证书验证
        curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,0);
        curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,0);
        //设置请求的超时时间
        curl_setopt($ch,CURLOPT_TIMEOUT,10);
        //模拟一个浏览器型号
        curl_setopt($ch,CURLOPT_USERAGENT,'MSIE');
        //判断请求方式
        if ($is_post == 1){
            //post请求
            curl_setopt($ch,CURLOPT_POST,1);
        }
        //发送请求
        $data = curl_exec($ch);
        //关闭资源
        curl_close($ch);
        //返回结果
        return $data;

    }
}
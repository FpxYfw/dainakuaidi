<?php

namespace App\Services;


class CurlService
{
    public $url = '';
    public $method;
    public $params = [];

    public function init($url, $method, $params)
    {
        $this->url = $url;
        $this->method = $method;
        $this->params = $params;

        return $this;
    }

    public function judge($method)
    {
       switch ($this->method) {
            case 'get':
                $res = $this->curl_get($this->url);
                break;
            case 'post':
                $res = $this->curl_post($this->url,$this->params);
                break;
       }
       return $res;
    }

    public function curl_get($url)
    {
        // 开启一个会话
        $ch = curl_init($url);
        
        // 拼接完整的 url 
        $url = $this->getRequest($this->url,$this->params);

        // 跳过证书验证
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        // 不验证主机
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        // 获取url
        curl_setopt($ch, CURLOPT_URL, $url);

        //  执行
        $result = json_decode(curl_exec($ch),true);
        
        // $res = curl_getinfo($ch,CURLINFO_HTTP_CODE);
        // 检查是否有错误发生
		if($i = curl_errno($ch))
		{
		    $result = [
		    	'errno' => $i,
		    	'info'    => 'request error['.$i.']: ' . curl_error($ch)
		    ];
        }
        
        // 关闭资源
        curl_close($ch);

        return $result;
    }

    public function getRequest($url,$params){
		if(!empty($this->params) && is_array($this->params)){
			$this->url .= '?';
			$count = 1;
			foreach($this->params as $k => $v){
				if($count == 1){
					$this->url .= $k .'='. $v;
					$count++;
				}else{
					$this->url .= '&'.$k .'='. $v;
				}
				
			}
		}

		return $this->url;
	}

    public function curl_post($url, $params)
    {
        // 开启一个会话
        $ch = curl_init();
        

        // 跳过证书验证
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        // 不验证主机
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        //设置post方式提交
        curl_setopt($ch, CURLOPT_POST, 1);
        //设置全部数据以post提交
		curl_setopt($ch, CURLOPT_POSTFIELDS, $this->params);
        // 获取url
        curl_setopt($ch, CURLOPT_URL, $this->url);
        //  执行
        $result = curl_exec($ch);
        
        // 检查是否有错误发生
		if($i = curl_errno($ch))
		{
		    $result = [
		    	'errno' => $i,
		    	'info'    => 'request error['.$i.']: ' . curl_error($ch)
		    ];
        }
        
        // 关闭资源
        curl_close($ch);

        return $result;
    }
}
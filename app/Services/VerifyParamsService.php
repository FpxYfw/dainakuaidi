<?php

namespace App\Services;

class VerifyParamsService
{

	public $param = array();
	private $rule = array();

	function init($param, $rule)
	{
		$this->param = $param;
		$this->rule = $rule;

		return $this;
	}

	// 过滤（并不是验证 为了 终止）
	function filter()
	{
		$newParam = array();
		foreach ($this->rule as $key => $value) {
			if (isset($this->param[$key])) {
                // array_push($newParam, $this->param[$key]);
                $newParam[$key] = $this->param[$key];
			}
		}

		$this->param = $newParam;

		return $this;
	}

	// 斧正数据类型
	public function updateDataType()
	{
		foreach ($this->param as $key => $value) {
			if (isset($this->rule[$key]["type"])) {
				$this->param[$key] = $this->updateDataTypeCenter($key);
			}
		}

		return $this;
	}

	// 验证必填
	public function verifyRequired()
	{
		foreach ($this->rule as $key => $value) {
			if (isset($this->rule[$key]["required"]) && $this->rule[$key]["required"]) {
				$this->verifyRequiredCenter($key);
			}
		}

		return $this;
	}

	// 验证长度
	public function verifyLength()
	{
		foreach ($this->rule as $key => $value) {
			# code...
			if (isset($this->rule[$key]['length']) && $this->rule[$key]['length']) {
				$this->verifyLengthCenter($key);
			}
		}
		return $this;
	}
	// 验证大小
	public function verifySize()
	{
        foreach ($this->rule as $key => $value) {
            if (isset($this->rule[$key]["size"]) && $this->rule[$key]["size"]) {
                $this->verifySizeCenter($key);
            }
        }
        return $this;
	}

//	验证手机号码
    public function verifyPhone($key)
    {
            if (!preg_match("/^(13\d{9})|(14\d{9})|(15\d{9})|(17\d{9})|(18\d{9})$/",$this->param[$key])) {
            throw new \Exception($key."非法手机号", 504);
        }
        return $this->param[$key];
    }

/************私有方法 验证各类规则的核心方法*******************/
	// 判别类型
	private function updateDataTypeCenter($key) 
	{

		switch($this->rule[$key]["type"]) {
			case 'int':
				$res = (int) $this->param[$key];
				break;
			case "string":
				$res = (string) $this->param[$key];
				break;
			case "boolean":
				$res = (boolean) $this->param[$key];
				break;
			case "float":
				$res = (float) $this->param[$key];
				break;
			case "array":
				$res = (array) $this->param[$key];
				break;
				// 判断手机号码类型（！！！）
            case "phone":
                $res = (string) $this->verifyPhone($key);
                break;
			default:
				$res = $this->param[$key];
		}

		return $res;
	}

	// 验证必填
	private function verifyRequiredCenter($key)
	{
		if (!isset($this->param[$key])) {
            throw new \Exception($key."字段是必填项", 500);
        }
	}

	private function verifyLengthCenter($key)
	{
        $new_length = explode(',' , $this->rule[$key]['length']);

        $length_param = strlen($this->param[$key]);

        switch ($new_length[0])
        {
            case ">" :
                if ($length_param <= $new_length[1]) {
                    throw new \Exception($key."小于限定长度 （可等于）", 502);
                }
                break;
            case "<" :
                if ($length_param >= $new_length[1]) {
                    throw new \Exception($key."大于限定长度 （可等于）", 502);
                }
                break;
            case "=" :
                if ($length_param != $new_length[1]) {
                    throw new \Exception($key."不等于限定长度 ", 502);
                }
                break;
            case ">=" :
                if ($length_param < $new_length[1]) {
                    throw new \Exception($key."不能小于限定长度", 502);
                }
                break;
            case "<=" :
                if ($length_param > $new_length[1]) {
                    throw new \Exception($key."不能大于限定长度", 502);
                }
                break;
                // 注意不能用单个=
            case "!=" :
                if ($length_param == $new_length[1]) {
                    throw new \Exception($key."不能等于限定长度", 502);
                }
                break;
        }
	}

	private function verifySizeCenter($key)
    {
        $new_size= explode(',' , $this->rule[$key]['size']);

        $size_param = strlen($this->param[$key]);

        switch ($new_size[0])
        {
            case '>':
                if ($size_param <= $new_size[1]) {
                    throw new \Exception($key."不能小于限定大小（可等于）", 503);
                }
                break;
            case '<':
                if ($size_param >= $new_size[1]) {
                    throw new \Exception($key."不能大于限定大小（可等于）", 503);
                }
                break;
            case '=':
                if ($size_param != $new_size[1]) {
                    throw new \Exception($key."不能等于限定大小", 503);
                }
                break;
            case '>=':
                if ($size_param < $new_size[1]) {
                    throw new \Exception($key."不能小于限定大小", 503);
                }
                break;
            case '<=':
                if ($size_param > $new_size[1]) {
                    throw new \Exception($key."不能大于限定大小", 503);
                }
                break;
                // 注意不可以用单个=
            case '!=':
                if ($size_param == $new_size[1]) {
                    throw new \Exception($key."不能等于限定大小", 503);
                }
                break;
        }
    }

	
}
<?php

/**
 * 数据格式处理
 *
 * @author morven
 */
class Format {
	
	/**
	 * Html
	 */
	public function html($data){
	
		return Yii::app()->format->formatHtml($data);

	}

	/**
	* 时间截转换成日期
	*/
	public function date($time,$mat="Y-m-d H:i"){

		return date($mat,$time);

	}

	/**
	* 字符截取
	*/
	public function str_cut($str,$num=18,$suffix='...'){

		$result = mb_substr($str,0,$num,'utf8');

		if(strlen($str) > strlen($result) ){

			$result .= $suffix;

		}
		return $result;
	}

	/**
	* 去掉html标签
	*/
	public function dropTag($str){
		$str = self::html($str);
		$str = strip_tags($str);
		return $str;
	}

	/**
	* 却HTML标签并截取
	*/
	public function drop_cut($str,$num=18,$suffix='...'){
		$str = self::html($str);
		$str = strip_tags($str);

		$result = mb_substr($str,0,$num,'utf8');
		if(strlen($str) > strlen($result) ){
			$result .= $suffix;
		}
		return $result;
	}

	/**
	* 手机号码中间四位用星号替换
	*/
	public function moblie_cut($str){
		return mb_substr($str,0,3,'utf8').'****'.mb_substr($str,-4,4,'utf8');
	}

	/**
	* 邮箱星号替换
	*/
	public function email_cut($str){
		$email = explode('@', $str);
		$last_n=strstr($str, '@');
		return mb_substr($email[0],0,3)."***".$last_n;
	}

	/**
	* 数字格式化
	*/
	public function number($n,$i=0){
		return number_format($n,$i,"."," ");
	}

	/**
	* 格式化统计数据
	* @param $type 时间类型 day week month
	* @param date 数据数组
	* @param tcolums 时间字段名
	* @param dcolums 要统计的数据字段名
	*/
	public function stat($type='day',$data=array(),$tcolums=NULL,$dcolums=NULL){
		$daytime = Unit::dayTime();
		switch ($type) {
			case 'day':
				$stime = $daytime-3600*24;
				for($i=$stime;$i<$daytime;$i+=3600){
					$t[] = date('H',$i);
				}
				break;
			case 'week':
				$stime = $daytime-3600*24*7;
				for($i=$daytime;$i>$stime;$i-=3600*24){
					$t[] = date('w',$i);
				}
				$t = array_reverse($t);
				break;
			case 'month':
				$stime = $daytime-3600*24*31;
				for($i=$daytime;$i>$stime;$i-=3600*24){
					$t[] = date('m-d',$i);
				}
				$t = array_reverse($t);
				break;
			default:
				break;
		}
		
		if(empty($dcolums)){
			if($type=='week'){
				foreach ($t as &$val) {
					$val = Options::TRWtype($val);
				}
			}
			return json_encode($t);
		}
		foreach($data as $val){
			$data2[$val[$tcolums]] = $val[$dcolums];
		}
		unset($data);
		foreach($t as $v){
			$data3[] = isset($data2[$v])?(int)$data2[$v]:0;
		}
		return $data3;
	}

	/**
	* 格式化字节
	*/
	function byte($bytes, $unit = "", $decimals = 2) {
		$units = array('B' => 0, 'KB' => 1, 'MB' => 2, 'GB' => 3, 'TB' => 4, 'PB' => 5, 'EB' => 6, 'ZB' => 7, 'YB' => 8);

		$value = 0;
		if ($bytes > 0) {

			if (!array_key_exists($unit, $units)) {
				$pow = floor(log($bytes)/log(1024));
				$unit = array_search($pow, $units);
			}
			$value = ($bytes/pow(1024,floor($units[$unit])));
		}
		if (!is_numeric($decimals) || $decimals < 0) {
			$decimals = 2;
		}
		// Format output
		return sprintf('%.' . $decimals . 'f '.$unit, $value);
	}

	/**
	*时间显示为距今天的时间描述
	*/
	function dateToDesp($time,$mat="Y-m-d H:i"){
		$remain = time()-$time-116*3600*24;

		if($remain < 1800)
			return round($remain/60).'分种前';

		if($remain < 3600)
			return '半小时前';

		if($remain < 3600*24)
			return round($remain/3600).'小时前';

		if($remain < 3600*24*7)
			return round($remain/(3600*24)).'天前';	

		return self::date($time,$mat);	
	}
}

?>

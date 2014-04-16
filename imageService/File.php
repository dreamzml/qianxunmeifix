<?php

/**
 * Description of Tool
 *
 * @author morven
 */
class File {
	
	/**
	 * 删除上传文件
	 * @param type $name
	 * @param type $path 
	 */
	public static function delFile($path) {
		if(is_file($path))
			return @unlink($path);
		else 
			return true;
	}
	
    /**
    *创建目录，
    * @param path 要创建目录的绝对路径
    * @param base 目录的基本目录，从些目录开始递归创建，因为基层目录可能无权限
    */
	public function makeDir ( $path,$base, $permissions = 0777 )
	{        
		$result = array();
		while( $base != dirname( $path) ) {
			array_push( $result, $path );
			$path = dirname( $path );
		}
		sort( $result );
		foreach( $result as $directory ) {
			if ( !file_exists( $directory ) ){
                @mkdir( $directory, $permissions );
                chmod($directory, 0777);
            }
			//if ( !file_exists( $directory ) ) return false;
		}
		return true;
	}

    /**
    * 判断文件是否存在
    * @param url 文件的绝对路径
    */
    static public function isfile($url) {
        $isfile = get_headers($url);
        foreach ($isfile as $str) {
            $isfilestr.=$str;
        }
        $pos = strpos($isfilestr, "Content-Type: image/");
        if ($pos > 0) {
            $result = true;
        } else {
            $result = false;
        }
        return $result;
    }

    /**
     * 删除目录下的所有内容
     * @param 目录的绝对路径
     */
    function delDir($dir) {
        if ($items = glob($dir . "/*")) {
            foreach ($items as $obj) {
                is_dir($obj) ? deleteDir($obj) : unlink($obj);
            }
        }
        rmdir($dir);
    }

    /**
    * 列出目录下的所有文件
    * @param 目录名称
    */
    function listFile($dir) {
        $fileArray = array();
        $cFileNameArray = array();
        if ($handle = opendir($dir)) {
            while (($file = readdir($handle)) !== false) {
                if ($file != "." && $file != "..") {
                    if (is_dir($dir . "\\" . $file)) {
                        $cFileNameArray = self::listFile($dir . "\\" . $file);
                        for ($i = 0; $i < count($cFileNameArray); $i++) {
                            $fileArray[] = $cFileNameArray[$i];
                        }
                    } else {
                        $fileArray[] = $file;
                    }
                }
            }

            return $fileArray;
        } else {
            echo "listFile出错了";
        }
    }

    /**
    * 格式化相对路径
    * @param path路径
    */
    function formatDir($path)
    {
        //转换dos路径为*nix风格
        $path=str_replace('\\','/',$path);
        //替换$path中的 /xxx/../ 为 / ，直到替换后的结果与原串一样（即$path中没有/xxx/../形式的部分）
        $last='';
        while($path!=$last){
            $last=$path;
            $path=preg_replace('/\/[^\/]+\/\.\.\//','/',$path);
        }
        //替换掉其中的 ./ 部分 及 //  部分
        $last='';
        while($path!=$last){
            $last=$path;
            $path=preg_replace('/([\.\/]\/)+/','/',$path);
        }
        return $path;
    }

    /**
    *生成hash码
    */
    public function hash($lenth=6){
        $chars = '123456789abcdefghijklmnpqrstuvwxyzABCDEFGHIJKLMNPQRSTUVWXYZ';
        $hash = '';
        $max = strlen($chars) - 1;
        for($i = 0; $i < $lenth; $i++) {
            $hash .= $chars[mt_rand(0, $max)];
        }
        return $hash;
    }
}

?>

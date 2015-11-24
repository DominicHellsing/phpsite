<?php 
//安装程序
@set_time_limit(0);
error_reporting(E_ALL & ~E_NOTICE);
header('Content-Type: text/html; charset=UTF-8');
define('ROOT', dirname(__FILE__));
define('HomeUrl', substr($_SERVER['PHP_SELF'], 0, stripos($_SERVER['PHP_SELF'], '/install')) );

//常量定义
$HomeUrl = substr($_SERVER['PHP_SELF'], 0, stripos($_SERVER['PHP_SELF'], '/install'));
$Css = "./Tpl/Public/css";
$Images = "./Tpl/Public/images";
$InstallLock = '../install.lock';
$DbSql = "./db.sql";
$DbDataSql = "./dbData.sql";
$ErrMsg = "";
$dbFile = "../App/Conf/db.php";
$copyFile = "../App/Conf/copy.php";
$Step = $_GET['Step'];  //当前安装步骤

//检查是否已经安装=========================================
if($Step != 4){  //第四步已经安装完成
	if (file_exists($InstallLock)){
		$ErrMsg = "系统已成功安装！";
		include_once './Tpl/error.html';
		exit;
	}
}
//====================================================

$InstallMsg = "<br/>本软件运行环境为：PHP5.2 + Mysql5.0 + Zend Optimizer 3.3.3";
if ( version_compare(phpversion(), '5.3.0', '>=') ) {
	$ErrMsg = "您的PHP版本是".phpversion()."，PHP版本过高，不能安装本软件！".$InstallMsg;
	include_once './Tpl/error.html';
	exit;
}

if ( version_compare(phpversion(), '5.2.0', '<') ) {
	$ErrMsg = "您的PHP版本是".phpversion()."，PHP版本过低，不能安装本软件！".$InstallMsg;
	include_once './Tpl/error.html';
	exit;
}

if( false === extension_loaded('Zend Optimizer') ){
	$ErrMsg = "您的服务器不支持Zend Optimizer 3.3.3，请安装！".$InstallMsg;
	include_once './Tpl/error.html';
	exit;
}

if(!file_exists($DbSql) || !file_exists($copyFile) ){
	$ErrMsg = "缺少必要的安装文件!";
	include_once './Tpl/error.html';
	exit;
}

if( file_exists($copyFile) ){
	$cmsinfo = include_once ( $copyFile );
	$CMSName = $cmsinfo['CMSNameNo'];
	$CompanyFullName = $cmsinfo['CompanyFullName'];
	$CompanyUrl = $cmsinfo['CompanyUrl'];
}

switch($Step){
	case '1': //第一步：检查系统配置
		//name项目, r系统所需配置, b最佳配置, current当前配置
		$cp_items = array(
				0 => array('name' => '操作系统', 'list' => 'os', 'c' => 'PHP_OS', 'r' => '不限', 'b' => 'Linux'),
				1 => array('name' => 'PHP', 'list' => 'php', 'c' => 'PHP_VERSION', 'r' => '5.2', 'b' => '5.2'),
				2 => array('name' => '上传配置', 'list' => 'upload', 'r' => '不限', 'b' => '5M'),
				3 => array('name' => 'GD库', 'list' => 'gdversion', 'r' => '2.0', 'b' => '2.0'),
				4 => array('name' => '磁盘空间', 'list' => 'disk', 'r' => '20M', 'b' => '不限'),
		);
		 
		$dir_items = array(
				0 => array('type' => 'file', 'path' => '../Upload/' ),
				1 => array('type' => 'file', 'path' => '../App/Conf'),
				//2 => array('type' => 'file', 'path' => '../App/Html'),
				2 => array('type' => 'file', 'path' => '../App/Runtime'),
		);
		 
		$func_items = array(
				0 => array('name' => 'mysql_connect'),
				1 => array('name' => 'mb_strlen'),
				2 => array('name' => 'fsockopen'),
				//3 => array('name' => 'gethostbyname'),
				3 => array('name' => 'xml_parser_create'),
				4 => array('name' => 'simplexml_load_file'),
		);
		$SystemInfo = syscheck($cp_items);
		$DirInfo = dircheck($dir_items);
		$FunctionInfo=function_check($func_items);
		include_once ("./Tpl/step1.html");
		ob_flush();
		flush();
		
		foreach($DirInfo as $d){
			if($d['status'] != 1){
				echo '<script type="text/javascript">DisableNext();</script>';
				ob_flush();
				flush();
				break;
			}
		}
		
		//函数有效性检查
		foreach($FunctionInfo as $s){
			if($s['status'] != true){
				echo '<script type="text/javascript">DisableNext();</script>';
				ob_flush();
				flush();
				break;
			}
		}
		
		exit ();
	case '2': //第二步：录入数据库配置参数
		include_once ("./Tpl/step2.html");
		ob_flush();
		flush();
		exit ();
	case '3': //第三步
		include_once ("../App/Common/common.php");
		$dbHost = trim( $_POST['dbhost'] );
		$dbName = trim( $_POST['dbname'] );
		$dbUser = trim( $_POST['dbuser'] );
		$dbPwd = $_POST['dbpw'];
		$dbPort = trim( $_POST['dbport'] );
		 
		if( $dbHost == "" ){
			alert('数据库服务器不能为空！', 'index.php?Step=2');
		}
		if( $dbName == "" ){
			alert('数据库名不能为空', 'index.php?Step=2');
		}
		if( $dbUser == "" ){
			alert('数据库用户名不能为空', 'index.php?Step=2');
		}
		 
		$AdminName = trim($_POST['AdminName']);
		$pwd1 = $_POST['pwd1'];
		$pwd2 = $_POST['pwd2'];
		if( $AdminName == "" ){
			alert('管理员用户名不能为空' ,  'index.php?Step=2');
		}
		if( $pwd1 == "" ){
			alert('管理密码不能为空' , 'index.php?Step=2');
		}
		if( $pwd2 == "" ){
			alert('重复密码不能为空' ,  'index.php?Step=2');
		}
		if( $pwd1 != $pwd2 ){
			alert('两次输入的密码不相同，请重新输入' ,  'index.php?Step=2');
		}
		$pwd1 = md5($pwd1);
		 
		$DemoDb = $_POST['DemoDb']; //是否安装演示数据（0，1）
		//检查数据库＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝
		if (!@mysql_connect($dbHost, $dbUser, $dbPwd)) {
			alert("无法连接数据库！请检查数据库用户名或者密码是否正确", 'index.php?Step=2');
		}
		 
		//如果不存在则创建数据库
		if (mysql_get_server_info() > '4.1') {
			mysql_query("CREATE DATABASE IF NOT EXISTS `$dbName` DEFAULT CHARACTER SET utf8");
		} else {
			mysql_query("CREATE DATABASE IF NOT EXISTS `$dbName`");
		}
		
		if (mysql_errno()) {
			alert("无法创建新的数据库或无法连接现有数据库！\n请检查用户权限或数据库名称填写是否正确", 'index.php?Step=2');
		}
		mysql_close();
		//=====================================================================
		include_once ("./Tpl/step3.html");
		ob_flush();
		flush();
		 
		showmessage("开始安装数据库...");
		
		$db = new dbmysq;
		$db->connect($dbHost, $dbUser, $dbPwd, $dbName, 'utf8');
		
		//获取正确的数据
		if($DemoDb==1 && file_exists($DbDataSql) ){
			$dbSqlFile = $DbDataSql;  //含表结构和演示数据
		}else{
			$dbSqlFile = $DbSql;  //含表结构和系统数据
		}
		
		//创建表结构和初始化系统数据
		$dbSql = file_get_contents($dbSqlFile);
		$sqlList = sql_split( $dbSql );
		foreach ($sqlList as $query) {
			$query = trim($query);
			if ($query) {
				$b = @$db->query($query); //DROP TABLE 不提示
				if (preg_match('/CREATE\s*TABLE\s* `([a-zA-Z0-9_\n]+)`/', $query, $matches)) {
					showmessage($matches[1]."表创建", $b);
				} else if (preg_match('/INSERT\s*INTO\s* `([a-zA-Z0-9_\n]+)`/', $query, $matches)) {
					showmessage("初始化".$matches[1]."表数据", $b);
				}
			}
		}
		showmessage("安装数据完成！");
		
		//写入管理员数据======================================================================
		$sql = "Update youdian_admin Set AdminName='$AdminName', AdminPassword='$pwd1' Where AdminID=1";
		$b = @$db->query($sql);
		$sql = "Update youdian_member Set MemberName='$AdminName', MemberPassword='$pwd1' Where MemberID=1";
		$b = @$db->query($sql);
		showmessage("创建管理员", $b);
		//==================================================================================
		
		//将数据库文件写入配置
		$dbInfo = array (
				'DB_TYPE' => 'mysql',
				'DB_HOST' => "$dbHost",
				'DB_NAME' => "$dbName",
				'DB_USER' => "$dbUser",
				'DB_PWD' => "$dbPwd",
				'DB_PORT' => "$dbPort",
				'DB_PREFIX' => 'youdian_',
		);
		$b = cache_array($dbInfo, $dbFile);
		showmessage("写入数据库配置文件", $b);
		echo '<script type="text/javascript">Finish();</script>';
		ob_flush();//修改部分
		flush();
		showmessage("数据库安装完成！");

		//创建安装锁定文件
		if (!file_exists( $InstallLock ) ) {
			@touch( $InstallLock );
		}
		exit ();
	case '4': //第四步
		include_once ("./Tpl/step4.html");
		ob_flush();
		flush();
		exit ();
	default:  //安装协议
		include_once ("./Tpl/index.html");
		ob_flush();
		flush();
		exit();
}


//系统函数=======================================================
//系统环境检查
function syscheck($items) {
	foreach ($items as $key => $item) {
		if ($item['list'] == 'php') { //PHP版本， current:当前版本
			$items[$key]['current'] = PHP_VERSION; //PHP_VERSION 存储当前PHP的版本号，也可以通过PHPVERSION()函数获取。
		} elseif ($item['list'] == 'upload') {  //文件上传参数
			$items[$key]['current'] = @ini_get('file_uploads') ? ini_get('upload_max_filesize') : 'unknow';
		} elseif ($item['list'] == 'gdversion') { //gd库版本
			$tmp = function_exists('gd_info') ? gd_info() : array();  //gd_info():返回一个关联数组描述了安装的 GD 库的版本和性能。
			$items[$key]['current'] = empty($tmp['GD Version']) ? 'noext' : $tmp['GD Version'];
			unset($tmp); //释放数组
		} elseif ($item['list'] == 'disk') { //可用磁盘空间
			if (function_exists('disk_free_space')) {
				//disk_free_space -- 返回目录中的可用空间(不能用于远程文件)
				$items[$key]['current'] = floor(disk_free_space(ROOT) / (1024 * 1024)) . 'M';
			} else {
				$items[$key]['current'] = 'unknow';
			}
		} elseif (isset($item['c'])) {
			$items[$key]['current'] = constant($item['c']);
		}
		$items[$key]['status'] = 1;
		if ($item['r'] != 'notset' && strcmp($items[$key]['current'], $item['r']) < 0) {
			$items[$key]['status'] = 0;
		}
	}
	return $items;
}

function dircheck($diritems) {
	foreach ($diritems as $key => $item) {
		$item_path = $item['path'];
		if ($item['type'] == 'dir') {
			if (!dir_writeable($item_path)) {
				$diritems[$key]['status'] = 0;
				$diritems[$key]['current'] = 0;
			} else {
				$diritems[$key]['status'] = 1;
				$diritems[$key]['current'] = 1;
			}
		} else {
			if (file_exists($item_path)) {
				if (filemode($item_path)) {
					$diritems[$key]['status'] = 1;
				} else {
					$diritems[$key]['status'] = 0;
				}
				$diritems[$key]['current'] = 1;
			} else {
				$diritems[$key]['status'] = 0;
				$diritems[$key]['current'] = 0;
			}
		}
	}
	return $diritems;
}

function filemode($file, $checktype='w') {
	if (!file_exists($file)) {
		return false;
	}
	if (strtoupper(substr(PHP_OS, 0, 3)) == 'WIN') {
		$testfile = $file . 'writetest.txt';
		if (is_dir($file)) {
			$dir = @opendir($file);
			if ($dir === false) {
				return false;
			}

			if ($checktype == 'r') {
				$mode = (@readdir($dir) != false) ? true : false;
				@closedir($dir);
				return $mode;
			}

			if ($checktype == 'w') {
				$fp = @fopen($testfile, 'wb');
				if ($fp != false) {
					$wp = @fwrite($fp, 'demo');
					$mode = ($wp != false) ? true : false;
					@fclose($fp);
					@unlink($testfile);
					return $mode;
				} else {
					return false;
				}
			}
		} elseif (is_file($file)) {
			if ($checktype == 'r') {
				$fp = @fopen($file, 'rb');
				@fclose($fp);
				$mode = ($fp != false) ? true : false;
				return $mode;
			}

			if ($checktype == 'w') {
				$fp = @fopen($file, 'ab+');
				if ($fp != false) {
					$wp = @fwrite($fp, '');
					$mode = ($wp != false) ? true : false;
					@fclose($fp);
					return $mode;
				} else {
					return false;
				}
			}
		}
	} else {
		if ($checktype == 'r') {
			$fp = @is_readable($file);
			$mode = ($fp) ? true : false;
			return $mode;
		}
		if ($checktype == 'w') {
			$fp = @is_writable($file);
			$mode = ($fp) ? true : false;
			return $mode;
		}
	}
}

function dir_writeable($dir) {
	$writeable = 0;
	if (!is_dir($dir)) {
		@mkdir($dir, 0777);
	}
	if (is_dir($dir)) {
		if ($fp = @fopen("$dir/test.txt", 'w')) {
			@fclose($fp);
			@unlink("$dir/test.txt");
			$writeable = 1;
		} else {
			$writeable = 0;
		}
	}
	return $writeable;
}

function function_check($funcitems) {
	foreach ($funcitems as $key => $item) {
		$funcitemslist[$key]['name'] = $item['name'];
		$funcitemslist[$key]['status'] = function_exists($item['name']);
	}
	return $funcitemslist;
}
function showmessage($msg, $tip='notip'){
	if( $tip !== 'notip'){
		$msg .= $tip ? '成功' : '失败';
	}
	echo '<script type="text/javascript">showmessage(\'' . addslashes($msg) . ' \');</script>' . "\r\n";
	ob_flush(); //修改部分
	flush();
}
//==============================================================
?>
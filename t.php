<?php 
error_reporting(E_ERROR);
//抑制所有的错误信息
ini_set('display_errors', 'off'); 

//计算页面运行时间函数
function getmicrotime(){ 
    list($usec, $sec) = explode(" ",microtime()); 
    return ((float)$usec + (float)$sec); 
    } 
$pagestartime=getmicrotime();

//显示常量
define("on", "<font color=\"green\"><b>Yes</b></font>");
define("off", "<font color=\"red\"><b>No</b></font>");
define("version", "v0.05.4");//版本号
define("overtime","2010.9.6&nbsp;&nbsp;11:30");//完成时间

//显示开关
$mysqlReShow = "none";

//性能信息结果刷新
$ts_int = (false == empty($_POST['tsint']))?$_POST['tsint']:test_int();
$ts_float = (false == empty($_POST['tsfloat']))?$_POST['tsfloat']:test_float();
$ts_io = (false == empty($_POST['tsio']))?$_POST['tsio']:test_io();
if(isset($_POST['speed']))
{
	$speed=round(100/($_POST['speed']/1000),2);
}
elseif($_GET['speed']=="0")
{
	$speed=6666.67;
}
elseif(isset($_GET['speed']) and $_GET['speed']>0)
{
	$speed=round(100/($_GET['speed']/1000),2);
}
else
{
	$speed="<font color=red>&nbsp;未探测&nbsp;</font>";
}
//phpinfo()信息列举
switch ($_GET['action']){
	case "phpinfo_GENERAL":
		phpinfo(INFO_GENERAL+INFO_ENVIRONMENT+INFO_VARIABLES);
		exit;
	case "phpinfo_CONFIGURATION":
		phpinfo(INFO_CONFIGURATION);
		exit;
	case "phpinfo_MODULES":
		phpinfo(INFO_MODULES);
		exit;
	case "phpinfo":
		phpinfo();
		exit;
	case "bom":
		bom();
		exit;
	default:
		break;
}
//表单处理
if(isset($_POST['Buginfo']) and $_POST['act']=="提交"){//Bug提交!
	$message=$message."\n\n 来自:".$_SERVER['SERVER_NAME'].$_SERVER['PHP_SELF'];
	$to="307292967@qq.com";
	$subject="浩哥你多大了？";
	$jg=@mail($to, $subject, $message);
	$jgprint= (true==$jg)?"<font color=\"green\">上报成功！谢谢你！</font>":"<font color=\"red\">上报失败！写信给我吧：307292967@qq.com</font>";
}
elseif($_POST['action']=="整数运算")
{
	$ts_int=test_int();
}
elseif($_POST['action']=="浮点运算")
{
	$ts_float=test_float();
}
elseif($_POST['action']=="IO测试")
{
	$ts_io=test_io();
}
elseif($_POST['action']=="开始测试")//网速测试，等你来完善。
{
?>
<script language="javascript" type="text/javascript">
var acd1;
acd1 = new Date();
acd1ok=acd1.getTime();
</script>
<?php
for($i=1;$i<=1000;$i++){
echo "<!--567890#########0#########0#########0#########0#########0#########0#########0#########012345-->";
}
?>
<script language="javascript" type="text/javascript">
var acd2;
acd2 = new Date();
acd2ok=acd2.getTime();
window.location = '?speed=' +(acd2ok-acd1ok)+'#bottom';
</script>
<?php
}
elseif($_POST['action'] == "连接Mysql")
{
    $mysqlReShow = "show";
    $mysqlRe = "MYSQL连接测试结果：";
    $mysqlRe .= (false !==mysql_connect($_POST['mysqlhost'], $_POST['mysqluser'], $_POST['mysqlpsd']))?"<font color=\"#009900\">MYSQL服务器连接正常</font>，":"<font color=\"red\">MYSQL服务器连接失败！</font>, ";
    $mysqlRe .= "数据库 <b>".$_POST['mysqldb']."</b>&nbsp; ";
    $mysqlRe .= (false != @mysql_select_db($_POST['mysqldb']))?"<font color=\"#009900\">连接正常</font>":"<font color=\"red\">连接失败！</font>";
	if(false !==mysql_connect($_POST['mysqlhost'], $_POST['mysqluser'], $_POST['mysqlpsd']))
	{
		$mysql_version=mysql_get_server_info();
	}
	else
	{	
		$mysql_version="<font color=red>获取失败！</font>";
	}
	$mysqlRe .= "，Mysql服务器版本：";
	$mysqlRe .= $mysql_version;
}
elseif($_POST['action'] == "发送")
    {
    $mailRe = (false !== @mail($_POST["mailReceiver"], "探针邮件测试", "成功发送！"))?"<font color=\"#090\">发送完成</font>":"<font color=red>发送失败!</font>";
}
elseif($_POST['action']=="检测")
	{
	$funre=$_POST['funame']."&nbsp;的支持情况：".getfunexists($_POST['funame']);
}
elseif($_POST['action']=="检测1")
	{
	$pmre=$_POST['pm']."&nbsp;的支持情况：".getvar($_POST['pm']);
}

function bom(){
	if (isset($_GET['dir'])) { //设置文件目录
		$basedir = $_GET['dir'];
	} else {
		$basedir = '.';
	}
	$num = checkdir($basedir);
	if($num==0){
		echo "<b style='color:blue'>No bom found</b>";
	}else{
		echo "<b style='color:red'>&nbsp;&nbsp;Total:$num bom found</b>";
	}
}

function checkdir($basedir){
	static $num = 0;
	if ($dh = opendir($basedir)) {
		while (($file = readdir($dh)) !== false) {
			if ($file != '.' && $file != '..' ) {
				if (!is_dir($basedir . "/" . $file)) {
					if( file_ext($file)== 'php' && checkBOM("$basedir/$file", false) ){
						echo "filename: $basedir/$file <b style='color:red'>bom found.</b><br/>";
						$num++;
					}
				} else {
					$dirname = $basedir . "/" . $file;
					checkdir($dirname);
				}
			}
		}
		closedir($dh);
	}
	return $num;
}
			
function checkBOM($filename, $removeBom=false){
	$contents   = file_get_contents($filename);
	$charset[1] = substr($contents, 0, 1);
	$charset[2] = substr($contents, 1, 1);
	$charset[3] = substr($contents, 2, 1);
	if (ord($charset[1]) == 239 && ord($charset[2]) == 187 && ord($charset[3]) == 191) {
		if ($removeBom) {
			$rest = substr($contents, 3);
			rewrite($filename, $rest);
		}
		return true;
	}else{
		return false;
	}
}

function file_ext($file) {
	//return strtolower(trim(substr(strrchr($filename, '.'), 1, 10)));
	$ext = pathinfo($file, PATHINFO_EXTENSION);
	$ext = strtolower($ext);
	return $ext;
}

function rewrite($filename, $data)
{
	$filenum = fopen($filename, "w");
	flock($filenum, LOCK_EX);
	fwrite($filenum, $data);
	fclose($filenum);
}

//获取Zend Optimizer版本,方法参考了废墟のPHP探针
function checkoptimizer()
{
	$url= "http://".$_SERVER['SERVER_NAME'].$_SERVER['PHP_SELF']."?action=phpinfo";
	$htmlct=file_get_contents($url);
	eregi("Optimizer&nbsp;v(.*),&nbsp;Copyright", $htmlct, $regs);
	$optimizerversion=$regs[1];
	$optimizerversion=(''!=$optimizerversion)?$optimizerversion:"<font color=red>获取失败！</font>";
	return $optimizerversion;
}
//获取php.ini配置参数,参考iProber
function getvar($varname)
{
	switch($var=get_cfg_var($varname)?get_cfg_var($varname):ini_get($varname))
	{
		case 0:
		return off;
		break;
		case 1:
		return on;
		break;
		default:
		return $var;
		break;
	}
}
//判断函数定义情况
function getfunexists($funame)
{
	return (false !== function_exists($funame))?on:off;
}
//整数运算测试
function test_int()
{
	$startime=getmicrotime();
    for($i = 0; $i < 3000000; $i++);
    {
     	$t = 1+1;
    }
	$endtime=getmicrotime();
	$time=round($endtime-$startime,4);
	return $time;
}
//浮点数运算测试
function test_float()
{
	$startime=getmicrotime();
    for($i = 0; $i < 3000000; $i++);
    {
      sqrt($t);
    }
	$endtime=getmicrotime();
	$time=round($endtime-$startime,4);
	return $time;
}
//IO能力测试
function test_io()
{
	$fp = fopen($_SERVER['PHP_SELF'], "r");
	$startime=getmicrotime();
    for($i = 0; $i < 300000; $i++);
    {
    	fread($fp, 10240);
    	rewind($fp);
    }
	$endtime=getmicrotime();
	$time=round($endtime-$startime,4);
	return $time;
}
//获取磁盘信息、disk_x_space("y")的参数不能用变量,@在这里不起作用
$diskct=0;
$disk=array();
/*if(@disk_total_space("A:")!=NULL) *为防止影响服务器，不检查软驱 - 阿江说的
{
	$diskct=1;
	$disk["A"]=round((@disk_free_space("A:")/(1024*1024*1024)),2)."G&nbsp;/&nbsp;".round((@disk_total_space("A:")/(1024*1024*1024)),2).'G';
}*/
$diskz=0; //磁盘总容量
$diskk=0; //磁盘剩余容量
if(@disk_total_space("B:")!=NULL)
{
	$diskct++;
	$disk["B"][0]=round(@disk_free_space("B:")/(1024*1024*1024),2).'G';
	$disk["B"][1]=round(@disk_total_space("B:")/(1024*1024*1024),2).'G';
	$disk["B"][2]=round(((@disk_free_space("B:")/(1024*1024*1024))/(@disk_total_space("B:")/(1024*1024*1024)))*100,2).'%';
	$diskk+=round((@disk_free_space("B:")/(1024*1024*1024)),2);
	$diskz+=round((@disk_total_space("B:")/(1024*1024*1024)),2);
}
if(@disk_total_space("C:")!=NULL)
{
	$diskct++;
	$disk["C"][0]=round((@disk_free_space("C:")/(1024*1024*1024)),2).'G';
	$disk["C"][1]=round((@disk_total_space("C:")/(1024*1024*1024)),2).'G';
		$disk["C"][2]=round(((@disk_free_space("C:")/(1024*1024*1024))/(@disk_total_space("C:")/(1024*1024*1024)))*100,2).'%';
	$diskk+=round((@disk_free_space("C:")/(1024*1024*1024)),2);
	$diskz+=round((@disk_total_space("C:")/(1024*1024*1024)),2);
}
if(@disk_total_space("D:")!=NULL)
{
	$diskct++;
	$disk["D"][0]=round((@disk_free_space("D:")/(1024*1024*1024)),2).'G';
	$disk["D"][1]=round((@disk_total_space("D:")/(1024*1024*1024)),2).'G';
	$disk["D"][2]=round(((@disk_free_space("D:")/(1024*1024*1024))/(@disk_total_space("D:")/(1024*1024*1024)))*100,2).'%';
	$diskk+=round((@disk_free_space("D:")/(1024*1024*1024)),2);
	$diskz+=round((@disk_total_space("D:")/(1024*1024*1024)),2);
}
if(@disk_total_space("E:")!=NULL)
{
	$diskct++;
	$disk["E"][0]=round((@disk_free_space("E:")/(1024*1024*1024)),2).'G';
	$disk["E"][1]=round((@disk_total_space("E:")/(1024*1024*1024)),2).'G';
		$disk["E"][2]=round(((@disk_free_space("E:")/(1024*1024*1024))/(@disk_total_space("E:")/(1024*1024*1024)))*100,2).'%';
	$diskk+=round((@disk_free_space("E:")/(1024*1024*1024)),2);
	$diskz+=round((@disk_total_space("E:")/(1024*1024*1024)),2);
}
if(@disk_total_space("F:")!=NULL)
{
	$diskct++;
	$disk["F"][0]=round((@disk_free_space("F:")/(1024*1024*1024)),2).'G';
	$disk["F"][1]=round((@disk_total_space("F:")/(1024*1024*1024)),2).'G';
	$disk["F"][2]=round(((@disk_free_space("F:")/(1024*1024*1024))/(@disk_total_space("F:")/(1024*1024*1024)))*100,2).'%';
	$diskk+=round((@disk_free_space("F:")/(1024*1024*1024)),2);
	$diskz+=round((@disk_total_space("F:")/(1024*1024*1024)),2);
}
if(@disk_total_space("G:")!=NULL)
{
	$diskct++;
	$disk["G"][0]=round((@disk_free_space("G:")/(1024*1024*1024)),2).'G';
	$disk["G"][1]=round((@disk_total_space("G:")/(1024*1024*1024)),2).'G';
	$diskk+=round((@disk_free_space("G:")/(1024*1024*1024)),2);
	$diskz+=round((@disk_total_space("G:")/(1024*1024*1024)),2);
}
if(@disk_total_space("H:")!=NULL)
{
	$diskct++;
	$disk["H"][0]=round((@disk_free_space("H:")/(1024*1024*1024)),2).'G';
	$disk["H"][1]=round((@disk_total_space("H:")/(1024*1024*1024)),2).'G';
	$diskk+=round((@disk_free_space("H:")/(1024*1024*1024)),2);
	$diskz+=round((@disk_total_space("H:")/(1024*1024*1024)),2);
}
if(@disk_total_space("I:")!=NULL)
{
	$diskct++;
	$disk["I"][0]=round((@disk_free_space("I:")/(1024*1024*1024)),2).'G';
	$disk["I"][1]=round((@disk_total_space("I:")/(1024*1024*1024)),2).'G';
	$diskk+=round((@disk_free_space("I:")/(1024*1024*1024)),2);
	$diskz+=round((@disk_total_space("I:")/(1024*1024*1024)),2);
}
if(@disk_total_space("J:")!=NULL)
{
	$diskct++;
	$disk["J"][0]=round((@disk_free_space("J:")/(1024*1024*1024)),2).'G';
	$disk["J"][1]=round((@disk_total_space("J:")/(1024*1024*1024)),2).'G';
	$diskk+=round((@disk_free_space("J:")/(1024*1024*1024)),2);
	$diskz+=round((@disk_total_space("J:")/(1024*1024*1024)),2);
}
if(@disk_total_space("K:")!=NULL)
{
	$diskct++;
	$disk["K"][0]=round((@disk_free_space("K:")/(1024*1024*1024)),2).'G';
	$disk["K"][1]=round((@disk_total_space("K:")/(1024*1024*1024)),2).'G';
	$diskk+=round((@disk_free_space("K:")/(1024*1024*1024)),2);
	$diskz+=round((@disk_total_space("K:")/(1024*1024*1024)),2);
}
if(@disk_total_space("L:")!=NULL)
{
	$diskct++;
	$disk["L"][0]=round((@disk_free_space("L:")/(1024*1024*1024)),2).'G';
	$disk["L"][1]=round((@disk_total_space("L:")/(1024*1024*1024)),2).'G';
	$diskk+=round((@disk_free_space("L:")/(1024*1024*1024)),2);
	$diskz+=round((@disk_total_space("L:")/(1024*1024*1024)),2);
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>PHP probe</title>
<style type="text/css">
body {background-color: #ffffff; color: #000000; font-size:12px; font-family:Arial, Helvetica, sans-serif;}
pre {margin: 0px;}
a {text-decoration: none; color: #000000;}
a:hover {text-decoration: none; background-color:#888888; color:#99FF00;}
table {border-collapse: collapse;margin: auto;}
td,th { border: 1px solid #000000; padding-left:4px; padding-right:4px; padding-top:3px; padding-bottom:1px; height: 22px; vertical-align:middle; text-align:left;}
span { font-weight:normal; padding-right:4px; }
.e {background-color: #ccccff; color: #000000;}
.h {background-color: #9999cc; font-weight: bold; color: #000000; font-size:14px; text-align:left;}
.vr {background-color: #cccccc; text-align: center; color: #000000;}
.vr2 {background-color: #cccccc; color: #000000;}
img {border: 0px;}
hr {width: 600px; background-color: #cccccc; border: 0px; height: 1px; color: #000000;}
.notice {color: #CC3300;}
.center {text-align:center;}
.gbutton {background-color: #ccccff;border-color:#003333;border-width:1px;}
.textborder {border-top-width: 1px;border-right-width: 1px;border-bottom-width: 1px;border-left-width: 1px;border-top-color: #9999cc;border-right-color: #9999cc;border-bottom-color: #9999cc;
border-left-color: #9999cc;}
.td1 {BORDER-top: rgb(0,0,0) 1px groove; BORDER-bottom: rgb(0,0,0) 1px groove; BORDER-left: rgb(0,0,0) 1px groove; BORDER-right: rgb(0,0,0) 1px groove}
.td2 {BORDER-top: rgb(0,0,0) 1px groove; BORDER-bottom: rgb(0,0,0) 1px groove; BORDER-right: rgb(0,0,0) 1px groove}
</style>
</head>

<body>
<div style="margin:auto; width:700px;">


<div align="left">
<b style="font-size:16px">服务器测定信息</b>：<BR><BR>
<div align="center">

<table width="700" border="0" cellpadding="0" cellspacing="1">
  <tr>
    <td  bgcolor="#9999cc" style="width:25%; text-align:center"><a href="#tx">服务器特征</a></td>
    <td  bgcolor="#9999cc" style="width:25%; text-align:center"><a href="#pz">PHP环境配置</a></td>
    <td  bgcolor="#9999cc"  style="width:25%; text-align:center"><a href="#zj">PHP组件支持</a></td>
    <td  bgcolor="#9999cc"  style="width:25%; text-align:center"><a href="<?php echo $_SERVER['PHP_SELF']?>?action=bom">BOM检测</a>
    </td>
  </tr>
</table>
<div style="margin:auto;">
 <img src="" alt="" name="xuhao" width="1" height="5" id="xuhao" />
</div>
<table width="700" border="0" cellspacing="1" cellpadding="0">
  <tr>
    <td colspan="2" class="h">
    <a name="tx" id="tx"></a>
    <div style="float:left;width:49%">
    <font face="Webdings, sans-serif">8</font>服务器参数    </div>
    <div style="float:right;width:50%;text-align:right;"><a href="<?php $_SERVER['PHP_SELF']?>?action=phpinfo_GENERAL" target="_blank">phpinfo()中的服务器信息</a></div>    </td>
  </tr>
  <tr>
    <td width="126" class="e">服务器域名/IP：</td>
    <td width="571"><?php echo $_SERVER['SERVER_NAME']."&nbsp;(".$_SERVER['REMOTE_ADDR'].")"; ?></td>
  </tr>
  <tr>
    <td class="e">Web服务端口：</td>
    <td><?php echo $_SERVER['SERVER_PORT']; ?></td>
  </tr>
  <tr>
    <td class="e">服务器类型/版本：</td>
    <td><?php echo $_SERVER['SERVER_SOFTWARE']; ?></td>
  </tr>
  <tr>
    <td class="e">服务器操作系统：</td>
    <td><?php echo PHP_OS."&nbsp;(".php_uname().")"; ?></td>
  </tr>
  <tr>
    <td class="e">网站跟目录：</td>
    <td><?php echo $_SERVER['DOCUMENT_ROOT']; ?></td>
  </tr>
  <tr>
    <td class="e">当前文件位置：</td>
    <td><?php echo $_SERVER['SCRIPT_FILENAME']; ?></td>
  </tr>
  <!-- 如果系统不是WINNT的，不显示以下信息 -->
  <?php if (PHP_OS=="WINNT"){?>
  <tr>
    <td class="e">系统目录：</td>
    <td><?php echo getenv('SystemRoot')?getenv('SystemRoot'):"<font color=red>获取失败！</font>"; ?>&nbsp;
      <div id="sysroot" class="notice" style="display:none;">
        <div style="border-bottom:1px dashed #ccc"></div>
    <strong>Path：</strong><?php echo getenv('Path')?getenv('Path'):"<font color=red>获取失败！</font>"; ?><br />
<strong>TEMP：</strong><?php echo getenv('TEMP')?getenv('TEMP'):"<font color=red>获取失败！</font>"; ?><br>
<strong>PATHEXT：</strong><?php echo getenv('PATHEXT')?getenv('PATHEXT'):"<font color=red>获取失败！</font>"; ?></div></td>
  </tr>
  <tr>
    <td class="e">处理器(CPU)信息：</td>
    <td><?php echo getenv('PROCESSOR_IDENTIFIER')?getenv('PROCESSOR_IDENTIFIER'):"<font color=red>获取失败！</font>"; ?>&nbsp;      <div id="cpu" class="notice" style="display:none;">
        <div style="border-bottom:1px dashed #ccc;"></div>
   从左至右分别表示Type（类型）、Family（系列）、Mode（型号）、Stepping（步进编号）和Brand ID（品种标识），一般CPU都有Brand ID，如果CPU不是非常老的话。你可以通过Brand ID（品种标识）来判断服务器CPU是什么型号档次的，具体怎么判断你可以去百度或百度知道搜索！在此不细说明！</div></td>
  </tr>
   <tr>
    <td class="e">处理器(CPU)个数：</td>
    <td><?php echo getenv('NUMBER_OF_PROCESSORS')?getenv('NUMBER_OF_PROCESSORS'):"获取失败！"; ?>&nbsp;
      <div id="cpunm" class="notice" style="display:none;">
        <div style="border-bottom:1px dashed #ccc;"></div>
   逻辑处理器个数，IDC客服的话的可信度没有上面这个数字的可信度高。但如果上面的数是16，在以后的几年里你最好别相信那是真的。如果是... 32...（开个玩笑）</div></td>
  </tr>
  <?php }?>
  <tr>
    <td class="e">服务器时间：</td>
    <td><?php echo date("y年n月j日 g:i:s a");?></td>
  </tr>
 <!-- 如果系统不是WINNT的，不显示以下信息 -->
  <?php if (PHP_OS=="WINNT"){?>
  <tr>
    <td class="e">磁盘空间信息：</td>
    <td>
	<?php if($diskct>0) {?>
	<table width="100%">
	<tr><th width="50">盘符</th><th width="80">总空间</th><th width="80">剩余空间</th><th>剩余百分比</th></tr>
	<?php foreach($disk as $key=>$value){ ?>
	<tr>
	<td><?php echo $key.'盘'; ?></td>
	<td><?php echo $value[1]; ?></td>
	<td><?php echo $value[0]; ?></td>
	<td>
	<div style="border:1px solid #999">
	<div style="width:<?php echo $value[2]; ?>;background-color:green; color:#FFF;"> <?php echo $value[2]; ?></div>
	</div>
	</td>
	</tr>
	<?php } ?>
	<tr style="background-color: #E5E5E5">
	<th>总计</th>
	<td><?PHP echo $diskz; ?>G</td>
	<td><?PHP echo $diskk.'G'; ?></td>
	<td>
		<div style="border:1px solid #999">
	<div style="width:<?php echo round(($diskk/$diskz)*100,2) ?>%;background-color:green; color:#FFF;"> <?php echo round(($diskk/$diskz)*100,2) ?>%</div>
	</div>
	</td>
	</tr>
	</table>
	<?php }else{echo '探测失败！';} ?>
	<br />
	声明：只能探测盘符为大写字母A-L的磁盘，且有权限获取！
	</td>
  </tr>
<?php }?>
</table>
<div style="margin:auto;">
 <img src="" alt="" name="xuhao" width="1" height="5" id="xuhao" />
</div>
<table width="700" border="0" cellspacing="1" cellpadding="0">
  <tr>
    <td colspan="2" class="h">
    <a name="pz" id="pz"></a>
    <div style="float:left;width:49%">
    <font face="Webdings, sans-serif">8</font>PHP环境基本配置(php.ini)</div>
    <div style="float:right;width:50%;text-align:right;"><a href="<?php $_SERVER['PHP_SELF']?>?action=phpinfo_CONFIGURATION" target="_blank">phpinfo()中的基本配置信息</a></div>    </td>
  </tr>
  <tr>
    <td width="256" class="e">运行方式：</td>
    <td width="441"><?php echo strtoupper(php_sapi_name()); ?></td>
  </tr>
  <tr>
    <td class="e">PHP版本：</td>
    <td><?php echo phpversion(); ?></td>
  </tr>
  <tr>
    <td class="e">Zend版本：</td>
    <td><?php echo zend_version(); ?></td>
  </tr>
  <!-- 如果系统不是WINNT的，不显示以下信息 -->
  <?php if (PHP_OS=="WINNT"){?>
  <tr>
    <td class="e">Zend Optimizer版本：</td>
    <td><?php echo checkoptimizer(); ?>&nbsp;
      <div id="optimizer" class="notice" style="display:none;">
        <div style="border-bottom:1px dashed #ccc;"></div>
  Zend Optimizer仔细检查所有运行 Zend 编译器产生的代码，分析并做优化，让它运行得更快。经过测试确实可以提高程序运行速度超过60%，并且降低了程序对系统资源的耗用。 </div></td>
  </tr>
<?php }?>
  <tr>
    <td class="e">Mysql客户端库版本：</td>
    <td><?php echo (false!=mysql_get_client_info())?mysql_get_client_info():"获取失败！";?>&nbsp;
      <div id="sqlcl" class="notice" style="display:none;">
        <div style="border-bottom:1px dashed #ccc;"></div>
    若成功获取，不要误会是服务器端的Mysql版本了，下面在做Mysql连接测试时会探测服务器的Mysql版本的。 </div></td>
  </tr>
  <tr>
    <td class="e">ZEND编译运行：</td>
    <td><?php echo (get_cfg_var("zend_optimizer.optimization_level")||get_cfg_var("zend_extension_manager.optimizer_ts")||get_cfg_var("zend_extension_ts")) ?on:off; //参考iProber?></td>
  </tr>
  <tr>
    <td class="e">运行于安全模式：(safe_mode)</td>
    <td><?php echo getvar("safe_mode"); ?></td>
  </tr>
  <tr>
    <td class="e">访问 URL 对象：(allow_url_fopen)</td>
    <td><?php echo getvar("allow_url_fopen"); ?></td>
  </tr>
  <tr>
    <td class="e">注册全局变量：(register_globals)</td>
    <td><?php echo getvar("register_globals"); ?></td>
  </tr>
  <tr>
    <td class="e">魔术引号开启：(magic_quotes_gpc)</td>
    <td><?php echo getvar("magic_quotes_gpc"); ?></td>
  </tr>
  <tr>
    <td class="e">短标记支持：(short_open_tag)</td>
    <td><?php echo getvar("short_open_tag"); ?>&nbsp;
      <div id="shortag" class="notice" style="display:none;">
        <div style="border-bottom:1px dashed #ccc;"></div>
  允许使用 PHP 代码开始标志的缩写形式（&lt;? ?&gt;）。很多PHP程序都使用短标记，如著名的Discuz!。如果你的空间不支持这个的话，要当心放DZ论坛哦。</div></td>
  </tr>
  <tr>
    <td class="e">自动转义溢出字符：(magic_quotes_runtime)</td>
    <td><?php echo getvar("magic_quotes_runtime"); ?></td>
  </tr>
  <tr>
    <td class="e">允许动态加载链接库：(enable_dl)</td>
    <td><?php echo getvar("enable_dl"); ?></td>
  </tr>
  <tr>
    <td class="e">显示错误信息：(display_errors)</td>
    <td><?php echo getvar("display_errors"); ?></td>
  </tr>
  <tr>
    <td class="e">post最大数据量：(post_max_size)</td>
    <td><?php echo getvar("post_max_size"); ?></td>
  </tr>
  <tr>
    <td class="e">上传文件的最大大小：(upload_max_filesize)</td>
    <td><?php echo getvar("upload_max_filesize"); ?></td>
  </tr><strong></strong>
  <tr>
    <td class="e">脚本最大内存使用量：(memory_limit)</td>
    <td><?php echo getvar("memory_limit"); ?></td>
  </tr>
  <tr>
    <td class="e">查看phpinfo()：</td>
    <td><a href="<?php $_SERVER['PHP_SELF']?>?action=phpinfo" target="_blank">PHPINFO</a></td>
  </tr>
</table>
<div style="margin:auto;">
 <img src="" alt="" name="xuhao" width="1" height="5" id="xuhao" />
</div>
<table width="700" border="0" cellspacing="1" cellpadding="0">
  <tr>
    <td colspan="4" class="h"><a name="zj" id="zj"></a>
      <div style="float:left;width:49%"> <font face="Webdings, sans-serif">8</font>PHP组件支持情况 </div>
        <div style="float:right;width:50%;text-align:right;"><a href="<?php $_SERVER['PHP_SELF']?>?action=phpinfo_MODULES" target="_blank">phpinfo()的组件支持信息</a></div></td>
  </tr>
  <tr>
    <td width="259" class="e">MySQL数据库：</td>
    <td width="87"><?php echo getfunexists("mysql_close"); ?></td>
    <td width="270" class="e">图形处理 GD 库：</td>
    <td width="79"><?php echo getfunexists("gd_info"); ?></td>
  </tr>
  <tr>
    <td class="e">SQL Server数据库：</td>
    <td><?php echo getfunexists("mssql_close"); ?></td>
    <td class="e">PDF文档支持：</td>
    <td><?php echo getfunexists("pdf_close"); ?></td>
  </tr>
  <tr>
    <td class="e">Oracle数据库：</td>
    <td><?php echo getfunexists("ora_close"); ?></td>
    <td class="e">FDF文档支持：</td>
    <td><?php echo getfunexists("fdf_get_ap"); ?></td>
  </tr>
  <tr>
    <td class="e">Oracle 8 数据库：</td>
    <td><?php echo getfunexists("OCILogOff"); ?></td>
    <td class="e">Session支持：</td>
    <td><?php echo getfunexists("session_start"); ?></td>
  </tr>
  <tr>
    <td class="e">mSQL数据库：</td>
    <td><?php echo getfunexists("msql_close"); ?></td>
    <td class="e">Socket支持：</td>
    <td><?php echo getfunexists("socket_accept"); ?></td>
  </tr>
  <tr>
    <td class="e">SyBase数据库：</td>
    <td><?php echo getfunexists("sybase_close"); ?></td>
    <td class="e">XML解析支持：</td>
    <td><?php echo getfunexists("xml_set_object"); ?></td>
  </tr>
  <tr>
    <td class="e">Postgre SQL数据库：</td>
    <td><?php echo getfunexists("pg_close"); ?></td>
    <td class="e">FTP支持：</td>
    <td><?php echo getfunexists("ftp_login"); ?></td>
  </tr>
  <tr>
    <td class="e">Informix数据库：</td>
    <td><?php echo getfunexists("ifx_close"); ?></td>
    <td class="e">ODBC数据库连接：</td>
    <td><?php echo getfunexists("odbc_close"); ?></td>
  </tr>
  <tr>
    <td class="e">Hyperwave数据库：</td>
    <td><?php echo getfunexists("hw_close"); ?></td>
    <td class="e">压缩文件支持(Zlib)：</td>
    <td><?php echo getfunexists("gzclose"); ?></td>
  </tr>
  <tr>
    <td class="e">FilePro数据库：</td>
    <td><?php echo getfunexists("filepro_fieldcount"); ?></td>
    <td class="e">Yellow Page系统：</td>
    <td><?php echo getfunexists("yp_match"); ?></td>
  </tr>
  <tr>
    <td class="e">DBM数据库：</td>
    <td><?php echo getfunexists("dbmclose"); ?></td>
    <td class="e">SNMP网络管理协议：</td>
    <td><?php echo getfunexists("snmpget"); ?></td>
  </tr>
  <tr>
    <td class="e">DBA数据库：</td>
    <td><?php echo getfunexists("dba_close"); ?></td>
    <td class="e">WDDX支持：</td>
    <td><?php echo getfunexists("wddx_add_vars"); ?></td>
  </tr>
  <tr>
    <td class="e">dBase数据库：</td>
    <td><?php echo getfunexists("dbase_close"); ?></td>
    <td class="e">拼写检查 ASpell Library：</td>
    <td><?php echo getfunexists("aspell_check_raw"); ?></td>
  </tr>
  <tr>
    <td class="e">IMAP电子邮件系统：</td>
    <td><?php echo getfunexists("imap_close"); ?></td>
    <td class="e">历法运算 Calendar：</td>
    <td><?php echo getfunexists("cal_days_in_month"); ?></td>
  </tr>
  <tr>
    <td class="e">VMailMgr邮件处理：</td>
    <td><?php echo getfunexists("vm_adduser"); ?></td>
    <td class="e">LDAP目录协议：</td>
    <td><?php echo getfunexists("ldap_close"); ?></td>
  </tr>
  <tr>
    <td class="e">MCrypt加密处理：</td>
    <td><?php echo getfunexists("mcrypt_cbc"); ?></td>
    <td class="e">PREL相容语法 PCRE：</td>
    <td><?php echo getfunexists("preg_match"); ?></td>
  </tr>
  <tr>
    <td class="e">高精度数学运算 BCMath：</td>
    <td><?php echo getfunexists("bcadd"); ?></td>
    <td class="e">哈稀计算 MHash：</td>
    <td><?php echo getfunexists("mhash_count"); ?></td>
  </tr>
  <tr>
    <td colspan="4" class="e">所有已编译模块： <br />
	<?php 
	$able=get_loaded_extensions();
	foreach ($able as $key=>$value) {
		if ($key!=0 && $key%13==0) {
			echo '<br />';
		}
		echo "$value&nbsp;&nbsp;&nbsp;";
	}
	?></td>
  </tr>
</table>
<div style="margin:auto;">
 <img src="" alt="" name="xuhao" width="1" height="5" id="xuhao" />
</div>
    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>#bottom" style="margin:0;">
    <input name="tsint" type="hidden" value="<?php echo $ts_int;?> " />
    <input name="tsfloat" type="hidden" value="<?php echo $ts_float;?> " />
    <input name="tsio" type="hidden" value="<?php echo $ts_io;?> " />
    <input name="speed" type="hidden" value="<?php echo $speed;?> " />
  
  <div style="margin:auto;"> <img src="" alt="" name="xuhao" width="5" height="5" id="xuhao2" /> </div>
  <table width="700" border="0" cellspacing="1" cellpadding="0">
    <tr>
      <td colspan="4" class="h"><font face="Webdings, sans-serif">8</font>自定义测试项目</td>
    </tr>
    <?php if(getfunexists("mysql_close")==on){?>
    <tr>
      <td colspan="4" class="e">Myslq数据库连接测试</td>
    </tr>
    <tr>
      <td width="111">Mysql服务器：</td>
      <td width="152"><label>
        <input name="mysqlhost" type="text" class="textborder" id="mysqlhost" size="15" />
      </label></td>
      <td width="116">Mysql用户名：</td>
      <td width="316"><label>
        <input name="mysqluser" type="text" class="textborder" id="mysqluser" size="15" />
      </label></td>
    </tr>
    <tr>
      <td>Mysql密码：</td>
      <td><label>
        <input name="mysqlpsd" type="text" class="textborder" id="mysqlpsd" size="15" />
      </label></td>
      <td>Mysql数据库名称：</td>
      <td><label>
        <input name="mysqldb" type="text" class="textborder" id="mysqldb" size="15" />
      </label>
      &nbsp;
      <label>
      <input name="action" type="submit" class="gbutton" id="button2" value="连接Mysql" />
      </label></td>
    </tr>
    <?php 
	}
	if("show"==$mysqlReShow){
	?>
			<tr>
				<td colspan="4" class="vr2"><?php echo $mysqlRe; ?>&nbsp;<a href="javascript:ShowHide('mysql');" title="点击此处查看提示信息"><img src="http://mobdown.maifou.net/admin/images/notice.gif"  width="16" height="16" alt="点击此处查看提示信息" border="0"/></a>
      <div id="mysql" class="notice" style="display:none;">
        <div style="border-bottom:1px dashed #ccc;"></div>
      服务器Mysql版本：<?php echo $mysql_version; ?> &nbsp;&nbsp;如果数据库连接失败，将无法探测该项！</div></td>
			</tr>
    <?php } ?>
    <tr>
      <td colspan="4" class="e">MAIL邮件发送测试</td>
    </tr>
    <tr>
      <td>测试邮件发送到：</td>
      <td colspan="3"><label>
        <input name="to" type="text" class="textborder" id="textfield" />
      &nbsp;
      <input name="action" type="submit" class="gbutton" id="button3" value="发送" />
      </label>&nbsp;<?php echo $mailRe; ?></td>
    </tr>
    <tr>
      <td colspan="4" class="e">函数支持检测</td>
    </tr>
    <tr>
      <td>探测的函数名：</td>
      <td colspan="3"><label>
        <input name="funame" type="text" class="textborder" id="textfield2" />
      &nbsp;
      <input name="action" type="submit" class="gbutton" id="button4" value="检测" />
      &nbsp;</label><?php echo $funre; ?></td>
    </tr>
    <tr>
      <td colspan="4" class="e">PHP配置(php.ini)检测</td>
    </tr>
    <tr>
      <td>探测的参数名：</td>
      <td colspan="3"><label>
        <input name="pm" type="text" class="textborder" id="textfield2" />
      &nbsp;
      <input name="action" type="submit" class="gbutton" id="button4" value="检测1" />
      &nbsp;</label><?php echo $pmre; ?></td>
    </tr>
  </table>
   <div style="margin:auto;"> <img src="" alt="" name="xuhao" width="5" height="5" id="xuhao2" /> </div>
        </form>
<div style="margin:auto;">
 <img src="" alt="" name="xuhao" width="1" height="5" id="xuhao" />
</div>
<table width="700" border="0" cellspacing="1" cellpadding="0">
  <tr>
<?php 
$pagendtime=getmicrotime();
$pagetime=round($pagendtime-$pagestartime,5);
?>
  </tr>
</table>
</body>
</html>
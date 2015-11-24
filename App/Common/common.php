<?php

/**
 * 系统缓存管理类
 */
class YdCache{
	//设置无需区分语言缓存项
	static $list = array('comment','water','upload','guestbook','stat','baidushare','link','html','other','thumb','wap','wx','order');
	//读取语言缓存
	static function readLanguage(){
		$data = F('language');
		if( empty($data) ){
			$data = YdCache::writeLanguage();
		}
		return $data;
	}
	
	//写入语言缓存，返回缓存数据
	static function writeLanguage(){
		$m = D('Admin/Language');
		$data = $m->getLanguage(1);
		$n = count($data);
		$lang = array();
		for($i = 0; $i < $n; $i++){
			unset($data[$i]['IsEnable'], $data[$i]['LanguageOrder']);
			$lang[ $data[$i]['LanguageMark'] ] = $data[$i];
		}
		F('language', $lang);  //快速缓存
		return $lang;
	}
	
	//删除缓存数据
	static function deleteLanguage(){
		F('language', NULL);
	}
	
	static function readTag(){
		$data = F('tag');
		if( empty($data) ){
			$data = YdCache::writeTag();
		}
		return $data;
	}
	
	static function writeTag(){
		$m = D('Admin/Tag');
		$where = get_language_where()." and IsEnable = 1";
		$data = $m->where($where)->getField('TagName,TagContent');
		F('tag', $data);
		return $data;
	}
	
	static function deleteTag(){
		F('tag', NULL);
	}
	
	//系统配置信息
	static function readBasic($item=false){ return YdCache::_read('basic', $item); }
	static function writeBasic(){ return YdCache::writeConfig('basic');}
	
	static function readSeo($item=false){return YdCache::_read('seo', $item);}
	static function writeSeo(){return YdCache::writeConfig('seo');}
	
	static function readLink($item=false){return YdCache::_read('link', $item);}
	static function writeLink(){return YdCache::writeConfig('link');}
	
	static function readContact($item=false){ return YdCache::_read('contact', $item);}
	static function writeContact(){ return YdCache::writeConfig('contact'); }
	
	static function readOnline($item=false){return YdCache::_read('online', $item);}
	static function writeOnline(){return YdCache::writeConfig('online');}
	
	static function readUpload($item=false){return YdCache::_read('upload', $item);}
	static function writeUpload(){return YdCache::writeConfig('upload');}
	
	static function readGuestbook($item=false){return YdCache::_read('guestbook', $item);}
	static function writeGuestbook(){return YdCache::writeConfig('guestbook');}
	
	static function readComment($item=false){return YdCache::_read('comment', $item);}
	static function writeComment(){return YdCache::writeConfig('comment');}
	
	static function readReg($item=false){return YdCache::_read('reg', $item);}
	static function writeReg(){return YdCache::writeConfig('reg');}
	
	static function readWater($item=false){return YdCache::_read('water', $item);}
	static function writeWater(){return YdCache::writeConfig('water');}
	
	static function readOrder($item=false){return YdCache::_read('order', $item);}
	static function writeOrder(){return YdCache::writeConfig('order');}
	
	static function readStat($item=false){return YdCache::_read('stat', $item);}
	static function writeStat(){return YdCache::writeConfig('stat');}
	
	static function readBaiduShare($item=false){return YdCache::_read('baidushare', $item);}
	static function writeBaiduShare(){return YdCache::writeConfig('baidushare');}
	
	static function writeCore(){return YdCache::writeConfig('core');}
	static function writeHomeConfig(){return YdCache::writeConfig('home/config');}
	static function writeWapConfig(){return YdCache::writeConfig('wap/config');}
	static function writeDomain(){return YdCache::writeConfig('domain');}
	
	static function readHtml($item=false){return YdCache::_read('html', $item);}
	static function writeHtml(){return YdCache::writeConfig('html');}
	
	static function readThumb($item=false){return YdCache::_read('thumb', $item);}
	static function writeThumb(){return YdCache::writeConfig('thumb');}
	
	static function readWap($item=false){return YdCache::_read('wap', $item);}
	static function writeWap(){return YdCache::writeConfig('wap');}
	
	static function readOther($item=false){return YdCache::_read('other', $item);}
	static function writeOther(){return YdCache::writeConfig('other');}
	
	static function readWx($item=false){return YdCache::_read('wx', $item);}
	static function writeWx(){return YdCache::writeConfig('wx');}
	
	static function _read($type, $item=false){
		$data = YdCache::readConfig($type);
		if( $item !== false ){
			$data = $data[$item];
		}
		return $data;
	}
	
	//清除频道缓存
	static function writeChannel(){
		$m = D('Admin/Channel');
		$m->WriteCache(); //写入频道缓存
	}
	
	static function readConfig($ConfigFile){
		$file = (in_array($ConfigFile, YdCache::$list)) ? $ConfigFile : $ConfigFile.'_'.get_language_mark();
		$data = F($file);
		if( empty($data) ){
			YdCache::writeConfig($ConfigFile);
			$data = F($file);
		}
		return $data;
	}

	static function writeConfig($ConfigFile){
		$m = D('Admin/Config');
		if($ConfigFile == 'core'){ //core缓存到配置目录
			$savefile = CONF_PATH.'core.php';
			$data = $m->getConfig($ConfigFile);
			$b = cache_array($data, $savefile);
			return $data;	
		}
		
		if($ConfigFile == 'home/config'){ //core缓存到配置目录
			$savefile = CONF_PATH.'Home/config.php';
			$data = $m->getConfig($ConfigFile);
			if( empty($data['DEFAULT_THEME']) ){
				$data['DEFAULT_THEME'] = 'Default';
			}
			$b = cache_array($data, $savefile);
			return $data;
		}
		
		if($ConfigFile == 'wap/config'){ //core缓存到配置目录
			$savefile = CONF_PATH.'Wap/config.php';
			$data = $m->getConfig($ConfigFile);
			if( empty($data['DEFAULT_THEME']) ){
				$data['DEFAULT_THEME'] = 'Default';
			}
			$b = cache_array($data, $savefile);
			return $data;
		}
		
		//缓存域名配置到缓存
		if($ConfigFile == 'domain'){
			$savefile = CONF_PATH.'domain.php';
			$data = $m->getConfig($ConfigFile);
			$domain = array('APP_SUB_DOMAIN_RULES'=>array());
			if( empty($data) ) {
				cache_array($domain, $savefile); //写入空
				return false;
			}
			$dList = explode(',', trim($data['WAP_URL']));
			foreach( (array)$dList as $d){
				if(!empty($d)){
					$d = str_ireplace('http://', '', $d); //去掉http://
					$temp[$d] = array('wap/');
				}
			}
			$domain['APP_SUB_DOMAIN_RULES'] = $temp;			
			$b = cache_array($domain, $savefile);
			return $data;
		}
		
		//html缓存
		if($ConfigFile == 'html'){
			$savefile = CONF_PATH.'html.php';
			$data = $m->getConfig($ConfigFile);
			$htmlEnable = ($data['HTML_ENABLE'] == 1) ? true : false;
			//Html首页缓存时间
			$IndexCacheTime = $data['INDEX_CACHE_TIME'];
			//$IndexCacheTime = is_numeric($IndexCacheTime) ? "'$IndexCacheTime'" : "'0'";
			
			//Html频道缓存时间
			$ChannelCacheTime = $data['CHANNEL_CACHE_TIME'];
			//$ChannelCacheTime = is_numeric($ChannelCacheTime) ? "'$ChannelCacheTime'" : "'0'";
			
			//Html信息缓存时间
			$InfoCacheTime = $data['INFO_CACHE_TIME'];
			//$InfoCacheTime = is_numeric($InfoCacheTime) ? "'$InfoCacheTime'" : "'0'";

			$html = array (
					'HTML_CACHE_ON' => $htmlEnable,
					'HTML_CACHE_RULES'=> array(
							'index:index'=>array('{:group}/index_{0|get_language_mark}', $IndexCacheTime),  
							'channel:index'=>array('{:group}/channel/{id}{jobid}{infoid}_{0|get_language_mark}_{0|get_para}', $ChannelCacheTime),  
							'info:read'=>array('{:group}/info/{id}_{0|get_para}', $InfoCacheTime), 
					)
			);
			$b = cache_array($html, $savefile);
			return $data;
		}
		
		//设置无需区分语言缓存项
		$file = $ConfigFile;
		if( in_array($ConfigFile, YdCache::$list) ){
			$data = $m->getConfig($ConfigFile);
			F($file, $data);  //快速缓存
		}else{ //需要缓存所有语言
			$lang = YdCache::readLanguage();
			foreach ($lang as $k=>$v){
				$file = $ConfigFile.'_'.$v['LanguageMark'];
				$where = '(LanguageID='.$v['LanguageID'].' or LanguageID=0)';
				$where .= " and IsEnable = 1 and ConfigFile='$ConfigFile'";
				$data = $m->where($where)->getField('ConfigName,ConfigValue');
				F($file, $data);  //快速缓存
			}
		}
		return $data;
	}
	static function deleteConfig(){
		$dir = RUNTIME_PATH.'Data';
		if(is_dir( $dir )){
			@deldir( $dir );
		}
	}
	
	//清除home模板缓存
	static function deleteHome(){
		$dir = RUNTIME_PATH.'Cache/Home';
		if(is_dir( $dir )){
			@deldir( $dir );
		}
	}
	
	//清除home模板缓存
	static function deleteWap(){
		$dir = RUNTIME_PATH.'Cache/Wap';
		if(is_dir( $dir )){
			@deldir( $dir );
		}
	}
	
	static function deleteAdmin(){
		$dir = RUNTIME_PATH.'Cache/Admin';
		if(is_dir( $dir )){
			@deldir( $dir );
		}
	}
	
	//清楚数据库字段缓存
	static function deleteTemp(){
		$dir = RUNTIME_PATH.'Temp';
		if(is_dir( $dir )){
			@deldir( $dir );
		}
	}
	
	/**
	 * 删除单个信息Html静态缓存
	 * @param int $InfoID
	 * @param string $Html  静态缓存文件名
	 */
	static function deleteInfoHtml($InfoID, $Html=false){
		$suffix = C('URL_HTML_SUFFIX');
		$filename = empty( $Html ) ? "$InfoID" : "$Html";
		$homeFile = HTML_PATH.'Home/info/'.$filename.'.'.$suffix;
		if( is_file($homeFile) ){
			@unlink($homeFile);
		}
		
		$wapFile = HTML_PATH.'Wap/info/'.$filename.'.'.$suffix;
		if( is_file($wapFile) ){
			@unlink($wapFile);
		}
	}
	
	/**
	 * 删除频道Html静态缓存
	 * @param int $ChannelID
	 * @param string $Html  静态缓存文件名
	 */
	static function deleteChannelHtml($Html){
		$suffix = C('URL_HTML_SUFFIX');
		$ext = $Html.'_'.LANG_SET.'.'.$suffix;
		$file = HTML_PATH.'Home/channel/'.$ext;
		if( is_file($file) ){
			@unlink($file);
		}

		$file = HTML_PATH.'Wap/channel/'.$ext;
		if( is_file( $file) ){
			@unlink($file);
		}
	}
	
	/**
	 * 清除Html静态缓存
	 */
	static function deleteHtml($type){
		$type = strtolower($type);
		import('ORG.Io.Dir');
		$dir = new Dir();
		switch($type){
			case 'channel': //频道Html缓存
				$path = HTML_PATH.'Home/channel';
				if( is_dir($path) ){
					@$dir->del( $path );
				}
				
				$path = HTML_PATH.'Wap/channel';
				if( is_dir($path) ){
					@$dir->del( $path );
				}
				break;
			case 'info': //信息Html缓存
				$path = HTML_PATH.'Home/info';
				if( is_dir($path) ){
					$dir->del( $path );
				}
				$path = HTML_PATH.'Wap/info';
				if( is_dir($path) ){
					$dir->del( $path );
				}
				break;
			case 'all':   //全部Html缓存
				if(is_dir( HTML_PATH )){
					@deldir( HTML_PATH );
				}
				break;
			case 'index':  //首页Html缓存
			default:
				$cnName = ChannelHtml(1);
				$enName = ChannelHtml(2);
				$suffix = C('URL_HTML_SUFFIX');
				$filelist = array(
						//Home分组=============================
						HTML_PATH.'Home/channel/'.$cnName.'_cn.'.$suffix,
						HTML_PATH.'Home/channel/'.$enName.'_en.'.$suffix,
						HTML_PATH.'Home/index_cn.'.$suffix,
						HTML_PATH.'Home/index_en.'.$suffix,
						//Wap分组=============================
						HTML_PATH.'Wap/channel/'.$cnName.'_cn.'.$suffix,
						HTML_PATH.'Wap/channel/'.$enName.'_en.'.$suffix,
						HTML_PATH.'Wap/index_cn.'.$suffix,
						HTML_PATH.'Wap/index_en.'.$suffix,
				);
				foreach ($filelist as $f){
					if( is_file($f) ){
						@unlink($f);
					}
				}
				break;
		}
}
	
	/**
	 * 删除所有缓存
	 */
	static function deleteAll(){
		$dir = RUNTIME_PATH;
		if(is_dir( $dir )){
			@deldir( $dir );
			@mkdir($dir); //创建目录
		}
	}
	
	/**
	 * 写入所有缓存
	 */
	static function writeAll(){
		YdCache::deleteAll();
		//仅更新Core，home/config即可，其它缓存会自动生成
		YdCache::writeCore(); 
		YdCache::writeHomeConfig(); //重写Home分组主题名称
		YdCache::writeWapConfig();   //重写Wap分组主题名称
		YdCache::writeDomain();   //重写多域名配置缓存
		YdCache::writeHtml();        //重写Html静态规则配置
		
		YdCache::writeWater();
		YdCache::writeUpload();
		
		YdCache::writeBaiduShare();
		YdCache::writeBasic();
		YdCache::writeComment();
		YdCache::writeContact();
		YdCache::writeGuestbook();
		YdCache::writeTag();
		YdCache::writeThumb();
		YdCache::writeSeo();
		
		YdCache::writeReg();
		YdCache::writeOrder();
		YdCache::writeStat();
		YdCache::writeWap();
		YdCache::writeOther();
		
		YdCache::writeChannel(); //频道缓存
	}
}


class dbmysq {

	var $querynum = 0;
	var $link;
	var $histories;
	var $time;
	var $tablepre;

	function connect($dbhost, $dbuser, $dbpw, $dbname = '', $dbcharset, $pconnect = 0, $tablepre = '', $time = 0) {
		$this->time = $time;
		$this->tablepre = $tablepre;
		if ($pconnect) {
			if (!$this->link = mysql_pconnect($dbhost, $dbuser, $dbpw)) {
				$this->halt('Can not connect to MySQL server');
			}
		} else {
			if (!$this->link = mysql_connect($dbhost, $dbuser, $dbpw, 1)) {
				$this->halt('Can not connect to MySQL server');
			}
		}

		if ($this->version() > '4.1') {
			if ($dbcharset) {
				mysql_query("SET character_set_connection=" . $dbcharset . ", character_set_results=" . $dbcharset . ", character_set_client=binary", $this->link);
			}

			if ($this->version() > '5.0.1') {
				mysql_query("SET sql_mode=''", $this->link);
			}
		}

		if ($dbname) {
			mysql_select_db($dbname, $this->link);
		}
	}

	function fetch_array($query, $result_type = MYSQL_ASSOC) {
		return mysql_fetch_array($query, $result_type);
	}

	function result_first($sql, &$data) {
		$query = $this->query($sql);
		$data = $this->result($query, 0);
	}

	function fetch_first($sql, &$arr) {
		$query = $this->query($sql);
		$arr = $this->fetch_array($query);
	}

	function fetch_all($sql, &$arr) {
		$query = $this->query($sql);
		while ($data = $this->fetch_array($query)) {
			$arr[] = $data;
		}
	}

	function cache_gc() {
		$this->query("DELETE FROM {$this->tablepre}sqlcaches WHERE expiry<$this->time");
	}

	function query($sql, $type = '', $cachetime = FALSE) {
		$func = $type == 'UNBUFFERED' && @function_exists('mysql_unbuffered_query') ? 'mysql_unbuffered_query' : 'mysql_query';
		if (!($query = $func($sql, $this->link)) && $type != 'SILENT') {
			$this->halt('MySQL Query Error', $sql);
		}
		$this->querynum++;
		$this->histories[] = $sql;
		return $query;
	}

	function affected_rows() {
		return mysql_affected_rows($this->link);
	}

	function error() {
		return (($this->link) ? mysql_error($this->link) : mysql_error());
	}

	function errno() {
		return intval(($this->link) ? mysql_errno($this->link) : mysql_errno());
	}

	function result($query, $row) {
		$query = @mysql_result($query, $row);
		return $query;
	}

	function num_rows($query) {
		$query = mysql_num_rows($query);
		return $query;
	}

	function num_fields($query) {
		return mysql_num_fields($query);
	}

	function free_result($query) {
		return mysql_free_result($query);
	}

	function insert_id() {
		return ($id = mysql_insert_id($this->link)) >= 0 ? $id : $this->result($this->query("SELECT last_insert_id()"), 0);
	}

	function fetch_row($query) {
		$query = mysql_fetch_row($query);
		return $query;
	}

	function fetch_fields($query) {
		return mysql_fetch_field($query);
	}

	function version() {
		return mysql_get_server_info($this->link);
	}

	function close() {
		return mysql_close($this->link);
	}

	function halt($message = '', $sql = '') {
		exit('<br/>提示：数据库错误<br/>SQL语句：' . $sql . '<br/>错误关键字：' . mysql_error());
	}

}

//弹框信息
function alert($msg,$url){
	header('Content-type: text/html; charset=utf-8');
	$msg = str_replace("'","\\'",$msg);
	$str = '<script>';
	$str.="alert('".$msg."');";
	switch($url){
		case 1:
			$s = 'window.history.go(-1);';
			break;
		case 2:
			$s = 'window.history.go(-2);';
			break;
		case 3:
			$s = 'self.close();';
			break;
		default:
			$s = "location.href='{$url}';";
	}
	$str.=$s;
	$str.='</script>';
	exit($str);
}

//删除目录函数
function deldir($dirname){
	if(file_exists($dirname)){
		$dir = opendir($dirname);
		while( $filename = readdir($dir) ){
			if($filename != "." && $filename != ".."){
				$file = $dirname."/".$filename;
				if(is_dir($file)){
					deldir($file); //使用递归删除子目录
				}else{
					@unlink($file);
				}
			}
		}
		closedir($dir);
		rmdir($dirname);
	}
}

//清除所有缓存
function clear_all_cache(){
	if(is_dir(RUNTIME_PATH)){
		@deldir(RUNTIME_PATH);
	}
}


//获取文件夹大小
function getdirsize($dir){
	$dirlist = opendir($dir);
	$dirsize = 0;
	while (false !==  ($folderorfile = readdir($dirlist))){
		if($folderorfile != "." && $folderorfile != ".."){
			if (is_dir("$dir/$folderorfile")){
				$dirsize += getdirsize("$dir/$folderorfile");
			}else{
				$dirsize += filesize("$dir/$folderorfile");
			}
		}
	}
	closedir($dirlist);
	return $dirsize;
}

//获取时间颜色:24小时内为红色
function getColorDate($type='Y-m-d H:i:s', $time, $color='red'){
	if((time()-$time)>86400){
		return date($type,$time);
	}else{
		return '<font color="'.$color.'">'.date($type,$time).'</font>';
	}
}

//获取模板类型名称
function getTplFileType($filename){
	$f = explode('.',$filename);
	$ext = strtolower( $f[1]);
	switch( $ext ){
		case 'js':
			return 'js脚本文件';
			break;
		case 'php':
			return 'php脚本文件';
			break;
		case 'css':
			return '层叠样式表';
			break;
		case 'jpg':
			return 'jpg图片';
			break;
		case 'gif':
			return 'gif图片';
			break;
		case 'png':
			return 'png图片';
			break;
		case 'zip':
			return 'zip压缩包';
			break;
		case 'rar':
			return 'rar压缩包';
			break;
		case 'html':
			return '模板文件';
			break;
		case 'htm':
			return '网页文件';
			break;
		case 'ico':
			return 'ico图标';
			break;
		case 'wmv':
			return 'wmv视频文件';
			break;
		case 'swf':
			return 'flash文件';
			break;
		case 'wma':
			return 'wma音频文件';
			break;
		case 'mp3':
			return 'mp3音频文件';
			break;
		case 'flv':
			return 'flv视频文件';
			break;
		case 'mp4':
			return 'mp4视频文件';
			break;
		case 'xml':
			return 'xml文件';
			break;			
		default:
			return '未知文件';
			break;
	}
}

//获取全局优化标题
function get_title($ChannelID){
	$seo = YdCache::readSeo();
	if( !is_numeric( $ChannelID ) ) return $seo['TITLE'];
	$m = D('Admin/Channel');
	while(true){
		//$data = $m->where("ChannelID=$ChannelID")->getField('Title,Parent');
		$data = $m->field('Title,Parent')->find($ChannelID);
		if( !empty($data['Title']) ) return $data['Title'];
		if( $data['Parent'] == 0 ) return $seo['TITLE'];
		$ChannelID = $data['Parent'];
	}
}

//获取全局优化关键词
function get_keywords($ChannelID){
	$seo = YdCache::readSeo();
	if( !is_numeric( $ChannelID ) ) return $seo['KEYWORDS'];
	$m = D('Admin/Channel');
	while(true){
		//$data = $m->where("ChannelID=$ChannelID")->getField('Keywords,Parent');
		$data = $m->field('Keywords,Parent')->find($ChannelID);
		if( !empty($data['Keywords']) ) return $data['Keywords'];
		if( $data['Parent'] == 0 ) return $seo['KEYWORDS'];
		$ChannelID = $data['Parent'];
	}
}
//获取全局优化描述
function get_description($ChannelID){
	$seo = YdCache::readSeo();
	if( !is_numeric( $ChannelID ) ) return $seo['DESCRIPTION'];
	$m = D('Admin/Channel');
	while(true){
		//$data = $m->where("ChannelID=$ChannelID")->getField('Description,Parent');
		$data = $m->field('Description,Parent')->find($ChannelID);
		if( !empty($data['Description']) ) return $data['Description'];
		if( $data['Parent'] == 0 ) return $seo['DESCRIPTION'];
		$ChannelID = $data['Parent'];
	}
}

//获取网站安装目录
function get_web_install(){
	$installDir = $_SERVER['DOCUMENT_ROOT'].__ROOT__;
	return $installDir;
}

//自动获取当前网站地址（含安装目录）, 返回如：http://192.168.1.10/FZYCMS4.0
//$hasProtocol 是否包http://含协议头
function get_web_url($hasProtocol = true, $hasPath=true){
	$url = $hasProtocol ? 'http://' : '';
	$url .= $_SERVER['HTTP_HOST']; //$_SERVER['HTTP_HOST']返回带端口号，80端口为默认
	$url .= $hasPath ? __ROOT__ : '';
	return $url;
}

//返回微信网站当前绝对地址，返回如：http://192.168.1.10/FZYCMS4.0/index.php
function get_wx_url($protocol='http://'){
	/*
	$v = C('URL_MODEL');
	$url = get_web_url(true);
	if($v == 1){
		$url .= '/index.php';
	}
	$url .= '/wap';
	return $url;
	*/
	//$url = $protocol.$_SERVER['HTTP_HOST'].__GROUP__;
	
	//当把DefaultGroup设为Wap后，以上语句存在Bug，频道地址会链接到电脑网站首页
	$url = $protocol.$_SERVER['HTTP_HOST'].__APP__.'/wap';
	return $url;
}

//判断当前用户是否有阅读当前信息的阅读权限
//返回false或true
//$readlevel：当前信息或频道的阅读权限
function has_read_level($readlevel){
	//如果是管理员，则拥有所有的阅读权限，阅读权限主要用于会员分组
	if( session('?AdminID') || empty($readlevel) ){
		return true;   
	}
	$list = explode(',', $readlevel);
	$MemberGroupID = session('MemberGroupID');
	if( in_array($MemberGroupID, $list)){
		return true;
	}
	return false;
}

//获取频道阅读权限
function get_read_level($ChannelID){
	$m = D('Admin/Channel');
	while(true){
		$data = $m->field('ReadLevel,Parent')->find($ChannelID);
		if( !empty($data['ReadLevel']) || $data['Parent'] == 0) return $data['ReadLevel'];
		$ChannelID = $data['Parent'];
	}
}

//获取网站根目录
function get_web_root(){
	return $_SERVER['DOCUMENT_ROOT'];
}

//缓存数组到文件, $keyUpper:是否将key转换为大写
function cache_array( $data, $fileName, $keyUpper = true){
	if( empty($data) ) {
		$content	=  "<?php\nreturn array();\n?>";
	}else{
		if($keyUpper){
			$content	=  "<?php\nreturn ".var_export(array_change_key_case($data, CASE_UPPER),true).";\n?>";
		}else{
			$content	=  "<?php\nreturn ".var_export($data, true).";\n?>";
		}
	}

	if(file_put_contents($fileName, $content)){
		return true;
	}else{
		return false;
	}
}

/**
 * 用于添加信息时验证频道是否能添加信息
 * 单页模型32和链接模型33不能添加信息
 * @param int $ChannelID
 */
function channel_allow($ChannelID){
	$where = "ChannelID=$ChannelID and ChannelModelID!=32 and  ChannelModelID!=33 and   ChannelModelID!=37";
	$n = D('Admin/Channel')->where($where)->count();
	if($n > 0) {
		return true;
	}else{
		return false;
	}
}


/**
 * 语言查询条件(作为第一个条件最好)
 * @param string $alias 表别名
 */
function get_language_where($alias = false){
	$str = (!empty($alias)) ? $alias.'.' : '';
	$LanguageID = get_language_id();
	$where = ' '.$str."LanguageID = $LanguageID ";
	return $where;
}

/**
 * 获取当前语言
 */
function get_language_id(){
	return LANG_ID;
}

/**
 * 获取当前语言标识符
 */
function get_language_mark(){
	return LANG_SET;
}

function get_para(){
	$p = trim( $_REQUEST['p'] );
	if( empty($p) ) $p = 1;
	return $p;
}

function get_wx_para(){
	$v = '';
	if( isset($_GET['wx']) && $_GET['wx'] == 1){
		$v = '_wx';
	}
	return $v;
}

function sql_split($sql){
	$sql = str_replace("\r\n", "\n", $sql);
	$sql = str_replace("\r", "\n", $sql);
	$ret = array();
	$num = 0;
	$sqlList = explode(";\n", trim($sql));
	foreach ($sqlList as $query) {
		$ret[$num] = '';
		$queries = explode("\n", trim($query));
		foreach ($queries as $query) {//去注释
			$ret[$num] .= ( isset($query[0]) && $query[0] == '#') || (isset($query[1]) && isset($query[1]) && $query[0] . $query[1] == '--') ? '' : $query;
		}
		$num++;
	}
	unset($sql);
	return $ret;
}

/**
 * 批量删除文件
 * @param array $fileToDelete
 */
function batchDelFile($fileToDelete){
	if( is_array($fileToDelete) ){
		foreach ($fileToDelete as $f){
			$b = unlink($f);
		}
	}else{
		$b = unlink($fileToDelete);
	}
}

//给图片添加水印
function addWater($imageFile, $saveFile=''){
	if ( !file_exists($imageFile) ) return;
	if( !yd_is_image( $imageFile) ) return ;
	$data = YdCache::readWater();
	$WaterEnable = $data['WATER_ENABLE'];
	if( $WaterEnable == 1){
		import('ORG.Util.Image.ThinkImage');
		$img = new ThinkImage(THINKIMAGE_GD, $imageFile);
		$position = $data['WATER_POSITION'];
		$saveFile = empty($saveFile) ? $imageFile : $saveFile;
		if( $data['WATER_TYPE'] == 2 ){//文字水印
			$text = $data['WATER_TEXT'];
			$font = './Public/font/'.$data['WATER_FONT'];
			if( !is_file($font)) return;  //水印字体不存在则直接返回
			$size = $data['WATER_TEXT_SIZE'];
			$color= $data['WATER_TEXT_COLOR'];
			$angle = $data['WATER_TEXT_ANGLE'];
			$offset = array($data['WATER_OFFSET_X'],$data['WATER_OFFSET_Y']);
			$img->text($text, $font, $size, $color, $position, $offset, $angle)->save($saveFile);
		}else if( $data['WATER_TYPE'] == 1 ){ //图片水印
			/*
			$pic = $_SERVER['DOCUMENT_ROOT'].$data['WATER_PIC'];
			if ( !file_exists($pic) ){
				return;
			}
			$right = $data['WATER_RIGHT'];
			$bottom = $data['WATER_BOTTOM'];
			$trans = $data['WATER_TRANS'];
			import("ORG.Util.Image");
			Image::water($imageFile, $pic, null, $trans, $right, $bottom);
			*/
			$pic = $_SERVER['DOCUMENT_ROOT'].$data['WATER_PIC'];
			if ( !file_exists($pic) ) return;
			$img->water($pic, $position)->save($saveFile);
		}
	}
}


/**
 * 生成缩略图
 * @param string $imageFile
 */
function makeThumb($imageFile){
	if( !file_exists($imageFile) ) return false;
	if( !yd_is_image( $imageFile) ) return false;
	$data = YdCache::readThumb();
	if( $data['THUMB_ENABLE'] == 1 ){
		$w = $data['THUMB_WIDTH'];   //缩略图宽度
		$h = $data['THUMB_HEIGHT'];  //缩略图高度
		$type = $data['THUMB_TYPE'];   //缩略图类型
		$filename = './Upload/thumb'.basename($imageFile);
		import('ORG.Util.Image.ThinkImage');
		$img = new ThinkImage(THINKIMAGE_GD, $imageFile);
		$img->thumb($w, $h, $type)->save($filename);
		if( $data['THUMB_WATER_ENABLE'] == 1 ){ //是否添加水印
			addWater($filename);
		}
		return $filename;
	}else{
		return $imageFile;
	}
}

?>
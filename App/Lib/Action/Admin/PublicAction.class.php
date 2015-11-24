<?php
/*********************/
/*                   */
/*  Version : 5.1.0  */
/*  Author  : RM     */
/*  Comment : 071223 */
/*                   */
/*********************/

class PublicAction extends AdminBaseAction
{

		public function index( )
		{
				redirect( __URL__."/Login" );
		}

		public function login( )
		{
				header( "Content-Type:text/html; charset=utf-8" );
				if ( $this->isLogin( ) )
				{
						redirect( __URL__."/AdminIndex" );
				}
				$this->display( );
		}

		public function logOut( )
		{
				header( "Content-Type:text/html; charset=utf-8" );
				session( "AdminID", NULL );
				session( "AdminName", NULL );
				session( "AdminGroupID", NULL );
				session( "AdminGroupName", NULL );
				session( "AdminMemberID", NULL );
				redirect( __URL__."/Login" );
		}

		public function checkLogin( )
		{
				header( "Content-Type:text/html; charset=utf-8" );
				$AdminName = trim( $_POST['username'] );
				$AdminPassword = trim( $_POST['password'] );
				$verifyCode = trim( $_POST['verifycode'] );
				if ( empty( $AdminName ) )
				{
						session( "verify", rand( 1000, 9999 ) );
						$this->ajaxReturn( NULL, "用户名不能为空1!", 0 );
				}
				if ( empty( $AdminPassword ) )
				{
						session( "verify", rand( 1000, 9999 ) );
						$this->ajaxReturn( NULL, "密码不能为空!", 0 );
				}
				if ( empty( $verifyCode ) )
				{
						session( "verify", rand( 1000, 9999 ) );
						$this->ajaxReturn( NULL, "验证码不能为空!", 0 );
				}
				$verifyCode2 = session( "verify" );
				if ( md5( $verifyCode ) != $verifyCode2 )
				{
						session( "verify", rand( 1000, 9999 ) );
						$this->ajaxReturn( NULL, "验证码错误!", 0 );
				}
				$admin = d( "Admin/Admin" );
				$result = $admin->checkLogin( $AdminName, md5( $AdminPassword ) );
				if ( $result == 0 )
				{
						$this->ajaxReturn( NULL, "用户名或密码错误!", 0 );
				}
				else if ( $result == 1 )
				{
						$this->ajaxReturn( NULL, "账户已被锁定!", 0 );
				}
				else if ( $result == 2 )
				{
						$this->ajaxReturn( NULL, "管理组不存在", 0 );
				}
				else if ( is_array( $result ) )
				{
						$admin->UpdateLogin( $result['AdminID'] );
						session( "AdminID", $result['AdminID'] );
						session( "AdminMemberID", $result['MemberID'] );
						session( "AdminName", $result['AdminName'] );
						session( "AdminGroupID", $result['AdminGroupID'] );
						session( "AdminGroupName", $result['AdminGroupName'] );
						session( "verify", rand( 1000, 9999 ) );
						$this->ajaxReturn( rand( 1000, 9999 ), "登录成功", 1 );
				}
		}

		private function getCurrentMenuTopID( )
		{
				if ( isset( $_GET['MenuTopID'] ) )
				{
						$id = $_GET['MenuTopID'];
						cookie( "MenuTopID", $id );
						return $id;
				}
				if ( cookie( "MenuTopID" ) )
				{
						$id = cookie( "MenuTopID" );
						return $id;
				}
				$id = 1;
				return $id;
		}

		public function adminTop( )
		{
				header( "Content-Type:text/html; charset=utf-8" );
				$m = d( "Admin/MenuTop" );
				$gid = session( "AdminGroupID" );
				if ( $gid == 1 )
				{
						$MenuTop = $m->getMenuTop( array( "MenuOwner" => 1 ) );
				}
				else
				{
						$MenuTop = $m->getMenuTopPurview( 1, $gid );
				}
				$MenuTopID = $this->getCurrentMenuTopID( );
				$this->assign( "MenuTopID", $MenuTopID );
				$this->assign( "MenuTop", $MenuTop );
				$this->display( );
		}

		public function adminLeft( )
		{
				header( "Content-Type:text/html; charset=utf-8" );
				$MenuTopID = $this->getCurrentMenuTopID( );
				$mg = d( "Admin/MenuGroup" );
				$m = d( "Admin/Menu" );
				$gid = session( "AdminGroupID" );
				if ( $gid == 1 )
				{
						$MenuGroup = $mg->getMenuGroup( $MenuTopID );
						$Menu = $m->getMenu( );
				}
				else
				{
						$MenuGroup = $mg->getMenuGroupPurview( 1, $gid, $MenuTopID );
						$Menu = $m->getMenuPurview( 1, $gid );
				}
				if ( $MenuTopID == 3 )
				{
						$c = d( "Admin/Channel" );
						$Channel = $gid == 1 ? $c->getChannelList( 0, -1, "" ) : $c->getChannelPurview( 1, $gid, "" );
						$n = count( $Channel );
						$maxDepth = -9999;
						$j = 0;
						for ( ;	$j < $n;	++$j	)
						{
								if ( $maxDepth < $Channel[$j]['ChannelDepth'] )
								{
										$maxDepth = $Channel[$j]['ChannelDepth'];
								}
						}
						$i = 0;
						for ( ;	$i < $n;	++$i	)
						{
								$Channel[$i]['HasChild'] = $c->hasChildChannel( $Channel[$i]['ChannelID'] );
								$Channel[$i]['ChannelDepth'] = $maxDepth - $Channel[$i]['ChannelDepth'] + 1;
						}
						$this->assign( "Channel", $Channel );
				}
				$this->assign( "MenuTopID", $MenuTopID );
				$this->assign( "Menu", $Menu );
				$this->assign( "MenuGroup", $MenuGroup );
				$this->assign( "AdminName", session( "AdminName" ) );
				$this->assign( "AdminGroupName", session( "AdminGroupName" ) );
				$this->display( );
		}

		public function adminBottom( )
		{
				header( "Content-Type:text/html; charset=utf-8" );
				$this->display( );
		}

		public function adminIndex( )
		{
				header( "Content-Type:text/html; charset=utf-8" );
				$MenuTopID = $this->getCurrentMenuTopID( );
				$this->assign( "MenuTopID", $MenuTopID );
				$this->display( );
		}

		public function setLanguage( )
		{
				redirect( __URL__."/AdminIndex" );
		}

		public function welcome( )
		{
				header( "Content-Type:text/html; charset=utf-8" );
				import( "@.Common.YdUpgrade" );
				import( "@.Common.YdServerInfo" );
				$s = new YdServerInfo( );
				$admin = d( "Admin/Admin" );
				$u = new YdUpgrade( $this->YouDianCMSVersion );
				$LastestVersion = $u->getLatestVersion( );
				$LastestDate = $u->getLatestDate( );
				$needUpgrade = $u->needUpgrade( ) ? 1 : 0;
				$info = $s->getServerInfo( );
				$adminInfo = $admin->find( session( "AdminID" ) );
				$para = "?version=".$this->CMSVersion."&host=".$_SERVER['HTTP_HOST']."&os=".PHP_OS;
				if ( strtolower( $this->CMSEnName ) == "youdiancms" )
				{
						$para .= "&oem=0";
				}
				else
				{
						$oem = urlencode( "{$this->CMSName}-{$this->CompanyName}-{$this->CompanyUrl}" );
						$para .= "&oem=".$oem;
				}
				$this->assign( "LastestDate", $LastestDate );
				$this->assign( "LastestVersion", $LastestVersion );
				$this->assign( "NeedUpgrade", $needUpgrade );
				$this->assign( "LastLoginTime", $adminInfo['LastLoginTime'] );
				$this->assign( "LastLoginIP", $adminInfo['LastLoginIP'] );
				$this->assign( "Server", $info );
				$this->display( );
		}

		public function upgrade( )
		{
				import( "@.Common.YdUpgrade" );
				$u = new YdUpgrade( $this->YouDianCMSVersion );
				$b = $u->needUpgrade( );
				if ( !$b )
				{
						$this->ajaxReturn( NULL, "已经是最新版本！", 2 );
				}
				$b = $u->start( );
				$u->deleteAll( );
				if ( $b )
				{
						$this->ajaxReturn( NULL, "升级成功！", 1 );
				}
				else
				{
						$this->ajaxReturn( NULL, "升级失败！", 0 );
				}
		}

		public function pwd( )
		{
				header( "Content-Type:text/html; charset=utf-8" );
				if ( $_POST['Action'] == "save" )
				{
						$admin = d( "Admin/Admin" );
						$pwd1 = trim( $_POST['pwd1'] );
						$pwd2 = $_POST['pwd2'];
						$pwd3 = $_POST['pwd3'];
						if ( empty( $pwd1 ) )
						{
								$this->ajaxReturn( NULL, "原始密码不能为空!", 0 );
						}
						if ( empty( $pwd2 ) )
						{
								$this->ajaxReturn( NULL, "新密码不能为空!", 0 );
						}
						if ( empty( $pwd3 ) )
						{
								$this->ajaxReturn( NULL, "重复密码不能为空!", 0 );
						}
						if ( $pwd2 != $pwd3 )
						{
								$this->ajaxReturn( NULL, "二次输入的密码不一致!", 0 );
						}
						if ( $pwd1 == $pwd3 )
						{
								$this->ajaxReturn( NULL, "新密码不能和原始密码相同!", 0 );
						}
						$b = $admin->exist( session( "AdminName" ), md5( $pwd1 ) );
						if ( !$b )
						{
								$this->ajaxReturn( NULL, "原密码错误!", 0 );
						}
						$adminID = session( "AdminID" );
						$r = $admin->where( "AdminID=".$adminID )->setField( "AdminPassword", md5( $pwd2 ) );
						if ( $r )
						{
								$this->ajaxReturn( NULL, "修改密码成功!", 1 );
						}
						else
						{
								$this->ajaxReturn( NULL, "修改密码失败!", 0 );
						}
				}
				$this->assign( "Action", __URL__."/pwd" );
				$this->display( );
		}

		public function browser( )
		{
				header( "Content-Type:text/html; charset=utf-8" );
				$this->display( );
		}

		public function clearCache( )
		{
				header( "Content-Type:text/html; charset=utf-8" );
				$action = strtolower( $_REQUEST['Action'] );
				cookie( "MenuTopID", NULL );
				switch ( $action )
				{
				case "systemcache" :
						YdCache::writeall( );
						$this->ajaxReturn( NULL, "清除系统缓存成功！", 1 );
						break;
				case "modelcache" :
						YdCache::deletetemp( );
						$this->ajaxReturn( NULL, "清除频道模型缓存成功！", 1 );
						break;
				case "homecache" :
						YdCache::deletehome( );
						$this->ajaxReturn( NULL, "清除模板缓存成功！", 1 );
						break;
				case "wapcache" :
						YdCache::deletewap( );
						$this->ajaxReturn( NULL, "清除模板缓存成功！", 1 );
						break;
				case "indexhtmlcache" :
						YdCache::deletehtml( "index" );
						$this->ajaxReturn( NULL, "清除首页Html缓存成功！", 1 );
						break;
				case "channelhtmlcache" :
						YdCache::deletehtml( "channel" );
						$this->ajaxReturn( NULL, "清除频道首页Html缓存成功！", 1 );
						break;
				case "infohtmlcache" :
						YdCache::deletehtml( "info" );
						$this->ajaxReturn( NULL, "清除内容页面Html缓存成功！", 1 );
						break;
				case "allhtmlcache" :
						YdCache::deletehtml( "all" );
						$this->ajaxReturn( NULL, "清除全部Html缓存成功！", 1 );
						break;
				case "saveconfig" :
						if ( isset( $_POST ) )
						{
								break;
						}
						if ( is_numeric( $_POST['INDEX_CACHE_TIME'] ) )
						{
								if ( is_numeric( $_POST['CHANNEL_CACHE_TIME'] ) )
								{
								}
						}
						if ( !is_numeric( $_POST['INFO_CACHE_TIME'] ) )
						{
								$this->ajaxReturn( NULL, "缓存时间必须为数字！", 0 );
						}
						unset( $_POST['__hash__'] );
						$m = d( "Admin/Config" );
						if ( $m->saveConfig( $_POST, "html" ) )
						{
								$this->ajaxReturn( NULL, "保存配置成功!", 1 );
						}
						else
						{
								$this->ajaxReturn( NULL, "保存配置失败!", 0 );
						}
				}
				$m = d( "Admin/Config" );
				$data = $m->getConfig( "html" );
				$this->assign( "HtmlEnable", $data['HTML_ENABLE'] );
				$this->assign( "IndexCacheTime", $data['INDEX_CACHE_TIME'] );
				$this->assign( "ChannelCacheTime", $data['CHANNEL_CACHE_TIME'] );
				$this->assign( "InfoCacheTime", $data['INFO_CACHE_TIME'] );
				$this->assign( "Action", __URL__."/clearCache" );
				$this->display( );
		}

		public function phpinfo( )
		{
				header( "Content-Type:text/html; charset=utf-8" );
				echo phpinfo( );
		}

		public function getWebTotalSize( )
		{
				header( "Content-Type:text/html; charset=utf-8" );
				$size = byte_format( getdirsize( "./" ) );
				$uploadSize = byte_format( getdirsize( "./Upload" ) );
				if ( 0 < $size )
				{
						$str = $size."&nbsp;&nbsp;其中上传目录大小为：".$uploadSize;
						$this->ajaxReturn( $str, "", 1 );
				}
				else
				{
						$this->ajaxReturn( NULL, "", 0 );
				}
		}

}

?>

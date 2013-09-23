<?phpinclude_once( 'qzone/utils.php' );require_once "oauth.class.php";class qzone  extends oauthClass{	protected $type='qzone';	protected $m_loginUrl;	private $m_akey;	private $m_skey;		public function __construct() {		parent::__construct();		$recArr=$this->getProviderList();		$this->m_akey = $recArr['key'];		$this->m_skey =$recArr['value'];	}	  	function login(){		$redirectPage=$this->getUrl($this->callBack);		BizSystem::clientProxy()->ReDirectPage($redirectPage);	} 	function test($akey,$skey){		$request_token = get_request_token($akey,$skey);		parse_str($request_token, $result);		return $result;	}	function callback(){ 		$keys=Bizsystem::getSessionContext()->getVar('qzone_keys');		$this->checkUser();		$userInfo=$this->userInfo();		$this->check($userInfo);	}	function getUrl($callback=null){		//授权登录页		$redirect = "http://openapi.qzone.qq.com/oauth/qzoneoauth_authorize?oauth_consumer_key=".$this->m_akey;		//获取request token		$result = array();		$request_token = get_request_token($this->m_akey,$this->m_skey);		parse_str($request_token, $result);		if ($result["oauth_token"] == "")		{			throw new Exception('Unknown oauth_token');			return false;		}		$callback=$callback."?oauth_token_secret=".$result["oauth_token_secret"];		//302跳转到授权页面		$redirect .= "&oauth_token=".$result["oauth_token"]."&oauth_callback=".rawurlencode($callback);		return $redirect;	}	//用户资料	function userInfo(){		$access_token=Bizsystem::getSessionContext()->getVar('qzone_access_token');		$url    = "http://openapi.qzone.qq.com/user/get_user_info";		$me = do_get($url,$this->m_akey,$this->m_skey, $access_token['oauth_token'], $access_token['oauth_token_secret'], $access_token["openid"]);		$me = json_decode($me);		$user['id']         =  $access_token["openid"];		$user['uname']       = $me->nickname;		$user['type']       = $this->type;		$user['province']    = 0;		$user['city']        = 0;		$user['location']    = '';		$user['userface']    = $me->figureurl_2;		$user['sex']         = ($me->gender=='男')?1:0;		return $user;	}	//验证用户	function checkUser(){		/**		 * QQ互联登录，授权成功后会回调此地址		 * 必须要用授权的request token换取access token		 * 访问QQ互联的任何资源都需要access token		 * 目前access token是长期有效的，除非用户解除与第三方绑定		 * 如果第三方发现access token失效，请引导用户重新登录QQ互联，授权，获取access token		 */		//授权成功后，会返回用户的openid		//检查返回的openid是否是合法id		if (!is_valid_openid($_REQUEST["openid"], $_REQUEST["timestamp"], $_REQUEST["oauth_signature"],$this->m_skey))		{			return false;		}		//tips		//这里已经获取到了openid，可以处理第三方账户与openid的绑定逻辑		//但是我们建议第三方等到获取accesstoken之后在做绑定逻辑		//用授权的request token换取access token		$access_str = get_access_token($this->m_akey,$this->m_skey, $_REQUEST["oauth_token"],$_REQUEST['oauth_token_secret'], $_REQUEST["oauth_vericode"]);		//echo "access_str:$access_str\n";		$result = array();		parse_str($access_str, $result);		//error		if (isset($result["error_code"]))		{			return false;		}		//获取access token成功后也会返回用户的openid		//我们强烈建议第三方使用此openid		//检查返回的openid是否是合法id		if (!is_valid_openid($result["openid"], $result["timestamp"], $result["oauth_signature"],$this->m_skey))		{			return false;		}		Bizsystem::getSessionContext()->setVar('qzone_access_token',$result);		return true;	}}?>
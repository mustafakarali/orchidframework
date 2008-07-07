<?php
class useragent
{
	private $useragent;
	private $platform	= '';
	private $browser	= '';
	private $version	= '';
	private $mobile		= '';
	private $robot;
	private $isBrowser	= FALSE;
	private $isRobot	= FALSE;
	private $isMobile	= FALSE;
	private $platforms = array (
	'windows nt 6.0'	=> 'Windows Longhorn',
	'windows nt 5.2'	=> 'Windows 2003',
	'windows nt 5.0'	=> 'Windows 2000',
	'windows nt 5.1'	=> 'Windows XP',
	'windows nt 4.0'	=> 'Windows NT 4.0',
	'winnt4.0'			=> 'Windows NT 4.0',
	'winnt 4.0'			=> 'Windows NT',
	'winnt'				=> 'Windows NT',
	'windows 98'		=> 'Windows 98',
	'win98'				=> 'Windows 98',
	'windows 95'		=> 'Windows 95',
	'win95'				=> 'Windows 95',
	'windows'			=> 'Unknown Windows OS',
	'os x'				=> 'Mac OS X',
	'ppc mac'			=> 'Power PC Mac',
	'freebsd'			=> 'FreeBSD',
	'ppc'				=> 'Macintosh',
	'linux'				=> 'Linux',
	'debian'			=> 'Debian',
	'sunos'				=> 'Sun Solaris',
	'beos'				=> 'BeOS',
	'apachebench'		=> 'ApacheBench',
	'aix'				=> 'AIX',
	'irix'				=> 'Irix',
	'osf'				=> 'DEC OSF',
	'hp-ux'				=> 'HP-UX',
	'netbsd'			=> 'NetBSD',
	'bsdi'				=> 'BSDi',
	'openbsd'			=> 'OpenBSD',
	'gnu'				=> 'GNU/Linux',
	'unix'				=> 'Unknown Unix OS'
	);


	// The order of this array should NOT be changed. Many browsers return
	// multiple browser types so we want to identify the sub-type first.
	private $browsers = array(
	'Opera'				=> 'Opera',
	'MSIE'				=> 'Internet Explorer',
	'Internet Explorer'	=> 'Internet Explorer',
	'Shiira'			=> 'Shiira',
	'Firefox'			=> 'Firefox',
	'Chimera'			=> 'Chimera',
	'Phoenix'			=> 'Phoenix',
	'Firebird'			=> 'Firebird',
	'Camino'			=> 'Camino',
	'Netscape'			=> 'Netscape',
	'OmniWeb'			=> 'OmniWeb',
	'Mozilla'			=> 'Mozilla',
	'Safari'			=> 'Safari',
	'Konqueror'			=> 'Konqueror',
	'icab'				=> 'iCab',
	'Lynx'				=> 'Lynx',
	'Links'				=> 'Links',
	'hotjava'			=> 'HotJava',
	'amaya'				=> 'Amaya',
	'IBrowse'			=> 'IBrowse'
	);

	private $mobiles = array(
	// legacy array, old values commented out
	'mobileexplorer'	=> 'Mobile Explorer',
	//					'openwave'			=> 'Open Wave',
	//					'opera mini'		=> 'Opera Mini',
	//					'operamini'			=> 'Opera Mini',
	//					'elaine'			=> 'Palm',
	'palmsource'		=> 'Palm',
	//					'digital paths'		=> 'Palm',
	//					'avantgo'			=> 'Avantgo',
	//					'xiino'				=> 'Xiino',
	'palmscape'			=> 'Palmscape',
	//					'nokia'				=> 'Nokia',
	//					'ericsson'			=> 'Ericsson',
	//					'blackberry'		=> 'BlackBerry',
	//					'motorola'			=> 'Motorola'

	// Phones and Manufacturers
	'motorola'			=> "Motorola",
	'nokia'				=> "Nokia",
	'palm'				=> "Palm",
	'iphone'			=> "Apple iPhone",
	'ipod'				=> "Apple iPod Touch",
	'sony'				=> "Sony Ericsson",
	'ericsson'			=> "Sony Ericsson",
	'blackberry'		=> "BlackBerry",
	'cocoon'			=> "O2 Cocoon",
	'blazer'			=> "Treo",
	'lg'				=> "LG",
	'amoi'				=> "Amoi",
	'xda'				=> "XDA",
	'mda'				=> "MDA",
	'vario'				=> "Vario",
	'htc'				=> "HTC",
	'samsung'			=> "Samsung",
	'sharp'				=> "Sharp",
	'sie-'				=> "Siemens",
	'alcatel'			=> "Alcatel",
	'benq'				=> "BenQ",
	'ipaq'				=> "HP iPaq",
	'mot-'				=> "Motorola",
	'playstation portable' 	=> "PlayStation Portable",
	'hiptop'			=> "Danger Hiptop",
	'nec-'				=> "NEC",
	'panasonic'			=> "Panasonic",
	'philips'			=> "Philips",
	'sagem'				=> "Sagem",
	'sanyo'				=> "Sanyo",
	'spv'				=> "SPV",
	'zte'				=> "ZTE",
	'sendo'				=> "Sendo",

	// Operating Systems
	'symbian'				=> "Symbian",
	'elaine'				=> "Palm",
	'palm'					=> "Palm",
	'series60'				=> "Symbian S60",
	'windows ce'			=> "Windows CE",

	// Browsers
	'obigo'					=> "Obigo",
	'netfront'				=> "Netfront Browser",
	'openwave'				=> "Openwave Browser",
	'mobilexplorer'			=> "Mobile Explorer",
	'operamini'				=> "Opera Mini",
	'opera mini'			=> "Opera Mini",

	// Other
	'digital paths'			=> "Digital Paths",
	'avantgo'				=> "AvantGo",
	'xiino'					=> "Xiino",
	'novarra'				=> "Novarra Transcoder",
	'vodafone'				=> "Vodafone",
	'docomo'				=> "NTT DoCoMo",
	'o2'					=> "O2",

	// Fallback
	'mobile'				=> "Generic Mobile",
	'wireless' 				=> "Generic Mobile",
	'j2me'					=> "Generic Mobile",
	'midp'					=> "Generic Mobile",
	'cldc'					=> "Generic Mobile",
	'up.link'				=> "Generic Mobile",
	'up.browser'			=> "Generic Mobile",
	'smartphone'			=> "Generic Mobile",
	'cellphone'				=> "Generic Mobile"
	);


	function __construct()
	{
		$this->useragent = trim($_SERVER['HTTP_USER_AGENT']);

		foreach ($this->browsers as $key => $val)
		{
			if (preg_match("|".preg_quote($key).".*?([0-9\.]+)|i", $this->agent, $match))
			{
				$this->isBrowser = TRUE;
				$this->version = $match[1];
				$this->browser = $val;
				break;
			}
		}

		foreach ($this->robots as $key => $val)
		{
			if (preg_match("|".preg_quote($key)."|i", $this->agent))
			{
				$this->isRobot = TRUE;
				$this->robot = $val;
				break;
			}
		}

		foreach ($this->mobiles as $key => $val)
		{
			if (FALSE !== (strpos(strtolower($this->agent), $key)))
			{
				$this->isMobile = TRUE;
				$this->mobile = $val;
				break;
			}
		}
	}
	
	function getBrowser()
	{
		return $this->browser;
	}
	
	function isBrowser()
	{
		return $this->isBrowser;
	}
	
	function isMobile()
	{
		return $this->isMobile;
	}
	
	function isRobot()
	{
		return $this->isRobot;
	}
	
	function getMobile()
	{
		return $this->mobile;
	}
	
	function getRobot()
	{
		return $this->robot;
	}
	
	function isIE()
	{
		if($this->browser=="Internet Explorer") return true;
		return false;
	}
	
	function isFirefox()
	{
		if ($this->browser == "Firefox") return true;
		return false;
	}
	
	function isOpera()
	{
		if ($this->browser=="Opera") return true;
		return false;
	}
	
	function isSafari()
	{
		if ($this->browser=="Safari") return true;
		return false;
	}
}
?>
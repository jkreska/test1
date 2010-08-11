<?php
/**
 * AskApacheNet
 *
 * @package AskApacheNet
 * @author askapache.com
 * @copyright Copyright (c) 2008 AskApache.com
 * @version 1.6
 * @access public
*/

if ( !@in_array('AskApacheNet', @get_declared_classes() ) ) :
if( !defined( 'AA_PP_NET_DEBUG' ) ) define( 'AA_PP_NET_DEBUG', 0 );

/**
 * AskApacheNet
 * 
 * @package AskApacheNet
 * @author askapache.com
 * @copyright Copyright (c) 2008 AskApache.com
 * @version 1.6
 * @access public
 */
class AskApacheNet
{
	var $socket = array( 
	'protocol' => '1.0', 'method' => 'GET', 'ua' => 'Mozilla/5.0 (compatible; AskApacheNet/1.0; http://www.askapache.com)', 'referer' => 'http://www.askapache.com', 
	'port' => '80', 
	'url' => '', 
	'scheme' => '', 
	'host' => '', 
	'ip' => '', 
	'user' => '', 
	'pass' => '', 
	'path' => '', 
	'query' => '', 
	'fragment' => '' 
	);
	
	var $Digests = array( 
	'realm' => '', 
	'nonce' => '', 
	'uri' => '', 
	'algorithm' => 'MD5', 
	'qop' => 'auth', 
	'opaque' => '', 
	'domain' => '', 
	'nc' => '00000001', 
	'cnonce' => '82d057852a9dc497', 
	'A1' => '', 
	'A2' => '', 
	'response' => ''
	);
	

	var $dh = '';
	var $authtype = 'Basic';
	var $error = '';
	var $request = '';
	var $request_headers = array();
	var $response = '';
	var $response_headers = array();
	var $response_code = '';
	var $time_start = null;
	var $redo_Digest = false;
	var $did_Digest = false;

	var $_cookie = '';
	var $_fp = null;
	var $_speed = 24576;
	var $_chunks = 256;
	var $_maxlength = 4096;
	var $_fp_timeout = 10;
	var $_read_timeout = 45;
	var $_ACLF = "\r\n";



	function _notify($message = '') {
    	if ( (bool)AA_PP_NET_DEBUG === true ) error_log("PHP AANET: {$message}", 0);
	}

	/**    
	 * AskApacheNet::sockit()
	 * 
	 * @return 
	 */
	function sockit( $URI )
	{
		//$this->_notify(__FUNCTION__.":".__LINE__." {$URI}");

		$this->_ACLF = chr( 13 ) . chr( 10 );

		if ( !$this->_build_sock( $URI ) ) return false;
		
		if( !$this->_connect() ) return false;
			
		if ( !$this->_build_request() ) return false;
			
		//if ( !$this->_set_sock_time() )	$this->_notify(__FUNCTION__.":".__LINE__." Failed setting socket timeout, not a big deal.");

		//$this->set_speed( 24 );

		if ( !$this->_tx() ) return false;
		
		$this->_rx();
		
		$this->_disconnect();

		/*
		if ( (bool)AA_PP_NET_DEBUG === true )
		{
			echo '<pre>';
			print_r( $this->request_headers );
			print_r( $this->response_headers );
			echo '</pre>';
		}
		*/
		
		return( int )$this->response_code;
	}

	/**
	 * AskApacheNet::get_ip()
	 * 
	 * @param mixed $host
	 * @return 
	 */
	function get_ip( $host )
	{
		$hostip = @gethostbyname( $host );
		$ip = ( $hostip == $host ) ? $host : long2ip( ip2long( $hostip ) );
		//$this->_notify(__FUNCTION__.":".__LINE__." {$host}={$ip}");
		return $ip;
	}


	/**
	 * AskApacheNet::get_response_code()
	 * 
	 * @return 
	 */
	function get_response_code()
	{
		//$this->_notify(__FUNCTION__.":".__LINE__);
		return $this->response_code;
	}

	/**
	 * AskApacheNet::get_response_headers()
	 * 
	 * @return 
	 */
	function get_response_headers()
	{
		//$this->_notify(__FUNCTION__.":".__LINE__);
		return $this->response_headers;
	}

	/**
	 * AskApacheNet::get_request_headers()
	 * 
	 * @return 
	 */
	function get_request_headers()
	{
		//$this->_notify(__FUNCTION__.":".__LINE__);
		return $this->request_headers;
	}

	/**
	 * AskApacheNet::get_tcp_trace()
	 * 
	 * @return 
	 */
	function get_tcp_trace()
	{
		//$this->_notify(__FUNCTION__.":".__LINE__);
		
		$headers=array_merge($this->request_headers, array(''), $this->response_headers);
		
		ob_start();
		echo "\n<pre style=\"padding:5px;width:auto;border:1px dotted #CCC;\">\n";
		foreach($headers as $rxtx_line)
		{
			echo $rxtx_line."\n";
		}		
		echo "\n</pre>\n";
		$tcp_trace=ob_get_clean();
		
		return $tcp_trace;
	}

	/**
	 * AskApacheNet::print_tcp_trace()
	 * 
	 * @return 
	 */
	function print_tcp_trace()
	{
		//$this->_notify(__FUNCTION__.":".__LINE__);
		
		$headers=$this->get_tcp_trace();
		echo $headers;
		
		return true;
	}


	/**
	 * AskApacheNet::get_response_body()
	 * 
	 * @return 
	 */
	function get_response_body()
	{
		//$this->_notify(__FUNCTION__.":".__LINE__);
		return $this->response;
	}

	/**
	 * AskApacheNet::set_speed()
	 * 
	 * @param mixed $speed
	 * @return 
	 */
	function set_cookie( $cook )
	{
		$this->_notify(__FUNCTION__.":".__LINE__." {$cook}");
		$this->_cookie = $cook;
	}

	/**
	 * AskApacheNet::set_speed()
	 * 
	 * @param mixed $speed
	 * @return 
	 */
	function set_speed( $speed )
	{
		//$this->_speed = round( $speed * 1024 );
		$this->_notify(__FUNCTION__.":".__LINE__." Speed set at {$speed} / ".$this->_speed);
	}

	/**
	 * AskApacheNet::_connect()
	 * 
	 * @return 
	 */
	function _connect()
	{
		//$this->_notify(__FUNCTION__.":".__LINE__." Creating fsockopen Socket");
		$this->_fp = null;
		if ( false === ( $this->_fp = @fsockopen( $this->socket['ip'], $this->socket['port'], $errno, $errstr, $this->_fp_timeout ) ) || !is_resource( $this->_fp ) )
		{
			switch ( $errno )
			{
				case - 3:
					$err = "Socket creation failed";
					break;
				case - 4:
					$err = "DNS lookup failure";
					break;
				case - 5:
					$err = "Connection refused or timed out";
					break;
				case 111:
					$err = "Connection refused";
					break;
				case 113:
					$err = "No route to host";
					break;
				case 110:
					$err = "Connection timed out";
					break;
				case 104:
					$err = "Connection reset by client";
					break;
				default:
					$err = "Connection failed";
					break;
			}
			echo "Fsockopen failed! [{$errno}] {$err} ({$errstr})";
			return false;
		}


		return true;
	}

	/**
	 * AskApacheNet::_disconnect()
	 * 
	 * @return 
	 */
	function _disconnect()
	{
		//$this->_notify(__FUNCTION__.":".__LINE__." Closing SOCKET");
		return( @fclose( $this->_fp ) );
	}

	/**
	 * AskApacheNet::_rx()
	 * 
	 * @return 
	 */
	function _rx()
	{
		//$this->_notify(__FUNCTION__.":".__LINE__." Receiving data on socket...");
		$buf = $response = '';
		while ( !feof( $this->_fp ) && $buf = @fread( $this->_fp, $this->_speed ) )
		{
			$response .= $buf;
			//sleep( 1 );
		}
		$g = strpos( $response, $this->_ACLF . $this->_ACLF );
		$headers = substr( $response, 0, $g );
		$this->response = trim(substr( $response, $g, ( strlen( $response ) - $g ) ));
		$this->response_headers = explode( $this->_ACLF, $headers );
		
		$status = null;
		preg_match( '/HTTP.*([0-9]{3}).*/', $this->response_headers[0], $status );
		$this->response_code = $status[1];
	}

	/**
	 * AskApacheNet::_tx()
	 * 
	 * @param mixed $request
	 * @return 
	 */
	function _tx( $request = null )
	{
		//$this->_notify(__FUNCTION__.":".__LINE__." Transmitting data on socket...");
		$g = ( !is_null( $request ) ) ? @fwrite( $this->_fp, $request, strlen( $request ) ) : @fwrite( $this->_fp, $this->request, strlen( $this->request ) );
		return( bool )$g;
	}

	/**
	 * AskApacheNet::_build_sock()
	 * 
	 * @param mixed $url
	 * @return 
	 */
	function _build_sock( $url )
	{
		$this->_notify(__FUNCTION__.":".__LINE__." {$url}");
		
		if ( !$u_bits = parse_url( $url ) ) return false;

		if ( empty( $u_bits['url'] ) ) $u_bits['url'] = ( !empty( $this->socket['url'] ) ) ? $this->socket['url'] : 'url';

		if ( empty( $u_bits['method'] ) ) $u_bits['method'] = ( !empty( $this->socket['method'] ) ) ? $this->socket['method'] : 'GET';

		if ( empty( $u_bits['protocol'] ) ) $u_bits['protocol'] = ( !empty( $this->socket['protocol'] ) ) ? $this->socket['protocol'] : '1.0';

		if ( empty( $u_bits['host'] ) ) $u_bits['host'] = ( !empty( $this->socket['host'] ) ) ? $this->socket['host'] : $_SERVER['HTTP_HOST'];

		if ( empty( $u_bits['ip'] ) ) $u_bits['ip'] = ( !empty( $this->socket['ip'] ) ) ? $this->socket['ip'] : $this->get_ip( $u_bits['host'] );

		if ( empty( $u_bits['scheme'] ) ) $u_bits['scheme'] = ( !empty( $this->socket['scheme'] ) ) ? $this->socket['scheme'] : 'http';

		if ( empty( $u_bits['port'] ) ) $u_bits['port'] = ( !empty( $this->socket['port'] ) ) ? $this->socket['port'] : $_SERVER['SERVER_PORT'];

		if ( empty( $u_bits['path'] ) ) $u_bits['path'] = ( !empty( $this->socket['path'] ) ) ? $this->socket['path'] : '/';

		if ( empty( $u_bits['ua'] ) ) $u_bits['ua'] = ( !empty( $this->socket['ua'] ) ) ? $this->socket['ua'] : 'Mozilla/5.0 (compatible; AskApacheNet/1.0; http://www.askapache.com)';

		if ( empty( $u_bits['referer'] ) ) $u_bits['referer'] = ( !empty( $this->socket['referer'] ) ) ? $this->socket['referer'] : 'http://www.askapache.com';

		if ( empty( $u_bits['fragment'] ) ) $u_bits['fragment'] = ( !empty( $this->socket['fragment'] ) ) ? $this->socket['fragment'] : '';

		if ( !empty( $u_bits['user'] ) ) $this->socket['user'] = $u_bits['user'];
		else $u_bits['user'] = ( !empty( $this->socket['user'] ) ) ? $this->socket['user'] : '';

		if ( !empty( $u_bits['pass'] ) ) $this->socket['pass'] = $u_bits['pass'];
		else $u_bits['pass'] = ( !empty( $this->socket['pass'] ) ) ? $this->socket['pass'] : '';

		if ( !empty( $u_bits['query'] ) ) $u_bits['path'] .= '?' . $u_bits['query'];
		else $u_bits['path'] .= ( !empty( $this->socket['query'] ) ) ? '?' . $this->socket['query'] : '';

		$this->socket = $u_bits;

		return true;
	}

	/**
	 * AskApacheNet::_build_request()
	 * 
	 * @return 
	 */
	function _build_request()
	{
		//$this->_notify(__FUNCTION__.":".__LINE__);
		$_request_headers = array();
		$_request_headers[] = $this->socket['method'] . " " . $this->socket['path'] . " HTTP/" . $this->socket['protocol'];
		$_request_headers[] = "Host: " . $this->socket['host'];
		$_request_headers[] = "User-Agent: " . $this->socket['ua'];
		$_request_headers[] = 'Accept: application/xhtml+xml,text/html;q=0.9,*/*;q=0.5';
		$_request_headers[] = 'Accept-Language: en-us,en;q=0.5';
		$_request_headers[] = 'Accept-Encoding: none';
		$_request_headers[] = 'Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.7';
		$_request_headers[] = 'Referer: ' . $this->socket['referer'];
		if ( !empty( $this->_cookie ) ) $_request_headers[] = 'Cookie: ' . $this->_cookie;
			
		if ( !empty( $this->socket['user'] ) && !empty( $this->socket['pass'] ) )
		{
			if ( $this->authtype == 'Basic' ) $_request_headers[] = 'Authorization: Basic ' . base64_encode( $this->socket['user'] . ":" . $this->socket['pass'] );
			elseif ( $this->authtype == 'Digest' ) $_request_headers[] = $this->getDigest();
		}

		$this->request_headers = $_request_headers;
		$this->request = join( $this->_ACLF, $_request_headers ) . $this->_ACLF . $this->_ACLF;
		return true;
	}


	/**
	 * AskApacheNet::_set_sock_time()
	 * 
	 * @return 
	 */
	function _set_sock_time()
	{
		//$this->_notify(__FUNCTION__.":".__LINE__." Socket_timeout set to ".$this->_read_timeout);
		
		@ini_set( "default_socket_timeout", $this->_read_timeout );
		if ( function_exists( "socket_set_timeout" ) ) @socket_set_timeout( $this->_fp, $this->_read_timeout );
		elseif ( function_exists( "stream_set_timeout" ) ) @stream_set_timeout( $this->_fp, $this->_read_timeout );
		return true;
	}

	/**
	 * AskApacheNet::getDigest()
	 * 
	 * @return 
	 */
	function getDigest()
	{
		$this->_notify(__FUNCTION__.":".__LINE__);
		
		foreach ( $this->response_headers as $num => $header )
		{
			if ( preg_match( '/WWW-Authenticate: Digest/i', $header ) ) $this->dh = $dh = substr( $header, 25 );
		}
		$dh = $this->dh;

		$this->socket['protocol'] = '1.1';
		$myDigest = $this->Digests;

		$hdr = array();
		preg_match_all('/(\w+)=(?:"([^"]+)"|([^\s,]+))/', $dh, $mtx, PREG_SET_ORDER);
		foreach ($mtx as $m) $hdr[$m[1]] = $m[2] ? $m[2] : $m[3];
		if ( (bool)AA_PP_NET_DEBUG === true ) {
			echo '<pre>';
			print_r($hdr);
			echo '</pre>';
		}

		$names=array('realm','nonce','cnonce','algorithm','domain','opaque','qop','nc');
		foreach($hdr as $key=>$val){
			if(in_array($key,$names) && !empty($val))$myDigest["{$key}"]=$val;
			else echo '<p>'.$key.':'.$val.'</p>';
		}

		$myDigest['uri'] = $this->socket['path'];
		$myDigest['A1'] = md5( $this->socket['user'] . ':' . $myDigest['realm'] . ':' . $this->socket['pass'] );
		$myDigest['A2'] = md5( $this->socket['method'] . ':' . $this->socket['path'] );
		$myDigest['response'] = md5( $myDigest['A1'] . ':' . $myDigest['nonce'] . ':' . $myDigest['nc'] . ':' . $myDigest['cnonce'] . ':' . $myDigest['qop'] . ':' . $myDigest['A2'] );
		$this->Digests = $myDigest;

		$ah = 'Authorization: Digest username="' . $this->socket['user'] . '", realm="' . $myDigest['realm'] . '", nonce="' . $myDigest['nonce'] . '", uri="' . $myDigest['uri'] . '"';
		$ah .= ', algorithm=' . $myDigest['algorithm'] . ', response="' . $myDigest['response'] . '"';
		$ah .= ', qop=' . $myDigest['qop'] . ', nc=' . $myDigest['nc'];
		if ( !empty( $myDigest['cnonce'] ) ) $ah .= ', cnonce="' . $myDigest['cnonce'] . '"';
		if ( !empty( $myDigest['opaque'] ) ) $ah .= ', opaque="' . $myDigest['opaque'] . '"';

		return $ah;
	}
}
endif;
?>
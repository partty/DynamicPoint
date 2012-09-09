<?php 
/*
 *   Copyright 2012 Ognian Tsonev
 *
 *   This file is part of DynamicPoint CMS
 *
 *   DynamicPoint CMS is free software: you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation, either version 3 of the License, or
 *   (at your option) any later version.
 *
 *   This program is distributed in the hope that it will be useful,
 *   but WITHOUT ANY WARRANTY; without even the implied warranty of
 *   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *   GNU General Public License for more details.
 *
 *   You should have received a copy of the GNU General Public License
 *   along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 */

/**
 * This Class provides instant acces to all the parameters of the URI
 * This parameters are: protocol, host, base (real path), logical fragments of the url
 * Use this for managing you input from the address.
 * 
 * @author Ognian Tsonev
 *
 */
class UriController {
	static private 
		$parsedUrl, 			// Takes the parsed url from parse_url( ... );
		$uri=array(), 			// When parsed, contains all the logical uris
		$protocol, 				// Once setuped contins protocol http/https/ftp/...
		$host, 					// Once setuped contins the host as given from $_SERVER['HTTP_HOST'];
		$base, 					// when parsed contains the real web path to the index.php (use it as base for all links)
		$query=array(), 		// When get is parced it contains all the Get variables. (Use this instead of $['_GET'])
		$fullUrl='',			// When url is parsed This is the full url without any GET 
		$isParseSetup=false, 	// This is true if the parse hase been setuped - self::_parseSetup();
		$isUrlParsed=false, 	// This is true if Url has been parsed - self::_parseUrl();
		$isGetParsed=false;		// This is true of GET has been parsed - self::_parseGet();
		

	/**
	 * This method is settind the pase for parsing url or get 
	 * and in the mean time extracts protocol and host
	 * 
	 * @return boolean
	 * 
	 * @author Ognian Tsonev
	 */
	static private function _parseSetup(){
		if(self::$isParseSetup) return true;
		
		self::$parsedUrl = parse_url($_SERVER['REQUEST_URI']);
		self::$protocol = $_SERVER['SERVER_PROTOCOL'];
		self::$host = $_SERVER['HTTP_HOST'];
		
		self::$isParseSetup=true;
		return true;
	}
	
	/**
	 * This method parses all the parts of the url, logical and physical
	 * 
	 * @return boolean
	 * 
	 * @author Ognian Tsonev
	 */
	static private function _parseUrl(){
		if(self::$isUrlParsed) return true;
		if(self::$isParseSetup) self::_parseSetup();
		
		$lastslash=strrpos ($_SERVER['SCRIPT_FILENAME'],'/');
		$rbase=substr($_SERVER['SCRIPT_FILENAME'],0,$lastslash);
		self::$base = '/'.substr($rbase,strlen($_SERVER['DOCUMENT_ROOT']),strlen($rbase)).'/';
		
		$uriWObase=substr(
				self::$parsedUrl['path'],
				strrpos (self::$parsedUrl['path'],self::$base)+strlen(self::$base),
				strlen(self::$parsedUrl['path'])
		);
		self::$uri  = explode("/", $uriWObase);
		if(self::$uri[count(self::$uri)-1] == '')
			array_pop (self::$uri);
		
		self::$fullUrl = self::$base.self::getUri();
		
		self::$isUrlParsed=true;
		return true;
	}
	
	/**
	 * This method parses the get query part of the URI
	 * 
	 * 
	 * @return boolean
	 * 
	 * @author Ognian Tsonev
	 */
	static private function _parseGet(){
		if(self::$isGetParsed) return true;
		if(self::$isParseSetup) self::_parseSetup();
		
		if(isset($puri['query'])){
			$query = explode("&", $puri['query']);
			for ($i = 0; $i < count($query); $i++ ){
				$b = explode( "=" , $query[$i] );
				@self::$query[$b[0]] = $b[1];
			}
		}
		self::$isGetParsed = true;
		return true;
	}
	

	/**
	 * This method gives you a logical fragment from the URL or false if not presant
	 * 
	 * @param int $index  The index of the fragment you whant. 0 is the first (the left-most) fragment. If there is no logical fragment with this index You'll get a bolean false
	 * @return string|boolean 
	 * 
	 * @author Ognian Tsonev
	 */
	static function getUrl($index=NULL){
		if(!self::$isUrlParsed)self::_parseUrl();
		if($index === NULL){
			return count(self::$uri)?(implode('/',self::$uri).'/'):'';
		}
		return isset(self::$uri[$index])?self::$uri[$index]:false;
	}
	
	/**
	 * THis method gives you the value of the get query named "name" or bolean false if it is not presant.
	 * 
	 * @param string $name
	 * @return string|boolean
	 * 
	 * @author Ognian Tsonev
	 */
	static function getQuery($name){
		if(!self::$isGetParsed) self::_parseGet(); return isset(self::$query[$name])?self::$query[$name]:false;
	}
	
	/**
	 * This method returnes the protocol used (http/https/...)
	 * 
	 * @return string
	 * 
	 * @author Ognian Tsonev
	 */
	static function getProtocol(){
		if(!self::$isParseSetup) self::_parseSetup(); return self::$protocol;
	}
	
	/**
	 * This method returns the host used.
	 * 
	 * @return string
	 * 
	 * @author Ognian Tsonev
	 */
	static function getHost(){
		if(!self::$isParseSetup) self::_parseSetup(); return self::$host;
	}
	
	/**
	 * This method returns the physical path to the index.php 
	 * Use it for <base> or beginings of all urls 
	 * 
	 * note: if the system is directly on the host and there are no directories, ths will return "/" 
	 * 
	 * @return string
	 * 
	 * @author Ognian Tsonev
	 */
	static function getBase(){
		if(!self::$isParseSetup) self::_parseSetup(); return self::$base;
	}
	
	/**
	 * This will return the pysical part and the logical part together. 
	 * You can use this for retreaving pages from DB, or cache.
	 * 
	 * @return string
	 * 
	 * @author Ognian Tsonev
	 */
	static function getFullUri(){
		if(!self::$isUrlParsed) self::_parseUrl(); return self::$fullUrl;}
}


?>
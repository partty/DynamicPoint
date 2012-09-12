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
 * Use this class to read INI configurations.
 * 
 * @author Ognian Tsonev
 */
class ConfigurationController
{
	private static 
		$sessionVarname			=	"__dynamicPoind_data*", //the name under wich the configuration is stored in session.
		$caching				=	true, 					// whether or not to cache the configuration on exit.
		$cacheDir				=	'',//"cache/", 			// where to find the cached configs
		$cacheFile				=	"config.cache", 		// The name of the cache file. (you can have many config files but they are loaded in a pool so we cache only one file.)
		$cacheTtl				=	10,	// time to live in seconds (nocache = 0) (1min = 60) (1hour = 3600) (24hours = 86400)  (7days = 604800) (28days = 2419200) (30days = 2592000) (365days =  31536000)
		$cacheTimestamp			=	0,						// used to check how old is the cache
		$cacheFragmentSeparator	=	'[<|>]',				// Used to separate fragments in cache string.
		$defaultConfiguration	=	"dynamicpoint.ini", 	// the name of the default configuration file. (for searching)
		$locateFile				=	'config.locate',		// the locate file pointing to the configuration dir.
		$fiels					=	array(), 				// loaded files
		$configurations			=	array(), 				// loded confirurations array
		$configDir				=	'',						// stores the configurations dir
		$lastSavedString		=	'',						// the entire string that hase bin writen to the cache
		$lastSavedChanged		=	true,					// wether or not the last saved to cache configuration hase been changed (generaly if new configurations have been added)
		$instance				= 	NULL					// The instance holder used for the auto save function
	;
	/**
	 * Only use for this is to provide a way to detect the termination of the script. 
	 * You are not suppose to create instances.
	 * The instance is minimal - no variables and no other methods than __destruct
	 * 
	 * @author Ognian Tsonev
	 */
	private function __construct(){
		
	}
	
	/**
	 * Execute a save before ending the program
	 * 
	 * @author Ognian Tsonev
	 */
	public function __destruct(){
		if(self::$caching && count(self::$fiels)>0){
			self::save();
		}
	}
	
	/**
	 * Sets default config filename
	 * @param string $defaultConfiguration filename (No directories and slashes)
	 * 
	 * @author Ognian Tsonev
	 */
	public static function setDefaultConfiguration ($defaultConfiguration) {
		self::$lastSavedChanged=true;					// flag that the data has been changed
		self::$defaultConfiguration=$defaultConfiguration;
	}
	/**
	 * sets the default locate-file filename
	 * @param string $locateFile the locate file name. (can be a filepath)
	 * 
	 * @author Ognian Tsonev
	 */
	public static function setLocateFile($locateFile){
		self::$lastSavedChanged=true;					// flag that the data has been changed
		self::$locateFile=$locateFile;
	}
	
	/**
	 * Sets the default configuration dir.
	 * @param string $configDir the path to the config dir finishing with '/'
	 * 
	 * @author Ognian Tsonev
	 */
	public static function setConfigDir($configDir){
		self::$lastSavedChanged=true;					// flag that the data has been changed
		self::$configDir=$configDir;
	}
	
	/**
	 * Set the directory for cache
	 * @param string $cacheDir  path to teh cache dir relative to the root of the install
	 * 
	 * @author Ognian Tsonev
	 */
	public static function setCacheDir($cacheDir){
		self::$lastSavedChanged=true;					// flag that the data has been changed
		self::$cacheDir=$cacheDir;
	}
	
	/**
	 * Scans the tree for the main sistem config file and loads the location as the config dir.
	 * @param unknown_type $dir
	 * 
	 * @author Ognian Tsonev
	 */
	private static function scanForSysConfig($dir = '.') {
		//echo $dir."  =  ";
		if($dir == '.') $dir=getcwd();
		$depth_ini=count(explode('/', getcwd()));
		//echo $dir."<br />\n";
		$r 			= dir($dir);   	// open the dir
		$flag 		= false;		// flag if the result is found
		$configPath = '';  			// the var for the end result, the path to the config file
		$list 		= array();  	// list for the subdirectories found in the current dir
		$filePath 	= '';  			// the variable for the filepaths
		while(false !== ($file = $r->read())){  // read the next entry
			if($file == '.' || $file == '..') continue;  // skip the linkbacks.
			//echo "-$dir/$file<br />\n";
			$filePath = $dir.'/'.$file;  // glue together the directory path and the file name to get the full path for the file
			
			if(is_dir($filePath)){   	// if it is a directory
					$list[] = $filePath;  // save the path for recurssion
			}else{
				if(strcasecmp($file , self::$defaultConfiguration) === 0){  // if the filename mach the default configuration file name
					$flag=true;   			// rize the flag that we have found it.
					$configPath=$filePath;  // set the configPath with the filePath value for return.
				}
			}
		}
		$r->close(); 	// close the dir
		
		
		$depth=count(explode('/', $dir)) - $depth_ini; // find the depth of the DIR
		
		/* If the file is not found in this directory recurse to the sub directories */
		if(!$flag && $depth<4){ 			// if the file is NOT FOUND AND the DEPTH is LESS-THAN 4
			foreach($list as $f){ 
				$try=self::scanForSysConfig($f);  // recurssion with the starting dir from the list
				if($try!==''){  	// if the result is found in this sub dir tree
					$configPath=$try;  // set the configPat with the found path
					break;  // if the file is found no need to continue recurssion, so we terminate the loop
				}
			}
			self::setConfigDir(dirname($configPath) . '/'); // extract and set the configuration dir form the path of the found config file.
		}else{
			
		}
		
		return $configPath;
	}
	
	/**
	 * Try to read the locate file and returns true on success or false otherwise
	 * 
	 * @throws Exception if there is a locatefile and the path in it isn't readable
	 * @return boolean true on succes and false on faillier
	 * 
	 * @author Ognian Tsonev
	 */
	private static function readLocateFile(){
		if(is_readable(self::$locateFile)) { 		// if the file is readable
			$configpath = file_get_contents(self::$locateFile);		// read the file in a var as a string
			$configpath = trim ($configpath);						// trinm any excess spases and new lines
			if($configpath!=''){									// if the file is not empty
				//$configpath = dirname($configpath);				
				if(!is_dir($configpath)){						// if the path is not a valid path to a directory
					throw new Exception("[dpConfig::readConfig] locate file found, but the path specified inside can't be accesed. Remove the file for automaticly finding the configuration directory, or specify the corect path.");
				}
				self::setConfigDir($configpath.'/');  			// if the path is valid we set the config dir.
				return true;									// and return true.
			}
		}
		return false; 		// if the file is not readable or empty just return false.
	}
	
	/**
	 * Reads configuration file. If $configfile is not specifyed it trys to read the main config.
	 * If the configuration directory is not known trys to find it either by config.locate file or scaning the tree for the main config filename.
	 * 
	 * @param string $configfile name of the fiele to read.
	 * @throws Exception
	 * @return boolean true on success or throws an error on failior
	 * 
	 * @author Ognian Tsonev
	 */
	public static function readConfig($configfile=NULL){
		/* if we are trying to load the main configuration */
		if($configfile == NULL) { 	// default case
			if(self::$caching){	// is caching enabled
				if(self::checkForSavedConfigurations()){ 	// chech if the file is created
					if(self::load()) return true; 		// load the cache and if successfull return true. Else continue to read the actual configuration files
				}
			}
			$configfile = self::$configDir.self::$defaultConfiguration;  // setup the pat of the configuration file
			if(!is_readable($configfile)) { 							 // if the path is not readable then the config path must be wrong
				if(!self::readLocateFile()) {									// try to read the .locate file and if this fails
					self::scanForSysConfig();										// scan for the system configuration file in the tree.
				}																// if the locate is write or the scan finds the config dir then on this point we have the path to the config dir.
				$configfile = self::$configDir.self::$defaultConfiguration;		// set up the path to the main config file again with the discovared directory.
			}
		}
		
		/* check to see if the file is allready procesed */
		if(array_search($configfile, self::$fiels)){ return true; }
		
		
		/* if the configfile we try to read is not readable */
		if(!is_readable($configfile)){
			if(array_search(self::$configDir.self::$defaultConfiguration, self::$fiels) === false){  // check if the main config file is loaded and if not.
				self::readConfig(); 					// try to load it by invocing the same function with no parameters. Note if the above section locating the default config dir is entered and succesfull this section cant be reached. So it can't be a infinit recurssion.
														// if not succesfull the above section it will trow an error so again can't end up here
			}else{
				throw new Exception("[dpConfig::readConfig] can't read the configuration file '{$configfile}'");  // if the main config hase been red the config dir must be good, so this means the requested file is wrong. 
			}
		}
		
		/* everything is good - process the file */
		$configstr = file_get_contents($configfile);						// read configuration file
		//$configstr = strtolower($configstr);								// make all lowercase. (we don't care about the case);
		$configs = parse_ini_string($configstr,true,INI_SCANNER_NORMAL);	// parse configuration
		if(is_array($configs)){												// if the fiel has been parsed corectly
			self::appendConfiguration($configs);			// add the red configuration array to the array we allready have
			self::$fiels[] = $configfile;					// add the file name to the list of procesed files.
			self::$lastSavedChanged=true;					// flag that the data has been changed
			self::$instance = new self();					// creates an empty instance to wach for termination of the script. The destructor will call self::save(); to cache the configuration.
		}else{
			throw new Exception("[dpConfig::readConfig] can't read the configuration file '{$configfile}' it is not  a good .ini file");  // if the file haven't produce an array it's not a good .ini
		}
		
	}
	
	/**
	 * Adds a configuration array to the current configuration
	 * 
	 * @param array &$newConfigArray the array produced by the parse_ini_file
	 * @return void
	 * 
	 * @author Ognian Tsonev
	 */
	private static function appendConfiguration(&$newConfigArray){
		foreach($newConfigArray as $k=>$v){			// for each of the sections in this array
			self::appendConfigSection($k, $v);			// add the each section to the current configuration.
		}
	}
	
	/**
	 * adds a section of configuration to the current configuration. Overwrites old configurations in the existing sections only when a var overlaps.
	 * 
	 * @param string $newSectionName the name of the section
	 * @param array &$newSectionArray the array containing the values.
	 * @return void
	 */
	private static function appendConfigSection($newSectionName, &$newSectionArray) {
		$newSectionName = strtolower($newSectionName);								// don't care about the case of the sections names
		$newSectionArray = array_change_key_case($newSectionArray, CASE_LOWER);		// don't care  about the case of the variables names
		
		if(array_key_exists ($newSectionName, self::$configurations)){				// if the section is defined
			self::$configurations[$newSectionName] = array_merge(self::$configurations[$newSectionName], $newSectionArray);			// merge the old with the new data.
		}else{		// if the section is NOT defined
			self::$configurations[$newSectionName] = $newSectionArray;		// just difine the section with the values
		}
	}
	
	
	/**
	 * Retreavs a value from the configuration files. 
	 * If the config is not yet red it trys to read the main config
	 * @param string $configVar  a string representing the config var. Format: 'sectionName-varName'  or 'sectionName.varName'
	 * @throws Exception
	 * @return string the value of the config var requested;
	 */
	public static function getValue($configVar) {
		$separator=strtolower($configVar);		// we don't care about the case of the characters
		/* determan the divider (This is needed every time for there is a posibility in moduls or else someone to have been using other separators) */
		$separator=stripos($configVar, '.') !== false		// dot is most likely. Simulating object relations 'system.version'
			? '.' : (stripos($configVar, '-') !== false		// dash is very likely. 'system-version';
				? '-' : (stripos($configVar, '/') !== false		// not so likely. Directory style 'system/version'
					? '/' : ''));		// if we are here something is wrong and we didn't find the the separator
		
		switch($separator){
		case '.':
		case '-':
		case '/':
			$config=explode($separator, $configVar);
			if(array_key_exists ($config[0], self::$configurations)) {
				if(array_key_exists ($config[1], self::$configurations[$config[0]])) {
					return self::$configurations[$config[0]][$config[1]];
				}
			}
			if(array_search(self::$configDir.self::$defaultConfiguration,self::$fiels) !== false){
				throw new Exception("[dpConfig::getValue] can't get the value for '{$configVar}' (detected separator: '{$separator}')");
			}else{
				self::readConfig();
				return self::getValue($configVar);
			}
			break;
		case '':
		default:
			throw new Exception("[dpConfig::getValue] can't get the value for '{$configVar}' can't find the separator. Use '.', '-' or '/' (Example: 'system.varsion')");
		}
	}
	
	/**
	 * Save the configuration to cache or session. 
	 * @param string $where "cache" or "session"
	 * @return boolean
	 * 
	 * @author Ognian Tsonev
	 */
	public function save($where='cache') {
		if(self::$lastSavedChanged){ 			// if the configuration is unchanged
			self::$lastSavedString=json_encode (array(
				'defaultConfiguration'	=>self::$defaultConfiguration,
				'locateFile'			=>self::$locateFile,
				'configDir'				=>self::$configDir,
				'fiels'					=>self::$fiels,
				'configurations'		=>self::$configurations
			));
		}
		
		switch($where){
			case 'session':
				/*$_SESSION[self::$sessionVarname] = self::$lastSavedString;
			break;*/
			
			case 'cache':
				if(self::$lastSavedChanged && ( self::$cacheTimestamp + self::$cacheTtl > strtotime('now') ) ){
						return false;
				}
				$where = self::$cacheDir.self::$cacheFile;	// normalize the conditions for file write

			// continue in the default for writing
			default:
				file_put_contents($where, strtotime('now').self::$cacheFragmentSeparator.self::$lastSavedString);		// write the string to a file
		}
		return false;
	}
	
	/**
	 * Loads Configuration from cache
	 * 
	 * @param unknown_type $fromwhere
	 * @return boolean false on failure or True on success
	 * 
	 * @author Ognian Tsonev
	 */
	public function load($fromwhere='cache') { 
		switch($fromwhere){
			case 'session':  // depricated (not working) (pass to 'cache')
				/*if(!self::checkForSavedConfigurations()){ return false; }		
				self::$lastSavedString = $_SESSION[self::$sessionVarname];
				break;*/
				
			case 'cache':
					if(($fromwhere = self::checkForSavedConfigurations()) === false){  	// check for cache file and set the result (false or path) to the $fromwhere (normalize the parameter for file reading)  Faill!
						return $fromwhere;	// if we are here, $fromwhere=false skiping some cicles when using the same value and conserving the program memory for the static value
					}
					
					// if there is a cache file continue to default
			default:
				if(!is_readable($fromwhere)){return false;}			// if the file is not readable can't load   Faill!
				$str = file_get_contents($fromwhere);  //read the vile and store the contents in the self::$lastSavedString so if you need to save without change you don't parse the variables but only write this to teh file
		}
		
		list(self::$cacheTimestamp,self::$lastSavedString) = explode(self::$cacheFragmentSeparator,$str);
		
		if(self::$lastSavedString == ''|| self::$lastSavedString == NULL){  // data is corupted
			self::$lastSavedString = '';
			return false;   // Faill!
		}
		
		
		if(self::$cacheTimestamp < strtotime('now')-self::$cacheTtl){		// check the timestamp against the time to live value
			self::$lastSavedString = '';
			//echo "|expired|";
			return false;   // the cache is expired.  Faill!	
			
		}
	
		
		
		$data=json_decode(self::$lastSavedString, true);			// decode the data from the string
		/* set the properties of the object */
		self::$defaultConfiguration	=	$data['defaultConfiguration'];
		self::$locateFile			=	$data['locateFile'];
		self::$configDir			=	$data['configDir'];
		self::$fiels				=	$data['fiels'];
		self::$configurations		=	$data['configurations'];
		
		self::$lastSavedChanged=false; 						// the $lastSavedString is consistant with the values of the properties.
		
		return true;			// Success!
	}
	
	/**
	 * This method scans for cache dir and redurns the path if found.
	 * @param string $dir  starting point
	 * @return string   retuns the path to the cache dir
	 * 
	 * @author Ognian Tsonev
	 */
	private function scanForCacheDir($dir='.') { 
		if(self::$cacheDir == '') { 
			if($dir=='.') $dir=getcwd();
			$depth_ini=count(explode('/', getcwd()));
			//echo $dir."<br />\n";
			$r=dir($dir);   	// open the dir
			$flag=false;		// flag if the result is found
			$cachePath='';  	// the var for the end result, the path to the config file
			$list=array();  	// list for the subdirectories found in the current dir
			$filePath='';  		// the variable for the filepaths
			
			/* iterate the file list */
			while(false !== ($file = $r->read())) {  // read the next entry
				if($file == '.' || $file == '..') continue;  // skip the linkbacks.
				//echo "-$dir/$file<br />\n";
				$filePath = $dir.'/'.$file;  // glue together the directory path and the file name to get the full path for the file
				
				if(is_dir($filePath)) {   	// if it is a directory
					$list[] = $filePath;  // save the path for recurssion
				}else{
					if(strcasecmp($file, self::$cacheFile)===0) {  // if the filename mach the cache file name
						$flag=true;   			// rize the flag that we have found it.
						$cachePath=dirname($filePath).'/';  // set the $cachePath with the filePath value for return.
					}
				}
			}
			
			$r->close(); 	// close the dir
			
			$depth=count(explode('/', $dir))-$depth_ini; // find the depth of the DIR
			/* If the file is not found in this directory recurse to the sub directories */
			if(!$flag && $depth<3){ 			// if the file is NOT FOUND AND the DEPTH is LESS-THAN 4
				foreach($list as $f){
					$try=self::scanForCacheDir($f);  // recurssion with the starting dir from the list
					if($try!==''){  	// if the result is found in this sub dir tree
						$cachePath=$try;  // set the configPat with the found path
						break;  // if the file is found no need to continue recurssion, so we terminate the loop
					}
				}
			}
			if($cachePath != '' ){
				self::setCacheDir($cachePath);// extract and set the cache dir form the path of the found cache file.
				//var_dump(self::$cacheDir);
			}
		}
		return self::$cacheDir;
	}
	
	/**
	 * This method will check for any saved config and return the path to it or false on failur
	 * The check will stop when something is found!
	 * @return string|bolean
	 * 
	 * @author Ognian Tsonev
	 */
	private function checkForSavedConfigurations() {
		//$cacheDir=self::getCa
		
		$dir 	= self::scanForCacheDir();
		$file 	= $dir.self::$cacheFile;
		if(is_readable($file)) {
			return $file;
		}
		return false;
	}
}

?>
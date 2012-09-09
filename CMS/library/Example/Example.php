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
 * Example package doesn't do anything. The purpous of this is to explayn the conventions for DPFW
 * 
 * First note this explanation of the purpous of this package. It's written as doc to the main class.
 * All classes should have documentation, and the main classes ahve aditional explanations.
 * You can make a README file in the package dir if there is alot to say about the package purpous, use or examples. 
 * 
 * @copyright 2012
 * @author Ognian Tsonev
 */
class Example {
	
	/**
	 * Static vars go first. 
	 * They are static. So you probably need to add some value to them right here 
	 * Use NULL for instance containers, empty array for arrays, empty string for strings and 0 to numerics.
	 */
	private static 
		$statVar1="", 	// make sure to explain everyone of the constants
		/*
		 * For Arrays or more info we use this type of comment
		 */
		$myStatArray=array( // don't write on the same line
				1=>"w",		// if it's not clear - wxplain all of the items
				2=>"o",
				3=>"r",
				4=>"l",
				5=>"d"
		);
	
	/**
	 * Here are the regular variables.
	 */
	private 
		$privateVariable1, 	// Explain what this var normaly contains
		$privateVariable2;	// Explain what is this var used for
	
	/**
	 * Protected vars go after private ones
	 */
	protected
		$protectedVar; 	// Explain what is this protected var for
	
	/**
	 * Last come the public vars
	 */
	public
		$variable1, 	// Explain what this var normaly contains
		$myVariable2;	// Explain what is this var used for
	/*
	 * Note the order we used here. 
	 */
	
	
	
	/**
	 * Always use __construct for constructor names. (Then we can reuse the code or change the name of the class without braking it.)
	 * The variables must be writhen with lower case letters and if the name is multiple words every other first letter must be upper case.
	 * The order is **Access** **[strict]** **function** **funcName
	 * Always use access word (public, private, protected) even when it is public!
	 * 
	 * @copyright 2012
	 * @author Ognian Tsonev
	 * @param String $inputVar
	 */
	public function __construct( $inputVar ){
		// this constructor will not do anything usefull
		
		$this->variable1 = $inputVar;
		
		/*
		 * Always use self:: for accessing static variables of methods
		 */
		self::$statVar1 = $inputVar;
	}
	
	/**
	 * This is an example of static method
	 * 
	 * @copyright 2012
	 * @author Ognian Tsonev
	 * @return string
	 */
	public static function staticExample( ){
		// This will return "world"
		return implode('', self::$myStatArray);
	}
}
?>
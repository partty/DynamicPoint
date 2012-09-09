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
 * This is an example of an abstract class
 * 
 * @copyright 2012
 * @author Ognian Tsonev
 *
 */

abstract class Example_MyType_Abstract {
	const TYPE = "Example_MyType"; 		// this is the type of the object
	
	/**
	 * in abstract classes private and protected make alot more sence than in other classes
	 */
	private $variable; // only when you have one variable to declate it is permited to do it on one line
	
	/**
	 * If you have a constructor in the abstract class there must be "parent::__construct();" statment in the child class
	 */
	public function __construct(){
		// do something here
	}
	
	/**
	 * 
	 * @param string $myInputVar
	 */	
	public function publicFunctionFromAbstract ( $myInputVar ){
		$this->variable = $myInputVar;
	}
	
	/**
	 * Returns the type of this object
	 * 
	 * Use a single underscore trailing the function name for protected  methods
	 * 
	 * @return string
	 */
	protected function _getType(){
		return self::TYPE;
	}
	
}
?>
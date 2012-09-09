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
 * This is an example of an Factory class
 * It's a good idea to use interface with factored classes
 * 
 * @copyright 2012
 * @author Ognian Tsonev
 *
 */

class Example_MyType_Factory {
	/**
	 * in abstract classes private and protected make alot more sence than in other classes
	 */
	private $variable; // only when you have one variable to declate it is permited to do it on one line
	
	/**
	 * There are may different factories. Some pass an object to convert it to othet object, others just create an instance.
	 * 
	 * @param string $myInputVar
	 * @return Example_MyType_Abstract
	 */	
	public static function create ( $type ) {
		$classname="Example_MyType_".$type;
		include_once 'Example/include.' . $type . '.php';
		return new $classname ( );
	}
	
	/**
	 * Shorthand for Example_MyType_Factory::create ( 'TypeOne' );
	 * @return Example_MyType_One
	 */
	public static function create_typeOne ( ) {
		return self::create ( 'One' );
	}
	
	/**
	 * Shorthand for Example_MyType_Factory::create ( 'TypeTue' );
	 * @return Example_MyType_One
	 */
	public static function create_typeTue ( ) {
		return self::create ( 'Tue' );
	}
}
?>
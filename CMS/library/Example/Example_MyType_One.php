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
 * It's the first type 
 * 
 * @copyright 2012
 * @author Ognian Tsonev
 *
 */
class Example_MyType_One extends Example_MyType_Abstract implements Example_MyType_Interface {
	const TYPE="One";
	
	public function __construct (){
		parent::__construct();
	}
	
	/**
	 * This method will return the full type of the object. 
	 */
	public function getType(){
		return parent::_getType() . '_' . self::TYPE;
	}
}
?>
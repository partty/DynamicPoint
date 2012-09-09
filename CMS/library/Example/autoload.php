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

/*
 * Autoloading is used most of the time for including classes. This is done automagicly. 
 * In this file we write a function named after the pacage with "autoloar_" prefix.
 *
 */

/**
 * This function is used to autoload every class in this package on demand.
 * It's not usualy needed if the convention is folowed. 
 * The implementation here is what will be done if there is no autoload file.
 * This should be used when something not covered by the convention is done.
 * 
 * Note that writing such function generaly will decrease performace slightly, 
 * but for the most part if the default algoritm can find the needed file, 
 * the function will not execute!
 * 
 * @param String $className  This is the name of the requested class.
 * @return void
 */
function autoload_Example ($className){
	try{
		include LIBRARYPATH.'Example/' . $className . '.php';
	}catch(Exception $e){
		include LIBRARYPATH.'Example/Example_' . $className . '.php';
	}
}
?>
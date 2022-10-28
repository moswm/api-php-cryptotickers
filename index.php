<?php
/*
 * api-php-cryptotickers / Getting crypto tickers (PHP)
 * Copyright (C) 2021 Baev
 *
 * MIT License
 * Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:
 * The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 * 
 * GNU General Public License, version 2
 * This program is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation; either version 2 of the License, or (at your option) any later version.
 * This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.
 * You should have received a copy of the GNU General Public License along with this program; if not, write to the Free Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
 * 
*/

ini_set('display_errors',1);
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);

	date_default_timezone_set('Europe/Amsterdam');

	settype($_GET['rqkey'],"string");
	settype($_GET['cmd'],"string");
	settype($_GET['type'],"string");

	if ($_GET['rqkey']!=trim(file_get_contents("rqkey"))) exit();
	if ($_GET['cmd']!='tickers') exit();

	header('Access-Control-Allow-Origin: *');

	$_gnrl_marketlist=array('btx','plx','cex');

	//======= auto-execution =======
	/* these URLs need to be added to the task for auto-execution
	 * at the required interval for each exchange, and these lines
	 * of code should be removed
	 */
	$srvurl='http://api-php-cryptotickers.moswm.ru/';
	$run1=file_get_contents($srvurl.'_tickers/plx/plx_run.php');
	$run2=file_get_contents($srvurl.'_tickers/btx/btx_run.php');
	$run3=file_get_contents($srvurl.'_tickers/cex/cex_run.php');
	//===== end auto-execution =====

	if ($_GET['type']=="stm") {
		include('_tickers/_tickers_gnrl_functions.php');
		echo _tickers_combtickerslist();
	} elseIf ($_GET['type']=="json") {
	}

?>

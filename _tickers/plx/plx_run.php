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

$plx_mt_start = microtime(true);

$plx_tickers=json_decode(file_get_contents("https://poloniex.com/public?command=returnTicker"),true);

$plx_mt_middle = microtime(true);

$plx_match_tickers=plx_matching();
$plx_result_tickers=array();
foreach ($plx_match_tickers as $key=>$val) {
	$plx_result_tickers[]=plx_getticker($key,$val);
}
file_put_contents('plx_tickers',implode("\r\n",$plx_result_tickers));

$plx_mt_end = microtime(true);

file_put_contents('plx_microtime',(string)$plx_mt_end);
file_put_contents('plx_stat',$plx_mt_start.' ('.($plx_mt_middle-$plx_mt_start).') '.$plx_mt_middle.' ('.($plx_mt_end-$plx_mt_middle).') '.$plx_mt_end.' / '.($plx_mt_end-$plx_mt_start));

function plx_matching() {
	return array(
'BTC_BTT'	=>'',
'BTC_XEC'	=>'',
'BTC_BCH'	=>'BTC_BCH',
'BTC_BCHSV'	=>'BTC_BCHSV',
'BTC_LSK'	=>'BTC_LSK',
'BTC_ASTR'	=>'',
'BTC_LTC'	=>'BTC_LTC',
'BTC_XRP'	=>'BTC_XRP',
'BTC_DGB'	=>'',
'BTC_DASH'	=>'BTC_DASH',
'BTC_NFT'	=>'',
'BTC_XEM'	=>'BTC_XEM',
'BTC_STR'	=>'BTC_STR',
'BTC_VTC'	=>'',
'BTC_SYS'	=>'',
'BTC_REPV2'	=>'BTC_REPV2',
'BTC_DOGE'	=>'BTC_DOGE',
'BTC_MANA'	=>'BTC_MANA',
'BTC_SC'	=>'BTC_SC',
'BTC_BCN'	=>'',
'BTC_XMR'	=>'BTC_XMR',
'BTC_SOLVE'	=>'',
'BTC_FCH'	=>'',
'USDT_BTC'	=>'USDT_BTC',
'USDT_BTT'	=>'USDT_BTT',
'USDT_XEC'	=>'',
'USDT_BCH'	=>'USDT_BCH',
'USDT_BCHSV'	=>'USDT_BCHSV',
'USDT_LSK'	=>'USDT_LSK',
'USDT_ASTR'	=>'',
'USDT_LTC'	=>'USDT_LTC',
'USDT_XRP'	=>'USDT_XRP',
'USDT_DGB'	=>'',
'USDT_DASH'	=>'USDT_DASH',
'USDT_NFT'	=>'USDT_NFT',
'USDT_XEM'	=>'USDT_XEM',
'USDT_STR'	=>'USDT_STR',
'USDT_VTC'	=>'',
'USDT_SYS'	=>'',
'USDT_REPV2'	=>'USDT_REPV2',
'USDT_DOGE'	=>'USDT_DOGE',
'USDT_MANA'	=>'USDT_MANA',
'USDT_SC'	=>'USDT_SC',
'USDT_BCN'	=>'USDT_BCN',
'USDT_XMR'	=>'USDT_XMR',
'USDT_SOLVE'	=>'',
'USDT_FCH'	=>''
	);
}

function plx_getticker($gnrticker,$ticker) {
global $plx_tickers;
	$result=array();
	$result[0]=$gnrticker;
	if (($ticker!='')&&(isset($plx_tickers[$ticker]))) {
		$currpair=$plx_tickers[$ticker];
		$result[1]=($currpair['isFrozen']=='0')?'trading':'frozen';
		$result[2]=$currpair['last'];
		$result[3]=$currpair['lowestAsk'];
		$result[4]=$currpair['highestBid'];
		$result[5]=$currpair['low24hr'];
		$result[6]=$currpair['high24hr'];
		$result[7]=$currpair['baseVolume'];
		$result[8]=$currpair['quoteVolume'];
	} else {
		$result[1]='not listed';
		$result[2]='0';
		$result[3]='0';
		$result[4]='0';
		$result[5]='0';
		$result[6]='0';
		$result[7]='0';
		$result[8]='0';
	}
	return implode(chr(9),$result);
}

?>

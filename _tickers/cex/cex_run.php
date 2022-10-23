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

$cex_mt_start = microtime(true);

$cex_tickers=json_decode(file_get_contents("https://api.coinex.com/v1/market/ticker/all"),true);

$cex_mt_middle = microtime(true);

$cex_match_tickers=cex_matching();
$cex_result_tickers=array();
foreach ($cex_match_tickers as $key=>$val) {
	$cex_result_tickers[]=cex_getticker($key,$val);
}
file_put_contents('cex_tickers',implode("\r\n",$cex_result_tickers));

$cex_mt_end = microtime(true);

file_put_contents('cex_microtime',(string)$cex_mt_end);
file_put_contents('cex_stat',$cex_mt_start.' ('.($cex_mt_middle-$cex_mt_start).') '.$cex_mt_middle.' ('.($cex_mt_end-$cex_mt_middle).') '.$cex_mt_end.' / '.($cex_mt_end-$cex_mt_start));

function cex_matching() {
	return array(
'BTC_BTT'	=>'BTTBTC',
'BTC_XEC'	=>'',
'BTC_BCH'	=>'BCHBTC',
'BTC_BCHSV'	=>'BSVBTC',
'BTC_LSK'	=>'LSKBTC',
'BTC_ASTR'	=>'ASTRBTC',
'BTC_LTC'	=>'LTCBTC',
'BTC_XRP'	=>'XRPBTC',
'BTC_DGB'	=>'DGBBTC',
'BTC_DASH'	=>'DASHBTC',
'BTC_NFT'	=>'',
'BTC_XEM'	=>'XEMBTC',
'BTC_STR'	=>'XLMBTC',
'BTC_VTC'	=>'VTCBTC',
'BTC_SYS'	=>'SYSBTC',
'BTC_REPV2'	=>'',
'BTC_DOGE'	=>'DOGEBTC',
'BTC_MANA'	=>'MANABTC',
'BTC_SC'	=>'SCBTC',
'BTC_BCN'	=>'BCNBTC',
'BTC_XMR'	=>'XMRBTC',
'BTC_SOLVE'	=>'',
'BTC_FCH'	=>'FCHBTC',
'USDT_BTC'	=>'BTCUSDT',
'USDT_BTT'	=>'BTTUSDT',
'USDT_XEC'	=>'XECUSDT',
'USDT_BCH'	=>'BCHUSDT',
'USDT_BCHSV'	=>'BSVUSDT',
'USDT_LSK'	=>'LSKUSDT',
'USDT_ASTR'	=>'ASTRUSDT',
'USDT_LTC'	=>'LTCUSDT',
'USDT_XRP'	=>'XRPUSDT',
'USDT_DGB'	=>'DGBUSDT',
'USDT_DASH'	=>'DASHUSDT',
'USDT_NFT'	=>'NFTUSDT',
'USDT_XEM'	=>'XEMUSDT',
'USDT_STR'	=>'XLMUSDT',
'USDT_VTC'	=>'VTCUSDT',
'USDT_SYS'	=>'SYSUSDT',
'USDT_REPV2'	=>'',
'USDT_DOGE'	=>'DOGEUSDT',
'USDT_MANA'	=>'MANAUSDT',
'USDT_SC'	=>'SCUSDT',
'USDT_BCN'	=>'BCNUSDT',
'USDT_XMR'	=>'XMRUSDT',
'USDT_SOLVE'	=>'',
'USDT_FCH'	=>'FCHUSDT'
	);
}

function cex_getticker($gnrticker,$ticker) {
global $cex_tickers;
	$result=array();
	$result[0]=$gnrticker;

	$cex_tickers_data=$cex_tickers['data'];
	$cex_tickers_data_ticker=$cex_tickers_data['ticker'];

	if (($ticker!='')&&(isset($cex_tickers_data_ticker[$ticker]))) {
		$currpair=$cex_tickers_data_ticker[$ticker];
		$result[1]='trading';
		$result[2]=$currpair['last'];
		$result[3]=$currpair['sell'];
		$result[4]=$currpair['buy'];
		$result[5]=$currpair['low'];
		$result[6]=$currpair['high'];
		$result[7]=number_format(((float)$currpair['vol'])*((float)$currpair['last']),8);
		$result[8]=$currpair['vol'];
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

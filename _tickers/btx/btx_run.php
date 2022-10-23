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

$btx_mt_start = microtime(true);

$btx_tickers=json_decode(file_get_contents("https://api.bittrex.com/v3/markets/tickers"),true);
$btx_summaries=json_decode(file_get_contents("https://api.bittrex.com/v3/markets/summaries"),true);

$btx_mt_middle = microtime(true);

$btx_match_tickers=btx_matching();
$btx_result_tickers=array();
foreach ($btx_match_tickers as $key=>$val) {
	$btx_result_tickers[]=btx_getticker($key,$val);
}
file_put_contents('btx_tickers',implode("\r\n",$btx_result_tickers));

$btx_mt_end = microtime(true);

file_put_contents('btx_microtime',(string)$btx_mt_end);
file_put_contents('btx_stat',$btx_mt_start.' ('.($btx_mt_middle-$btx_mt_start).') '.$btx_mt_middle.' ('.($btx_mt_end-$btx_mt_middle).') '.$btx_mt_end.' / '.($btx_mt_end-$btx_mt_start));

function btx_matching() {
	return array(
'BTC_BTT'	=>'BTT-BTC',
'BTC_XEC'	=>'',
'BTC_BCH'	=>'BCH-BTC',
'BTC_BCHSV'	=>'BSV-BTC',
'BTC_LSK'	=>'LSK-BTC',
'BTC_ASTR'	=>'',
'BTC_LTC'	=>'LTC-BTC',
'BTC_XRP'	=>'XRP-BTC',
'BTC_DGB'	=>'DGB-BTC',
'BTC_DASH'	=>'',
'BTC_NFT'	=>'',
'BTC_XEM'	=>'XEM-BTC',
'BTC_STR'	=>'XLM-BTC',
'BTC_VTC'	=>'VTC-BTC',
'BTC_SYS'	=>'SYS-BTC',
'BTC_REPV2'	=>'REPV2-BTC',
'BTC_DOGE'	=>'DOGE-BTC',
'BTC_MANA'	=>'MANA-BTC',
'BTC_SC'	=>'SC-BTC',
'BTC_BCN'	=>'',
'BTC_XMR'	=>'',
'BTC_SOLVE'	=>'SOLVE-BTC',
'BTC_FCH'	=>'',
'USDT_BTC'	=>'BTC-USDT',
'USDT_BTT'	=>'BTT-USDT',
'USDT_XEC'	=>'',
'USDT_BCH'	=>'BCH-USDT',
'USDT_BCHSV'	=>'BSV-USDT',
'USDT_LSK'	=>'',
'USDT_ASTR'	=>'',
'USDT_LTC'	=>'LTC-USDT',
'USDT_XRP'	=>'XRP-USDT',
'USDT_DGB'	=>'DGB-USDT',
'USDT_DASH'	=>'',
'USDT_NFT'	=>'',
'USDT_XEM'	=>'',
'USDT_STR'	=>'XLM-USDT',
'USDT_VTC'	=>'',
'USDT_SYS'	=>'',
'USDT_REPV2'	=>'',
'USDT_DOGE'	=>'DOGE-USDT',
'USDT_MANA'	=>'',
'USDT_SC'	=>'SC-USDT',
'USDT_BCN'	=>'',
'USDT_XMR'	=>'',
'USDT_SOLVE'	=>'SOLVE-USDT',
'USDT_FCH'	=>''
	);
}

function btx_getticker($gnrticker,$ticker) {
global $btx_tickers;
global $btx_summaries;
	$result=array();
	$result[0]=$gnrticker;
	$key_tickers = array_search($ticker, array_map(function($element){return $element['symbol'];}, $btx_tickers));
	$key_summaries = array_search($ticker, array_map(function($element){return $element['symbol'];}, $btx_summaries));
	if (($ticker!='')&&($key_tickers)&&($key_summaries)) {
		$currpair_tickers=$btx_tickers[$key_tickers];
		$currpair_summaries=$btx_summaries[$key_summaries];
		$result[1]='trading';
		$result[2]=$currpair_tickers['lastTradeRate'];
		$result[3]=$currpair_tickers['askRate'];
		$result[4]=$currpair_tickers['bidRate'];
		$result[5]=$currpair_summaries['low'];
		$result[6]=$currpair_summaries['high'];
		$result[7]=$currpair_summaries['quoteVolume'];
		$result[8]=$currpair_summaries['volume'];
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

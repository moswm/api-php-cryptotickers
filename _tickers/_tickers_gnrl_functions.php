<?php

// by Baev, 2021

function _tickers_combtickerslist() {
global $_gnrl_marketlist;
	$alt='';
	foreach ($_gnrl_marketlist as $mktname) {
		$alt.=_tickers_getstmtickerslist($mktname);
	}
	return $alt;
}

function _tickers_getstmtickerslist($stm) {
	$tl=$stm.'#';
	$pagerec=file('_tickers/'.$stm.'/'.$stm.'_tickers');
	foreach ($pagerec as $rec) {
		$tmp=explode(chr(9), $rec);
		if ($tmp[0]!='') {
			$tl.=str_replace('	','!',$rec).'|';
		}
	}
	$tl.='#';
	return $tl;
}

?>

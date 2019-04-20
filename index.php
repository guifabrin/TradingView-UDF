<?php

date_default_timezone_set ("UTC");
ini_set("display_startup_errors", 1);
ini_set("display_errors", 1);
error_reporting(E_ALL|E_STRICT);
date_default_timezone_set("UTC");
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
require_once("functions.php");
if (!file_exists("vendor/autoload.php")) return api_error('[Composer] Please run composer install.');
    require_once("vendor/autoload.php");
$action = $_REQUEST["action"];
if (!isset($action)) api_error("[Action] Not Implemented");
try{
	if (isset($_REQUEST['symbol'])){
		$_REQUEST['symbol_fake'] = $_REQUEST['symbol'];
		if  (strpos($_REQUEST['symbol'], 'OTC:BTC/') !== false){
			$_REQUEST['symbol'] = 'BINANCE:BNB/BTC';
		}
		if  (strpos($_REQUEST['symbol'], 'OTC:ETH/') !== false){
			$_REQUEST['symbol'] = 'BINANCE:BNB/ETH';
		}
		if  (strpos($_REQUEST['symbol'], 'OTC:LCT/') !== false){
			$_REQUEST['symbol'] = 'BINANCE:BNB/LCT';
		}
		if  (strpos($_REQUEST['symbol'], 'OTC:XRP/') !== false){
			$_REQUEST['symbol'] = 'BINANCE:BNB/XRP';
		}
		if  (strpos($_REQUEST['symbol'], 'OTC:USDT/') !== false){
			$_REQUEST['symbol'] = 'BINANCE:BNB/USDT';
		}
	}
    $action = "api_".$action;
    $action();
} catch (\ccxt\NetworkError $exception) {
    return api_error("[Network Error] " . $exception->getMessage ());
} catch (\ccxt\ExchangeError $exception) {
    return api_error("[Exchange Error] " . $exception->getMessage ());
} catch (Exception $exception) {
    return api_error("[Error] " . $exception->getMessage ());
}
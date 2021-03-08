<?php
/**
 * 
 */
if (!function_exists('get_defined_functions2')) {
	function get_defined_functions2()
	{
		$arr = get_defined_functions();
		sort($arr['internal']);
		sort($arr['user']);
		return $arr;
	}
}

/**
 * 
 */
if (!function_exists('dump_defined_functions')) {
	function dump_defined_functions()
	{
		$arr = get_defined_functions2();
		dd($arr);
	}
}

/**
 * 
 */
if (function_exists('d')) {
	throw new \Exception('Cannot call dumper. Function d() exists');
} else {
	function d(...$args) {
		return \FireBender\Laravel\Dumper\Dumper::getInstance(...$args);
	}
}

/**
 * 
 */
if (function_exists('eb')) {
	throw new \Exception('Cannot call dumper. Function eb() exists');
} else {
	function eb($s, $html = false) {
		$line = $s . PHP_EOL;
		if ($html) $line = nl2br($line);
		echo $line;
	}
}

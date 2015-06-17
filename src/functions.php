<?php

/**
 * 10% faster than internal static function.
 * @param array $find
 * @return string
 */
function underscoreCallback($find)
{
	if (!empty($find[1])) {
		return $find[1] . '_' . $find[2];
	}
	return $find[3] . '_' . $find[4];
}

function camelCallback($find)
{
	return strtoupper($find[1]);
}

if (!function_exists('_')) {
	function _($message)
	{
		return $message;
	}
}
<?php

namespace PTK\AutoInv\util;

class ColorUtils {

	/**
	 * Apply minecraft color codes to a string from our custom ones
	 *
	 * @param string $string
	 * @param string $symbol
	 *
	 * @return string
	 */
	public static function translateColors(string $string, string $symbol = "&") : string {
		return preg_replace("/{$symbol}([0123456789abcdefklmnor])/i", "§$1", $string);
	}

	/**
	 * Removes all minecraft color codes from a string
	 *
	 * @param string $string
	 * @param string $symbol
	 *
	 * @return string
	 */
	public static function cleanString(string $string, string $symbol = "&") : string {
		return preg_replace("/(?:{$symbol}|§)([0123456789abcdefklmnor])/i", "", $string);
	}

}
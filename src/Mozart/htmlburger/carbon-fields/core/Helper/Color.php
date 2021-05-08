<?php
/**
 * @license GPL-2.0-only
 *
 * Modified by Mike iLL Kilmer on 08-May-2021 using Strauss.
 * @see https://github.com/BrianHenryIE/strauss
 */

namespace MZoo\MBO_Sandbox\Dependencies\Carbon_Fields\Helper;

/**
 * Color functions
 */
class Color {
	/**
	 * Converts a hexadecimal color into it's RGBA components
	 * Accepts hex with and without alpha: #112233, #112233FF
	 * Accepts hex with and without a leading # sign
	 *
	 * @param  string $hex
	 * @return array
	 */
	public static function hex_to_rgba( $hex ) {
		$hex = str_replace( '#', '', $hex );
		$hex = strlen( $hex ) > 6 ? $hex : $hex . 'FF';

		$int = hexdec( $hex );
		$red = ( $int >> 24 ) & 255;
		$green = ( $int >> 16 ) & 255;
		$blue = ( $int >> 8 ) & 255;
		$alpha = floatval( $int & 255 ) / 255;

		return array(
			'red' => $red,
			'green' => $green,
			'blue' => $blue,
			'alpha' => $alpha,
		);
	}
}

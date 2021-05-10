<?php
/**
 * @license GPL-2.0-only
 *
 * Modified by Mike iLL Kilmer on 10-May-2021 using Strauss.
 * @see https://github.com/BrianHenryIE/strauss
 */

namespace MZoo\MBO_Sandbox\Dependencies\Carbon_Fields\Container\Condition;

/**
 * Check is post is of specific format
 *
 * Pass an empty string as the value for this condition in order to test if the post has no format assigned
 */
class Post_Format_Condition extends Condition {

	/**
	 * Check if the condition is fulfilled
	 *
	 * @param  array $environment
	 * @return bool
	 */
	public function is_fulfilled( $environment ) {
		$post_id = $environment['post_id'];
		$format = get_post_format( $post_id );
		$format = ( $format ) ? $format : ''; // force an empty string for falsy values to ensure strict comparisons work

		return $this->compare(
			$format,
			$this->get_comparison_operator(),
			$this->get_value()
		);
	}
}
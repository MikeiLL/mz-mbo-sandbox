<?php
/**
 * @license GPL-2.0-only
 *
 * Modified by Mike iLL Kilmer on 10-May-2021 using Strauss.
 * @see https://github.com/BrianHenryIE/strauss
 */

namespace MZoo\MBO_Sandbox\Dependencies\Carbon_Fields\Datastore;

use MZoo\MBO_Sandbox\Dependencies\Carbon_Fields\Field\Field;

/**
 * Comment meta datastore class.
 */
class Comment_Meta_Datastore extends Meta_Datastore {

	/**
	 * Retrieve the type of meta data.
	 *
	 * @return string
	 */
	public function get_meta_type() {
		return 'comment';
	}

	/**
	 * Retrieve the meta table name to query.
	 *
	 * @return string
	 */
	public function get_table_name() {
		global $wpdb;
		return $wpdb->commentmeta;
	}

	/**
	 * Retrieve the meta table field name to query by.
	 *
	 * @return string
	 */
	public function get_table_field_name() {
		return 'comment_id';
	}
}

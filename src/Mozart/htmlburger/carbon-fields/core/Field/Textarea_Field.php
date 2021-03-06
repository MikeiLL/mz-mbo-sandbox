<?php
/**
 * @license GPL-2.0-only
 *
 * Modified by Mike iLL Kilmer on 10-May-2021 using Strauss.
 * @see https://github.com/BrianHenryIE/strauss
 */

namespace MZoo\MBO_Sandbox\Dependencies\Carbon_Fields\Field;

/**
 * Textarea field class.
 */
class Textarea_Field extends Field {

	/**
	 * {@inheritDoc}
	 */
	protected $allowed_attributes = array( 'maxLength', 'minLength', 'placeholder', 'readOnly', 'is' );

	/**
	 * Number of rows (affects textarea height)
	 *
	 * @var integer
	 */
	protected $rows = 5;

	/**
	 * Change the number of rows of this field.
	 *
	 * @param  integer $rows Number of rows
	 * @return self    $this
	 */
	public function set_rows( $rows = 0 ) {
		$this->rows = absint( $rows );
		return $this;
	}

	/**
	 * Returns an array that holds the field data, suitable for JSON representation.
	 *
	 * @param  bool  $load Should the value be loaded from the database or use the value from the current instance.
	 * @return array
	 */
	public function to_json( $load ) {
		$field_data = parent::to_json( $load );

		$field_data = array_merge( $field_data, array(
			'rows' => $this->rows,
		) );

		return $field_data;
	}
}

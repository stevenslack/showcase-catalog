<?php
/**
 * No Cart Item
 *
 * The no cart item class which handles all data from each item
 *
 * @class       No_Cart_Item
 * @version     1.0.0
 */

class No_Cart_Item {

	/** @var int The item (post) ID. */
	public $id;

	/** @var object The actual post object. */
	public $post;

	public function __construct( $item ) {

		if ( is_numeric( $item ) ) {
			$this->id   = absint( $item );
			$this->post = get_post( $this->id );
		} elseif ( $item instanceof WC_Product ) {
			$this->id   = absint( $item->id );
			$this->post = $item;
		} elseif ( $item instanceof WP_Post || isset( $item->ID ) ) {
			$this->id   = absint( $item->ID );
			$this->post = $item;
		}
	}

}
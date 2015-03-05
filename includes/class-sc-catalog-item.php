<?php
/**
 * Showcase Catalog Item
 *
 * The Showcase Catalog item class which handles all data from each item
 *
 * @class       SC_Catalog_Item
 * @version     1.0.0
 */

class SC_Catalog_Item {

	/** @var int The item (post) ID. */
	public $id;

	/** @var object The actual post object. */
	public $post;

	/**
	 * Showcase Catalog Item Construct
	 * @param int $item the ID of the product or item
	 */
	public function __construct( $item ) {

		if ( is_numeric( $item ) ) {
			$this->id   = absint( $item );
			$this->post = get_post( $this->id );
		} elseif ( $item instanceof SC_Catalog_Item ) {
			$this->id   = absint( $item->id );
			$this->post = $item;
		} elseif ( $item instanceof WP_Post || isset( $item->ID ) ) {
			$this->id   = absint( $item->ID );
			$this->post = $item;
		}
	}


	/**
	 * Return an instance of this class.
	 *
	 * @since     1.0.0
	 *
	 * @return    object    A single instance of this class.
	 */
	public static function instance() {

		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	/**
	 * Get the item price
	 * @return string the price of the product
	 */
	public function get_price() {

		// set the currency to US standards
		setlocale( LC_MONETARY, 'en_US' );

		$price = get_post_meta( $this->id, 'sc-catalog-price', true );
		if ( $price ) {

			// curently only show US price symbol
			return money_format( '%+#10n', intval( $price ) );
		}

	}


	/**
	 * Get the item reduced price
	 * 
	 * @return string the reduced price of the item
	 */
	public function get_reduced_price() {

		// set the currency to US standards
		setlocale( LC_MONETARY, 'en_US' );

		$price = get_post_meta( $this->id, 'sc-catalog-sale-price', true );
		if ( $price ) {

			// curently only show US price symbol
			return money_format( '%+#10n', $price );
		}
	}

	/**
	 * The Adusted Price
	 * displays the sale price and the regular price
	 * 
	 * @return string html span tags with price
	 */
	public function adjusted_price() {

		$price = '';

		// get the discounted price
		$sale_price = $this->get_reduced_price() ? '<span class="sc-catalog-sale-price">' . $this->get_reduced_price() . '</span>' : '';

		// the strikethough class if there is a sale price
		$strike_class = $sale_price ? ' strike' : '';

		// get the regular price
		$reg_price = $this->get_price() ? '<span class="sc-catalog-reg-price' . $strike_class . '">' . $this->get_price() . '</span>' : '';

		if ( $sale_price && $reg_price ) {

			$price = sprintf( '<del>%1$s</del> <ins>%2$s</ins>', $reg_price, $sale_price );

			$price = apply_filters( 'sc_catalog_adjusted_price', $price, $this );

		} else {

			$price = $reg_price . $sale_price;

			$price = apply_filters( 'sc_catalog_display_price', $price, $this );
		}

		if ( $price )

			$price_html = sprintf( '<div class="sc-catalog-price">%s</div>', $price );

		return apply_filters( 'sc_catalog_display_html_price', $price_html, $this );

	}


	/**
	 * Get the SKU
	 * 
	 * @return string the SKU
	 */
	public function get_sku() {

		$sku = esc_html( get_post_meta( $this->id, 'sc-catalog-sku', true ) );

		if ( ! $sku )
			return;

		return apply_filters( 'sc_catalog_get_the_sku', $sku, $this );

	}

	/**
	 * Get the SKU html format
	 * @return [type] [description]
	 */
	public function get_sku_html() {

		$sku = $this->get_sku();

		if ( ! $sku )
			return;

		return sprintf( '<div class="sc-catalog-sku">%s</div>', $sku );

	}

}
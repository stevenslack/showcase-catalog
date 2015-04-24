<?php
/*
Description: Example plugin for adding an image upload field to a taxonomy term edit page.
Author: daggerhart
Version: 1.0
Author URI: http://daggerhart.com
*/

class Taxonomy_Term_Image {

    private $version = '1.0';

    // the taxonomy we are targeting
    private $taxonomy = 'sc-catalog-categories';

    // location of our plugin as a url
    private $plugin_url;

    // where we will store our term_data
    private $option_name = 'catalog_term_images';

    // array of key value pairs:  term_id => image_id
    private $term_images = array();

    /**
     * Init the plugin and hook into WordPress
     */
    function __construct() {
        // get our plugin location for enqueing scripts and styles
        $this->plugin_url = plugin_dir_url( __FILE__ );

        $this->term_images = get_option( $this->option_name, $this->term_images );

        // Only fire the hooks if we are in the admin

        if ( is_admin() ) {

            // hook into wordpress admin
            add_action( 'admin_enqueue_scripts', array( $this, 'action_admin_enqueue_scripts' ) );

            add_action( $this->taxonomy . '_add_form_fields', array( $this, 'taxonomy_add_form' ) );
            add_action( $this->taxonomy . '_edit_form_fields', array( $this, 'taxonomy_edit_form' ) );

            if ( isset( $_POST['taxonomy_term_image'] ) ) {
                add_action( 'created_term', array( $this, 'taxonomy_term_form_save' ) );
                add_action( 'edited_term', array( $this, 'taxonomy_term_form_save' ) );
            }

        }
    }

    /**
     * WordPress action "admin_enqueue_scripts"
     */
    function action_admin_enqueue_scripts(){
        // get the screen object to decide if we want to inject our scripts
        $screen = get_current_screen();

        // we're looking for "edit-category"
        if ( $screen->id == 'edit-' . $this->taxonomy ){
            // WP core stuff we need
            wp_enqueue_media();
            wp_enqueue_style( 'thickbox' );
            $dependencies = array( 'jquery', 'thickbox', 'media-upload' );

            // our custom script
            wp_register_script( 'taxonomy-term-image-js', $this->plugin_url . '/js/taxonomy-term-image.js', $dependencies, $this->version, true );

            // Localize the modal window title
            $translation_array = array(
                'modal_title' => __( 'Select or upload an image for this category', 'sc-catelog' ),
                'modal_attach' => __( 'Attach', 'sc-catelog' )
            );
            wp_localize_script( 'taxonomy-term-image-js', 'tax_term_image_vars', $translation_array );
            wp_enqueue_script( 'taxonomy-term-image-js' );
        }
    }

    /**
     * The HTML form for our taxonomy image field
     * 
     * @param  int    $image_ID  the image ID
     * @param  array  $image_src 
     * @return string the html output for the image form
     */
    function taxonomy_term_form_html( $image_ID = '', $image_src = array() ) {
        ?>
            <input type="button" class="taxonomy-term-image-attach button" value="<?php _e( 'Select Image', 'sc-catelog' ); ?>" />
            <input type="button" class="taxonomy-term-image-remove button" value="<?php _e( 'Remove', 'sc-catelog' ); ?>" />
            <input type="hidden" id="taxonomy-term-image-id" name="taxonomy_term_image" value="<?php print absint( $image_ID ); ?>" />
            <p class="description"><?php _e( 'Select which image should represent this category.', 'sc-catelog' ); ?></p>

            <p id="taxonomy-term-image-container">
                <?php if ( isset( $image_src[0] ) ) : ?>
                    <img class="taxonomy-term-image-attach" src="<?php print esc_attr( $image_src[0] ); ?>" />
                <?php endif; ?>
            </p>
        <?php
    }

    /**
     * Add a new form field for the add taxonomy term form
     */
    function taxonomy_add_form(){

        ?>
            <div class="form-field term-image-wrap">
                <label><?php _e( 'Category Image', 'sc-catelog' ); ?></label>
                <?php $this->taxonomy_term_form_html(); ?>
            </div>
        <?php
       
    }

    /**
     * Add a new form field for the edit taxonomy term form
     *
     * @param $tag | object | the term object
     */
    function taxonomy_edit_form( $tag ){
        
        // default values
        $image_ID = '';
        $image_src = array();

        // look for existing data for this term
        if ( isset( $this->term_images[ $tag->term_id ] ) ) {
            $image_ID  = $this->term_images[ $tag->term_id ];
            $image_src = wp_get_attachment_image_src( $image_ID, 'thumbnail' );
        } 

        ?>
            <tr class="form-field">
                <th scope="row" valign="top"><label><?php _e( 'Taxonomy Term Image', 'sc-catelog' ); ?></label></th>
                <td class="taxonomy-term-image-row">
                <?php $this->taxonomy_term_form_html( $image_ID, $image_src ); ?>
                </td>
            </tr>
        <?php
       
    }

    /**
     * Handle saving our custom taxonomy data
     *
     * @param $term_id
     */
    function taxonomy_term_form_save( $term_id, $tt_id = '', $taxonomy = '' ) {

        if ( $_POST['taxonomy'] == $this->taxonomy && isset( $_POST['taxonomy_term_image'] ) ) {
            // we only care about this term, look for it specifically
            if ( ! empty( $_POST['taxonomy_term_image'] ) ) {
                // set the image in the term_data array, and sanitize it
                $this->term_images[ $term_id ] = absint( $_POST['taxonomy_term_image'] );

            } else {
                unset( $this->term_images[ $term_id ] );
            }

            // save the data
            update_option( $this->option_name, $this->term_images );
        }
    }

}


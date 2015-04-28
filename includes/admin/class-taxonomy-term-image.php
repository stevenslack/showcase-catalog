<?php
/*
 * Taxonomy Term Images
 * https://github.com/daggerhart/taxonomy-term-image
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

if ( ! class_exists( 'Taxonomy_Term_Image' ) ) :

class Taxonomy_Term_Image {

    // object version used for enqueuing scripts
    private $version = '1.4';

    // location of our plugin as a url
    private $plugin_url;

    // the slug for the taxonomy we are targeting
    // api: use filter 'taxonomy-term-image-taxonomy' to override
    private $taxonomy = 'category';

    // defined during __construct() for i18n reasons
    // api: use filter 'taxonomy-term-image-labels' to override
    private $labels = array();

    // where we will store our term_data
    // will dynamically be set to $this->taxonomy . '_term_images' by default
    // api: use filter 'taxonomy-term-image-option-name' to override
    private $option_name = '';

    // array of key value pairs:  term_id => image_id
    private $term_images = array();

    /**
     * Simple singleton to enforce once instance
     *
     * @return Taxonomy_Term_Image object
     */
    static function instance() {
        static $object = null;
        if ( is_null( $object ) ) {
            $object = new Taxonomy_Term_Image();
        }
        return $object;
    }

    /**
     * Init the plugin and hook into WordPress
     */
    private function __construct() {
        // default labels
        $this->labels = array(
            'fieldTitle'       => __( 'Taxonomy Term Image', 'sc-catalog' ),
            'fieldDescription' => __( 'Select which image should represent this term.', 'sc-catalog' ),
            'imageButton'      => __( 'Select Image', 'sc-catalog' ),
            'removeButton'     => __( 'Remove', 'sc-catalog' ),
            'modalTitle'       => __( 'Select or upload an image for this term', 'sc-catalog' ),
            'modalButton'      => __( 'Attach', 'sc-catalog' ),
        );

        // default option name keyed to the taxonomy
        $this->option_name = $this->taxonomy . '_term_images';

        // allow overriding of the target taxonomy
        $this->taxonomy = apply_filters( 'taxonomy-term-image-taxonomy', $this->taxonomy );

        // allow overriding of the html text
        $this->labels = apply_filters( 'taxonomy-term-image-labels', $this->labels );

        // allow overriding of option_name
        $this->option_name = apply_filters( 'taxonomy-term-image-option-name', $this->option_name );

        // gather data
        $this->term_images = get_option( $this->option_name, $this->term_images );

        // hook into wordpress

        // Only fire the hooks if we are in the admin
        if ( is_admin() ) {
            $this->hook_up();
        }
    }

    // prevent cloning
    private function __clone(){}

    // prevent unserialization
    private function __wakeup(){}

    /**
     * Initialize the object
     * - hook into WordPress admin
     */
    private function hook_up(){
        add_action( 'admin_enqueue_scripts', array( $this, 'action_admin_enqueue_scripts' ) );

        add_action( $this->taxonomy . '_add_form_fields', array( $this, 'taxonomy_add_form' ) );
        add_action( $this->taxonomy . '_edit_form_fields', array( $this, 'taxonomy_edit_form' ) );

        add_action( 'created_term', array( $this, 'taxonomy_term_form_save' ), 10, 3 );
        add_action( 'edited_term', array( $this, 'taxonomy_term_form_save' ), 10, 3 );
        add_action( 'delete_term', array( $this, 'delete_term' ), 10, 4 );
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

            // register our custom script
            wp_register_script( 'taxonomy-term-image-js', SC_URL . '/assets/js/admin/taxonomy-term-image.js', $dependencies, $this->version, true );

            // Localize the modal window text so that we can translate it
            wp_localize_script( 'taxonomy-term-image-js', 'TaxonomyTermImageText', $this->labels );

            // enqueue the registered and localized script
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
    function taxonomy_term_form_html( $image_ID = null, $image_src = array() ) {
        wp_nonce_field('taxonomy-term-image-form-save', 'taxonomy-term-image-save-form-nonce');
        ?>
        <input type="button" class="taxonomy-term-image-attach button" value="<?php echo esc_attr( $this->labels['imageButton'] ); ?>" />
        <input type="button" class="taxonomy-term-image-remove button" value="<?php echo esc_attr( $this->labels['removeButton'] ); ?>" />
        <input type="hidden" id="taxonomy-term-image-id" name="taxonomy_term_image" value="<?php print absint( $image_ID ); ?>" />
        <p class="description"><?php echo $this->labels['fieldDescription']; ?></p>

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
            <label><?php echo $this->labels['fieldTitle']; ?></label>
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
            $image_src =  wp_get_attachment_image_src( $image_ID, 'thumbnail' );
        }
        ?>
        <tr class="form-field">
            <th scope="row" valign="top"><label><?php echo $this->labels['fieldTitle']; ?></label></th>
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
     * @param $tt_id
     * @param $taxonomy
     */
    function taxonomy_term_form_save( $term_id, $tt_id, $taxonomy ) {

        // our requirements for saving:
        if (
            //  - nonce was submitted and is verified
            isset( $_POST['taxonomy-term-image-save-form-nonce'] ) &&
            wp_verify_nonce( $_POST['taxonomy-term-image-save-form-nonce'], 'taxonomy-term-image-form-save' ) &&

            //  - taxonomy data and taxonomy_term_image data was submitted
            isset( $_POST['taxonomy'] ) &&
            isset( $_POST['taxonomy_term_image'] ) &&

            //  - the taxonomy submitted is the taxonomy we are dealing with
            $_POST['taxonomy'] == $this->taxonomy
        )
        {
            if ( ! empty( $_POST['taxonomy_term_image'] ) ) {
                // set the image in the term_data array, and sanitize it
                $this->term_images[ $term_id ] = absint( $_POST['taxonomy_term_image'] );
            }
            else if ( isset( $this->term_images[ $term_id ] ) ) {
                // term was submitted with no image value,
                unset( $this->term_images[ $term_id ] );
            }

            // save the data
            update_option( $this->option_name, $this->term_images );
        }
    }

    /**
     * Delete a term's image data when the term is deleted
     *
     * @param $term_id
     * @param $tt_id
     * @param $taxonomy
     * @param $deleted_term
     */
    function delete_term( $term_id, $tt_id, $taxonomy, $deleted_term ) {
        if ( $taxonomy == $this->taxonomy && isset( $this->term_images[ $term_id ] ) ) {
            unset( $this->term_images[ $term_id ]  );

            // save the data
            update_option( $this->option_name, $this->term_images );
        }
    }
}

endif;

/**
 * Filter the label for the 
 * @param  [type] $labels [description]
 * @return [type]         [description]
 */
function my_taxonomy_term_image_labels( $labels ) {
    $labels['fieldTitle'] = __( 'Catalog Category Image', 'sc-catalog' );

    return $labels;
}
add_filter( 'taxonomy-term-image-labels', 'my_taxonomy_term_image_labels' );


function sc_taxonomy_term_image_taxonomy( $taxonomy ) {
    // use for tags instead of categories
    return 'sc-catalog-categories';
}
add_filter( 'taxonomy-term-image-taxonomy', 'sc_taxonomy_term_image_taxonomy' );


function my_taxonomy_term_image_option_name( $option_name ) {
    // store in wp_options where option_name = 'catalog_term_images'
    return 'catalog_term_images';
}
add_filter( 'taxonomy-term-image-option-name', 'my_taxonomy_term_image_option_name' );
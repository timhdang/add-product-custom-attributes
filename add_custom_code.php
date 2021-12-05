add_action( 'woocommerce_variation_options_pricing', 'bbloomer_add_custom_field_to_variations', 10, 3 );
 
function bbloomer_add_custom_field_to_variations( $loop, $variation_data, $variation ) {
   woocommerce_wp_text_input( array(
                                    'id' => 'my_custom_code[' . $loop . ']',
                                    'class' => 'short',
                                    'label' => __( 'my_custom_code', 'woocommerce' ),
                                    'value' => get_post_meta( $variation->ID, 'my_custom_code', true )
                                       ) );
}
 
// -----------------------------------------
// 2. Save custom field on product variation save
 
add_action( 'woocommerce_save_product_variation', 'bbloomer_save_custom_field_variations', 10, 2 );
 
function bbloomer_save_custom_field_variations( $variation_id, $i ) {
   $custom_field = $_POST['my_custom_code'][$i];
   if ( isset( $custom_field ) ) update_post_meta( $variation_id, 'my_custom_code', esc_attr( $custom_field ) );
}
 
// -----------------------------------------
// 3. Store custom field value into variation data
 
add_filter( 'woocommerce_available_variation', 'bbloomer_add_custom_field_variation_data' );
 
function bbloomer_add_custom_field_variation_data( $variations ) {
   $variations['my_custom_code'] = '<div class="woocommerce_custom_field">Custom Code: <span>' . get_post_meta( $variations[ 'variation_id' ], 'my_custom_code', true ) . '</span></div>';
   return $variations;
}

<?php
/**
 * This function is use for creating mini shortcode
 */
function ak_mini_cart() {
    // if ( is_admin() ) return false;
    global $woocommerce;
    if( empty( $woocommerce->cart ) ){
        $items = array();
    }
    else{
        $items = $woocommerce->cart->get_cart();
    }
    ob_start();
    ?>
        <div class="ak-cart-wrapper1">
            <a class="ak-cart">
                <span class="ak-count"><?php echo $woocommerce->cart->cart_contents_count; ?></span>
            </a>
            <?php if( $items ) : ?>
                <div class="ak-content ak-content">
                    <h3><?php printf( __('You have %d items in cart', 'ak-minicart'), $woocommerce->cart->cart_contents_count); ?></h3>
                    <ul class="ak-products">
                        <?php foreach($items as $item => $values) {  
                            $_product =  wc_get_product( $values['data']->get_id() );
                        //echo $_product; 
                            ?>
                            <li>
                                <div class="ak-remove">
                                    <?php
                                        // @codingStandardsIgnoreLine
                                    echo apply_filters( 'woocommerce_cart_item_remove_link', sprintf(
                                        '<a href="%s" class="remove" aria-label="%s" data-product_id="%s" data-product_sku="%s">&times;</a>',
                                        esc_url( wc_get_cart_remove_url( $item ) ),
                                        __( 'Remove this item', 'ak-minicart' ),
                                        esc_attr( $_product ),
                                        esc_attr( wc_get_product( $values['data']->get_id() )->get_sku() )
                                    ), $item );
                                    ?>
                                </div>
                                <div class="ak-image">
                                    <?php
                                    $getProductDetail = wc_get_product( $values['product_id'] );
                                    ?>
                                    <a href="<?php echo $_product->get_permalink(); ?>">
                                        <?php echo $getProductDetail->get_image(); ?>
                                    </a>
                                </div>	
                                <div class="ak-details">
                                    <a class="ak-product-title" href="<?php echo $_product->get_permalink(); ?>">
                                        <h4><?php echo $_product->get_title() ?></h4>
                                    </a>
                                    <?php
                                    $price      = $_product->get_price_html();
                                    ?>
                                    <p>
                                        <?php echo '<span class="ak-price">'. $price .'</span> x '. $values["quantity"]; ?>
                                    </p>
                                </div>
                            </li>
                        <?php } ?>
                    </ul>
                    <div class="ak-subtota ak-subtotal">
                        <h5><?php _e( 'Subtotal:&nbsp;', 'ak-minicart' ); echo $woocommerce->cart->get_cart_subtotal(); ?></h5>
                    </div>
                    <div class="ak-bottom-buttons">
                        <a href="<?php 
                            // echo wc_get_cart_url(); 
                        ?>https://ak.carpediemqm-dev.fr/card"><?php _e( 'View Cart', 'ak-minicart' ) ?></a>
                        <a href="https://ak.carpediemqm-dev.fr/checkout/"><?php _e( 'Checkout', 'ak-minicart' ) ?></a>
                    </div>
                </div>
                <?php else: ?>
                    <div class="ak-content ak-empty">
                        <h3><?php  _e('Your cart is empty.', 'ak-minicart'); ?></h3>
                    <?php endif; ?>
            </div>
        </div>
    <?php
    $contents = ob_get_contents();
    ob_end_clean();
    return $contents;
}

/**
 * Creating shortcode for mini cart
 * @return html
 */
add_shortcode( 'ak_mini_cart', 'ak_mini_cart_fn' );
function ak_mini_cart_fn() {
    return ak_mini_cart();
}

function ak_nav_menu_items($items, $args) {
    if( $args->theme_location != 'footer-menu' ){
        $mini_cart = ak_mini_cart();
       $shop_item = '<li class="spec">'.$mini_cart.'</li>';
       $items = $items . $shop_item;
    }
    return $items;
}
add_filter('wp_nav_menu_items', 'ak_nav_menu_items', 10, 2);


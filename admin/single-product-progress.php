<?php

add_action( 'woocommerce_single_product_summary' , 'add_below_prod_gallery', 5 );

function add_below_prod_gallery() {

    global $product, $wpdb;
    
    $units_sold = $product->get_total_sales();

    $table_name = $wpdb->prefix . 'progress_discount_ahh';

    $result = $wpdb->get_results ( "
        SELECT * 
        FROM  $table_name
            WHERE id = 1
    " );

    if ( exists( $result ) ) $result = $result[0];

    $def_val_1 = 250;
    $def_val_2 = 500;
    $def_val_3 = 1000;
    if ( exists( $result ) ) {
        $def_val_1           = $result->range_1;
        $def_val_2           = $result->range_2;
        $def_val_3           = $result->range_3;
        $sold_items_manually = $result->sold_items_manually;
        $date                = $result->date;
        $range_price_1       = $result->range_1_price;
        $range_price_2       = $result->range_2_price;
        $range_price_3       = $result->range_3_price;
        $product_id          = $result->product_id;
    }

    // var_dump($product_id);
    // var_dump($product->get_data()['id']);
    // die;
    if ($product_id != $product->get_data()['id']) return;

    $units_sold = intval( $units_sold ) + intval( $sold_items_manually );

    // echo '<div class="woocommerce-product-gallery" style="background: #fdfd5a; padding: 1em 2em">';
    // echo '<span> YOU CAN ADD TEXT, IMAGES AND ANY HTML</span>';
    // echo '</div>';

    // require_once AHH_PROGRESS_PLUGIN_DIR_PATH . "progress.html";
    echo html($units_sold, $def_val_1, $def_val_2, $def_val_3, $date, $range_price_1, $range_price_2, $range_price_3);
}

function html($units_sold, $def_val_1, $def_val_2, $def_val_3, $date, $range_1_price, $range_2_price, $range_3_price) {

    $percent_val_1 = intval( $def_val_1 ) * 100 / intval( $def_val_3 );
    $percent_val_2 = intval( $def_val_2 ) * 100 / intval( $def_val_3 );
    $percent_val_3 = 100;

    $percent_units_sold = intval( $units_sold ) * 100 / intval( $def_val_3 );

    return '<section id="wc_progress_discount_html"><div class="position-relative progress-parent">
    <span class="tooltip-progress sold-items bg-warning">'.$units_sold.'</span>
    <div class="progress">
        <div class="progress-bar bg-warning" style="width: ' . $percent_units_sold . '%"></div>
    </div>
    <span class="tooltip-progress tooltip-progress-bottom t2 ' . ($units_sold >= $def_val_1 ? "bg-warning" : "") . ' ">'.$def_val_1.'</span>
    <span class="tooltip-progress tooltip-progress-bottom t3 ' . ($units_sold >= $def_val_2 ? "bg-warning" : "") . ' ">'.$def_val_2.'</span>
    <span class="tooltip-progress tooltip-progress-bottom t4 ' . ($units_sold >= $def_val_3 ? "bg-warning" : "") . ' ">'.$def_val_3.'</span>
    <span class="range-price-progress n1">' .( strlen($range_1_price) > 0 ? $range_1_price . ",000 تومان" : "" ). '</span>
    <span class="range-price-progress n2">' .( strlen($range_1_price) > 0 ? $range_1_price . ",000 تومان" : "" ). '</span>
    <span class="range-price-progress n3">' .( strlen($range_1_price) > 0 ? $range_1_price . ",000 تومان" : "" ). '</span>
</div>
<div id="wc_progress_discount_date">تاریخ ارسال: 
' . $date . '
</div>
<style type="text/css">
 .tooltip-progress.sold-items {
    left: calc( ' . $percent_units_sold . '% - 2rem );
}
.tooltip-progress.t2 {
    left: calc( ' . $percent_val_1 . '% - 2rem );
}
.tooltip-progress.t3 {
    left: calc( ' . $percent_val_2 . '% - 2rem );
}
.tooltip-progress.t4 {
    left: calc( ' . $percent_val_3 . '% - 2rem );
}
.range-price-progress.n1 {
    left: calc( ' . (0 + $percent_val_1) / 2 . '% - 3rem);
}
.range-price-progress.n2 {
    left: calc( ' . ($percent_val_1 + $percent_val_2) / 2 . '% - 3rem);
}
.range-price-progress.n3 {
    left: calc( ' . ($percent_val_2 + $percent_val_3) / 2 . '% - 3rem);
}
</style>
</section>
<script>
function docReady(fn) {
    // see if DOM is already available
    if (document.readyState === "complete" || document.readyState === "interactive") {
        // call on next available tick
        setTimeout(fn, 1);
    } else {
        document.addEventListener("DOMContentLoaded", fn);
    }
}
docReady(wc_progress_discount);
function wc_progress_discount(){
document.querySelector(".price").insertAdjacentHTML("afterend", document.querySelector("#wc_progress_discount_date").innerHTML);
document.querySelector("#wc_progress_discount_date").remove();
document.querySelector(".price").insertAdjacentHTML("beforebegin", document.querySelector("#wc_progress_discount_html").innerHTML);
document.querySelector("#wc_progress_discount_html").remove();
}
</script>';
}

// remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );

// function woocommerce_add_custom_text_after_product_title(){

//     the_title( '<h3 class="product_title entry-title">', html() .'</h3>' );

// }
// add_action( 'woocommerce_single_product_summary', 'woocommerce_add_custom_text_after_product_title', 5);
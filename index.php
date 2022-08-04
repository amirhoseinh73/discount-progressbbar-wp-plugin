<?php
/**
 *
 * Plugin Name: wc progress discount
 * Plugin URI:  https://instagram.com/amirhoseinh73
 * Description: ایجاد تخفیف روی یک محصوول خاص در رنج های فروش
 * Version:     1.0
 * Author:      Amirhosein
 * Author URI:  http://instagram.com/amirhoseinh73
 * License:     
 * License URI:
 */

define('AHH_PROGRESS_PLUGIN_FILE'       , __FILE__);
define('AHH_PROGRESS_PLUGIN_DIR_PATH'   , plugin_dir_path(__FILE__));
define('AHH_PROGRESS_PLUGIN_DIR_URL'    , plugin_dir_url(__FILE__));

define('AHH_PROGRESS_PLUGIN_JS_URL'     , AHH_PROGRESS_PLUGIN_DIR_URL . 'asset/js/');
define('AHH_PROGRESS_PLUGIN_CSS_URL'    , AHH_PROGRESS_PLUGIN_DIR_URL . 'asset/css/');

define('AHH_PROGRESS_PLUGIN_ADMIN_PATH' , AHH_PROGRESS_PLUGIN_DIR_PATH . 'admin/');
define('AHH_PROGRESS_PLUGIN_ADMIN_URL'  , AHH_PROGRESS_PLUGIN_DIR_URL . 'admin/');

require_once AHH_PROGRESS_PLUGIN_DIR_PATH . 'single-product-progress.php';

if ( is_admin() ) {
	require_once AHH_PROGRESS_PLUGIN_ADMIN_PATH . 'admin.php';
}

// require_once VIRA_PLUGIN_DIR_PATH . 'capabilities.php';

date_default_timezone_set('Asia/Tehran');

function enqueue_css_js()
{
    wp_enqueue_style( 'progress-discount-style', AHH_PROGRESS_PLUGIN_CSS_URL . 'style.css', array(), '1.5.0' );
    // wp_enqueue_style('vira-nice-select-style', VIRA_PLUGIN_CSS_URL . 'nice-select.css', array(), '1.0.0');
    // wp_enqueue_style('vira-style', VIRA_PLUGIN_CSS_URL . 'vira-2.css', array('vira-nice-select-style'), '1.0.2');
    //wp_enqueue_style('vira-select-2-style', VIRA_PLUGIN_CSS_URL . 'select2.min.css', array(), '1.0.0');

    // wp_register_script('vira-jquery-script', VIRA_PLUGIN_JS_URL . 'jquery-3.6.0.js', array(), '1.0.0', true);
    // wp_register_script('vira-nice-select-script', VIRA_PLUGIN_JS_URL . 'jquery.nice-select.js', array(), '1.0.0', true);
    //wp_register_script('vira-select-2-script', VIRA_PLUGIN_JS_URL . 'select2.min.js', array('jquery'), '1.0.0', true);
    
    //wp_enqueue_script('wp-util');
    // wp_enqueue_script('vira-jquery-script');
    //wp_enqueue_script('vira-select-2-script');

}

add_action('wp_enqueue_scripts', 'enqueue_css_js');

function exists ( $item ) {
    return ( isset ( $item ) && ! empty ( $item ) );
}

add_filter( 'woocommerce_gallery_thumbnail_size', function( $size ) {
return 'medium_large';
} );

add_filter('woocommerce_default_catalog_orderby', 'default_catalog_orderby');
function default_catalog_orderby( $sort_by ) {
	return 'date';
}

function njengah_custom_checkbox_fields( $checkout ) {

    echo '<div class="cw_custom_class"><h3>'.__('قبل از پرداخت به نکات زیر توجه کنید: ').'</h3>';

    woocommerce_form_field( 'custom_checkbox_1', array(

        'type'          => 'checkbox',

        'label'         => __('<b>نرم افزار موبوجت فعلا فقط برای گوشی های اندرویدی انتشار یافته است.</b>'),

        'required'  => true,

    ), $checkout->get_value( 'custom_checkbox_1' ));

    echo '<span>علی رغم اماده سازی اپلیکیشن ios موبوجت به علت مسایل مربوط به محدودیت های ایران از جانب اپل هنوز مراحل تست و انتشار نرم افزار ios فراهم نشده است و انتشار آن چند هفته به طول می انجامد</span></div>';

}

add_action('woocommerce_after_order_notes', 'njengah_custom_checkbox_fields');

add_action('woocommerce_checkout_process', 'njengah_custom_process_checkbox');

function njengah_custom_process_checkbox() {

global $woocommerce;

if (!$_POST['custom_checkbox_1'])

wc_add_notice( __( 'نکات قبل ار خرید را بررسی و تایید بفرمایید!' ), 'error' );

}

function njengah_custom_checkbox_fields2( $checkout ) {

    woocommerce_form_field( 'custom_checkbox_2', array(

        'type'          => 'checkbox',

        'label'         => __('<b>مدت زمان ارسال</b>'),

        'required'  => true,

    ), $checkout->get_value( 'custom_checkbox_2' ));

    echo '<span>تمام تلاش تیم هابینو این است که سفارش های شما عزیزان در اسرع وقت بدست شما برسد ولی به علت غیر قابل پیش بینی بودن تعداد و زمانبندی سفارش ها زمان ارسال چند روز دیرتر ثبت شده تا از جانب ما بدقولی صورت نگیرد لذا هنگام سفارش به زمان درج شده در صفحه فروش محصول دقت کنید</span>';

}

function njengah_custom_process_checkbox2() {

global $woocommerce;
	
if (!$_POST['custom_checkbox_2'])
	wc_add_notice( __( 'نکات قبل ار خرید را بررسی و تایید بفرمایید!' ), 'error' );
}

add_action('woocommerce_after_order_notes', 'njengah_custom_checkbox_fields2');

add_action('woocommerce_checkout_process', 'njengah_custom_process_checkbox2');

// add_action('woocommerce_checkout_update_order_meta', 'njengah_checkout_order_meta');

// function njengah_checkout_order_meta( $order_id ) {

// if ($_POST['custom_checkbox']) update_post_meta( $order_id, 'checkbox name', esc_attr($_POST['custom_checkbox']));

// }

//sms after pay

function UltraFastSendServiceSms($mobile, $data)
{
    try {
        date_default_timezone_set("Asia/Tehran");

        // your sms.ir panel configuration
        $APIKey = "6cd9a745d16c8c3a865fa745";
        $SecretKey = "asd54321ASD%#@!";

        $APIURL = "https://ws.sms.ir/";

        // message data
        $data = array(
            "ParameterArray" => array(
                array(
                    "Parameter" => "customerName",
                    "ParameterValue" => $data["customerName"]
                ),
                array(
                    "Parameter" => "orderId",
                    "ParameterValue" => $data["orderId"]
                ),
            ),
            "Mobile" => $mobile,
            "TemplateId" => "61582",
        );
        require_once "SmsIR_UltraFastSend.php";
        $SmsIR_UltraFastSend = new SmsIR_UltraFastSend($APIKey, $SecretKey, $APIURL);
        $UltraFastSend = $SmsIR_UltraFastSend->ultraFastSend($data);

        var_dump($UltraFastSend);

    } catch (Exeption $e) {
        echo 'Error UltraFastSend : ' . $e->getMessage();
    }
}

// add_action('woocommerce_payment_complete', 'custom_update_order_meta', 20, 1 );
// function custom_update_order_meta( $order_id ) {

//      $order      = wc_get_order( $order_id );
//      $items      = $order->get_items();
//      $customer   = $order->get_user();

     
//      $price          = $order->get_total();
//      $original_price = $order->get_subtotal();

//      var_dump($customer);
// }

add_action( 'woocommerce_thankyou', 'woocommerce_redirect_after_checkout');
function woocommerce_redirect_after_checkout( $order_id ){
 
    $order      = wc_get_order( $order_id );
     $items      = $order->get_items();
     $customer   = $order->get_user();

     
     $price          = $order->get_total();
     $original_price = $order->get_subtotal();

    // Get the Customer billing email
    $billing_email  = $order->get_billing_email();

    // Get the Customer billing phone
     $billing_phone  = $order->get_billing_phone();
    $shipping_first_name = $order->get_shipping_first_name();
    $shipping_last_name  = $order->get_shipping_last_name();
    $shipping_company    = $order->get_shipping_company();
    $shipping_address_1  = $order->get_shipping_address_1();
    $shipping_address_2  = $order->get_shipping_address_2();
    $shipping_city       = $order->get_shipping_city();
    $shipping_state      = $order->get_shipping_state();
    $shipping_postcode   = $order->get_shipping_postcode();
    $shipping_country    = $order->get_shipping_country();

    if ( ! exists( $billing_phone )) return;

    $data = array();
    $data["customerName"] = $shipping_first_name . " " . $shipping_last_name;
    if ( ! exists( $shipping_first_name ) && ! exists( $shipping_last_name ) ) {

        $billing_first_name = $order->get_billing_first_name();
        $billing_last_name  = $order->get_billing_last_name();

        $data["customerName"] = $billing_first_name . " " . $billing_last_name;

        if ( ! exists( $billing_first_name ) && ! exists( $billing_last_name ) ) {
            $data["customerName"] = "مشتری";
        }
    }

    $data["orderId"] = $order_id;

    UltraFastSendServiceSms($billing_phone, $data);

    // $order_id = array_values($items)[0]->get_data()["order_id"];
    //[0]->get_data()["order_id"]
    // $billing_first_name = $order->get_billing_first_name();
    // $billing_last_name  = $order->get_billing_last_name();
    // $billing_company    = $order->get_billing_company();
    // $billing_address_1  = $order->get_billing_address_1();
    // $billing_address_2  = $order->get_billing_address_2();
    // $billing_city       = $order->get_billing_city();
    // $billing_state      = $order->get_billing_state();
    // $billing_postcode   = $order->get_billing_postcode();
    // $billing_country    = $order->get_billing_country();
}
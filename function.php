<?php //do not include this line
add_filter( 'woocommerce_available_payment_gateways', 'o354_payment_gateway_disable_country' );
function o354_payment_gateway_disable_country( $available_gateways ) {
    if ( is_admin() ) return $available_gateways;
	$afr_shipping = array(
		//Lista 99MIN para los tipos de envios para Pagos con Tarjeta No borrar a menos que sea necesario.
		0 => 'advanced_flat_rate_shipping:7463', //Recibelo Hoy
		1 => 'advanced_flat_rate_shipping:7462', //Recibelo Mañana
		2 => 'advanced_flat_rate_shipping:7729', //Recibelo Lunes (VIE)
		3 => 'advanced_flat_rate_shipping:7527', //Recibelo Lunes (SAB)
		4 => 'advanced_flat_rate_shipping:7528', //Recibelo Martes (SAB)
		5 => 'advanced_flat_rate_shipping:7731', //Recibelo Martes (DOM)
		6 => 'advanced_flat_rate_shipping:7730', //Recibelo Martes (LUN)
		7 => 'advanced_flat_rate_shipping:7529', //Recibelo Miercoles (LUN)
		8 => 'advanced_flat_rate_shipping:7732', //Recibelo Miercoles (MAR)
		9 => 'advanced_flat_rate_shipping:7530', //Recibelo Jueves (MAR)
		10 => 'advanced_flat_rate_shipping:7733', //Recibelo Jueves (MIE)
		11 => 'advanced_flat_rate_shipping:7531', //Recibelo Viernes (MIE)
		12 => 'advanced_flat_rate_shipping:7734', //Recibelo Viernes (JUE)
		13 => 'advanced_flat_rate_shipping:7532', //Recibelo Sabado (JUE)
		14 => 'advanced_flat_rate_shipping:7735', //Recibelo Sabado (VIE)
		15 => 'advanced_flat_rate_shipping:7792' //VENTAS
	);
    $chosen_methods = WC()->session->get( 'chosen_shipping_methods' );
    $chosen_shipping = $chosen_methods[0];
	//Entonces si customer->get_billing_state no es igual a LMA o CAL (Lima o Callao) 
	//Quita el pago en efectivo y deja solo el pago con tarjeta
    if ( WC()->customer->get_billing_state() != 'LMA' && WC()->customer->get_billing_state() != 'CAL' && WC()->customer->get_billing_city() != $afr_shipping[15]) {
			unset( $available_gateways['cod'] );
			unset( $available_gateways['bacs'] );
	//Entonces si $chosen_shipping es = a SD -> ND -> afr_shipping = pago con tarjeta
    } else if ( $chosen_shipping == 'SD' || $chosen_shipping == 'ND' || $chosen_shipping == $afr_shipping[0] || $chosen_shipping == $afr_shipping[1] || $chosen_shipping == $afr_shipping[2] || $chosen_shipping == $afr_shipping[3] || $chosen_shipping == $afr_shipping[4] || $chosen_shipping == $afr_shipping[5] || $chosen_shipping == $afr_shipping[6] || $chosen_shipping == $afr_shipping[7] || $chosen_shipping == $afr_shipping[8] || $chosen_shipping == $afr_shipping[9] || $chosen_shipping == $afr_shipping[10] || $chosen_shipping == $afr_shipping[11] || $chosen_shipping == $afr_shipping[12] || $chosen_shipping == $afr_shipping[13] || $chosen_shipping == $afr_shipping[14]) {
			unset( $available_gateways['cod'] );
			unset( $available_gateways['bacs'] );
    /*}else if ($user_id == 82){
		unset( $available_gateways['bacs'] );*/
	}
    return $available_gateways;
}

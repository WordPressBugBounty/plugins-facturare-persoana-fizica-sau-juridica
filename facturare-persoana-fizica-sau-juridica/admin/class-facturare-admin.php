<?php

use Automattic\WooCommerce\Internal\DataStores\Orders\CustomOrdersTableController;

class Woo_Facturare_Admin {

	private $fields   = array() ;
	private $defaults = array() ;

	public function __construct() {
		$this->defaults = array(
			'facturare_pers_fiz_label'                  => esc_html__( 'Persoana Fizica', 'woo-facturare' ),
			'facturare_pers_fiz_cnp_label'              => esc_html__( 'CNP', 'woo-facturare' ),
			'facturare_pers_fiz_cnp_placeholder'        => esc_html__( 'Introduceti Codul numeric personal', 'woo-facturare' ),
			'facturare_pers_fiz_cnp_vizibility'         => 'no',
			'facturare_pers_fiz_cnp_required'           => 'no',
			'facturare_pers_fiz_cnp_error'              => esc_html__( 'Datorita legislatiei in vigoare trebuie sa completati campul CNP', 'woo-facturare' ),
			'facturare_pers_jur_label'                  => esc_html__( 'Persoana Juridica', 'woo-facturare' ),
			'facturare_pers_jur_company_label'          => esc_html__( 'Nume Firma', 'woo-facturare' ),
			'facturare_pers_jur_company_placeholder'    => esc_html__( 'Introduceti numele firmei dumneavoastra', 'woo-facturare' ),
			'facturare_pers_jur_company_vizibility'     => 'yes',
			'facturare_pers_jur_company_required'       => 'yes',
			'facturare_pers_jur_company_error'          => esc_html__( 'Pentru a va putea emite factura avem nevoie de numele firmei dumneavoastra', 'woo-facturare' ),
			'facturare_pers_jur_cui_label'              => esc_html__( 'CUI', 'woo-facturare' ),
			'facturare_pers_jur_cui_placeholder'        => esc_html__( 'Introduceti Codul Unic de Inregistrare', 'woo-facturare' ),
			'facturare_pers_jur_cui_vizibility'         => 'yes',
			'facturare_pers_jur_cui_required'           => 'yes',
			'facturare_pers_jur_cui_error'              => esc_html__( 'Pentru a va putea emite factura avem nevoie de CUI-ul firmei dumneavoastra', 'woo-facturare' ),
			'facturare_pers_jur_nr_reg_com_label'       => esc_html__( 'Nr. Reg. Com', 'woo-facturare' ),
			'facturare_pers_jur_nr_reg_com_placeholder' => 'J20/20/20.02.2020',
			'facturare_pers_jur_nr_reg_com_vizibility'  => 'yes',
			'facturare_pers_jur_nr_reg_com_required'    => 'yes',
			'facturare_pers_jur_nr_reg_com_error'       => esc_html__( 'Pentru a va putea emite factura avem nevoie de numarul de ordine in registrul comertului', 'woo-facturare' ),
			'facturare_pers_jur_nume_banca_label'       => esc_html__( 'Nume Banca', 'woo-facturare' ),
			'facturare_pers_jur_nume_banca_placeholder' => esc_html__( 'Numele bancii cu care lucrati', 'woo-facturare' ),
			'facturare_pers_jur_nume_banca_vizibility'  => 'no',
			'facturare_pers_jur_nume_banca_required'    => 'no',
			'facturare_pers_jur_nume_banca_error'       => esc_html__( 'Pentru a va putea emite factura avem nevoie de numele bancii cu care lucrati', 'woo-facturare' ),
			'facturare_pers_jur_iban_label'             => esc_html__( 'IBAN', 'woo-facturare' ),
			'facturare_pers_jur_iban_placeholder'       => esc_html__( 'Numarul contului IBAN', 'woo-facturare' ),
			'facturare_pers_jur_iban_vizibility'        => 'no',
			'facturare_pers_jur_iban_required'          => 'no',
			'facturare_pers_jur_iban_error'             => esc_html__( 'Pentru a va putea emite factura avem nevoie de numarul contului', 'woo-facturare' ),
			'facturare_output'                          => 'select',
			'facturare_default'                         => 'pers-fiz',
			'facturare_label'                           => esc_html__( 'Tip Facturare', 'woo-facturare' ),
			'reclame'									=> 'no',
		);
	}

	public function init(){
		new GC_Facturare_Review();
	}

	public function setting_page_class( $settings ) {
		$settings[] = include 'class-wc-settings-facturare.php';
		return $settings;
	}

	public function register_wc_admin_tabs( $tabs_with_sections ){
		$tabs_with_sections['facturare'] = array( '', 'pers-fiz', 'pers-jur' );
		return $tabs_with_sections;
	}

	public function wc_admin_connect_page(){

		if ( ! function_exists( 'wc_admin_connect_page' ) ) {
			return;
		}

		$admin_page_base    = 'admin.php';

		wc_admin_connect_page(
			array(
				'id'        => 'woocommerce-settings-facturare',
				'parent'    => 'woocommerce-settings',
				'screen_id' => 'woocommerce_page_wc-settings-facturare',
				'title'     => array(
					__( 'Facturare', 'woo-facturare' ),
					__( 'General', 'woo-facturare' ),
				),
				'path'      => add_query_arg(
					array(
						'page' => 'wc-settings',
						'tab'  => 'facturare',
					),
					$admin_page_base
				),
			)
		);

		wc_admin_connect_page(
			array(
				'id'        => 'woocommerce-settings-facturare-pers-fiz',
				'parent'    => 'woocommerce-settings-facturare',
				'screen_id' => 'woocommerce_page_wc-settings-facturare-pers-fiz',
				'title'     => __( 'Persoana Fizica', 'woo-facturare' ),
			)
		);

		wc_admin_connect_page(
			array(
				'id'        => 'woocommerce-settings-facturare-pers-jur',
				'parent'    => 'woocommerce-settings-facturare',
				'screen_id' => 'woocommerce_page_wc-settings-facturare-pers-jur',
				'title'     => __( 'Persoana Juridica', 'woo-facturare' ),
			)
		);

	}

	/**
	 * Update the order meta with extra fields
	*/
	public function update_order_meta( $order_id ) {
		$av_settings = array();

		if ( ! isset( $_POST['tip_facturare'] ) ) {
			return;
		}

		$av_settings['tip_facturare'] = sanitize_text_field($_POST['tip_facturare']);

		if ( 'pers-fiz' == $_POST['tip_facturare'] ) {
			
			if ( isset( $_POST['cnp'] ) ) {
				$av_settings['cnp'] = sanitize_text_field($_POST['cnp']);

				if ( '' == $av_settings['cnp'] ) {
					$av_settings['cnp'] = '0000000000000';
				}

			}

		}elseif ( 'pers-jur' == $_POST['tip_facturare'] ) {
			
			if ( isset( $_POST['cui'] ) && '' != $_POST['cui'] ) {
				$av_settings['cui'] = sanitize_text_field($_POST['cui']);
			}

			if ( isset( $_POST['nr_reg_com'] ) && '' != $_POST['nr_reg_com'] ) {
				$av_settings['nr_reg_com'] = sanitize_text_field($_POST['nr_reg_com']);
			}

			if ( isset( $_POST['nume_banca'] ) && '' != $_POST['nume_banca'] ) {
				$av_settings['nume_banca'] = sanitize_text_field($_POST['nume_banca']);
			}

			if ( isset( $_POST['iban'] ) && '' != $_POST['iban'] ) {
				$av_settings['iban'] = sanitize_text_field($_POST['iban']);
			}

		}

		if ( ! empty( $av_settings ) ) {
			$order = wc_get_order( $order_id );
			$order->update_meta_data( 'av_facturare', $av_settings );
			$order->save();
		}

	}

	/**
	 * Update the customer meta with extra fields
	*/
	public function update_customer_data( $customer_id, $data ) {
		$av_settings = array();

		if ( ! isset( $data['tip_facturare'] ) ) {
			return;
		}

		$av_settings['tip_facturare'] = $data['tip_facturare'];

		if ( 'pers-fiz' == $data['tip_facturare'] ) {
			
			if ( isset( $_POST['cnp'] ) ) {
				$av_settings['cnp'] = sanitize_text_field($_POST['cnp']);

				if ( '' == $av_settings['cnp'] ) {
					$av_settings['cnp'] = '0000000000000';
				}

			}

		}elseif ( 'pers-jur' == $data['tip_facturare'] ) {
			
			if ( isset( $data['cui'] ) && '' != $data['cui'] ) {
				$av_settings['cui'] = sanitize_text_field($data['cui']);
			}

			if ( isset( $data['nr_reg_com'] ) && '' != $data['nr_reg_com'] ) {
				$av_settings['nr_reg_com'] = sanitize_text_field($data['nr_reg_com']);
			}

			if ( isset( $data['nume_banca'] ) && '' != $data['nume_banca'] ) {
				$av_settings['nume_banca'] = sanitize_text_field($data['nume_banca']);
			}

			if ( isset( $data['iban'] ) && '' != $data['iban'] ) {
				$av_settings['iban'] = sanitize_text_field($data['iban']);
			}

		}

		if ( ! empty( $av_settings ) ) {
			foreach ( $av_settings as $key => $value ) {
				update_user_meta( $customer_id, $key, sanitize_text_field( $value ) );
			}
		}

	}

	/**
	 * Filter billing fields.
	*/
	public function filter_billing_fields( $fields, $order ){

		$defaults = array(
			'cnp'        => '',
			'cui'        => '',
			'nr_reg_com' => '',
			'nume_banca' => '',
			'iban'       => '',
		);

		$facturare = $order->get_meta( 'av_facturare' );
		$tip = isset($facturare['tip_facturare']) ? $facturare['tip_facturare'] : '';
		if ( isset( $facturare['tip_facturare'] ) ) {
			unset( $facturare['tip_facturare'] );
		}

		if ( 'pers-fiz' == $tip && isset( $fields['company'] ) ) {
			$fields['company'] = '';
		}

		$extra_fields = wp_parse_args( $facturare, $defaults );

		return array_merge( $fields, $extra_fields );

	}

	public function myacc_filter_billing_fields( $fields, $customer_id, $address_type ) {

		if ( 'billing' != $address_type ) {
			return $fields;
		}

		$fields['cnp']        = get_user_meta( $customer_id, 'cnp', true );
		$fields['cui']        = get_user_meta( $customer_id, 'cui', true );
		$fields['nr_reg_com'] = get_user_meta( $customer_id, 'nr_reg_com', true );
		$fields['nume_banca'] = get_user_meta( $customer_id, 'nume_banca', true );
		$fields['iban']       = get_user_meta( $customer_id, 'iban', true );

		return $fields;

	}

	/**
	 * Add replacements for our extra fields.
	*/
	public function extra_fields_replacements( $replacements, $args ) {

		$replacements['{cnp}']        = isset( $args['cnp'] ) ? $args['cnp'] : '';
		$replacements['{cui}']        = isset( $args['cui'] ) ? $args['cui'] : '';
		$replacements['{nr_reg_com}'] = isset( $args['nr_reg_com'] ) ? $args['nr_reg_com'] : '';
		$replacements['{nume_banca}'] = isset( $args['nume_banca'] ) ? $args['nume_banca'] : '';
		$replacements['{iban}']       = isset( $args['iban'] ) ? $args['iban'] : '';

		return $replacements;

	}

	public function localisation_address_formats( $formats ) {
		$formats['default'] = "{name}\n{cnp}\n{company}\n{cui}\n{nr_reg_com}\n{nume_banca}\n{iban}\n{address_1}\n{address_2}\n{city}\n{state}\n{postcode}\n{country}";

		return $formats;
	}

	public function action_links( $links, $file ){

		if ( 'woo-facturare/facturare.php' == $file ) {
			$links[] = '<a href="' . admin_url( 'admin.php?page=wc-settings&tab=facturare&section' ) . '">' . esc_html__( 'Setari', 'woo-facturare' ) . '</a>';
		}

		return $links;
	}

	public function settings_links( $links ){

		if ( is_array( $links ) ) {
            $links['facturare-settings'] = sprintf('<a href="%s">%s</a>', admin_url( 'admin.php?page=wc-settings&tab=facturare' ), __( 'Settings', 'woo-facturare' ) );
        }

		return $links;

	}

	public function start_advertise(){
		echo '<style>';
		echo '.woofacturare-feedback-box {width: 50%;background: #fff;padding: 10px;box-sizing: border-box;border: 1px solid #ddd;margin-right: 10px;}';
		echo '.woofacturare-contact-box {width: 30%;background: #fff;padding: 10px;box-sizing: border-box;border: 1px solid #ddd;}';
		echo '.woofacturare-advertise{display:flex;padding: 20px 20px 0;}';
		echo '</style>';
		echo '<div class="woofacturare-advertise">';
	}

	public function stop_advertise(){
		echo '</div>';
	}

	public function feedback_box(){

		$tab = isset( $_GET['tab'] ) ? $_GET['tab'] : '';

		if ( 'facturare' != $tab ) {
			return;
		}

		include WOOFACTURARE_PATH . 'admin/views/feedback-box.php';

	}

	public function contact_box(){

		$tab = isset( $_GET['tab'] ) ? $_GET['tab'] : '';

		if ( 'facturare' != $tab ) {
			return;
		}

		include WOOFACTURARE_PATH . 'admin/views/contact-box.php';

	}

	public function pdf_macros( $macros, $orderData ){

		$facturare = $orderData->get_meta( 'av_facturare' );

		$macros['{{cnp}}']        = isset( $facturare['cnp'] ) ? $facturare['cnp'] : '';
		$macros['{{cui}}']        = isset( $facturare['cui'] ) ? $facturare['cui'] : '';
		$macros['{{nr_reg_com}}'] = isset( $facturare['nr_reg_com'] ) ? $facturare['nr_reg_com'] : '';
		$macros['{{nume_banca}}'] = isset( $facturare['nume_banca'] ) ? $facturare['nume_banca'] : '';
		$macros['{{iban}}']       = isset( $facturare['iban'] ) ? $facturare['iban'] : '';

		return $macros;

	}

	public function admin_billing_fields( $fields ){
		$options = get_option( 'av_facturare', array() );
		$options = wp_parse_args( $options, $this->defaults );

		$new_fields = array(
				'tip_facturare' => array(
				'label'   		=> __( 'Tip facturare', 'woocommerce' ),
				'show'    		=> false,
				'type'    		=> 'select',
				'wrapper_class' => 'form-field-wide',
				'options'       => array(
					'pers-fiz' => esc_html__( 'Persoana Fizica', 'woo-facturare' ),
	            	'pers-jur' => esc_html__( 'Persoana Juridica', 'woo-facturare' )
	            ),
			)
		);
		foreach ( $fields as $key => $field ) {

			$new_fields[ $key ] = $field;
			if ( 'company' == $key ) {

				if ( isset( $options['facturare_pers_fiz_cnp_vizibility'] ) && 'yes' == $options['facturare_pers_fiz_cnp_vizibility'] ) {
					$new_fields['cnp'] = array(
						'label'			=> $options['facturare_pers_fiz_cnp_label'],
						'wrapper_class' => 'form-field-wide av_facturare_field show_if_pers-fiz',
						'show'			=> false,
					);
				}

				if ( isset( $options['facturare_pers_jur_cui_vizibility'] ) && 'yes' == $options['facturare_pers_jur_cui_vizibility'] ) {
					$new_fields['cui'] = array(
						'label'	=> $options['facturare_pers_jur_cui_label'],
						'wrapper_class' => 'av_facturare_field show_if_pers-jur',
						'show'	=> false,
					);
				}

				if ( isset( $options['facturare_pers_jur_nr_reg_com_vizibility'] ) && 'yes' == $options['facturare_pers_jur_nr_reg_com_vizibility'] ) {
					$new_fields['nr_reg_com'] = array(
						'label'			=> $options['facturare_pers_jur_nr_reg_com_label'],
						'wrapper_class' => 'last av_facturare_field show_if_pers-jur',
						'show'			=> false,
					);
				}

				if ( isset( $options['facturare_pers_jur_nume_banca_vizibility'] ) && 'yes' == $options['facturare_pers_jur_nume_banca_vizibility'] ) {
					$new_fields['nume_banca'] = array(
						'label'	=> $options['facturare_pers_jur_nume_banca_label'],
						'wrapper_class' => 'av_facturare_field show_if_pers-jur',
						'show'	=> false,
					);
				}

				if ( isset( $options['facturare_pers_jur_iban_vizibility'] ) && 'yes' == $options['facturare_pers_jur_iban_vizibility'] ) {
					$new_fields['iban'] = array(
						'label'			=> $options['facturare_pers_jur_iban_label'],
						'wrapper_class' => 'last av_facturare_field show_if_pers-jur',
						'show'			=> false,
					);
				}
			}
		}

		return $new_fields;
	}

	public function admin_billing_get_tip_facturare( $value, $object ){
		$options_helper = Facturare_Options_Helper::get_instance();
		$value = $options_helper->get_tip( $object->get_id() );
		return $value;
	}

	public function admin_billing_get_cnp( $value, $object ){
		$options_helper = Facturare_Options_Helper::get_instance();
		$value = $options_helper->get_cnp( $object->get_id() );
		return $value;
	}

	public function admin_billing_get_cui( $value, $object ){
		$options_helper = Facturare_Options_Helper::get_instance();
		$value = $options_helper->get_cui( $object->get_id() );
		return $value;
	}

	public function admin_billing_get_nume_banca( $value, $object ){
		$options_helper = Facturare_Options_Helper::get_instance();
		$value = $options_helper->get_nume_banca( $object->get_id() );
		return $value;
	}

	public function admin_billing_get_nr_reg_com( $value, $object ){
		$options_helper = Facturare_Options_Helper::get_instance();
		$value = $options_helper->get_nr_reg_com( $object->get_id() );
		return $value;
	}

	public function admin_billing_get_iban( $value, $object ){
		$options_helper = Facturare_Options_Helper::get_instance();
		$value = $options_helper->get_iban( $object->get_id() );
		return $value;
	}

	public function save_admin_billing_fields( $order_id, $order ){

		$av_settings = array();

		if ( ! isset( $_POST[ '_billing_tip_facturare' ] ) ) {
			return;
		}

		$av_settings['tip_facturare'] = sanitize_text_field( $_POST['_billing_tip_facturare'] );
		unset( $_POST['_billing_tip_facturare'] );

		if ( 'pers-fiz' == $av_settings['tip_facturare'] ) {
			if ( isset( $_POST['_billing_cnp'] ) && '' != $_POST['_billing_cnp'] ) {
				$av_settings['cnp'] = sanitize_text_field( $_POST['_billing_cnp'] );
				unset( $_POST['_billing_cnp'] );
			}
		}elseif ( 'pers-jur' == $av_settings['tip_facturare'] ) {

			$fields = array( '_billing_cui', '_billing_nr_reg_com', '_billing_iban', '_billing_nume_banca' );
			foreach ( $fields as $field_key ) {
				$av_key = str_replace( '_billing_', '', $field_key );
				if ( isset( $_POST[ $field_key ] ) ) {
					$av_settings[ $av_key ] = sanitize_text_field( $_POST[ $field_key ] );
					unset( $_POST[ $field_key ] );
				}
			}

		}

		$order = wc_get_order( $order_id );
		$order->update_meta_data( 'av_facturare', $av_settings );
		$order->save();
		// update_post_meta( $order_id, 'av_facturare', $av_settings );

	}

	public function admin_enqueue_scripts( $hook ){
		$screen = class_exists( '\Automattic\WooCommerce\Internal\DataStores\Orders\CustomOrdersTableController' ) && wc_get_container()->get( CustomOrdersTableController::class )->custom_orders_table_usage_is_enabled()
		? wc_get_page_screen_id( 'shop-order' )
		: 'shop_order';

		if ( ! in_array( $screen, array( 'shop_order', 'woocommerce_page_wc-orders' ) ) ) {
			return;
		}

		wp_enqueue_script( 'woo-facturare', WOOFACTURARE_ASSETS . 'js/admin.js', array( 'jquery' ), WOOFACTURARE_VERSION );
	}

	// Order metabox
	public function order_metabox() {
		$options = get_option( 'av_facturare', array() );
		$options = wp_parse_args( $options, $this->defaults );

		if ( isset( $options['reclame'] ) && 'yes' == $options['reclame'] ) {
			return;
		}

		$screen = class_exists( '\Automattic\WooCommerce\Internal\DataStores\Orders\CustomOrdersTableController' ) && wc_get_container()->get( CustomOrdersTableController::class )->custom_orders_table_usage_is_enabled()
		? wc_get_page_screen_id( 'shop-order' )
		: 'shop_order';

		add_meta_box( 'woo_smartbill_upsell', 'SmartBill', array(
			$this,
			'display_order_metabox',
		), $screen, 'side', 'high' );
	}

	public function display_order_metabox( $post ){
		?>
		<div style="background:#f8dda7;padding:10px;">
		<h4 style="margin-top:0;">Automatizează magazinul online cu WooCommerce SmartBill</h4>
		<ul>
			<li style="margin-bottom:10px;"><span class="dashicons dashicons-saved" style="color:green;margin-right: 5px;"></span>Generare automată a facturilor.</li>
			<li style="margin-bottom:10px;"><span class="dashicons dashicons-saved" style="color:green;margin-right: 5px;"></span>Incasarea automată a facturilor.</li>
			<li style="margin-bottom:10px;"><span class="dashicons dashicons-saved" style="color:green;margin-right: 5px;"></span>Gestiune.</li>
			<li style="margin-bottom:10px;"><span class="dashicons dashicons-saved" style="color:green;margin-right: 5px;"></span>Generare automată a proformelor.</li>
			<li style="margin-bottom:10px;"><span class="dashicons dashicons-saved" style="color:green;margin-right: 5px;"></span>Adaugarea documentelor in email-uri.</li>
		</ul>

		<a href="https://avianstudio.com/plugin/woocommerce-smartbill?utm_source=upsell&utm_medium=wporg&utm_campaign=ordermetabox" target="_blank" class="button button-primary button-hero" style="display:block;text-align:center">Află mai multe</a>

		<p style="font-size:10px;color:#777;text-align:center;">Ascunde această reclamă <a target="_blank" href="<?php echo esc_url( admin_url('admin.php?page=wc-settings&tab=facturare') ) ?>">aici</a></p>
		</div>
		<?php
	}

	public function show_woopro_notice(){

		if ( 'dismiss' == get_option( 'woofacturareproupsell' ) ) {
			return;
		}

		?>
		<div id="woo-facturare-pro-upsell" class="notice notice-success woocommerce-message" style="margin-top:30px;">
			<a class="woocommerce-message-close notice-dismiss woofacturarprobutton" href="#">Dismiss</a>
			<p style="font-size:15px">Salut 👋,</p>
			<p style="font-size:15px">Sunt George, autorul pluginul de Facturare și vreau să te anunț că am lansat <a href="https://avianstudio.com/plugin/woocommerce-facturare-pro/?utm_source=woofacturareupsell&utm_medium=link&utm_campaign=upsell" target="_blank"><strong>WooCommerce Facturare PRO</strong></a>, cu următoarele funcționalități:</p>
			<ol>
				<li><strong>Taxe diferite pentru persoane fizice și juridice.</strong> Prin această funcționalitate, poți stabili o taxă pentru persoanele fizice și o altă taxă pentru persoanele juridice. Prețurile din magazin se vor actualiza automat în funcție de tipul de client, bazat pe informațiile furnizate de utilizator.</li>
				<li><strong>Afișare prețuri cu și fără TVA.</strong> Poți permite clienților tăi să vizualizeze prețurile atât cu TVA, cât și fără. Nu mai este necesar să folosești coduri preluate de pe internet pentru a afișa prețurile în ambele moduri.</li>
				<li><strong>Vinde doar B2B.</strong> Acum poți limita vânzările doar către persoane juridice, iar pe pagina de finalizare a comenzii vor apărea doar informațiile necesare acestui tip de client.</li>
				<li><strong>Campuri inregistrare.</strong> Acum, câmpurile din pluginul de facturare sunt disponibile și pe pagina de înregistrare. Astfel, clienții se pot înregistra selectând opțiunea corespunzătoare pentru persoane fizice sau juridice.</li>
			</ol>
			<p class="actions">
				<a id="woo-facturare-rate" href="https://avianstudio.com/plugin/woocommerce-facturare-pro/?utm_source=woofacturareupsell&utm_medium=button&utm_campaign=upsell" target="_blank" class="button button-primary woofacturarprobutton">Află mai mult.</a>
				<a id="woo-facturare-no-rate" href="#" style="margin-left:10px" class="woofacturarprobutton">Nu mă interesează.</a>
			</p>
		</div>
		<?php

	}

	public function dismiss_woopro_notice(){

		check_ajax_referer( 'woo-facturare-pro-upsell', 'security' );
		update_option( 'woofacturareproupsell', 'dismiss' );

	}

	public function enqueue() {
		wp_enqueue_script( 'jquery' );
	}

	public function ajax_script() {

		$ajax_nonce = wp_create_nonce( "woo-facturare-pro-upsell" );

		?>

		<script type="text/javascript">
			jQuery( document ).ready( function( $ ){

				$( '#woo-facturare-pro-upsell .woofacturarprobutton' ).click( function( evt ){
					var href = $(this).attr('href');

					if ( '#' == href ) { evt.preventDefault(); }

					var data = {
						action: 'woofacturarepro',
						security: '<?php echo $ajax_nonce; ?>',
					};

					$.post( '<?php echo admin_url( 'admin-ajax.php' ) ?>', data, function( response ) {
						$( '#woo-facturare-pro-upsell' ).slideUp( 'fast', function() {
							$( this ).remove();
						} );
					});

				} );

			});
		</script>

		<?php
	}

	public function add_facturare_data( $data, $customer, $user_id ){

		if ( isset( $data['billing'] ) ) {
			$tip_facturare = get_user_meta( $user_id, 'tip_facturare', true );
			$cnp = get_user_meta( $user_id, 'cnp', true );
			$cui = get_user_meta( $user_id, 'cui', true );
			$nume_banca = get_user_meta( $user_id, 'nume_banca', true );
			$iban = get_user_meta( $user_id, 'iban', true );

			$data['billing']['tip_facturare'] = $tip_facturare ? $tip_facturare : 'pers-fiz';
			$data['billing']['cnp'] = $cnp ? $cnp : '-';
			$data['billing']['cui'] = $cui ? $cui : '-';
			$data['billing']['nume_banca'] = $nume_banca ? $nume_banca : '-';
		}

		return $data;

	}

}

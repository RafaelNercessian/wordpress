<?php

add_theme_support( 'post-thumbnails' );

function register_houses() {
	$description = 'List houses of Malura';
	$singular = 'House';
	$plural = 'Houses';

	$labels = array(
		'name' => $plural,
		'singular_name' => $singular,
		'view_item' => 'See ' . $singular,
		'edit_item' => 'Edit ' . $singular,
		'new_item' => 'New ' . $singular,
		'add_new_item' => 'Add new ' . $singular
	);

	$supports = array(
		'title',
		'editor',
		'thumbnail'
	);

	$args = array(
		'labels' => $labels,
		'description' => $description,
		'public' => true,
		'menu_icon' => 'dashicons-admin-home',
		'supports' => $supports
	);


	register_post_type( 'house', $args);
}

add_action('init', 'register_houses');

/* Registrando menu de navegação */

function registering_nav_menu() {
	register_nav_menu('header-menu', 'Menu Header');
}

add_action( 'init', 'registering_nav_menu');

function get_titulo() {
	if( is_home() ) {
		bloginfo('name');
	} else {
		bloginfo('name');
		echo ' | ';
		the_title();
	}
}

/* Criando a taxonomia de localização */

function criando_taxonomia_localizacao() {
	$singular = 'Location';
	$plural = 'Locations';

	$labels = array(
		'name' => $plural,
		'singular_name' => $singular,
		'view_item' => 'See ' . $singular,
		'edit_item' => 'Edit ' . $singular,
		'new_item' => 'New ' . $singular,
		'add_new_item' => 'Add new ' . $singular
		);

	$args = array(
		'labels' => $labels,
		'public' => true,
		'hierarchical' => true
		);

	register_taxonomy('location', 'house', $args);
}

add_action( 'init' , 'criando_taxonomia_localizacao' );

function is_selected_taxonomy($taxonomy, $search) {
	if($taxonomy->slug === $search) {
		echo 'selected';
	}
}

function adicionar_meta_info_imovel() {
	add_meta_box(
		'informacoes_imovel',
		'Informações',
		'informacoes_imovel_view',
		'house',
		'normal',
		'high'
	);
}

add_action('add_meta_boxes', 'adicionar_meta_info_imovel');

function informacoes_imovel_view( $post ) {
	$imoveis_meta_data = get_post_meta( $post->ID ); ?>

	<style>
		.maluras-metabox {
			display: flex;
			justify-content: space-between;
		}

		.maluras-metabox-item {
			flex-basis: 30%;

		}

		.maluras-metabox-item label {
			font-weight: 700;
			display: block;
			margin: .5rem 0;

		}

		.input-addon-wrapper {
			height: 30px;
			display: flex;
			align-items: center;
		}

		.input-addon {
			display: block;
			border: 1px solid #CCC;
			border-bottom-left-radius: 5px;
			border-top-left-radius: 5px;
			height: 100%;
			width: 30px;
			text-align: center;
			line-height: 30px;
			box-sizing: border-box;
			background-color: #888;
			color: #FFF;
		}

		.maluras-metabox-input {
			height: 100%;
			border: 1px solid #CCC;
			border-left: none;
			margin: 0;
		}

	</style>
	<div class="maluras-metabox">
		<div class="maluras-metabox-item">
			<label for="maluras-preco-input">Price:</label>
			<div class="input-addon-wrapper">
				<span class="input-addon">NZD</span>
				<input id="maluras-preco-input" class="maluras-metabox-input" type="text" name="price_id"
				value="<?= number_format($imoveis_meta_data['price_id'][0], 2, ',', '.'); ?>">
			</div>
		</div>

		<div class="maluras-metabox-item">
			<label for="maluras-quartos-input">Rooms:</label>
			<input id="maluras-quartos-input" class="maluras-metabox-input" type="number" name="rooms_id"
			value="<?= $imoveis_meta_data['rooms_id'][0]; ?>">
		</div>

		<div class="maluras-metabox-item">
			<label for="maluras-banheiros-input">Toilets:</label>
			<input id="maluras-banheiros-input" class="maluras-metabox-input" type="number" name="toilets_id"
			value="<?= $imoveis_meta_data['toilets_id'][0]; ?>">
		</div>



	</div>
<?php

}

function salvar_meta_info_imoveis( $post_id ) {
	if( isset($_POST['price_id']) ) {
		update_post_meta( $post_id, 'price_id', sanitize_text_field( $_POST['price_id'] ) );
	}

	if( isset($_POST['toilets_id']) ) {
		update_post_meta( $post_id, 'toilets_id', sanitize_text_field( $_POST['toilets_id'] ) );
	}
	if( isset($_POST['rooms_id']) ) {
		update_post_meta( $post_id, 'rooms_id', sanitize_text_field( $_POST['rooms_id'] ) );
	}
}

add_action('save_post', 'salvar_meta_info_imoveis');

function enviar_e_checar_email($nome, $email, $mensagem) {
		return wp_mail( 'rafanercessian@gmail.com', 'Email Malura', 'Name: ' . $nome . "\n" . $mensagem  );
}

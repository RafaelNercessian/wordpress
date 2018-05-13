<?php
$css_escolhido = 'page';
require_once('header.php');

$nome = $_POST['form-nome'];
$email = $_POST['form-email'];
$mensagem = $_POST['form-mensagem'];

$formularioEnviado = isset($nome) && isset($email) && isset($mensagem);

if($formularioEnviado) {
	$enviou = enviar_e_checar_email($nome, $email, $mensagem);

	if($enviou) { ?>
		<span class="email-sucesso">E-mail sent succesfully!</span>
	<?php } else { ?>
		<span class="email-fracasso">Sorry, there was an error and email couldn't be sent!</span>
	<?php }
}
?>

<main class="pagina-main">

	<article class="pagina">
		<h1 class="pagina-titulo">
			<?php the_title(); ?>
		</h1>

		<?php if( have_posts() ) {
			while( have_posts() ) {
				the_post(); ?>

			<div class="pagina-conteudo">
			 <?php the_content(); ?>
			</div>

		<?php	}
		}

		if( is_page('contact') ) {
		?>

		<form method="post">
			<div class="form-nome">
				<label for="form-nome">Name:</label>
				<input id="form-nome" type="text" placeholder="Your name here" name="form-nome">
			</div>

			<div class="form-email">
				<label for="form-email">Email:</label>
				<input id="form-email" type="email" placeholder="email@exemple.com" name="form-email">
			</div>

			<div class="form-mensagem">
				<label for="form-mensagem">Message:</label>
				<textarea id="form-mensagem" name="form-mensagem"></textarea>
			</div>
			<button type="submit">Send</button>

		</form>

	<?php } ?>

	</article>
</main>

<?php get_footer(); ?>

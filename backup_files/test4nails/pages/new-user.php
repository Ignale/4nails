<?php /* Template Name: Congratulations */?>
<?php get_header(); ?>
<main class="content">
	<section class="new-user">
		<div class="wrapper">
			<div class="new-user__container">
				<h1 class="title new-user__title copyright"><?= __('Congratulations!', '4nails')?></h1>
				<div class="new-user__text copyright"><?php the_post_content() ?></div>
				<a href="/" class="red-btn new-user__btn"><?= __('Continue shopping', '4nails')?></a>
				<a href="<?php account_url() ?>" class="cyan-link new-user__link"><?= __('My Account', '4nails')?></a>
			</div>
		</div>
	</section>
</main>

<?php get_footer() ?>
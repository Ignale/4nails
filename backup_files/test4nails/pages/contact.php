<?php /* Template Name: Contact */ ?>

<?php get_header(); ?>

<main class="content">

	
	<section class="contact">
		<div class="wrapper">
			<h1 class="title contact__title"><?php the_title() ?></h1>
			<div class="contact__container">
				<div>
					<div class="contact__text"><p> <?= get_field('intro'); ?> </p></div>
					<?php if( have_rows('socials') ): ?>
						<div class="contact__img">
							<?php while( have_rows('socials') ): the_row(); 
								$image = get_sub_field('image');
								?>
								<a href="<?php echo get_sub_field('link');?>" target="_blank">
									<?php echo wp_get_attachment_image($image['id'], 'full'); ?>
								</a>
							<?php endwhile; ?>
						</div>
					<?php endif; ?>
				</div>
				<div>
					<h2 class="contact-form__title"><?= __(get_field('contact_form_label')) ?></h2>
					<?php if (get_field('contact_form_id')) { ?>
						<?= do_shortcode('[contact-form-7 id="' . get_field('contact_form_id') . '" title="__("Cotact us", "4nails")"]') ?>
					<?php } ?>
				</div>
			</div>
			<div class="contact__content">
				<?php echo the_content(); ?>
			</div>
			<div class="contact__container">
				<?php if( have_rows('collage') ): ?>
					<div class="contact__collage">
						<?php while( have_rows('collage') ): the_row(); 
							$image = get_sub_field('image');
							?>
							<a class="image-link" href="<?php echo $image['url']; ?>">
								<div class="media-wrapper">
									<img id="image-1" class="alignnone wp-image-23946" src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>" />
								</div>
							</a>
						<?php endwhile; ?>
					</div>
				<?php endif; ?>
				<?php if (get_field('google_map_link')) { ?>
					<div>
						<iframe src="<?= __(get_field('google_map_link')) ?>" width="100%" allowfullscreen="allowfullscreen"></iframe>
					</div>
				<?php } ?>
			</div>
		</div>
	</section>

</main>

<?php get_footer() ?>


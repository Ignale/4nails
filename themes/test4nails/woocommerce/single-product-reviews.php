<?php

global $product, $post;

if (!comments_open()) {
    return;
}

$comments = get_comments([
    'parent' => 0,
    'post_id' => get_the_ID(),
    'status' => 'approve'
]);
?>
<div id="reviews" class="woocommerce-Reviews">
    <div id="comments">
        <h2 class="woocommerce-Reviews-title"><?php
            if (get_option('woocommerce_enable_review_rating') === 'yes' && ($count = $product->get_review_count())) {
                printf(esc_html(_n('%1$s review for %2$s', '%1$s reviews for %2$s', $count, 'woocommerce')), esc_html($count), '<span>' . get_the_title() . '</span>');
            } else {
                _e('Reviews', 'woocommerce');
            }
            ?></h2>

        <?php if (!empty($comments)) :
            comments($comments);
        else : ?>
            <p class="woocommerce-noreviews"><?php _e('There are no reviews yet.', 'woocommerce'); ?></p>
        <?php endif; ?>
    </div>

    <?php if (get_option('woocommerce_review_rating_verification_required') === 'no' || wc_customer_bought_product('', get_current_user_id(), $product->get_id())) : ?>

        <div id="review_form_wrapper">
            <div id="review_form">
                <?php
                $commenter = wp_get_current_commenter();

                $comment_form = array(
                    'title_reply' => !empty($comments) ? __('Add a review', 'woocommerce') : sprintf(__('Be the first to review &ldquo;%s&rdquo;', 'woocommerce'), get_the_title()),
                    'title_reply_to' => __('Leave a Reply to %s', 'woocommerce'),
                    'title_reply_before' => '<span id="reply-title" class="comment-reply-title">',
                    'title_reply_after' => '</span>',
                    'comment_notes_after' => '',
                    'fields' => array(
                        'author' => '<p class="comment-form-author mb-2">' . '<label for="author">' . esc_html__('Name', 'woocommerce') . '&nbsp;<span class="required">*</span></label> ' .
                            '<input class="control-form" id="author" name="author" type="text" value="' . esc_attr($commenter['comment_author']) . '" size="30" required /></p>',
                        'email' => '<p class="comment-form-email mb-2"><label for="email">' . esc_html__('Email', 'woocommerce') . '&nbsp;<span class="required">*</span></label> ' .
                            '<input class="control-form" id="email" name="email" type="email" value="' . esc_attr($commenter['comment_author_email']) . '" size="30" required /></p>',
                    ),
                    'label_submit' => __('Send', '4nails'),
                    'class_submit' => 'submit button btn-cyan btn-lg',
                    'logged_in_as' => '',
                    'comment_field' => '',
                );

                if ($account_page_url = wc_get_page_permalink('myaccount')) {
                    $comment_form['must_log_in'] = '<p class="must-log-in">' . sprintf(__('You must be <a href="%s">logged in</a> to post a review.', 'woocommerce'), esc_url($account_page_url)) . '</p>';
                }

                if (get_option('woocommerce_enable_review_rating') === 'yes') {
                    $comment_form['comment_field'] .= '<div class="comment-form-rating"><label for="rating">' . esc_html__('Your rating', 'woocommerce') . '</label><select name="rating" id="rating" required>
							<option value="">' . esc_html__('Rate&hellip;', 'woocommerce') . '</option>
							<option value="5">' . esc_html__('Perfect', 'woocommerce') . '</option>
							<option value="4">' . esc_html__('Good', 'woocommerce') . '</option>
							<option value="3">' . esc_html__('Average', 'woocommerce') . '</option>
							<option value="2">' . esc_html__('Not that bad', 'woocommerce') . '</option>
							<option value="1">' . esc_html__('Very poor', 'woocommerce') . '</option>
						</select></div>';
                }

                $comment_form['comment_field'] .= '<p class="comment-form-comment mb-2"><textarea id="comment" name="comment" class="control-form" cols="45" rows="8" required></textarea></p>';

                comment_form(apply_filters('woocommerce_product_review_comment_form_args', $comment_form));
                ?>
            </div>
        </div>

    <?php else : ?>
        <p class="woocommerce-verification-required">
            <?php if (!is_user_logged_in()): ?>
                <?php printf(__('If you bought this product earlier and want to leave feedback here, you need to log into your account. Want to %1$slog into%2$s your account?', '4nails'),
                    "<a href='" . get_permalink(get_option('woocommerce_myaccount_page_id')) ."'>",
                    '</a>'); ?>
            <?php else : ?>
                <?= __('You cannot leave a review because you have not purchased this product from us.','4nails') ?>
            <?php endif; ?></p>
    <?php endif; ?>
</div>

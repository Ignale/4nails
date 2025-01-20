<div class="header__search <?= is_front_page() ? 'search__home-page' : ''; ?>">

    <form action="<?= home_url('/'); ?>" method="post" class="field-search">

        <input type="text"  aria-label="search"  name="s" minlength="3" placeholder="<?php the_field('search', 'option') ?>" required>

        <input type="hidden" name="post_type" value="product">

        <button type="submit"  aria-label="search-button" class="btn-search">

            <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="21px" height="22px" viewBox="-164 186.5 21 22" enable-background="new -164 186.5 21 22" xml:space="preserve">
                <g><path fill="#17CFB9" d="M-155.506,186.5c-4.691,0-8.494,3.814-8.494,8.52s3.803,8.521,8.494,8.521c1.805,0,3.477-0.563,4.852-1.526 l6.19,6.442c0.06,0.058,0.153,0.058,0.207,0.003l1.211-1.213c0.055-0.057,0.052-0.153-0.004-0.208l-6.108-6.358 c1.336-1.505,2.146-3.486,2.146-5.66C-147.012,190.314-150.814,186.5-155.506,186.5z M-155.501,202.5 c-4.142,0-7.499-3.357-7.499-7.5s3.357-7.5,7.499-7.5c4.144,0,7.501,3.357,7.501,7.5S-151.357,202.5-155.501,202.5z"/></g>
            </svg>
        </button>
    </form>
    <button class="close-icon" type="button">
            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" x="0px" y="0px" width="10px" height="10px" viewBox="-164.5 181.5 10 10" enable-background="new -164.5 181.5 10 10" xml:space="preserve">
            <polygon fill-rule="evenodd" clip-rule="evenodd" fill="#EF8989" points="-154.5,182.333 -155.333,181.5 -159.5,185.667   -163.667,181.501 -164.5,182.334 -160.334,186.5 -164.5,190.666 -163.667,191.499 -159.5,187.333 -155.333,191.5 -154.5,190.667   -158.667,186.5 "/>
            </svg>
        </button>

</div>
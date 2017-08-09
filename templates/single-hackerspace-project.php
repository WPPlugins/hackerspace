<?php
/**
 * Template for displaying the Projects custom post type
 *
 */

/** Display the post additional fields */
function hackerspace_project_post_meta()
{
    $status = esc_html(get_post_meta(get_the_ID(), '_project_status', true));
    $contact = esc_html(get_post_meta(get_the_ID(), '_project_contact', true));
    $repository = esc_html(get_post_meta(get_the_ID(), '_project_repository_url', true));

    // exit if totaly empty to avoid unecessary div
    if ($status == false &&  $contact == false && $repository == false) {
        return;
    }

    echo '<div class="entry-meta">';
    if ($status == true) {
        _e('Status:', 'wp-hackerspace');
        echo '&nbsp;'.$status.'</br>';
    }
    if ($contact == true) {
        _e('Contact person:', 'wp-hackerspace');
        echo '&nbsp;'.$contact.'</br>';
    }
    if ($repository == true) {
        _e('Repository:', 'wp-hackerspace');
        echo '&nbsp;<a href='.$repository.'>'.$repository.'</a></br>';
    }
    echo '</div>';
}


get_header();

echo '<div id="primary" class="content-area">';
echo '<div id="content" class="site-content" role="main">';

while (have_posts()) {
    the_post();
    echo '<article>';
    echo '<header>';
    if (has_post_thumbnail()) {
        the_post_thumbnail();
    }
    echo '<h1>'.get_the_title().'</h1>';
    the_author_posts_link();
    echo '&nbsp;';
    the_category(', ');
    if (has_tag()) {
        echo '&nbsp;';
        the_tags('');
    }
    echo '</header>';
    echo '<div class="entry-content">';
    // display the project additional fields
    hackerspace_project_post_meta();
    the_content();
    echo '</div>';
    echo '</article>';

    if (comments_open() || get_comments_number()) {
        comments_template();
    }
}
echo '</div></div>';

get_sidebar();
get_footer();

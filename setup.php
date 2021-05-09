<?php

/**
* Plugin Name: Šablona pluginů
* Description: ...
* Version: 1.00
* Author: WeDesIn
* Author URI: https://www.wedesin.cz/
* Requires at least: 3.0.
* Tested up to: 5.6
* Text Domain: doplnit
* License: GPL2 or higher
*/

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if( !class_exists( 'setupWDS' ) )
{

    class setupWDS {

        public $tasks;
        public $comments;

        /**
         *
         * construct
         *
         * @date	21/1/21
         * @since	1.0
         *
         * @param	string $name The constant name.
         * @param	mixed $value The constant value.
         * @return	void
         */
        public function __construct()
        {
            //init the plugin        
            add_action( 'init', [$this, 'plugin_init'] );
        }

        /**
         * define
         *
         * Defines a constant if doesnt already exist.
         *
         * @date	21/1/21
         * @since	1.0
         *
         * @param	string $name The constant name.
         * @param	mixed $value The constant value.
         * @return	void
         */

        function define( $name, $value = true ) {
            if( !defined($name) ) {
                define( $name, $value );
            }
        }

        /**
         * 
         * Plugin initiation functions
         *
         * @date	21/1/21
         * @since	1.0
         *
         * @return	void
         */
        public function plugin_init( ) {

            $this->define( 'WDS_PATH', plugin_dir_path( __FILE__ ) );
            $this->define( 'WDS_URL', plugin_dir_url( __FILE__ ) );

            // Include utility functions
            include_once( WDS_PATH . 'functions/styles-scripts.php');  
            include_once( WDS_PATH . 'functions/comments-setup.php');           

            $this->tasks = new ScriptsStyles();
            $this->comments = new customizeComments();

        }

    }

}

new setupWDS;




//Walker_Comment::start_el( string $output, WP_Comment $comment, int $depth, array $args = array(), int $id );
/*
class comment_walker extends Walker_Comment {

    // start_lvl – wrapper for child comments list
    function start_lvl( &$output, $depth = 0, $args = array() ) {
        $GLOBALS['comment_depth'] = $depth + 2;
        
        $output .= '<h1>hallo tady jsem</h1>'; 

        return $output;
    
    }

}*/

class comment_walker extends Walker_Comment {
    var $tree_type = 'comment';
    var $db_fields = array( 'parent' => 'comment_parent', 'id' => 'comment_ID' );

    // constructor – wrapper for the comments list
    function __construct() { ?>

        <section class="comments-list">

    <?php }

    // start_lvl – wrapper for child comments list
    function start_lvl( &$output, $depth = 0, $args = array() ) {
        $GLOBALS['comment_depth'] = $depth + 2; ?>
        
        <section class="child-comments comments-list">

    <?php }

    // end_lvl – closing wrapper for child comments list
    function end_lvl( &$output, $depth = 0, $args = array() ) {
        $GLOBALS['comment_depth'] = $depth + 2; ?>

        </section>

    <?php }

    // start_el – HTML for comment template
    function start_el( &$output, $comment, $depth = 0, $args = array(), $id = 0 ) {
        $depth++;
        $GLOBALS['comment_depth'] = $depth;
        $GLOBALS['comment'] = $comment;
        $parent_class = ( empty( $args['has_children'] ) ? '' : 'parent' ); 

        if ( 'article' == $args['style'] ) {
            $tag = 'article';
            $add_below = 'comment';
        } else {
            $tag = 'article';
            $add_below = 'comment';
        } ?>

        <article <?php comment_class(empty( $args['has_children'] ) ? '' :'parent') ?> id="comment-<?php comment_ID() ?>" itemprop="comment" itemscope itemtype="http://schema.org/Comment">
            <figure class="gravatar"><?php echo get_avatar( $comment, 65, '[default gravatar URL]', 'Author’s gravatar' ); ?></figure>
            <div class="comment-meta post-meta" role="complementary">
                <h2 class="comment-author">
                    <a class="comment-author-link" href="<?php comment_author_url(); ?>" itemprop="author"><?php comment_author(); ?></a>
                </h2>
                <time class="comment-meta-item" datetime="<?php comment_date('Y-m-d') ?>T<?php comment_time('H:iP') ?>" itemprop="datePublished"><?php comment_date('jS F Y') ?>, <a href="#comment-<?php comment_ID() ?>" itemprop="url"><?php comment_time() ?></a></time>
                <?php edit_comment_link('<p class="comment-meta-item">Edit this comment</p>','',''); ?>
                <?php if ($comment->comment_approved == '0') : ?>
                <p class="comment-meta-item">Your comment is awaiting moderation.</p>
                <?php endif; ?>
            </div>
            <div class="comment-content post-content" itemprop="text">
                <?php comment_text() ?>
                <?php comment_reply_link(array_merge( $args, array('add_below' => $add_below, 'depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
            </div>

    <?php }

    // end_el – closing HTML for comment template
    function end_el(&$output, $comment, $depth = 0, $args = array() ) { ?>

        </article>

    <?php }

    // destructor – closing wrapper for the comments list
    function __destruct() { ?>

        </section>
    
    <?php }

}

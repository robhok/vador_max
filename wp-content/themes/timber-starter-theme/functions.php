<?php

if ( ! class_exists( 'Timber' ) ) {
	add_action( 'admin_notices', function() {
			echo '<div class="error"><p>Timber not activated. Make sure you activate the plugin in <a href="' . esc_url( admin_url( 'plugins.php#timber' ) ) . '">' . esc_url( admin_url( 'plugins.php' ) ) . '</a></p></div>';
		} );
	return;
}

Timber::$dirname = array('templates', 'views');

class StarterSite extends TimberSite {

	function __construct() {
		add_theme_support( 'post-formats' );
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'menus' );
        add_theme_support( 'custom-header', array(
          'header_image'    => '',
          'header-selector' => '.site-title a',
          'header-text'     => false,
          'height'          => 150,
          'width'           => 150,
        ) );
		add_filter( 'timber_context', array( $this, 'add_to_context' ) );
		add_filter( 'get_twig', array( $this, 'add_to_twig' ) );
		add_action( 'init', array( $this, 'register_post_types' ) );
		add_action( 'init', array( $this, 'register_taxonomies' ) );
		add_action( 'init', array( $this, 'register_sidebars' ) );
		add_action( 'init', array( $this, 'add_scripts' ) );
		parent::__construct();
	}

  function add_scripts() {

    // enregistrement d'un nouveau script
    wp_register_script('main_script', get_template_directory_uri() . '/scripts/main.js', array('jquery'),'1.1', true);

    // appel du script dans la page
    wp_enqueue_script('main_script');

    // enregistrement d'un nouveau style
    wp_register_style( 'main_style', get_template_directory_uri() . '/styles/main.css' );

    // appel du style dans la page
    wp_enqueue_style( 'main_style' );

    // enregistrement d'un nouveau style
    wp_register_style( 'custom_grid', get_template_directory_uri() . '/styles/grid.css' );

    // appel du style dans la page
    wp_enqueue_style( 'custom_grid' );

    // enregistrement d'un nouveau style
    wp_register_style( 'fonts', get_template_directory_uri() . '/styles/fonts.css' );

    // appel du style dans la page
    wp_enqueue_style( 'fonts' );

    // A SUPPRIMER A LA FIN
    // MAX CSS
    wp_register_style( 'max_style', get_template_directory_uri() . '/styles/maxime.css' );

    // ADD MAX CSS
    wp_enqueue_style( 'max_style' );

//    add_filter('upload_mimes', array( $this, 'cc_mime_types' ) );

    /* add_action('admin_head', array( $this,'fix_svg_thumb_display') ); */

  }
  function cc_mime_types($mimes) {
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
  }

  function fix_svg_thumb_display() {
    echo '
      td.media-icon img[src$=".svg"], img[src$=".svg"].attachment-post-thumbnail {
        width: 100% !important;
        height: auto !important;
      }'
      ;
}


  function register_post_types() {
		//this is where you can register custom post types
    $labels = array(
    'name'               => 'Empire',
    'singular_name'      => 'Empire',
    'all_items'          => 'Tous les profils',
    'add_new'            => 'Ajouter un profil',
    'add_new_item'       => 'Ajouter un profil',
    'edit_item'          => "Modifier un profil",
    'new_item'           => 'Nouveau profil',
    'view_item'          => "Voir le profil",
    'search_items'       => 'Trouver un profil',
    'not_found'          => 'Pas de résultat',
    'not_found_in_trash' => 'Pas de résultat',
    'parent_item_colon'  => 'Profils parents:',
    'menu_name'          => 'Empire',
  );

  $args = array(
    'labels'              => $labels,
    'hierarchical'        => false,
    'supports'            => array( 'title','thumbnail','editor', 'excerpt', 'comments' ),
    'public'              => true,
    'show_ui'             => true,
    'show_in_menu'        => true,
    'menu_position'       => 2,
    'menu_icon'           => 'dashicons-groups',
    'show_in_nav_menus'   => true,
    'publicly_queryable'  => true,
    'exclude_from_search' => false,
    'has_archive'         => false,
    'query_var'           => true,
    'can_export'          => true,
    'rewrite'             => array( 'slug' => 'empire' ),
    /*'capabilities'        => array(
      'edit_post'        => 'edit_annonce',
      'read_post'        => 'read_annonce',
      'create_posts'     => 'create_annonces',
    ),*/
  );

  register_post_type('Empire', $args );
    ;
	}

  function register_taxonomies() {
		//this is where you can register custom taxonomies
	}

  function register_sidebars() {
    register_sidebar(array(
      'name' => __( 'Home Widgets', 'home-widgets' ),
      'id' => 'sidebar-1',
      'description' => __( 'Widgets in this area will be shown on all posts and pages.', 'home-widgets' ),
      'before_widget' => '<li id="%1$s" class="widget %2$s">',
    	'after_widget'  => '</li>',
    	'before_title'  => '<h2 class="latest-news widgettitle">',
    	'after_title'   => '</h2>',
    ));
    register_sidebar(array(
      'name' => __( 'News Widgets', 'news-widgets' ),
      'id' => 'sidebar-2',
      'description' => __( 'Widgets in this area will be shown on all posts and pages.', 'news-widgets' ),
      'before_widget' => '<li id="%1$s" class="widget %2$s no-style">',
    	'after_widget'  => '</li>',
    	'before_title'  => '<h2 class="widgettitle">',
    	'after_title'   => '</h2>',
    ));
    register_sidebar(array(
      'name' => __( 'Footer Widgets', 'footer-widgets' ),
      'id' => 'sidebar-3',
      'description' => __( 'Widgets in this area will be shown on all posts and pages.', 'footer-widgets' ),
      'before_widget' => '<li id="%1$s" class="widget %2$s no-style">',
    	'after_widget'  => '</li>',
    	'before_title'  => '<h2 class="widgettitle">',
    	'after_title'   => '</h2>',
    ));
  }

	function add_to_context( $context ) {
		$context['foo'] = 'bar';
		$context['stuff'] = 'I am a value set in your functions.php file';
		$context['notes'] = 'These values are available everytime you call Timber::get_context();';
		$context['menu'] = new TimberMenu('menu_header');
		$context['image_header'] = get_header_image();
    $context['footer'] = Timber::get_widgets('footer-widgets');
		$context['site'] = $this;
		return $context;
	}

	function myfoo( $text ) {
		$text .= ' bar!';
		return $text;
	}

	function add_to_twig( $twig ) {
		/* this is where you can add your own functions to twig */
		$twig->addExtension( new Twig_Extension_StringLoader() );
		$twig->addFilter('myfoo', new Twig_SimpleFilter('myfoo', array($this, 'myfoo')));
		return $twig;
	}

}

new StarterSite();

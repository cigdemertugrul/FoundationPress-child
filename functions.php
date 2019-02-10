<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

// BEGIN ENQUEUE PARENT ACTION
// AUTO GENERATED - Do not modify or remove comment markers above or below:

if ( !function_exists( 'chld_thm_cfg_locale_css' ) ):
    function chld_thm_cfg_locale_css( $uri ){
        if ( empty( $uri ) && is_rtl() && file_exists( get_template_directory() . '/rtl.css' ) )
            $uri = get_template_directory_uri() . '/rtl.css';
        return $uri;
    }
endif;
add_filter( 'locale_stylesheet_uri', 'chld_thm_cfg_locale_css' );
         
if ( !function_exists( 'child_theme_configurator_css' ) ):
    function child_theme_configurator_css() {
        if ( !file_exists( trailingslashit( get_stylesheet_directory() ) . 'dist/assets/css/app.css' ) ):
            wp_deregister_style( 'main-stylesheet' );
            wp_register_style( 'main-stylesheet', trailingslashit( get_template_directory_uri() ) . 'dist/assets/css/app.css' );
        endif;
        wp_enqueue_style( 'chld_thm_cfg_child', trailingslashit( get_stylesheet_directory_uri() ) . 'style.css', array( 'main-stylesheet' ) );
    }
endif;
add_action( 'wp_enqueue_scripts', 'child_theme_configurator_css', 20 );

// END ENQUEUE PARENT ACTION 
//-----------------------FOUNDATION REVEAL WIDGET---------------------------------//

class foundationReveal extends WP_Widget {
	public function __construct()
{
    parent::__construct('widget_freveal', 'Foundation Reveal', [
        'classname' => 'Foundation Reveal',
        'description' => 'Foundation Reveal ile sayfa göstermenizi sağlar.',
        'customize_selective_refresh' => true,
    ]);
}

public function form($instance)
{
    //Admin kısmındaki form alanını oluşturur.    
    $fr_url=!empty($instance['fr_url'])? $instance['fr_url'] : '#';
    $fr_title=!empty($instance['fr_title'])? $instance['fr_title'] : '';
   ?>
   <label for="<?php echo $this->get_field_id('fr_title')?>">Başlık :</label>
   <input class="widefat" type="" name="<?php echo $this->get_field_name('fr_title')?>" id="<?php echo $this->get_field_id('fr_title')?>" value="<?php echo $fr_title;?>">
   
   <label for="<?php echo $this->get_field_id('fr_url')?>">Sayfa Url :</label>
   <input class="widefat" type="" name="<?php echo $this->get_field_name('fr_url')?>" id="<?php echo $this->get_field_id('fr_url')?>" value="<?php echo $fr_url;?>">
   <?php
    
}
//update fonksiyonunda forma girilen değerleri eski değerlerle güncelliyorum.
public function update($new_instance, $old_instance)
{
 $old_instance['fr_title']=$new_instance['fr_title'];
 $old_instance['fr_url']=$new_instance['fr_url'];
 return $old_instance;
}
//Temada görünen kısmı bu fonksiyonda yazılır.
public function widget($args, $instance)
{ 
    
    $title=apply_filters('widget_title',$instance['fr_title']);    
    $w_url=$instance['fr_url'];
    
    echo $args['before_title'].$args['before_widget'];
    
    ?>
<h6><a data-open="exampleModal1" aria-controls="exampleModal1" aria-haspopup="true" tabindex="0"><?php echo $title;?></a></h6>

<div class="reveal" id="exampleModal1" data-reveal>
     <div id="revealdiv" class="main-content">
     
    </div>
	<button class="close-button" data-close aria-label="Close reveal" type="button">
	<span aria-hidden="true">&times;</span>
	</button>                    
</div>
<script>
$("#revealdiv").empty();
$( "#revealdiv" ).load( "<?php echo $w_url;?> .main-content");
</script>

<?php
echo  $args['after_title'].$args['after_widget'];  
          }
}
//Widgeti adminde göstermek ,tanıtmak için 
function foundation_reveal_widget(){
	register_widget('foundationReveal');
}
add_action('widgets_init','foundation_reveal_widget');
//-----------------JAVASCRIPT EKLEME-----------------------------------//
function my_custom_scripts() {
    //reveal-foundation javascript kodlarını içeren js dosyası
    wp_enqueue_script( 'appc27b', get_stylesheet_directory_uri() . '/dist/assets/js/appc27b.js', array( 'jquery' ),'',true );
    
}
add_action( 'wp_enqueue_scripts', 'my_custom_scripts' );

#######################################################

//--------------TUM YAZILARI LİSTELEME VE SAYFALAMA--------------------/
function sayfalama()
{ echo  "<ul>";
query_posts(array('posts_per_page' => 50,'cat' => 1, 'paged' => get_query_var('paged')));
while(have_posts()) : the_post();?>
  <li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>

<?php endwhile; ?></ul>
<?php 
  $pages = '';
  $range = 3;
    $showitems = ($range * 2)+1;
    global $paged;
    if(empty($paged)) $paged = 1;
    if($pages == '')
    {
        global $wp_query;
        $pages = $wp_query->max_num_pages;
        
        if(!$pages)
        {
            $pages = 1;
        }
    }
    if(1 != $pages)
    {
        echo "<ul class='pagination text-center' role='navigation' aria-label='Pagination'>";        
        if($paged > 2 && $paged > $range+1 && $showitems < $pages) echo "<li><a class='prev' href='".get_pagenum_link(1)."'>«</a></li>";
        if($paged > 1 && $showitems < $pages) echo "<li><a href='".get_pagenum_link($paged - 1)."'>&laquo;</a></li>";
        for ($i=1; $i <= $pages; $i++)
        {
            if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems ))
            {
                echo ($paged == $i)? "<li><span class='current' aria-current='page'>".$i."</span></li>":"<li><a href='".get_pagenum_link($i)."'  >".$i."</a></li>";
            }
        }
       if ($paged < $pages && $showitems < $pages) echo "<li><a class='next' href='".get_pagenum_link($paged + 1)."'>«</a></li>";
        if ($paged < $pages-1 &&  $paged+$range-1 < $pages && $showitems < $pages) echo "<li><a href='".get_pagenum_link($pages)."'>«</a></li>";
        echo "</ul>";
    }
    wp_reset_query();
}
//---------------------TÜM YAZILARI LİSTELEME VE SAYFALAMA BİTİŞ------------------------->
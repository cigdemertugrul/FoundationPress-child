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
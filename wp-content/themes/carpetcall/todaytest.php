<?php


function armand_fandera_js(){
  
  wp_register_script( 'agile-main-js', get_template_directory_uri() . '/js/script.js', array( 'jquery' ), '1.0', false );
  wp_enqueue_script( 'agile-main-js' );
  wp_localize_script( 'agile-main-js', 'headJS', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ), 'templateurl' => /get_template_directory_uri(), 'posts_per_page' => get_option('posts_per_page') ) );
  
}
add_action( 'wp_enqueue_scripts', 'armand_fandera_js', 90);


add_action( "wp_ajax_load_more", "load_more_func" ); // when logged in
add_action( "wp_ajax_nopriv_load_more", "load_more_func" );//when logged out 
function load_more_func() {
  //verifying nonce here
    if ( !wp_verify_nonce( $_REQUEST['nonce'], "load_posts" ) ) {
      exit("No naughty business please");
    }     
  $offset = isset($_REQUEST['offset'])?intval($_REQUEST['offset']):0;

 
  $post_type = isset($_REQUEST['post_type'])?$_REQUEST['post_type']:'blog';
  
  
  ob_start(); // buffer output instead of echoing it
  $args = array(
                'post_type'=>$post_type,
                'offset' => $offset,     
				'orderby'=> 'modified',
				'order' => 'DESC',
				'post_status' => 'publish',
				'posts_per_page' => 4,
				);
  $posts_query = new WP_Query( $args );

  if ($posts_query->have_posts()) {

          $result['have_posts'] = true; 
           
          while ( $posts_query->have_posts() ) : $posts_query->the_post(); 
					  $i = 0;								
							$terms = wp_get_post_terms(get_the_ID(),'blog_category');          
								   $category_names = array();
								foreach($terms  as $cat){
									$i++;
                                    if ($i > 4) {
                                        break;
                                    }
										 $category_names[] =  $cat->name;
									}
          ?>
            
                  <div class="col-md-3 single-article"  >
            <div class="blog-box">
              <div class="pov"><?php _e('Blog /'); ?> <?php  echo implode(', ', $category_names);   ?>   </div>
              <h3><?php the_title(); ?></h3>
            <div class="detail_summary"><?php echo resolution_content(10); ?></div>
              <a class="read_more_content" href="<?php echo  the_permalink(); ?>" tabindex="0"><?php _e('Read More'); ?></a>
               </div>
          </div>

           
            <?php endwhile;
        $result['html'] = ob_get_clean(); // put alloutput data into "html" item
  } else {
      //no posts found
      $result['have_posts'] = false; // return that there is no posts found
  } 

        if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            $result = json_encode($result); // encode result array into json feed


            echo $result; // by echo we return JSON feed on POST request sent via AJAX
        }
        else { 
            header("Location: ".$_SERVER["HTTP_REFERER"]);
        }
  die();
}

?>



+++++++++++++++for display ++++++++++++++++++
<div id="posts_list">
<?php $loadmore_post = array( 
   'orderby'=> 'modified',
  'order' => 'DESC',
  'post_type' => 'blog',
  'post_status' => 'publish',
  'posts_per_page' => 4,
   
   );
  $query_loop = new WP_Query($loadmore_post); 

  while($query_loop->have_posts()) : $query_loop->the_post(); 

              $i = 0;
					$taxonomies = array( 'blog_category');
					$args = array();
					$terms = wp_get_post_terms(get_the_ID() ,$taxonomies, $args);
					   $category_names = array();
					foreach($terms  as $cat){
						$i++;
                        if ($i > 4) {
                            break;
                        }
							 $category_names[] =  $cat->name;
						}
 ?>


 <div class="col-md-3 single-article"  >
            <div class="blog-box">
              <div class="pov"><?php _e('Blog /'); ?> <?php  echo implode(', ', $category_names);   ?>   </div>
              <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
            <div class="detail_summary"><?php echo resolution_content(10); ?></div>
              <a class="read_more_content" href="<?php echo the_permalink(); ?>" tabindex="0"><?php _e('Read More'); ?></a>
               </div>
          </div>


<?php endwhile;   ?>
</div>
<script type="text/javascript">
++++++++++++++javascript+++++++++++
jQuery(document).ready(function($){


$('.load_more:not(.loading)').live('click',function(e){
	e.preventDefault();
	var $load_more_btn = $(this);
	var post_type = 'blog'; // this is optional and can be set from anywhere, stored in mockup etc...
	var offset = $('#posts_list .single-article').length;
	var nonce = $load_more_btn.attr('data-nonce');
	$.ajax({
		type : "post",
		context: this,
		dataType : "json",
		url : headJS.ajaxurl,
		data : {action: "load_more", offset:offset, nonce:nonce, post_type:post_type, posts_per_page:headJS.posts_per_page},
		beforeSend: function(data) {
			// here u can do some loading animation...
			$load_more_btn.addClass('loading').html('Loading...');// good for styling and also to prevent ajax calls before content is loaded by adding loading class
		},
		success: function(response) {
			if (response['have_posts'] == 1){//if have posts:
				$load_more_btn.removeClass('loading').html('Load More');
				var $newElems = $(response['html'].replace(/(\r\n|\n|\r)/gm, ''));// here removing extra breaklines and spaces
				$('#posts_list').append($newElems);
			} else {
				//end of posts (no posts found)
				$load_more_btn.removeClass('loading').addClass('end_of_posts').html('<span>No More Post</span>'); // change buttom styles if no more posts
			}
		}
	});
});

});</script>

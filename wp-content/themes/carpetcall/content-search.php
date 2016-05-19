<form action="<?php echo $list_url;?>" method="post" class="search-form">
			<div class="text-conte-search ">
				<h2>Store  Listings</h2>
			</div>
			
			<div class="clearfix wrap-search-ele">
				<fieldset class="col-md-12 no-css-imp">
					<input id="dir_keyword" name="dir_keyword" type="text" class="form-control" placeholder="keyword/phrase" onkeyup="autocomplet()" autocomplete="off">
                    <ul id="directory_list_id"></ul>
				</fieldset>
				<fieldset class="col-md-4 no-css-imp">
					<select name="dirloc" class="form-control">
						<option value="" selected="selected" disabled>chhose title</option>
						<?php  $loop = new WP_Query(array(
                          'post_type'=>'',
                          'posts_per_page'=>'4'
						));
						while($loop->have_posts()):
						$loop->the_post();
							 ?>
						<option value="title" ><?php the_title();?></option>
						
					</select>
				<?php endwhile;?>
				</fieldset>
				
				<fieldset class="col-md-4 no-css-imp">
					<input id="direc_search" type="submit" name="searchdir" class="btn btn-resource btn-block" value="Search">
				</fieldset>
			</div>

		</form>
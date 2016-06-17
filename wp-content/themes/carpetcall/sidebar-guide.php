<ul class="guide_list_cbg">
            
					<?php
                            $tax = 'guide'; 
						$tax_terms = get_terms($tax);
						
						foreach($tax_terms as $tax_term)
						{
						echo '<li><a href="'.get_term_link($tax_term).'">'.$tax_term->name.'<i class="fa fa-caret-right" aria-hidden="true"></i></li></a>';
						}

				?>
</ul>
<div class="nowspe nowsppe"><a href="#" target="_blank"> SHOP NOW </a></div>
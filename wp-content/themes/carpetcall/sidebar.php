<ul class="guide_list " style="color:black;">
            
					<?php
                            $tax = 'guide'; 
						$tax_terms = get_terms($tax);
						
						foreach($tax_terms as $tax_term)
						{
						echo '<li> &nbsp;<a href="'.get_term_link($tax_term).'" style="color:#000000;">'.$tax_term->name.'<i class="fa fa-caret-right" aria-hidden="true"></i></li></a>';
						}

				?>
</ul>
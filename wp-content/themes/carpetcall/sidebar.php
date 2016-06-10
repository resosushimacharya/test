<ul class="guide_list">
            
					<?php
                            $tax = 'faq'; 
						$tax_terms = get_terms($tax);
						
						foreach($tax_terms as $tax_term)
						{
						echo '<li><i class="fa fa-caret-right" aria-hidden="true"></i> &nbsp;<a href="'.get_term_link($tax_term).'">'.$tax_term->name.'</li></a>';
						}

				?>
            </ul><div class="clearfix"></div>
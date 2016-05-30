<?php //hook into the init action and call create_book_taxonomies when it fires
add_action( 'init', 'callCustomTaxonomy', 0 );
//create a custom taxonomy name it $plural for your posts
function callCustomTaxonomy()
{

create_dynamic_hierarchical_taxonomy('profaq','profaqs','faqs','FAQ Category','faq');
create_dynamic_hierarchical_taxonomy('Guide','Guides','guides','Gudie Category','guide');
}
function create_dynamic_hierarchical_taxonomy($singular,$plural,$posttype,$cat,$catreg) {
// Add new taxonomy, make it hierarchical like categories
//first do the translations part for GUI
$labels = array(
'name' => _x( $cat, 'taxonomy general name' ),
'singular_name' => _x( $singular, 'taxonomy singular name' ),
'search_items' =>  __( 'Search '. $plural ),
'all_items' => __( 'All '. $plural ),
'parent_item' => __( 'Parent '.$singular ),
'parent_item_colon' => __( 'Parent '.$singular.':' ),
'edit_item' => __( 'Edit '. $cat ),
'update_item' => __( 'Update '. $singular ),
'add_new_item' => __( 'Add New '. $cat),
'new_item_name' => __( 'New '.$singular .'Name' ),
'menu_name' => __( $cat ),
    );
// Now register the taxonomy
register_taxonomy($catreg,array($posttype), array(
'hierarchical' => true,
'labels' => $labels,
'show_ui' => true,
'show_admin_column' => true,
'query_var' => true,
'rewrite' => array( 'slug' => $catreg ),
));
}
add_action('admin_init','add_category_once');
function add_category_once(){
///////////////////// Create Main Category /////////////////////////
$cats = array(

array('name' => 'Modern','description' => ' ','slug' => 'modern'),
array('name' => 'Shag','description' => ' ','slug' => 'shag'),
array('name' => 'Tribal ','description' => ' ','slug' => 'tribal'),
array('name' => 'Clearance ','description' => ' ','slug' => 'clearance'),
array('name' => 'Traditional','description' => ' ','slug' => 'traditional'),
array('name' => 'Childrens','description' => ' ','slug' => 'childrens'),
array('name' => 'Bathroom','description' => ' ','slug' => 'bathroom'),
array('name' => 'Outdoor','description' => ' ','slug' => 'outdoor'),
array('name' => 'Handknotted','description' => ' ','slug' => 'handknotted'),

);
foreach($cats as $data) {
$cid = wp_insert_term(
$data['name'], // the term
'product_cat', // the taxonomy
array(
'description'=> $data['description'],
'slug' => $data['slug'],
// 'parent' => $data['parent']
)
);
}


///////////////////// Create  Sub  Category /////////////////////////
$sub_cats=array(
////////////////////////////// Sub cat of Type category ///////////////////////////////
array('name' => 'AMORE','description' => ' ','slug' => 'amore','parent'=>"modern"),
array('name' => 'BERLIN','description' => ' ','slug' => 'berlin','parent'=>"modern"),
array('name' => 'BOUNCE','description' => ' ','slug' => 'bounce','parent'=>"modern"),
array('name' => 'DENVER','description' => ' ','slug' => 'denver','parent'=>"modern"),
array('name' => 'DOLCE','description' => ' ','slug' => 'dolce','parent'=>"modern"),
array('name' => 'EBONY','description' => ' ','slug' => 'ebony','parent'=>"modern"),
array('name' => 'JORDAN','description' => ' ','slug' => 'jordan','parent'=>"modern"),
array('name' => 'MANHATTAN','description' => ' ','slug' => 'manhattan','parent'=>"modern"),
array('name' => 'MAYFAIR','description' => ' ','slug' => 'mayfair','parent'=>"modern"),
array('name' => 'MIAMI','description' => ' ','slug' => 'miami','parent'=>"modern"),
array('name' => 'THE DESIGNER COLLECTION','description' => 'the_designer_collection','slug' => 'ebony','parent'=>"modern"),
array('name' => 'LONDON','description' => ' ','slug' => 'london','parent'=>"modern"),
array('name' => 'VENTUS','description' => '','slug' => 'ventus','parent'=>"modern"),
array('name' => 'LAUREL','description' => ' ','slug' => 'laurel','parent'=>"modern"),



array('name' => 'TASHKENT','description' => ' ','slug' => 'tashkent','parent'=>"traditional"),
array('name' => 'NOBILITY','description' => ' ','slug' => 'nobility','parent'=>"traditional"),
array('name' => 'KASHQAI','description' => ' ','slug' => 'kashqai','parent'=>"traditional"),
array('name' => 'KIRMAN','description' => ' ','slug' => 'kirman','parent'=>"traditional"),
array('name' => 'ESFAHAN','description' => ' ','slug' => 'esfahan','parent'=>"traditional"),
array('name' => 'TLAY','description' => ' ','slug' => 'tlay','parent'=>"traditional"),

array('name' => 'FLORYA','description' => ' ','slug' => 'florya','parent'=>"clearance "),
array('name' => 'CABO','description' => ' ','slug' => 'cabo','parent'=>"clearance "),
array('name' => 'VIPER','description' => ' ','slug' => 'viper','parent'=>"clearance "),

array('name' => 'BLOOM 2','description' => ' ','slug' => 'bloom_2','parent'=>"shag"),
array('name' => 'EVOLUTION','description' => ' ','slug' => 'evolution','parent'=>"shag"),
array('name' => 'RISIS','description' => ' ','slug' => 'rists','parent'=>"shag"),
array('name' => ' MAGNIFICENT','description' => ' ','slug' => 'magnificent','parent'=>"shag"),
array('name' => 'PLUSH','description' => ' ','slug' => 'plush','parent'=>"shag"),
array('name' => ' SPAGHETTI','description' => ' ','slug' => 'spaghetti','parent'=>"shag"),

array('name' => 'MOHAMMADI','description' => ' ','slug' => 'mohammadi','parent'=>"handknotted"),

array('name' => ' LAYTON','description' => ' ','slug' => 'layton','parent'=>"outdoor"),
array('name' => 'LANDEN','description' => ' ','slug' => 'landen','parent'=>"outdoor"),

array('name' => 'HOME','description' => ' ','slug' => 'home','parent'=>"bathroom"),

array('name' => 'CUDDLES','description' => ' ','slug' => 'cuddles','parent'=>"childrens"),
array('name' => 'BRAZIL','description' => ' ','slug' => 'brazil','parent'=>"tribal")
);

/*  [Modern                                                           AMORE                                                       ] => 36
[Modern                                                           BERLIN                                                      ] => 42
[Shag                                                             BLOOM 2                                                     ] => 59
[Modern                                                           BOUNCE                                                      ] => 54
[Tribal                                                           BRAZIL                                                      ] => 8
[Clearance                                                        CABO                                                        ] => 35
[Traditional                                                      TLAY                                                        ] => 16
[Childrens                                                        CUDDLES                                                     ] => 16
[Modern                                                           DENVER                                                      ] => 3
[Modern                                                           DOLCE                                                       ] => 38
[Modern                                                           EBONY                                                       ] => 18
[Traditional                                                      ESFAHAN                                                     ] => 41
[Shag                                                             EVOLUTION                                                   ] => 95
[Clearance                                                        FLORYA                                                      ] => 67
[Bathroom                                                         HOME                                                        ] => 2
[Shag                                                             RISIS                                                       ] => 14
[Modern                                                           JORDAN                                                      ] => 19
[Traditional                                                      KIRMAN                                                      ] => 82
[Traditional                                                      KASHQAI                                                     ] => 13
[Outdoor                                                          LANDEN                                                      ] => 9
[Modern                                                           LAUREL                                                      ] => 15
[Outdoor                                                          LAYTON                                                      ] => 23
[Modern                                                           LONDON                                                      ] => 79
[Shag                                                             MAGNIFICENT                                                 ] => 15
[Modern                                                           MANHATTAN                                                   ] => 29
[Modern                                                           MAYFAIR                                                     ] => 68
[Modern                                                           MIAMI                                                       ] => 72
[Handknotted                                                      MOHAMMADI                                                   ] => 15
[Traditional                                                      NOBILITY                                                    ] => 61
[Shag                                                             PLUSH                                                       ] => 34
[Shag                                                             SPAGHETTI                                                   ] => 67
[Modern                                                           THE DESIGNER COLLECTION                                     ] => 147
[Traditional                                                      TASHKENT                                                    ] => 80
[Modern                                                           VENTUS                                                      ] => 73
[Clearance                                                        VIPER                                                       ] => 12
*/

foreach($sub_cats as $data) {

$parent=$category = get_term_by('slug',$data['parent'], 'product_cat');
$cid = wp_insert_term(
$data['name'], // the term
'product_cat', // the taxonomy
array(
'description'=> $data['description'],
'slug' => $data['slug'],
'parent' => $parent->term_id
)
);
}
}
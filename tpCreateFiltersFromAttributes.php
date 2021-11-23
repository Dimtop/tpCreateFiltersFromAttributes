<?php
/**
 * Plugin Name: TP Create Filters From Attrbiutes
 */


function createFilterPosts(){
    global $wpdb;
    $attributes =  wc_get_attribute_taxonomies();

    foreach ($attributes as $a=>$v){

        $existingFilters = $wpdb->get_results("SELECT * FROM wp_posts WHERE post_type='br_product_filter' AND post_name='". $v->attribute_name ."' AND post_status='publish'");

        if(count($existingFilters)>0){
            break;
        }
        $rows = $wpdb->insert("wp_posts", array(
            "ID" => NULL,
            "post_author" => 1,
            "post_date" =>  date("Y-m-d H:i:s")     ,
            "post_date_gmt" => date("Y-m-d H:i:s")  ,
            "post_content" => '',
            "post_title" => $v->attribute_label,
            "post_excerpt" => '' ,
            "post_status"=>"publish",
            "comment_status"=>"closed",
            "ping_status"=>"closed",
            "post_password"=>"",
            "post_name"=>$v->attribute_name,
            "to_ping"=>"",
            "pinged"=>"",
            "post_modified"=>date("Y-m-d H:i:s"),
            "post_modified_gmt"=>date("Y-m-d H:i:s"),
            "post_content_filtered"=>"",
            "post_parent"=>0,
            "guid"=>"",
            "menu_order"=>0,
            "post_type"=>"br_product_filter",
            "post_mime_type"=>"",
            "comment_count"=>0
        ));

    }
}

function createFilterMeta(){
    global $wpdb;

    $filters = $wpdb->get_results("SELECT * FROM wp_posts WHERE post_type='br_product_filter' AND post_status='publish'");
 

    foreach ($filters as $k=>$v){

        $filterData = array (
            'data' =>
                array (
                ),
            'br_wp_footer' => '',
            'widget_type' => 'filter',
            'reset_hide' => '',
            'title' => '',
            'filter_type' => 'attribute',
            'attribute' => 'pa_' . $v->post_name,
            'custom_taxonomy' => '',
            'type' => '',
            'select_first_element_text' => '',
            'operator' => 'OR',
            'order_values_by' => '',
            'order_values_type' => 'asc',
            'text_before_price' => '',
            'text_after_price' => '',
            'enable_slider_inputs' => '',
            'parent_product_cat' => '',
            'depth_count' => '',
            'widget_collapse_enable' => '',
            'widget_is_hide' => '1',
            'show_product_count_per_attr' => '',
            'hide_child_attributes' => '',
            'hide_collapse_arrow' => '',
            'use_value_with_color' => '',
            'values_per_row' => '',
            'icon_before_title' => '',
            'icon_after_title' => '',
            'icon_before_value' => '',
            'icon_after_value' => '',
            'price_values' => '',
            'description' => '',
            'css_class' => '',
            'use_min_price' => '',
            'min_price' => '',
            'use_max_price' => '',
            'max_price' => '',
            'height' => '',
            'scroll_theme' => '',
            'selected_area_show' => '',
            'hide_selected_arrow' => '',
            'selected_is_hide' => '',
            'slider_default' => '',
            'number_style' => '',
            'number_style_thousand_separate' => '',
            'number_style_decimal_separate' => '',
            'number_style_decimal_number' => '',
            'is_hide_mobile' => '',
            'user_can_see' => '',
            'cat_propagation' => '',
            'product_cat' => '',
            'parent_product_cat_current' => '',
            'attribute_count' => '',
            'version' => '1.0',
            'filter_title' => $v->post_title,
            'cat_value_limit' => '',
            'style' => 'checkbox',
            'widget_collapse' => 'with_arrow',
            'attribute_count_show_hide' => '',
        );
        $rows = $wpdb->insert("wp_postmeta", array(
            "meta_id" => NULL,
            "post_id" => $v->ID,
            "meta_key" =>  "br_product_filter"    ,
            "meta_value" => serialize($filterData)
        ));
        $rows1 = $wpdb->insert("wp_postmeta", array(
            "meta_id" => NULL,
            "post_id" => $v->ID,
            "meta_key" =>  "auxin-autop"    ,
            "meta_value" => "no"
        ));

    }

}

function createFiltersGroup(){
    global $wpdb;
    
    $filters = $wpdb->get_results("SELECT * FROM wp_posts WHERE post_type='br_product_filter' AND post_status='publish'");
    $filtersData = array (
        'data' =>
            array (
            ),
        'filters' =>
            array (

            ),
        'search_box_link_type' => '',
        'search_box_url' => '',
        'search_box_category' => '',
        'search_box_style' =>
            array (
                'position' => '',
                'search_position' => '',
                'search_text' => '',
                'background' => '',
                'back_opacity' => '',
                'button_background' => '',
                'button_background_over' => '',
                'text_color' => '',
                'text_color_over' => '',
            ),
        'custom_class' => '',
        'filters_data' =>
            array (

            ),
    );

    $existingGroup = $wpdb->get_results("SELECT * FROM wp_posts WHERE post_type='br_filters_group' AND post_name='Auto generated filters' AND post_status='publish'");


    if(count($existingGroup)==0){

        $group = $wpdb->insert("wp_posts", array(
            "ID" => NULL,
            "post_author" => 1,
            "post_date" =>  date("Y-m-d H:i:s")     ,
            "post_date_gmt" => date("Y-m-d H:i:s")  ,
            "post_content" => '',
            "post_title" => "Auto generated filters",
            "post_excerpt" => '' ,
            "post_status"=>"publish",
            "comment_status"=>"closed",
            "ping_status"=>"closed",
            "post_password"=>"",
            "post_name"=>"Auto generated filters",
            "to_ping"=>"",
            "pinged"=>"",
            "post_modified"=>date("Y-m-d H:i:s"),
            "post_modified_gmt"=>date("Y-m-d H:i:s"),
            "post_content_filtered"=>"",
            "post_parent"=>0,
            "guid"=>"",
            "menu_order"=>0,
            "post_type"=>"br_filters_group",
            "post_mime_type"=>"",
            "comment_count"=>0
        ));





        foreach ($filters as $k=>$v) {
            $filtersData["filters"][] = $v->ID;
            $filtersData["filters_data"][$v->ID] = array(
                'width'=>''
            );
        }

        $rows = $wpdb->insert("wp_postmeta", array(
            "meta_id" => NULL,
            "post_id" => $wpdb->insert_id,
            "meta_key" =>  "br_filters_group"    ,
            "meta_value" => serialize($filtersData)
        ));
        $rows1 = $wpdb->insert("wp_postmeta", array(
            "meta_id" => NULL,
            "post_id" =>  $wpdb->insert_id,
            "meta_key" =>  "auxin-autop"    ,
            "meta_value" => "no"
        ));
        $rows2 = $wpdb->insert("wp_postmeta", array(
            "meta_id" => NULL,
            "post_id" =>  $wpdb->insert_id,
            "meta_key" =>  "_wp_old_slug"    ,
            "meta_value" => "autoGeneratedFilters"
        ));

        print_r($wpdb->insert_id);

    }

}

function run(){
    createFilterPosts();
    createFilterMeta();
    createFiltersGroup();
}

add_action("wp_ajax_runFiltersGeneration", "run");
add_action("wp_ajax_nopriv_runFiltersGeneration", "run");



function tpcffaUI(){
    ?>
    <h3>Simply press run</h3>
    <button id="tpRun">Run</button>

    <script>
        jQuery("#tpRun").click(()=>{
            jQuery.ajax({
                type:"post",
                url:"<?php echo site_url(); ?>/wp-admin/admin-ajax.php",
                data:{
                    "action":"runFiltersGeneration"
                },
                success:(data)=>{
                    console.log(data)
                    location.reload();
                }
            })
        })
    </script>

<?php
}


function tpcffa(){
    add_menu_page(
        'TP Create Filters From Attrbiutes',
        'TP Create Filters From Attrbiutes Options',
        'manage_options',
        'tpcffa',
        'tpcffaUI',
        '',
        20
    );
}

add_action( 'admin_menu', 'tpcffa' );
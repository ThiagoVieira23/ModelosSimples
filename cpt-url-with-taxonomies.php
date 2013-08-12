<?php
class ClassPostTypeConvenio
{
    public function __construct()
    {
        add_action('init', array( &$this, 'initPostType' ));
        add_filter('post_type_link', array( &$this, 'post_type_link' ), 10, 2 );
        add_action( 'init', array( &$this, 'init' ));
    }
    function initPostType()
    {
        register_post_type( 'convenio',
            array(
                'labels' => array(
                    'name'               => 'Convenios',
                    'singular_name'      => 'Convenio',
                    'add_new'            => 'Adicionar novo convênio',
                    'add_new_item'       => 'Adicionar novo convênio',
                    'edit'               => 'Editar',
                    'edit_item'          => 'Editar convênio',
                    'new_item'           => 'Novo convênio',
                    'view'               => 'Ver',
                    'view_item'          => 'Ver convênio',
                    'search_items'       => 'Buscar convênio',
                    'not_found'          => 'Nenhuma convênio encontrado',
                    'not_found_in_trash' => 'Nenhuma convênio encontrado na lixeira',
                    'parent'             => 'Convênios'
                    ),

                'hierarchical'    => false,
                'public'          => true,
                'query_var'       => true,
                'rewrite'         => array('slug' => 'parceiros/%categoria_convenio%', 'with_front' => false),
                'menu_position'   => null,
                'supports'        => array( 'title','editor','thumbnail' ),
                'has_archive'     => true,
                'capability_type' => 'post'
                )
    );
    
    register_taxonomy('categoria_convenio',array('convenio'),
        array(
            'labels'  => array(
                'name'              => _x( 'Categorias dos Convenios', 'taxonomy general name' ),
                'singular_name'     => _x( 'Categoria dos Convenios', 'taxonomy singular name' ),
                'search_items'      =>  __( 'Buscar categoria' ),
                'all_items'         => __( 'Todas as categorias' ),
                'parent_item'       => __( 'Categoria Pai' ),
                'parent_item_colon' => __( 'Categori Pai:' ),
                'edit_item'         => __( 'Editar Categoria' ),
                'update_item'       => __( 'Atualizar Categoria' ),
                'add_new_item'      => __( 'Adicionar nova Categoria' ),
                'new_item_name'     => __( 'New Tag Name' )
                ),
            'public'        => true,
            'hierarchical'  => true,
            'show_ui'       => true,
            'query_var'     => true,
            'show_tagcloud' => false,
            'rewrite'       => array( 'slug' => 'parceiros', 'with_front' => false),
            ));
    
    }
    function post_type_link($post_link, $id = 0)
    {
        $post = get_post($id);
    
        if ( is_wp_error($post) || 'convenio' != $post->post_type || empty($post->post_name) )
            return $post_link;
    
        $terms = get_the_terms($post->ID, 'categoria_convenio');
    
        if( is_wp_error($terms) || !$terms ) {
            $grupo = 'desalocado';
        }
        else {
            $categoria_convenio_obj = array_pop($terms);
            $categoria_convenio = $categoria_convenio_obj->slug;
        }
    
        return home_url(user_trailingslashit( "parceiros/$categoria_convenio/$post->post_name" ));
    }
    
    function init() {
        add_rewrite_rule( '^parceiros$', 'index.php?post_type=convenio', 'top' );
    }
}

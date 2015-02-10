<?php
/*
Plugin Name: Wp CPT Jobs (Trabalhos)
Plugin URI: http://www.thiagopassamani.com.br/wordpress/wp-cpt-jobs/
Description: Plugin de Custom Post Types (CPT) desenvolvido para exibir "Trabalhos / Jobs" no Wordpress.
Version: 1.1
Author: Thiago Passamani
Author URI: http://www.thiagopassamani.com.br/	
*/ 

/* Diretorio Plugin */
define( 'WP_CPT_JOBS_URL_PLUGIN', plugin_dir_url( __FILE__ ) );

// Verifica à ação e evita acesso direto ao arquivo wp-cpt-jobs.php.
if ( ! function_exists( 'add_action' ) )
{   
    exit( '<h1>Arquivo não pode ser carregado diretamente.</h1>' );
}

// Aqui verificamos se a função não existe, para que possa ser executada e assim ativar o recurso de CPT "Jobs".
if ( ! function_exists( 'wp_cpt_jobs' ) ) :

    /**
     * Função que adiciona ao Wordpress uma nova opção para inserir "Jobs/Trabalhos",
     * utilizando CPT (Custom Post Types).
     * 
     * @package Wordpress
     * @author Thiago Passamani <thiagopassamani@gmail.com>
     * @example http://localhost/jobs 
     */
    function wp_cpt_jobs()
    {

        /**
         * Categoria e Tag - Personalizadas
         * @package Wordpress
         * @author Thiago Passamani <thiagopassamani@gmail.com>
         * @example http://localhost/jobs/tipo/cartão-de-visitas (Tipo)
         * @example http://localhost/jobs/marcador/post.html (Marcador)
         */

        // Titulos customizados para Tipo (Category)
        $labels_tipo =  array( // Labels customizadas
            'name'                => _x( 'Tipos de Job &lsaquo;', 'taxonomy general name' ),
            'singular_name'       => _x( 'Tipo de Job', 'taxonomy singular name' ),
            'search_items'        => __( 'Procurar tipo de Job' ),
            'all_items'           => __( 'Todos os tipos de Jobs' ),
            'parent_item'         => __( 'SubTipo' ),
            'parent_item_colon'   => __( 'SubTipo:' ),
            'edit_item'           => __( 'Editar Tipo' ),
            'update_item'         => __( 'Atualizar Tipo' ),
            'add_new_item'        => __( 'Adicionar novo tipo de Job'),
            'new_item_name'       => __( 'Novo Tipo de Job' ),
            'menu_name'           => __( 'Tipos de Job' ),
        );
        // URL personalizada
        $rewrite_tipo = array(
            'slug'                => 'jobs/tipo',
            'with_front'          => false,
        );
        // Registrado a Taxonomia "Tipo", compatível como Categoria
        register_taxonomy( 'jobs_category', array( 'tipo' ), array(
            'label'               => __( 'Tipo' ),
            'labels'              => $labels_tipo,
            'show_ui'             => true,
            'show_in_tag_cloud'   => true,
            'query_var'           => true,
            'hierarchical'        => true,
            'rewrite'             => $rewrite_tipo,
        ));
        register_taxonomy_for_object_type( 'jobs_category', 'jobs' );

        /**
         * Marcadores (Tags)
         * @package Wordpress
         * @author 
         */
        $labels_marcador =  array( // Labels customizadas
            'name'                => _x( 'Marcadores &lsaquo; Jobs', 'taxonomy general name' ),
            'singular_name'       => _x( 'Marcador', 'taxonomy singular name' ),
            'search_items'        => __( 'Procurar marcador de Job' ),
            'all_items'           => __( 'Todos os marcadores Jobs' ),
            'edit_item'           => __( 'Editar Marcador' ),
            'update_item'         => __( 'Atualizar Marcador' ),
            'add_new_item'        => __( 'Adicionar novo marcador'),
            'new_item_name'       => __( 'Novo Marcador' ),
            'menu_name'           => __( 'Marcadores' ),
        );
        /**
         * URL customizada para "Marcador".
         *
         * @package Wordpress
         * @author Thiago Passamani <thiagopassamani@gmail.com>
         */
        $rewrite_marcador = array(
            'slug'                => 'jobs/marcador',
            'with_front'          => false,
        );
        // Registrando a Taxonomia "Marcador", compatível como Tags
        register_taxonomy( 'jobs_tags', array( 'marcador' ), array(
            'label'               => __( 'Marcador' ),
            'labels'              => $labels_marcador,
            'show_ui'             => true,
            'show_in_tag_cloud'   => true,
            'query_var'           => true,
            'hierarchical'        => false,            
            'rewrite'             => $rewrite_marcador,
        ));
       
        register_taxonomy_for_object_type( 'jobs_tags', 'jobs' );

        /**
         * Textos para menu e opções personalizadas para o Wp CPT Jobs.
         *
         * @package Wordpress
         * @author Thiago Passamani <thiagopassamani@gmail.com>
         */
        $labels = array(
            'name'                => _x( 'Jobs', 'Post Type General Name' ),
            'singular_name'       => _x( 'Job', 'Post Type Singular Name'),
            'menu_name'           => __( 'Jobs' ),
            'parent_item_colon'   => __( 'Sub-Job' ),
            'all_items'           => __( 'Todos os Jobs' ),
            'view_item'           => __( 'Visualizar' ),
            'add_new_item'        => __( 'Adicionar Novo Job' ),
            'add_new'             => __( 'Novo Job' ),
            'edit_item'           => __( 'Editar Job' ),
            'update_item'         => __( 'Atualizar Job' ),
            'search_items'        => __( 'Procurar Job' ),
            'not_found'           => __( 'Não há Job cadastrado' ),
            'not_found_in_trash'  => __( 'Não há Job na lixeira' ),
        );

        /**
         * URL personalizada para Wp CPT Jobs. Método rewrite, altera a URL.
         *
         * @package Wordpress
         * @author Thiago Passamani <thiagopassamani@gmail.com>         
         * @example http://localhost/jobs
         */
        $rewrite = array(
            'slug'                => 'jobs',
            'with_front'          => false,
            'pages'               => true,
            'feeds'               => true,
        );

	
        /**
         * Argumentos de configuração da função register_post_type.
         * 
         * @package Wordpress
         * @author Thiago Passamani <thiagopassamani@gmail.com>
         */
        $args = array(
            'label'               => __( 'jobs' ),
            'description'         => __( 'Informações referentes a Trabalhos' ),
            'labels'              => $labels,
            'supports'            => array( 'title', 'editor', 'author', 'thumbnail', 'comments', 'revisions', 'tags', 'post-formats' ),
            'taxonomies'          => array( 'jobs_category', 'jobs_tags' ),  // Utiliza Categorias (Tipo) e Tags (Marcador) personalizada.
            'hierarchical'        => true,
            'public'              => true,
            'show_ui'             => true,
            'show_in_menu'        => true,
            'show_in_nav_menus'   => true,
            'show_in_admin_bar'   => true,
            'menu_position'       => 5,
            'menu_icon'           => plugins_url( 'img/jobs_16px.png', __FILE__ ), // Ícone personalizado
            'can_export'          => true,
            'has_archive'         => true,
            'exclude_from_search' => false,
            'publicly_queryable'  => true,
            'query_var'           => 'jobs',
            'rewrite'             => $rewrite,
            'capability_type'     => 'page',
        );

        // Adicionando os formatos de postagem para JOBS
        add_post_type_support( 'jobs', 'post-formats' );
        
        // Adiciona todos os formatos
        add_theme_support( 'post-formats',array( 'aside', 'gallery', 'link', 'image', 'quote', 'status', 'video', 'audio', 'chat' ) );
	
	   // Registrando nova Custom Post Type "Jobs" (Trabalhos).
	   register_post_type( 'jobs', $args );
	   
       // Refaz as regras do rewrite e assim mantem a URL personalizada.
	   flush_rewrite_rules();

    }
    // Iniciando função $wp_cpt_jobs e adicionando em 'init'.
    add_action( 'init', 'wp_cpt_jobs', 0 );

    /**
     * Função @jobs_thumbnail_list adiciona uma imagem de width: 128px height: 128px.
     *
     * @package Wordpress
     * @author Thiago Passamani <thiagopassamani@gmail.com>
     */ 
    function wp_cpt_jobs_thumbnail_list()
    {
      add_image_size( 'jobs-screen-thumbnail', 128, 128, true );
    }
    add_action( 'after_setup_theme', 'wp_cpt_jobs_thumbnail_list' );

        
    /**
     * Função @jobs_edit_columns edita as colunas acrescentando as colunas customizadas que serão inseridas
     * nas função @jobs_custom_columns.
     *
     * @package Wordpress
     * @author Thiago Passamani <thiagopassamani@gmail.com>
     */    
    function wp_cpt_jobs_edit_columns( $columns )
    {
      $position = 2;
      
      // separando o array, para inserir no meio.
      $after_columns = array_reverse( array_splice( array_reverse( $columns ), count( $columns )-$position ) );
      $before_columns = array_splice( $columns, $position );
      
      /**
       * Títulos das colunas personalizadas.
       *
       * @package Wordpress
       * @author Thiago Passamani <thiagopassamani@gmail.com>
       * @example Nome da Coluna => Título da Colina
       */
      $custom_news_columns = array(
        "description"           => "Descrição",
        "thumbnail"             => "Imagem",
        "jobs_category"         => "Tipos",
        "jobs_tags"             => "Marcadores",
      );
    
      $columns = array_merge( $after_columns, $custom_news_columns, $before_columns );
    
      return $columns;
    }    
    // Adicionando filtro para Custom Post Type Jobs
    add_filter( 'manage_edit-jobs_columns', 'wp_cpt_jobs_edit_columns',10, 1 );
  
    /**
     * Adicionando os filtros para exibir conteúdo nas colunas.
     *
     * @package Wordpress
     * @author Thiago Passamani <thiagopassamani@gmail.com>
     */
    function wp_cpt_jobs_custom_columns( $column )
    {
      global $post;
    
      if ( $post->post_type == "jobs" )
      {
        switch ( $column ){

          case "description" :
            the_excerpt();
          break;
        
          case "jobs_category" :
            echo get_the_term_list( $post->ID, 'jobs_category', '', ', ','' );
          break;
      
          case "jobs_tags" :
            echo get_the_term_list( $post->ID, 'jobs_tags', '', ', ','' );
          break;  

          case 'thumbnail' :
            if ( get_the_post_thumbnail(null) ) :
                echo get_the_post_thumbnail( $post->ID, 'jobs-screen-thumbnail' );
            else :
                echo '<img src="'. plugins_url( 'img/no-image.png', __FILE__ ).'" alt="Não há imagem anexada" />';
            endif;
          break;

          default:
          break;    
        }
      }
    }
    add_action( 'manage_jobs_posts_custom_column', 'wp_cpt_jobs_custom_columns' );  

    /**
     * Função altera o icone do título do plugin Wp CPT JObs.
     *
     * @package Wordpress
     * @author Thiago Passamani <thiagopassamani@gmail.com>
     */
    function wp_cpt_jobs_icons()
    {
      echo '<style type="text/css" media="screen">';
      echo '#icon-edit.icon32-posts-jobs {background: url('. plugins_url( 'img/jobs_32px.png', __FILE__ ) .') no-repeat !important;}';
      echo '</style>';
    }
    // Adicionando função
    add_action( 'admin_head', 'wp_cpt_jobs_icons' );

    /**
     * Adicionando contexto de ajuda (help) ao Wp CPT Jobs.
     *
     * @package Wordpress
     * @author Thiago Passamani <thiagopassamani@gmail.com>
     */
    function wp_cpt_jobs_help_text( $contextual_help, $screen_id, $screen )
    {
      if ( 'jobs' == $screen->id )
      {
        $contextual_help    = '<p>Este é um texto de ajuda ao nosso tipo de post Filme que aparece na página de edição.</p>';
        $contextual_help   .= '<p>Você pode criar o texto que quiser aqui</p>';
        $contextual_help   .= '<p><strong>Plugin:</strong> Wp CPT Jobs / <strong>Criado por</strong> <a href="http://www.thiagopassamani.com.br/" title="Site">Thiago Passamani</a></p>';
      }
      elseif ( 'edit-jobs' == $screen->id )
      {
        $contextual_help    = '<p>A opção de "Jobs" foi criada através do plugin Wp CPT Jobs (Trabalhos) por Thiago Passamani.</p>';
        $contextual_help   .= '<p>Esse plugin tem o intuito de agregar uma nova entrada de informações segmetando as inclusões no Wordpress.</p>';
        $contextual_help   .= '<p><strong>Plugin:</strong> Wp CPT Jobs / <strong>Criado por</strong> <a href="http://www.thiagopassamani.com.br/" title="Site">Thiago Passamani</a></p>';
      }
      return $contextual_help;
    }
    // Adicionando ao contexto de help a função $jobs_help_text.
    add_action( 'contextual_help', 'wp_cpt_jobs_help_text', 10, 3 );  

    /**
     * Função @wp_cpt_jobs_widget_dashboard_text() monta a Widget que será exibida na dashboard administrativa do Wordpress. 
     * 
     * @package Wordpress
     * @author Thiago Passamani <thiagopassamani@gmail.com>
     */
    function wp_cpt_jobs_widget_dashboard_text()
    {

        global $wpdb, $table_prefix;

        $query_dash_jobs = "
            SELECT COUNT(*) AS Jobs,
                (SELECT COUNT(". $wpdb->prefix ."comments.comment_ID) FROM ". $wpdb->prefix ."posts INNER JOIN ". $wpdb->prefix ."comments ON(". $wpdb->prefix ."posts.ID = ". $wpdb->prefix ."comments.comment_post_ID) WHERE ". $wpdb->prefix ."posts.post_type = 'jobs' AND ". $wpdb->prefix ."posts.post_status = 'publish') AS Comments,
                (SELECT COUNT(*) FROM ". $wpdb->prefix ."term_taxonomy WHERE ". $wpdb->prefix ."term_taxonomy.taxonomy = 'jobs_category') AS Tipos,
                (SELECT COUNT(*) FROM ". $wpdb->prefix ."term_taxonomy WHERE ". $wpdb->prefix ."term_taxonomy.taxonomy = 'jobs_tags') AS Marcadores
            FROM ". $wpdb->prefix ."posts WHERE ". $wpdb->prefix ."posts.post_type = 'jobs' AND ". $wpdb->prefix ."posts.post_status = 'publish';";

        $dash_jobs = $wpdb->get_results( $query_dash_jobs );

        if ( $dash_jobs > 0 )
        {

            echo '<img src="'. plugins_url( 'img/jobs_32px.png', __FILE__ ) .'" atl="Plugin Wp_CPT_Jobs_Widget" style="float:left;margin:0 5px" />';
            echo '<p>Essa é a Dashboard do Jobs (Custom Post Type) ativado pelo plugin instalado no Wordpress.</p>';

            foreach( $dash_jobs as $dash_job )
            {
                echo '<div class="table table_content"><table><tbody>';
                echo '<tr><td><h4><a href="'. admin_url( 'edit.php?post_type=jobs' ) .'" title="Jobs"><strong>'. $dash_job->Jobs .'</strong> - Jobs</a></h4></td></tr>';
                echo '<tr><td><h4><a href="'. admin_url( 'edit-comments.php' ) .'"><strong>'. $dash_job->Comments .'</strong> - Comentários (Jobs)</a></h4></td></tr>';
                echo '<tr><td><h4><a href="'. admin_url( 'edit-tags.php?taxonomy=jobs_category&post_type=jobs' ).'" title="Tipos de Jobs"><strong>'. $dash_job->Tipos .'</strong> - Tipos de Jobs</a></h4></td></tr>';
                echo '<tr><td><h4><a href="'. admin_url( 'edit-tags.php?taxonomy=jobs_tags&post_type=jobs' ).'" title="Marcadores"><strong>'. $dash_job->Marcadores .'</strong> - Marcadores</a></h4></td></tr>';
                echo '</tbody></table></div>';
            };

            echo '<p>Criando por <a href="http://www.thiagopassamani.com.br/" title="Thiago Passamani" target="_blank">Thiago Passamani</a>';
        }
        else
        {
            echo '<p>Nenhum informação cadastrada!</p>';
        }
    }
    
    /**
     * Função @wp_cpt_jobs_add_widget_dashboard() ativa a Widget montada na função @wp_cpt_jobs_widget_dashboard_text().
     *
     * @package Wordpress
     * @author Thiago Passamani <thiagopassamani@gmail.com>
     */
    function wp_cpt_jobs_add_widget_dashboard()
    {
        wp_add_dashboard_widget( 'dashboard_widget', 'Jobs (Dashboard)', 'wp_cpt_jobs_widget_dashboard_text' );
    }
    // Registra a nova widget na dashboard
    add_action( 'wp_dashboard_setup', 'wp_cpt_jobs_add_widget_dashboard' );

    /**
     * Função @wp_cpt_jobs_rewrite_rules() modifica as regras do rewrite para aceita (.html).
     *
     * @package Wordpress
     * @author Thiago Passamani <thiagopassamani@gmail.com>
     */
    function wp_cpt_jobs_rewrite_rules($rules)
    {
        $new_rules = array();
        
        foreach (get_post_types() as $t)
            
        $new_rules[$t . '/(.+?)\.html$'] = 'index.php?post_type=' . $t . '&name=$matches[1]';
        
        return $new_rules + $rules;
    }
    add_action('rewrite_rules_array', 'wp_cpt_jobs_rewrite_rules');

    /**
     * Função @wp_cpt_jobs_custom_post_permalink() altera o endereço.
     *
     * @package Wordpress
     * @author Thiago Passamani <thiagopassamani@gmail.com>
     */
    function wp_cpt_jobs_custom_post_permalink ($post_link)
    {
        global $post;
    
        $type = get_post_type($post->ID);
    
        return home_url() . '/' . $type . '/' . $post->post_name . '.html';
    }
    add_filter('post_type_link', 'wp_cpt_jobs_custom_post_permalink');

    /**
     * Função @wp_cpt_jobs_remove_redirect_canonical() redireciona a URL alterada.
     *
     * @package Wordpress
     * @author Thiago Passamani <thiagopassamani@gmail.com>
     */
    function wp_cpt_jobs_remove_redirect_canonical($redirect_url)
    {
        return false;
    }
    add_filter('redirect_canonical', 'wp_cpt_jobs_remove_redirect_canonical');

    /**
    * Função @wp_cpt_jobs_submenu_page() Adiciona Custom Menu ao Jobs.
    */
    function wp_cpt_jobs_submenu_page()
    {
        echo '<h1>Partifipantes dos Jobs</h1>';
    
        wp_list_authors('post_type=jobs&show_fullname=1&optioncount=1&orderby=post_count&order=DESC&number=3&hide_empty=true');
        // http://localhost/demo/wp-admin/edit.php?post_type=jobs&author=1
    }

    function wp_cpt_jobs_register_submenu()
    {
        add_submenu_page( 'edit.php?post_type=jobs', 'Estatísticas &lsaquo; Jobs', 'Estatísticas', 'manage_options', 'jobs-statistic', 'wp_cpt_jobs_submenu_page' ); 
    }
    add_action('admin_menu', 'wp_cpt_jobs_register_submenu');

endif;
<?php
/*
Plugin Name: Wp CPT Jobs (Widgets)
Plugin URI: http://www.thiagopassamani.com.br/wordpress/wp-cpt-jobs-widgets/
Description: Plugin para ativar Widgets para Wp CPT Jobs, trabalho em conjunto com o de Custom Post Types (CPT).
Version: 0.5
Author: Thiago Passamani
Author URI: http://www.thiagopassamani.com.br/	
*/ 

// Verifica à ação e evita acesso direto ao arquivo wp-cpt-jobs-widgets.php.
if ( ! function_exists( 'add_action' ) )
{   
    exit( '<h1>Arquivo não pode ser carregado diretamente.</h1>' );
}

// Aqui verificamos se a função $wp_cpt_jobs() existe, para ativar o plugin das Widgets.
if ( ! function_exists( 'wp_cpt_jobs' ) ) :

	class Wp_CPT_Jobs_Widget extends WP_Widget
	{

		// Construtor
		public function Wp_CPT_Jobs_Widget()
		{
			parent::WP_Widget( false, $name = 'Tipos de Jobs' );
		}
	
		/**
		 * Exibição final do Widget (já no sidebar)
	 	 *
	 	 * @package Wordpress, Wp CPT Jobs Widget
	 	 * @author Thiago Passamani <thiagopassamani@gmail.com>	 	 	 	 
	 	 * @param array $args Argumentos passados para o widget
	 	 * @param array $instance Instância do widget
	 	 */
		public function widget( $args, $instance )
		{	
			// Argumentos para filtrar a taxonomia "Tipos de Jobs".
			$args = array(
				'orderby'            => 'name',
				'order'              => 'ASC',
				'style'              => 'list',
				'show_count'         => 1,
				'hide_empty'         => 0,
				'use_desc_for_title' => 1,
				'child_of'           => 0,
				'hierarchical'       => 1,
				'title_li'			 => '', // __( 'Tipos de Jobs' )
				'show_option_none'   => __( 'Nenhum tipo cadastrado!' ),
				'taxonomy'           => 'jobs_category'
			);
		
			// Exibe o HTML do Widget
			echo $args['before_widget'];

			echo $args['before_title'] . $args['widget_name'] . $args['after_title'];

			echo '<h3 class="widget-title wp-cpt-jobs-widgets plugin-custom">Tipos de Jobs</h3>';
			echo '<ul class="wp-cpt-jobs-widgets plugin-custom">'; 
			echo wp_list_categories( $args );
			echo '</ul>';

			echo $args['after_widget'];
		}
	
		/**
		 * Salva os dados do widget no banco de dados
	 	 *
	 	 * @package Wordpress, Wp CPT Jobs Widget
	 	 * @author Thiago Passamani <thiagopassamani@gmail.com>	 	 	 	 
	 	 * @param array $new_instance Os novos dados do widget (a serem salvos)
	  	 * @param array $instance_old Os dados antigos do widget
	 	 * 
	   	 * @return array $instance Dados atualizados a serem salvos no banco de dados
	 	 */
		public function update( $new_instance, $instance_old )
		{
			$instance = array_merge( $instance_old, $new_instance );
			
			return $instance;
		}
	
		/**
	 	 * Formulário para os dados do widget (exibido no painel de controle)
	 	 *
	 	 * @package Wordpress, Wp CPT Jobs Widget
	 	 * @author Thiago Passamani <thiagopassamani@gmail.com>	 	 
	 	 * @param array $instance Instância do widget
	 	 */
		public function form( $instance )
		{
			echo '<img src="'. plugins_url( 'img/jobs_32px.png', __FILE__ ) .'" atl="Plugin Wp_CPT_Jobs_Widget" style="float:left;margin:0 5px" />';
			echo '<p>Se o plugin Wp CPT Jobs (Custom Post Type) estiver ativo, será exivida a listagem da taxonomia "tipo".</p>';
			echo '<p>Criando por <a href="http://www.thiagopassamani.com.br/" title="Thiago Passamani" target="_blank">Thiago Passamani</a>';
		}

	}

	/**
	 * Adicionando a class Wp_CPT_Jobs_Widget, registrando a widget "Wp_CPT_Jobs_Widget".
	 *
	 * @package Wordpress, Wp CPT Jobs Widget
	 * @author Thiago Passamani <thiagopassamani@gmail.com>
	 */
	add_action( 'widgets_init', create_function( '', 'return register_widget("Wp_CPT_Jobs_Widget");' ) );

else :

	echo '<p>Plugin Wp CPT Jobs (Trabalhos) não está ativo, ative-o e tente ativar novamente o plugin Wp CPT Jobs (Widgets).';

endif;
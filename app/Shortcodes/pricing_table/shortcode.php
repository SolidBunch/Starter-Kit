<?php
/**
 * Pricing Table Shortcode
 *
 */

use StarterKit\Base\Shortcode;
use StarterKit\Helper\View;

if ( ! class_exists( 'StarterKitShortcode_Pricing_Table' ) ) {
	class StarterKitShortcode_Pricing_Table extends Shortcode {
		
		public function content( $atts, $content = null ) {
			
			$this->content = $content;
			
			$this->atts = shortcode_atts( [
				'columns'                 => '',
				'border_color'            => '',
				'header_bg_color'         => '',
				'header_text_color'       => '',
				'button_bg_color'         => '',
				'button_hover_bg_color'   => '',
				'button_text_color'       => '',
				'button_hover_text_color' => '',
				'button_border_color'     => '',
				'border_radius'           => '',
				'border_width'            => '',
				'button_border_width'     => '',
				'el_classes'              => '',
				'el_id'                   => '',
			
			], $this->atts( $atts ), $this->shortcode );
			
			\StarterKit\Helper\Assets::enqueue_style_dist(
				$this->shortcode . '-style',
				'shortcode-pricing_table.css'
			);
			
			$columns = $this->getColumsData();
			
			$data = $this->data( [
				'atts'    => $atts,
				'content' => $content,
				'columns' => $columns
			] );
			
			return View::load( '/view/view', $data, true, $this->shortcode_dir );
		}
		
		/**
		 * Get columns data
		 *
		 * @return array
		 */
		protected function getColumsData() {
			$pricing_columns = $this->param_group_parse_atts( $this->atts['columns'] );
			
			$columns = [];
			
			foreach ( $pricing_columns as $column ) {
				$columns[] = [
					'title'        => $column['title'],
					'features'     => $column['features'],
					'currency'     => $column['currency'],
					'price'        => $column['price'],
					'period'       => $column['period'],
					'button_url'   => $column['button_url'],
					'button_title' => $column['button_title']
				];
			}
			
			return $columns;
		}
		
	}
}

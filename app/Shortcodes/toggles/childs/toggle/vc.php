<?php

/**
 * Toggle Child / VC Support
 **/

if ( class_exists( 'WPBakeryShortCode' ) ) {
	class WPBakeryShortCode_Toggle extends WPBakeryShortCode {
		
		protected function content( $atts, $content = null ) {
			
			$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
			
			return Starter_Kit()->getShortcodesManager()->content( $this->settings['base'], $atts, $content );
		}
		
	}
}
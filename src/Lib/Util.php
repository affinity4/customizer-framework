<?php declare(strict_types=1);

namespace CustomizerFramework\Lib;

defined( 'ABSPATH' ) || exit;

/**
 * Customizer Framework Utilities.
 *
 * @since   1.0.0
 * @version 1.0.0
 */
final class Util
{
	/**
	 * Returns all the pages.
	 *
	 * @since 1.0.0
	 *
	 * @return array
	 */
	public static function _get_pages() {
		$args = array(
			'post_type'			=> 'page',
			'post_status'		=> 'publish',
			'order'				=> 'desc',
			'posts_per_page'	=> -1
		);
		$query = new \WP_Query( $args );
		$data = wp_list_pluck( $query->posts, 'post_title', 'ID' );
		wp_reset_postdata();
		return $data;
	}

	/**
	 * Returns all the posts.
	 *
	 * @since 1.0.0
	 *
	 * @return array
	 */
	public static function _get_posts() {
		$args = array(
			'post_type'			=> 'post',
			'post_status'		=> 'publish',
			'order'				=> 'desc',
			'posts_per_page'	=> -1
		);
		$query = new \WP_Query( $args );
		$data = wp_list_pluck( $query->posts, 'post_title', 'ID' );
		wp_reset_postdata();
		return $data;
	}

	/**
	 * Gets all post in custom post type
	 *
	 * @since 1.0.0
	 *
	 * @param  string    $post_type     the name of custom post type
	 * @return array     returns the post id and post title
	 */
	public static function _get_post( $post_type = '' ) {
		if ( ! empty( $post_type ) ) {
			$args = array(
				'post_type'			=> $post_type,
				'post_status'		=> 'publish',
				'order'				=> 'desc',
				'posts_per_page'	=> -1
			);
			$query = new \WP_Query( $args );
			$data = wp_list_pluck( $query->posts, 'post_title', 'ID' );
			wp_reset_postdata();
			return $data;
		} else {
			\CustomizerFramework\alert_warning( 'Fatal Error 400: empty parameter in '. \CustomizerFramework\code( 'info', __CLASS__ . '::_get_post_type' ) .' must provide a custom post type.' );
			return [];
		}
	}

	/**
	 * Returns all the taxonomy name and slug.
	 *
	 * @since 1.0.0
	 *
	 * @return array
	 */
	public static function _get_taxonomies() {
		return get_taxonomies();
	}

	/**
	 * Returns all the post type title and slug.
	 *
	 * @since 1.0.0
	 *
	 * @return array
	 */
	public static function _get_post_types() {
		return get_post_types();
	}

	/**
	 * Returns set of color to be used in color-set control.
	 *
	 * @since 1.0.0
	 *
	 * @param  string  $type  Containing the type of color based in $valid_type.
	 * @return array
	 */
	public static function _get_material_colors( $type = '' ) {
		$valid_type = [ 'all', 'primary', 'a100', 'a200', 'a400', 'a700', 'red', 'pink', 'purple', 'deepPurple', 'indigo', 'lightBlue', 'cyan', 'teal', 'green', 'lightGreen', 'lime', 'yellow', 'amber', 'orange', 'deepOrange', 'brown', 'grey', 'blueGrey' ];

		$all = [ '#ffebee', '#ffcdd2', '#ef9a9a', '#e57373','#ef5350','#f44336','#e53935','#d32f2f','#c62828','#b71c1c','#ff8a80','#ff5252','#ff1744','#d50000', '#fce4ec', '#f8bbd0', '#f48fb1', '#f06292', '#ec407a', '#e91e63', '#d81b60', '#c2185b', '#ad1457', '#880e4f', '#ff80ab', '#ff4081', '#f50057', '#c51162', '#f3e5f5', '#e1bee7', '#ce93d8', '#ba68c8', '#ab47bc', '#9c27b0', '#8e24aa', '#7b1fa2', '#6a1b9a', '#4a148c', '#ea80fc', '#e040fb', '#d500f9', '#aa00ff', '#ede7f6', '#d1c4e9', '#b39ddb', '#9575cd', '#7e57c2', '#673ab7', '#5e35b1', '#512da8', '#4527a0', '#311b92', '#b388ff', '#7c4dff', '#651fff', '#6200ea', '#e3f2fd', '#bbdefb', '#90caf9', '#90caf9', '#42a5f5', '#2196f3', '#1e88e5', '#1976d2', '#1565c0', '#0d47a1', '#82b1ff', '#448aff', '#2979ff', '#2962ff', '#e1f5fe', '#b3e5fc', '#81d4fa', '#4fc3f7', '#29b6f6', '#03a9f4', '#039be5', '#0288d1', '#0277bd', '#01579b', '#80d8ff', '#40c4ff', '#00b0ff', '#0091ea', '#e0f7fa', '#b2ebf2', '#80deea', '#4dd0e1', '#26c6da', '#00bcd4', '#00acc1', '#0097a7', '#00838f', '#006064', '#84ffff', '#18ffff', '#00e5ff', '#00b8d4', '#e0f2f1', '#b2dfdb', '#80cbc4', '#4db6ac', '#26a69a', '#009688', '#00897b', '#00796b', '#00695c', '#004d40', '#a7ffeb', '#64ffda', '#1de9b6', '#00bfa5', '#e8f5e9', '#c8e6c9', '#a5d6a7', '#81c784', '#66bb6a', '#4caf50', '#43a047', '#388e3c', '#2e7d32', '#1b5e20', '#b9f6ca', '#69f0ae', '#00e676', '#00c853', '#f1f8e9', '#dcedc8', '#c5e1a5', '#aed581', '#9ccc65', '#8bc34a', '#7cb342', '#689f38', '#558b2f', '#33691e', '#ccff90', '#ccff90', '#76ff03', '#64dd17', '#f9fbe7', '#f0f4c3', '#e6ee9c', '#dce775', '#d4e157', '#cddc39', '#c0ca33', '#afb42b', '#9e9d24', '#827717', '#f4ff81', '#eeff41', '#c6ff00', '#aeea00', '#fffde7', '#fff9c4', '#fff59d', '#fff176', '#ffee58', '#ffeb3b', '#fdd835', '#fbc02d', '#f9a825', '#f57f17', '#ffff8d', '#ffff00', '#ffea00', '#ffd600', '#fff8e1', '#ffecb3', '#ffe082', '#ffd54f', '#ffca28', '#ffc107', '#ffb300', '#ffa000', '#ff8f00', '#ff6f00', '#ffe57f', '#ffd740', '#ffc400', '#ffab00', '#fff3e0', '#ffe0b2', '#ffcc80', '#ffb74d', '#ffa726', '#ff9800', '#fb8c00', '#f57c00', '#ef6c00', '#e65100', '#ffd180', '#ffab40', '#ff9100', '#ff6d00', '#fbe9e7', '#ffccbc', '#ffab91', '#ff8a65', '#ff7043', '#ff5722', '#f4511e', '#e64a19', '#d84315', '#bf360c', '#ff9e80', '#ff9e80', '#ff3d00', '#dd2c00', '#efebe9', '#d7ccc8', '#bcaaa4', '#a1887f', '#8d6e63', '#795548', '#6d4c41', '#5d4037', '#4e342e', '#3e2723', '#fafafa', '#f5f5f5', '#eeeeee', '#e0e0e0', '#bdbdbd', '#9e9e9e', '#757575', '#616161', '#424242', '#212121',  '#eceff1', '#cfd8dc', '#b0bec5', '#90a4ae', '#78909c', '#607d8b', '#546e7a', '#455a64', '#37474f', '#263238' ];

		if ( ! empty( $type ) ) {
			if ( in_array( $type, $valid_type ) ) {

				switch ( $type ) {
					case 'all':
						$output = $all;
						break;
					case 'primary':
						$output = [ '#f44336', '#e91e63', '#9c27b0', '#673ab7', '#3f51b5', '#2196f3', '#03a9f4', '#00bcd4', '#009688', '#4caf50', '#8bc34a', '#cddc39', '#ffeb3b', '#ffc107', '#ff9800', '#ff5722', '#795548', '#9e9e9e', '#607d8b' ];
						break;
					case 'a100':
						$output = [ '#ff8a80', '#ff80ab', '#ea80fc', '#b388ff', '#8c9eff', '#82b1ff', '#80d8ff', '#84ffff', '#a7ffeb', '#b9f6ca', '#ccff90', '#f4ff81', '#ffff8d', '#ffe57f', '#ffd180', '#ff9e80' ];
						break;
					case 'a200':
						$output = [ '#ff5252', '#ff4081', '#e040fb', '#7c4dff', '#536dfe', '#448aff', '#40c4ff', '#18ffff', '#64ffda', '#69f0ae', '#b2ff59', '#eeff41', '#ffff00', '#ffd740', '#ffab40', '#ff6e40' ];
						break;
					case 'a400':
						$output = [ '#ff1744', '#f50057', '#d500f9', '#651fff', '#3d5afe', '#2979ff', '#00b0ff', '#00e5ff', '#1de9b6', '#00e676', '#76ff03', '#c6ff00', '#ffea00', '#ffc400', '#ff9100', '#ff3d00', ];
						break;
					case 'a700':
						$output = [ '#d50000', '#c51162', '#aa00ff', '#6200ea', '#304ffe', '#2962ff', '#0091ea', '#00b8d4', '#00bfa5', '#00c853', '#64dd17', '#aeea00', '#ffd600', '#ffab00', '#ff6d00', '#dd2c00' ];
						break;
					case 'red':
						$output = [ '#ffebee', '#ffcdd2', '#ef9a9a', '#e57373','#ef5350','#f44336','#e53935','#d32f2f','#c62828','#b71c1c','#ff8a80','#ff5252','#ff1744','#d50000' ];
						break;
					case 'pink':
						$output = [ '#fce4ec', '#f8bbd0', '#f48fb1', '#f06292', '#ec407a', '#e91e63', '#d81b60', '#c2185b', '#ad1457', '#880e4f', '#ff80ab', '#ff4081', '#f50057', '#c51162' ];
						break;
					case 'purple':
						$output = [ '#f3e5f5', '#e1bee7', '#ce93d8', '#ba68c8', '#ab47bc', '#9c27b0', '#8e24aa', '#7b1fa2', '#6a1b9a', '#4a148c', '#ea80fc', '#e040fb', '#d500f9', '#aa00ff' ];
						break;
					case 'deepPurple':
						$output = [ '#ede7f6', '#d1c4e9', '#b39ddb', '#9575cd', '#7e57c2', '#673ab7', '#5e35b1', '#512da8', '#4527a0', '#311b92', '#b388ff', '#7c4dff', '#651fff', '#6200ea' ];
						break;
					case 'indigo':
						$output = [ '#e3f2fd', '#bbdefb', '#90caf9', '#90caf9', '#42a5f5', '#2196f3', '#1e88e5', '#1976d2', '#1565c0', '#0d47a1', '#82b1ff', '#448aff', '#2979ff', '#2962ff' ];
						break;
					case 'lightBlue':
						$output = [ '#e1f5fe', '#b3e5fc', '#81d4fa', '#4fc3f7', '#29b6f6', '#03a9f4', '#039be5', '#0288d1', '#0277bd', '#01579b', '#80d8ff', '#40c4ff', '#00b0ff', '#0091ea' ];
						break;
					case 'cyan':
						$output = [ '#e0f7fa', '#b2ebf2', '#80deea', '#4dd0e1', '#26c6da', '#00bcd4', '#00acc1', '#0097a7', '#00838f', '#006064', '#84ffff', '#18ffff', '#00e5ff', '#00b8d4' ];
						break;
					case 'teal':
						$output = [ '#e0f2f1', '#b2dfdb', '#80cbc4', '#4db6ac', '#26a69a', '#009688', '#00897b', '#00796b', '#00695c', '#004d40', '#a7ffeb', '#64ffda', '#1de9b6', '#00bfa5' ];
						break;
					case 'green':
						$output = [ '#e8f5e9', '#c8e6c9', '#a5d6a7', '#81c784', '#66bb6a', '#4caf50', '#43a047', '#388e3c', '#2e7d32', '#1b5e20', '#b9f6ca', '#69f0ae', '#00e676', '#00c853' ];
						break;
					case 'lightGreen':
						$output = [ '#f1f8e9', '#dcedc8', '#c5e1a5', '#aed581', '#9ccc65', '#8bc34a', '#7cb342', '#689f38', '#558b2f', '#33691e', '#ccff90', '#ccff90', '#76ff03', '#64dd17' ];
						break;
					case 'lime':
						$output = [ '#f9fbe7', '#f0f4c3', '#e6ee9c', '#dce775', '#d4e157', '#cddc39', '#c0ca33', '#afb42b', '#9e9d24', '#827717', '#f4ff81', '#eeff41', '#c6ff00', '#aeea00' ];
						break;
					case 'yellow':
						$output = [ '#fffde7', '#fff9c4', '#fff59d', '#fff176', '#ffee58', '#ffeb3b', '#fdd835', '#fbc02d', '#f9a825', '#f57f17', '#ffff8d', '#ffff00', '#ffea00', '#ffd600' ];
						break;
					case 'amber':
						$output = [ '#fff8e1', '#ffecb3', '#ffe082', '#ffd54f', '#ffca28', '#ffc107', '#ffb300', '#ffa000', '#ff8f00', '#ff6f00', '#ffe57f', '#ffd740', '#ffc400', '#ffab00' ];
						break;
					case 'orange':
						$output = [ '#fff3e0', '#ffe0b2', '#ffcc80', '#ffb74d', '#ffa726', '#ff9800', '#fb8c00', '#f57c00', '#ef6c00', '#e65100', '#ffd180', '#ffab40', '#ff9100', '#ff6d00' ];
						break;
					case 'deepOrange':
						$output = [ '#fbe9e7', '#ffccbc', '#ffab91', '#ff8a65', '#ff7043', '#ff5722', '#f4511e', '#e64a19', '#d84315', '#bf360c', '#ff9e80', '#ff9e80', '#ff3d00', '#dd2c00' ];
						break;
					case 'brown':
						$output = [ '#efebe9', '#d7ccc8', '#bcaaa4', '#a1887f', '#8d6e63', '#795548', '#6d4c41', '#5d4037', '#4e342e', '#3e2723' ];
						break;
					case 'grey':
						$output = [ '#fafafa', '#f5f5f5', '#eeeeee', '#e0e0e0', '#bdbdbd', '#9e9e9e', '#757575', '#616161', '#424242', '#212121' ];
						break;
					case 'blueGrey':
						$output = [ '#eceff1', '#cfd8dc', '#b0bec5', '#90a4ae', '#78909c', '#607d8b', '#546e7a', '#455a64', '#37474f', '#263238' ];
						break;
				}

			} else {
				\CustomizerFramework\alert_warning( 'Fatal Error 350: invalid material argument in '. \CustomizerFramework\code( 'error', '_get_material_color ' ) .' here are the list of valid arguments '. \CustomizerFramework\code( 'info', 'all, primary, a100, a200, a400, a700, red, pink, purple, deepPurple, indigo, lightBlue, cyan, teal, green, lightGreen, lime, yellow, amber, orange, deepOrange, brown, grey, blueGrey') .'.' );
				$output = [];
			}
		} else {
			$output = $all;
		}
		return $output;
	}
}

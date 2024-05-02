<?php declare(strict_types=1);

namespace CustomizerFramework\Control;

defined( 'ABSPATH' ) || exit;

/**
 * Dropdown Page Control.
 *
 * @since   1.0.0
 * @version 1.0.0
 */
final class Dropdown_Page_Control extends \WP_Customize_Control
{
	/**
	 * Set the order of page.
	 *
	 * @since 1.0.0
	 *
	 * @var string
	 */
	public $order;


	/**
	 * Get all pages.
	 *
	 * @since 1.0.0
	 *
	 * @return object
	 */
	protected function get_page_data() {
		$order = $this->order;
		if ( empty( $order ) ) {
			$order = 'asc';
		}

		$args = array(
			'post_type'			=> 'page',
			'post_status'		=> 'publish',
			'order'				=> $order,
			'posts_per_page'	=> -1
		);
		$query = new \WP_Query( $args );
		$data  = $query->posts;
		return $data;
	}


	/**
	 * Render the page dropdown controller and display in frontend.
	 *
	 * @since 1.0.0
	 *
	 * @return html
	 */
	public function render_content() {
	?>
		<div class="customizer-framework--dropdown-page-parent">
			<label>
				<?php if ( ! empty( $this->label ) ): ?>
					<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
				<?php endif; ?>

				<?php if ( ! empty( $this->description ) ): ?>
					<span class="description customize-control-description"><?php echo wp_kses_post( $this->description ); ?></span>
				<?php endif; ?>
			</label>

			<select class="customizer-framework--dropdown-page"
					id="<?php echo  esc_attr( $this->id ); ?>"
					name="<?php echo esc_attr( $this->id ); ?>"
					<?php $this->link(); ?>>

				<?php if ( ! empty( $this->get_page_data() ) ): ?>
					<?php foreach ( $this->get_page_data() as $value ): ?>
							<option value="<?php echo $value->ID; ?>" title="<?php echo $value->post_title ?>"  <?php selected( $this->value(), $value->ID, false ); ?>>
								<?php echo \CustomizerFramework\wordwrap( $value->post_title, 40 ); ?>
							</option>
					<?php endforeach; ?>
				<?php else: ?>
						<option>No page available</option>
				<?php endif; ?>

			</select>
		</div>
	<?php
	}
}

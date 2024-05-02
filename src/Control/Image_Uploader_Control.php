<?php declare(strict_types=1);

namespace CustomizerFramework\Control;

defined( 'ABSPATH' ) || exit;

use CustomizerFramework\Inc\Attachment;

/**
 * Image Uploader Control.
 *
 * @since   1.0.0
 * @version 1.0.0
 */
final class Image_Uploader_Control extends \WP_Customize_Control
{
	/**
	 * List of valid extensions [ 'png', 'jpg', 'jpeg', 'ico', 'gif' ].
	 *
	 * @since 1.0.0
	 *
	 * @var array
	 */
	public $extensions;


	/**
	 * Holds the placeholder.
	 *
	 * @since 1.0.0
	 *
	 * @var string
	 */
	public $placeholder;


	/**
	 * Instantiating Attachment and return object attachment.
	 *
	 * @since 1.0.0
	 *
	 * @return object
	 */
	private function attachment() {
		$attachment = new Attachment( [
			'type'			=> 'image',
			'id'			=> $this->id,
			'label'			=> $this->label,
			'description'	=> $this->description,
			'placeholder'	=> $this->placeholder,
			'extensions'	=> $this->extensions,
			'value'			=> $this->value()
		]);
		return $attachment;
	}


	/**
	 * Render the image uploader controller and display in frontend.
	 *
	 * @since 1.0.0
	 *
	 * @return html
	 */
	public function render_content() {
		$this->attachment()->create();
	}
}


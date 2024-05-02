<?php declare(strict_types=1);

namespace CustomizerFramework\Control;

defined( 'ABSPATH' ) || exit;

use CustomizerFramework\Inc\Attachment;


/**
 * File Uploader Control.
 *
 * @since   1.0.0
 * @version 1.0.0
 */
final class File_Uploader_Control extends \WP_Customize_Control
{
	/**
	 * List of valid extensions [ pdf', 'doc', 'docx', 'ppt', 'pptx', 'pps',
	 * 'ppsx', 'odt', 'xls', 'xlsx', 'psd' ].
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
			'type'			=> 'application',
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
	 * Render the file uploader controller and display in frontend.
	 *
	 * @since 1.0.0
	 *
	 * @return html
	 */
	public function render_content() {
		$this->attachment()->create();
	}
}

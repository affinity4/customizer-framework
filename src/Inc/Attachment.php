<?php declare(strict_types=1);

namespace CustomizerFramework\Inc;

defined( 'ABSPATH' ) || exit;

/**
 * customizer-framework- Attachment Inc.
 *
 * @since   1.0.0
 * @version 1.0.0
 */
class Attachment
{
	/**
	 * Type of attachment [ image, video, audio, file ].
	 *
	 * @since 1.0.0
	 *
	 * @var array
	 */
	private array $data;

	/**
	 * Constructing class and initialize properties.
	 *
	 * @since 1.0.0
	 *
	 * @param any  $data
	 */
	public function __construct(array $data)
    {
		$this->data = $data;
	}

	/**
	 * Return mimes depending on type and extension
	 * @return string    json_ecode
	 */
	private function get_extensions()
    {
		$mimes = array();
		$output = '';
		$data_type = $this->data['type'];
		$extensions = $this->data['extensions'];
		if ( ! empty( $extensions ) ) {
			if ( $data_type == 'image' ) {
				foreach ( $this->data['extensions'] as $key => $value ) {
					switch ( $value ) {
						case 'jpg':
							array_push( $mimes, 'image/jpeg', 'image/pjpeg' );
							break;
						case 'jpeg':
							array_push( $mimes, 'image/jpeg', 'image/pjpeg' );
							break;
						case 'png':
							array_push( $mimes, 'image/png' );
							break;
						case 'gif':
							array_push( $mimes, 'image/gif' );
							break;
						case 'ico':
							array_push( $mimes, 'image/x-icon' );
							break;
					}
				}
			} elseif ( $data_type == 'video' ) {
				foreach ( $extensions as $key => $value ) {
					switch ( $value ) {
						case 'mp4':
							array_push( $mimes, 'video/mp4' );
							break;
						case 'm4v':
							array_push( $mimes, 'video/x-m4v' );
							break;
						case 'mov':
							array_push( $mimes, 'video/quicktime' );
							break;
						case 'wmv':
							array_push( $mimes, 'video/x-ms-wmv' );
							break;
						case 'avi':
							array_push( $mimes, 'video/avi' );
							break;
						case 'mpg':
							array_push( $mimes, 'video/mpeg' );
							break;
						case 'ogv':
							array_push( $mimes, 'video/ogg' );
							break;
						case '3gp':
							array_push( $mimes, 'video/3gpp' );
							break;
						case '3g2':
							array_push( $mimes, 'video/3gpp2' );
							break;
						case 'webm':
							array_push( $mimes, 'video/webm' );
							break;
						case 'mkv':
							array_push( $mimes, 'video/x-matroska' );
							break;
					}
				}
			} elseif ( $data_type == 'audio' ) {
				foreach ( $extensions as $key => $value ) {
					switch ( $value ) {
						case 'mp3':
							array_push( $mimes, 'audio/mpeg3', 'audio/mpeg' );
							break;
						case 'm4a':
							array_push( $mimes, 'audio/m4a' );
							break;
						case 'ogg':
							array_push( $mimes, 'audio/ogg' );
							break;
						case 'wav':
							array_push( $mimes, 'audio/wav' );
							break;
						case 'mpg':
							array_push( $mimes, 'audio/mpeg3', 'audio/mpeg' );
							break;
					}
				}
			} elseif ( $data_type == 'application' ) {
				foreach ( $extensions as $key => $value ) {
					switch ( $value ) {
						case 'pdf':
							array_push( $mimes, 'application/pdf' );
							break;
						case 'doc':
							array_push( $mimes, 'application/msword' );
							break;
						case 'docx':
							array_push( $mimes, 'application/vnd.openxmlformats-officedocument.wordprocessingml.document' );
							break;
						case 'ppt':
							array_push( $mimes, 'application/mspowerpoint', 'application/powerpoint', 'application/vnd.ms-powerpoint', 'application/x-mspowerpoint' );
							break;
						case 'pptx':
							array_push( $mimes, 'application/vnd.openxmlformats-officedocument.presentationml.presentation' );
							break;
						case 'pps':
							array_push( $mimes, 'application/mspowerpoint', 'application/vnd.ms-powerpoint' );
							break;
						case 'ppsx':
							array_push( $mimes, 'application/vnd.openxmlformats-officedocument.presentationml.slideshow' );
							break;
						case 'odt':
							array_push( $mimes, 'application/vnd.oasis.opendocument.text' );
							break;
						case 'xls':
							array_push( $mimes, 'application/excel', 'application/vnd.ms-excel', 'application/x-excel', 'application/x-msexcel' );
							break;
						case 'xlsx':
							array_push( $mimes, 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' );
							break;
						case 'psd':
							array_push( $mimes, 'application/octet-stream' );
							break;
					}
				}
			}
			$output = json_encode( array_unique( $mimes ) );
		}
		return $output;
	}

	/**
	 * Return the appropriate icon depending on $this->data['type']
	 * @return string
	 */
	private function get_icon()
    {
		switch ( $this->data['type'] ) {
			case 'image':
				$icon = 'dashicons-format-image';
				break;
			case 'video':
				$icon = 'dashicons-video-alt3';
				break;
			case 'video':
				$icon = 'dashicons-video-alt3';
				break;
			case 'audio':
				$icon = 'dashicons-format-audio';
				break;
			case 'application':
				$icon = 'dashicons-media-default';
				break;
		}

		return $icon;
	}

	/**
	 * Return the placeholder and set default
	 * $this->data['placeholder'] is empty
	 * @return string
	 */
	private function get_placeholder()
    {
		$placeholder = $this->data['placeholder'];
		if ( empty( $this->data['placeholder'] ) ) {
			$placeholder = 'No Selected '. ucfirst( $this->data['type'] );
		}
		return $placeholder;
	}

	/**
	 * Get the field id by replacing '_field' in $this->data['id']
	 * and return the data-customize-setting-link attribute
	 * @return string
	 */
	private function get_link()
    {
		$id = str_replace( '_field', '', $this->data['id'] );
		return 'data-customize-setting-link="'. $id .'"';
	}

	/**
	 * Return the status depending on $this->data['value']
	 * @param  integer      $control      element control
	 * @return string
	 */
	private function get_status( $control )
    {
		if ( $control == 1 ) {
			$status = ( empty( $this->data['value'] ) == true ? 'visible' : 'hidden' );
		} else {
			$status = ( empty( $this->data['value'] ) == true ? 'hidden' : 'visible' );
		}
		return $status;
	}

	/**
	 * Return the data attachment needed in thumbnail
	 * @return array
	 */
	private function get_attachment()
    {
		if ( $this->data['type'] == 'image' ) {
			$url = wp_get_attachment_url( $this->data['value'] );
			$output = [ 'url' => $url ];
		}
		return $output;
	}

	/**
	 * Return the status if attachment is available
	 * @param  integer     $control     the control element
	 * @return string
	 */
	private function get_attachment_status( $control )
    {
		$error = 'none';
		$status = '';
		if ( ! empty( $this->data['value'] ) ) {
			$url = wp_get_attachment_url( $this->data['value'] );
			$file_type = $this->get_attachment_format();
			if ( $control == 1 ) {
				if ( $url == false || $file_type != $this->data['type'] ) {
					$status = 'hidden';
				} else {
					$status = 'visible';
				}
			} else {
				if ( $url == false || $file_type != $this->data['type'] ) {
					$status = 'visible';
				} else {
					$status = 'hidden';
				}
			}

			if ( $url != false ) {
				if ( $file_type != $this->data['type'] ) {
					$error = 'invalid_format';
				}
			} else {
				$error = 'invalid_url';
			}
		}
		$output = [
			'status'	=> $status,
			'error'		=> $error
		];

		return $output;
	}

	/**
	 * Returns the attachment format
	 * @return string
	 */
	private function get_attachment_format()
    {
		if ( ! empty( $this->data['value'] ) ) {
			$type = $this->data['type'];
			$attachment = wp_get_attachment_url( $this->data['value'] );
			if ( $attachment != false ) {
				$extension = pathinfo( basename( $attachment ), PATHINFO_EXTENSION );
				if ( $type == 'image' ) {
					$valid_extensions = [ 'png', 'jpg', 'jpeg', 'ico', 'gif' ];
				} elseif ( $type == 'video' ) {
					$valid_extensions = [ 'mp4', 'm4v',  'mov', 'wmv', 'avi', 'mpg', 'ogv', '3gp', '3g2', 'webm', 'mkv' ];
				} elseif ( $type == 'audio' ) {
					$valid_extensions = [ 'mp3', 'm4a', 'ogg', 'wav', 'mpg' ];
				} elseif ( $type == 'application' ) {
					$valid_extensions = [ 'pdf', 'doc', 'docx', 'ppt', 'pptx', 'pps', 'ppsx', 'odt', 'xls', 'xlsx', 'psd' ];
				}
				if ( in_array( $extension, $valid_extensions ) ) {
					switch ( $this->data['type'] ) {
						case 'image':
							$format = 'image';
							break;
						case 'video':
							$format = 'video';
							break;
						case 'audio':
							$format = 'audio';
							break;
						case 'application':
							$format = 'application';
							break;
					}
					return $format;
				}
			}
		}
	}

	/**
	 * Returns the filename also the error message as filename
	 * used in type video, audio and application
	 * @return string
	 */
	private function get_filename()
    {
		$filename = '';
		if ( ! empty( $this->data['value'] ) ) {
			$error = $this->get_error( $this->get_attachment_status(2)['error'] );
			if ( empty( $error ) ) {
				$filename = basename( get_attached_file( $this->data['value'] ) );
			} else {
				$filename = $error;
			}
		}
		return $filename;
	}

	/**
	 * Returns the error message depending on error type
	 * @param  string      $error        the error type
	 * @return string
	 */
	private function get_error( $error )
    {
		$error_message = '';
		if ( ! empty( $error ) ) {
			if ( $error == 'invalid_url' ) {
				$error_message = ucfirst( $this->data['type'] ). ' Not Found';
			} elseif ( $error == 'invalid_format' ) {
				$error_message = 'Not An '. ucfirst( $this->data['type'] ) .' Format';
			}
		}
		return $error_message;
	}

	/**
	 * Render the field in the front-end
	 * @return html
	 */
	public function create()
    {
	?>
		<div class="customizer-framework--attachment-parent <?php echo esc_attr( $this->data['type'] ); ?>">

			<!-- Labels -->
			<label>
				<?php if ( ! empty( $this->data['label'] ) ): ?>
					<span class="customize-control-title"><?php echo esc_html( $this->data['label'] ); ?></span>
				<?php endif; ?>

				<?php if ( ! empty( $this->data['description'] ) ): ?>
					<span class="description customize-control-description"><?php echo wp_kses_post( $this->data['description'] ); ?></span>
				<?php endif; ?>
			</label>
			<!-- End label -->

			<!-- Main Input -->
			<input type="hidden"
				   id="customizer-framework--attachment-main-input-<?php echo esc_attr( $this->data['id'] ); ?>"
				   name="<?php echo esc_attr( $this->data['id'] ); ?>"
				   value="<?php echo esc_attr( $this->data['value'] ); ?>"
				   <?php echo $this->get_link(); ?>>

			<div class="customizer-framework--attachment-container">
				<div id="customizer-framework--attachment-error-<?php echo esc_attr( $this->data['id'] ); ?>" class="customizer-framework--custom-error">
					<p>Error Message</p>
				</div>
				<div id="customizer-framework--attachment-btn-open-<?php echo esc_attr( $this->data['id'] ); ?>"
					 class="customizer-framework--attachment-btn-open customizer-framework--attachment-upload <?php echo esc_attr( $this->get_status(1) ); ?>"
					 data-id="<?php echo esc_attr( $this->data['id'] ); ?>"
					 data-type="<?php echo esc_attr( $this->data['type'] ); ?>"
					 data-extensions="<?php echo esc_attr( $this->get_extensions() ); ?>">
					 <i class="dashicons <?php echo esc_attr( $this->get_icon() ); ?>"></i>
					 <p><?php echo esc_html( $this->get_placeholder() ); ?></p>
				</div>

				<div id="customizer-framework--attachment-frame-<?php echo esc_attr( $this->data['id'] ); ?>" class="customizer-framework--attachment-frame <?php echo esc_attr( $this->get_status(0) ); ?>">

					<!-- Displaying Thumbnail -->
					<?php if ( $this->data['type'] == 'image' ): ?>
								<div id="customizer-framework--attachment-thumbnail-<?php echo esc_attr( $this->data['id'] ); ?>"
									 class="customizer-framework--attachment-thumbnail <?php echo esc_attr( $this->get_attachment_status(1)['status'] ); ?>">
									<img src="<?php echo esc_attr( $this->get_attachment()['url'] ); ?>">
								</div>
					<?php elseif ( $this->data['type'] == 'video' || $this->data['type'] == 'audio' || $this->data['type'] == 'application' ): ?>
								<div id="customizer-framework--attachment-thumbnail-<?php echo esc_attr( $this->data['id'] ); ?>"
									 class="customizer-framework--attachment-thumbnail-item <?php echo esc_attr( $this->get_attachment_status(1)['status'] ); ?>">
									 <div class="customizer-framework--attachment-image-container">
										<img src="<?php echo wp_get_attachment_image_url( $this->data['value'], $size = 'thumbnail', $icon = true ); ?>">
									</div>
									<div class="customizer-framework--attachment-filename">
										<p title="<?php echo esc_attr( $this->get_filename() ); ?>">
											<?php echo mb_strimwidth( $this->get_filename(), 0, 65, "..."); ?>
										</p>
									</div>
								</div>
					<?php else : ?>
                        <!-- Error Actions -->
                        <div id="customizer-framework--attachment-btn-not-found-<?php echo esc_attr( $this->data['id'] ); ?>"
                            class="customizer-framework--attachment-btn-open customizer-framework--attachment-upload error <?php echo esc_attr( $this->get_attachment_status(2)['status'] ); ?>"
                            data-id="<?php echo esc_attr( $this->data['id'] ); ?>"
                            data-type="<?php echo esc_attr( $this->data['type'] ); ?>"
                            data-extensions="<?php echo esc_attr( $this->get_extensions() ); ?>">
                            <i class="dashicons <?php echo esc_attr( $this->get_icon() ); ?>"></i>
                            <p><b><?php echo $this->get_error( $this->get_attachment_status(2)['error'] ); ?></b></p>
                        </div><!-- End: Error Actions -->
                    <?php endif ?>
					<!-- End Thumbnail -->

					<!-- Actions -->
					<div class="customizer-framework--attachment-action">
						<button class="customizer-framework--attachment-btn-remove button"
								data-id="<?php echo esc_attr( $this->data['id'] ); ?>">Remove</button>
						<button class="customizer-framework--attachment-btn-open button"
								data-id="<?php echo esc_attr( $this->data['id'] ); ?>"
					 			data-type="<?php echo esc_attr( $this->data['type'] ); ?>"
					 			data-extensions="<?php echo esc_attr( $this->get_extensions() ); ?>">Change</button>
					</div>
					<!-- End Actions -->
                </div>

                <p>This field accepts only: .<?php echo implode(', .', $this->data['extensions']) ?></p>
			</div>
		</div>
	<?php
	}
}

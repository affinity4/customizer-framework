<?php declare(strict_types=1);

namespace CustomizerFramework\Core;

defined( 'ABSPATH' ) || exit;

use CustomizerFramework\Field\Field_Audio_Uploader;
use CustomizerFramework\Field\Field_Button_Set;
use CustomizerFramework\Field\Field_Text;
use CustomizerFramework\Field\Field_Select;
use CustomizerFramework\Field\Field_Size;
use CustomizerFramework\Field\Field_Sortable;
use CustomizerFramework\Field\Field_Switch;
use CustomizerFramework\Field\Field_Checkbox;
use CustomizerFramework\Field\Field_Checkbox_Multiple;
use CustomizerFramework\Field\Field_Checkbox_Pill;
use CustomizerFramework\Field\Field_Code_Editor;
use CustomizerFramework\Field\Field_Color;
use CustomizerFramework\Field\Field_Color_Picker;
use CustomizerFramework\Field\Field_Color_Set;
use CustomizerFramework\Field\Field_Content_Editor;
use CustomizerFramework\Field\Field_Date_Picker;
use CustomizerFramework\Field\Field_Dropdown_Custom_Post;
use CustomizerFramework\Field\Field_Dropdown_Page;
use CustomizerFramework\Field\Field_Dropdown_Post;
use CustomizerFramework\Field\Field_Email;
use CustomizerFramework\Field\Field_Error_Handler;
use CustomizerFramework\Field\Field_File_Uploader;
use CustomizerFramework\Field\Field_Image_Checkbox;
use CustomizerFramework\Field\Field_Image_Radio;
use CustomizerFramework\Field\Field_Image_Uploader;
use CustomizerFramework\Field\Field_Markup;
use CustomizerFramework\Field\Field_Numeric;
use CustomizerFramework\Field\Field_Radio;
use CustomizerFramework\Field\Field_Range;
use CustomizerFramework\Field\Field_Tagging;
use CustomizerFramework\Field\Field_Tagging_Select;
use CustomizerFramework\Field\Field_Textarea;
use CustomizerFramework\Field\Field_Time_Picker;
use CustomizerFramework\Field\Field_Toggle;
use CustomizerFramework\Field\Field_Url;
use CustomizerFramework\Field\Field_Video_Uploader;
use Exception;

/**
 * Framework.
 *
 * @since   1.0.0
 * @version 1.0.0
 */
class Customizer
{
	/**
	 * Holds set of arguments.
	 *
	 * @since 1.0.0
	 *
	 * @var array
	 */
	public $args = [];

	/**
	 * Get WP_Customize_Manager.
	 *
	 * @since 1.0.0
	 *
	 * @return object
	 */
	protected function wp_customize()
    {
		global $wp_customize;

		return $wp_customize;
	}


	/**
	 * Adding panel.
	 *
	 * @since 1.0.0
	 *
	 * @param string 	$id 					a unique slug-like string to use as an id
	 * @param array 	$args
	 */
	public static function panel($id, $args)
    {
		if (is_customize_preview() && !empty($id) && !empty($args)) {
            (new self)->render_panel($id, $args);
		}
	}

	/**
	 * Adding Section.
	 *
	 * @since 1.0.0
	 *
	 * @param string  $id 	   A unique slug-like string to use as an id.
	 * @param array   $args  Containing the set of arguments.
	 */
	public static function section(string $id, array $args)
    {
		if (is_customize_preview() && !empty($id) && !empty($args)) {
            (new self)->render_section($id, $args);
		}
	}

	/**
	 * Adding Field.
	 *
	 * @since 1.0.0
	 *
	 * @param string  $id 	   A unique slug-like string to use as an id.
	 * @param array   $args  Hold the set of arguments for specific field.
	 */
	public static function field(string $type, array $args)
    {
		if (is_customize_preview() && !empty($type) && !empty($args)) {
            (new self)->render_field($type, $args);
		}
	}

    /**
	 * Rendering Panel.
	 *
	 * @since 1.0.0
	 *
	 * @param string  $id 			 A unique slug-like string to use as an id.
	 * @param array   $args 		 Containing the set of arguments.
	 */
	private function render_panel(string $id, array $args): void
    {
		$this->wp_customize()->add_panel($id, $args);
	}

	/**
	 * Rendering Section.
	 *
	 * @since 1.0.0
	 *
	 * @param string  $id 	   A unique slug-like string to use as an id.
	 * @param array   $args  Hold the set of arguments.
	 */
	private function render_section(string $id, array $args): void
    {
        $this->wp_customize()->add_section($id, $args);
	}

	/**
	 * Rendering Field.
	 *
	 * @since 1.0.0
	 *
	 * @param string  $type    The type of field.
	 * @param array   $args  Hold the set of arguments for specific field.
	 */
	private function render_field(string $type, array $args): void
    {
        try {
            match ($type) {
                'audio-uploader'        => (new Field_Audio_Uploader)->render($this->wp_customize(), $args),
                'button-set'            => (new Field_Button_Set)->render($this->wp_customize(), $args),
                'checkbox-multiple'     => (new Field_Checkbox_Multiple)->render($this->wp_customize(), $args),
                'checkbox-pill'         => (new Field_Checkbox_Pill)->render($this->wp_customize(), $args),
                'checkbox'              => (new Field_Checkbox)->render($this->wp_customize(), $args),
                'code-editor'           => (new Field_Code_Editor)->render($this->wp_customize(), $args),
                'color-picker'          => (new Field_Color_Picker)->render($this->wp_customize(), $args),
                'color-set'             => (new Field_Color_Set)->render($this->wp_customize(), $args),
                'color'                 => (new Field_Color)->render($this->wp_customize(), $args),
                'content-editor'        => (new Field_Content_Editor)->render($this->wp_customize(), $args),
                'date-picker'           => (new Field_Date_Picker)->render($this->wp_customize(), $args),
                'dropdown-custom-post'  => (new Field_Dropdown_Custom_Post)->render($this->wp_customize(), $args),
                'dropdown-page'         => (new Field_Dropdown_Page)->render($this->wp_customize(), $args),
                'dropdown-post'         => (new Field_Dropdown_Post)->render($this->wp_customize(), $args),
                'email'                 => (new Field_Email)->render($this->wp_customize(), $args),
                'file-uploader'         => (new Field_File_Uploader)->render($this->wp_customize(), $args),
                'image-checkbox'        => (new Field_Image_Checkbox)->render($this->wp_customize(), $args),

                'text'                  => (new Field_Text)->render($this->wp_customize(), $args),

                'image-radio'           => (new Field_Image_Radio)->render($this->wp_customize(), $args),
                'image-uploader'        => (new Field_Image_Uploader)->render($this->wp_customize(), $args),
                'markup'                => (new Field_Markup)->render($this->wp_customize(), $args),
                'numeric'               => (new Field_Numeric)->render($this->wp_customize(), $args),
                'radio'                 => (new Field_Radio)->render($this->wp_customize(), $args),
                'range'                 => (new Field_Range)->render($this->wp_customize(), $args),
                'select'                => (new Field_Select)->render($this->wp_customize(), $args),
                'size'                  => (new Field_Size)->render($this->wp_customize(), $args),
                'sortable'              => (new Field_Sortable)->render($this->wp_customize(), $args),
                'switch'                => (new Field_Switch)->render($this->wp_customize(), $args),
                'tagging-select'        => (new Field_Tagging_Select)->render($this->wp_customize(), $args),
                'tagging'               => (new Field_Tagging)->render($this->wp_customize(), $args),
                'textarea'              => (new Field_Textarea)->render($this->wp_customize(), $args),
                'time-picker'           => (new Field_Time_Picker)->render($this->wp_customize(), $args),
                'toggle'                => (new Field_Toggle)->render($this->wp_customize(), $args),
                'url'                   => (new Field_Url)->render($this->wp_customize(), $args),
                'video-uploader'        => (new Field_Video_Uploader)->render($this->wp_customize(), $args)
            };
        } catch(Exception $e) {
            $args['id'] = 'customizer_framework__error_handler';
            $args['label'] = $e->getMessage();
            $args['description'] = $e->getTraceAsString();
            (new Field_Error_Handler)->render($this->wp_customize(), $args);
        }
	}
}

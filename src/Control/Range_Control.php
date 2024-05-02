<?php

declare(strict_types=1);

namespace CustomizerFramework\Control;

defined('ABSPATH') || exit;

use function CustomizerFramework\assets_url;

/**
 * Range Control.
 *
 * @since   1.0.0
 * @version 1.0.0
 */
final class Range_Control extends \WP_Customize_Control
{
    /**
     * Options value. Contains `min`, `max`, `step`
     *
     * @since 1.0.0
     *
     * @var object
     */
    public $options;

    /**
     * Adding third party libraries.
     *
     * @since 1.0.0
     */
    public function enqueue()
    {
        // js
        if (wp_script_is('customizer-framework--range-js', 'enqueued') == false) {
            wp_enqueue_script('customizer-framework--range-js', assets_url() . '/range/range.js', array(), '1.0', false);
        }
    }


    /**
     * Render the range controller and display in frontend.
     *
     * @since 1.0.0
     *
     * @return html
     */
    public function render_content()
    {
    ?>
        <div class="customizer-framework--range-parent">
            <label>
                <?php if (!empty($this->label)) : ?>
                    <span class="customize-control-title"><?php echo esc_html($this->label); ?></span>
                <?php endif ?>

                <?php if (!empty($this->description)) : ?>
                    <span class="description customize-control-description"><?php echo wp_kses_post($this->description); ?></span>
                <?php endif ?>
            </label>

            <div class="customizer-framework--range-container">
                <input type="text" id="<?php echo esc_attr($this->id) ?>" class="customizer-framework--range" name="<?php echo esc_attr($this->id) ?>" value="<?php echo esc_attr($this->value()) ?>" min="<?php echo esc_attr($this->options->min) ?>" max="<?php echo esc_attr($this->options->max) ?>" step="<?php echo esc_attr($this->options->step) ?>" <?php echo $this->link(); ?>>
            </div>
        </div>
    <?php
    }
}

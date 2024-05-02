<?php declare(strict_types=1);

namespace CustomizerFramework\Control;

use Exception;

defined( 'ABSPATH' ) || exit;

/**
 * Dropdown Post Control.
 *
 * @since   1.0.0
 * @version 1.0.0
 *
 * @property \Exception $error
 */
final class Error_Handler_Control extends \WP_Customize_Control
{
    public function render_content(): void
    {
    ?>
        <div class="customizer-framework--error-handler-parent" style="background-color: hsl(0, 75%, 55%); color: white; border-radius: 5px; padding: 0.5rem;">
            <label class="customize-control-title"><strong>!!! ERROR OCCURRED !!!</strong></label>
            <span class="description customize-control-description" style="overflow-x: auto; color: white;">
                <pre><p><strong><?php echo $this->label ?></strong></p><?php if (WP_DEBUG) echo $this->description ?></pre>
            </span>
        </div>
    <?php
    }
}

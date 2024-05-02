<?php declare(strict_types=1);

namespace CustomizerFramework\Trait;

use Exception;

defined('ABSPATH') || exit;

trait Has_Extension_Validation
{
    protected array $validation_failures = [];

    /**
     * If has Validation failures, returns true, else false.
     *
     * @return bool
     */
    private function has_failed_validation(): bool
    {
        if (!property_exists($this, 'valid_extensions')) {
            throw new Exception('You must define the property `valid_extensions` in classes which use the `Has_Extension_Validation` trait.');
        }

        $this->validation_failures = [];

        // Empty array means nothing is valid
        if (empty($this->valid_extensions)) {
            $this->validation_failures = ['No extensions allowed'];

            return true;
        }

        // A '*' means everything is valid
        if (in_array('*', $this->valid_extensions)) {
            $this->validation_failures = [];

            return false;
        }

        foreach ($this->extensions as $extension) {
            if (!in_array($extension, $this->valid_extensions)) {
                $this->validation_failures[] = sprintf('"%s" not a valid file type for this control. Valid file types: %s', $extension, implode(', ', $this->valid_extensions));
            }
        }

        return (!empty($this->validation_failures));
    }

    public function render_validation_failure_reasons(): void
    {
        ?>
            <div>
                <ul>
                <?php foreach ($this->validation_failures as $validation_failure) : ?>
                    <li><?php echo $validation_failure ?></li>
                <?php endforeach ?>
                </ul>
            </div>
        <?php
    }
}

## Usage

```php
use CustomizerFramework\Trait\Has_Extension_Validation;


class Some_Class
{
    use Has_Extension_Validation;
    
    /**
     * List of valid extensions
     */
    protected array $valid_extensions = ['mp3', 'm4a', 'ogg', 'wav', 'mpg'];

    public function render()
    {
        if ($this->has_failed_validation()) {
            $this->render_validation_failure_reasons();
        }

        // ...validation passed...continue as expected
    }
}
```

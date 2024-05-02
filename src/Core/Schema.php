<?php declare(strict_types=1);

namespace CustomizerFramework\Core;

use Exception;
use stdClass;

defined( 'ABSPATH' ) || exit;

use function get_stylesheet_directory;

class Schema
{
    protected \stdClass $json;

    protected string $filepath;

    protected static array $properties = [
        'default',
        'input_attrs',
        'extensions',
        'style',
        'language',
        'format',
        'opacity',
        'colors',
        'shape',
        'size',
        'uploader',
        'toolbars',
        'mode',
        'enable_time',
        'post_type',
        'order',
        'direction',
        'html',
        'options',
        'units',
        'military_format',
    ];

    public function __construct(?string $filepath = null)
    {
        $this->filepath = (!is_null($filepath)) ? $filepath : get_stylesheet_directory() . '/customizer.json';

        if (!file_exists($this->filepath)) {
            throw new Exception("There is no `customizer.json` file in the root of your theme. Create one, or remove call to `\CustomizerFramework\Core\Schema::load()` in your `functions.php` file");
        }

        $json = json_decode(file_get_contents($this->filepath));
        if ($json === null) {
            throw new Exception("`customizer.json` could not be read. Check the file does not have any syntax errors.");
        }
        $this->setJson($json);
    }

    protected function setJson(stdClass $json): void
    {
        $this->json = $json;
    }

    protected static function args(stdClass $Field, Schema $Schema, array $args): array
    {
        foreach (array_unique(self::$properties) as $property) {
            if (isset($Field->{$property})) {
                $args[$property] = $Field->{$property};
            }
        }

        if (isset($Field->choices)) {
            $args['choices'] = [];
            foreach ($Field->choices as $Choice) {
                $args['choices'][$Choice->value] = __($Choice->text, $Schema->json->domain);
            }
        }

        return $args;
    }

    public static function load(string $filepath = null): void
    {
        $Schema = new self($filepath);
        foreach ($Schema->json->panels as $Panel) {
            Customizer::panel($Panel->id, [
                'title'         => __($Panel->title, $Schema->json->domain),
                'description'   => __($Panel->description, $Schema->json->domain),
                'priority'      => isset($Panel->priority) ? $Panel->priority : 0
            ]);

            if (isset($Panel->sections)) {
                foreach ($Panel->sections as $Section) {
                    Customizer::section($Section->id, [
                        'title'         => __($Section->title, $Schema->json->domain),
                        'description'   => __($Section->description, $Schema->json->domain),
                        'priority'      => isset($Section->priority) ? $Section->priority : 0,
                        'panel'         => $Panel->id,
                    ]);

                    if (isset($Section->fields)) {
                        foreach ($Section->fields as $Field) {
                            Customizer::field($Field->type, self::args($Field, $Schema, [
                                'id'            => $Field->id,
                                'label'         => isset($Field->title) ? __($Field->title, $Schema->json->domain) : __($Field->label, $Schema->json->domain),
                                'description'   => __($Field->description, $Schema->json->domain),
                                'priority'      => isset($Field->priority) ? $Field->priority : 0,
                                'section'       => $Section->id
                            ]));
                        }
                    }
                }
            }
        }

        if (isset($Schema->json->fields)) {
            foreach ($Schema->json->fields as $Field) {
                Customizer::field($Field->type, self::args($Field, $Schema, [
                    'id'            => $Field->id,
                    'label'         => isset($Field->title) ? __($Field->title, $Schema->json->domain) : __($Field->label, $Schema->json->domain),
                    'description'   => __($Field->description, $Schema->json->domain),
                    'priority'      => isset($Field->priority) ? $Field->priority : 0,
                    'section'       => $Field->section
                ]));
            }
        }
    }
}

# Customizer Framework

__Contributors:__ Luke Watts  
__Tags:__ customizer, customizer framework, theme, theme customizer, mods, theme  
__Requires Wordpress:__ >=6.5  
__Requires PHP:__ >=8.2  

The easiest framework for Theme Developer in using WordPress Customizer.

## Description

Simplified static wrapper for the Wordpress Customizer API. Removes the need to define a seperate `setting` and `control` , and instead adds a `field` method which does configures both the `setting` and `control` in one method. Also The Cusomizer Framework adds many new control types which can be used.

## Available Controls:

* [Audio Uploader](#audio-uploader)
* [Button Set](#button-set)
* [Checkbox Multiple](#checkbox-multiple)
* [Checkbox Pill](#checkbox-pill)
* [Checkbox](#checkbox)
* [Code Editor](#code-editor)
* [Color Picker](#color-picker)
* [Color Set](#color-set)
* [Content Editor](#content-editor)
* [Date Picker](#date-picker)
* [Dropdown Custom Post](#dropdown-custom-post)
* [Dropdown Page](#dropdown-page)
* [Dropdown Post](#dropdown-post)
* [Email](#email)
* [File Uploader](#file-uploader)
* [Image Uploader](#image-uploader)
* [Markup](#markup)
* [Numeric](#numeric)
* [Radio](#radio)
* [Range](#range)
* [Select](#select)
* [Size](#size)
* [Switch](#switch)
* [Tagging Select](#tagging-select)
* [Tagging](#tagging)
* [Text](#text)
* [Textarea](#textarea)
* [Timepicker](#time-picker)
* [Toggle](#toggle)
* [URL](#url)
* [Video Uploader](#video-uploader)

## Documentation

### Installation

There are two ways to install Customizer Framework in your wordpress project. The first option is to download Customizer Framework plugin version and install in your WordPress Directory. The second option is to download Customizer Framework library version and include in your theme.

#### Install as Plugin

1. Copy the folder `customizer-framework` to your plugins directory (or zip and upload through Dashboard).
3. Activate.

_Note: If using as a plugin, it is recommended to check check first if the `\\CustomizerFramework\\Core\\Customizer` class exists._

```php
// Check if Customizer class exists
if (class_exists('\\CustomizerFramework\\Core\\Customizer')) {
    // in here you can add panel, section, fields
}
```

You can also write in this way.

```php
// Check if Customizer class exists
if (class_exists('\\CustomizerFramework\\Core\\Customizer') ) {
    // call the function inside
    customizer_fields();
}

// Holds all the field
function customizer_fields() {
    // panel
    \CustomizerFramework\Core\Customizer::panel( 'panel_id', [
    'title'	   => 'Panel title',
    'description' => 'Panel description',
    'priority'    => 1
    ] );

    // section
    \CustomizerFramework\Core\Customizer::section( 'section_id', [
    'title'       => 'Section title',
    'description' => 'Section description',
    'priority'    => 1,
    'panel'       => 'panel_id'
    ] );

    // Text Field
    \CustomizerFramework\Core\Customizer::field( 'text', [
    'id'          => 'textdb1',
    'label'       => 'Text Title',
    'description' => 'Text Description',
    'section'     => 'section_id',
    'priority'    => 1,
    'placeholder' => 'Write text'
    ]);
}
```

#### Install as Library

1. Copy folder `customizer-framework` anywhere inside your theme
2. Require `customizer-framework/customizer-framework.php` in your `functions.php` file
3. Add `use CustomizerFramework\Core\Customizer;` to the top of your `functions.php` file.

Example `functions.php` file:

```php
// in functions.php
// include customizer-framework.php
require get_parent_theme_file_path('/customizer-framework/customizer-framework.php');

// after requiring
// check if Customizer Class Exists
if (class_exists('\CustomizerFramework\Core\Customizer')) {
     // in here you can add panel, section, fields
     // the same as example in above
}

```

### Panel

Panels are containers for section, they allow you to group multiple sections. You can add panel using `Customizer::panel()` method.

```php
Customizer::panel('panel_id', [
   'title'       => 'Panel title',
   'description' => 'Panel description',
   'priority'    => 1
]);

```

#### Parameters

__id__

_string | required_

A unique slug-like string to use as an id.

__title__

_string | required_

The visible name of the panel.

__description__

_string | optional_

The description of the panel, displayed at the top of the panel, hidden behind the help icon.

__priority__

_integer | optional_

The order of panels appears in the Theme Customizer Sizebar.

### Section

Sections are where the Fields reside, you can have multiple Field in each Section. Also Section can be added in panel. You can add section using `Customizer::section()` method.

```php
Customizer::section('section_id', [
   'title'       => 'Section title',
   'description' => 'Section description',
   'priority'    => 1,
]);

```

Adding section inside a panel, you just need to add `panel` in section and copy the panel `id` .

```php
Customizer::section('section_id', [
   'title'       => 'Section title',
   'description' => 'Section description',
   'priority'    => 1,
   'panel'       => 'panel_id'
]);

```

#### Parameters

Here are the parameters for creating section.

__id__

_string | required_

A unique slug-like string to use as an id.

__title__

_string | required_

The visible name of the panel.

__description__

_string | optional_

The description of the section, displayed at the top of the section.

__priority__

_integer | optional_

The order of panels appears in the Theme Customizer Sizebar.

__panel__

_string | optional_

The id of Panel where this section will be reside.

Note: value must be existing Panel id.

### Fields

#### Audio Uploader

The `audio-uploader` lets you add a field for uploading and selecting audio files in WordPress Media Library.

#### Parameters

Here are the parameters in adding audio-uploader.

__id__

_string | required_

A unique slug-like string to use as an id and also as index in saving data in database.

__label__

_string | optional_

The label of the field.

__description__

_string | optional_

The description of the field and display under the label.

__section__

_string | requiredl_

The section where the field will be displayed.

__default__

_integer | optional_

The default value of the field.

Note: default value must be valid or existing "attachment ID"

__priority__

_integer | optional_

Determines the order of fields in section.

__placeholder__

_string | optional_

Display placeholder in the field.

__extensions__

_array | optional_

Allowing to set the allowed audio extensions.

Note: here are the list of allowed extensions [ 'mp3', 'm4a', 'ogg', 'wav', 'mpg' ]

#### Examples

```php
Customizer::field('audio-uploader', [
   'id'          => 'audiodb1',
   'label'       => 'Select Audio',
   'description' => 'Description Here.',
   'section'     => 'section_id',
   'priority'    => 1,
   'placeholder' => 'Select Audio'
]);
```

Example with `default` value! note: default value can only be supplied of the `attachment` ID.

```php
Customizer::field( 'audio-uploader', [
   'id'          => 'audiodb1',
   'label'       => 'Select Audio',
   'description' => 'Description Here.',
   'section'     => 'section_id',
   'default'     => 123,
   'priority'    => 1,
   'placeholder' => 'Select Audio'
] );
```

Example with `extensions` value! note: here are the list of allowed extensions `mp3` , `m4a` , `ogg` , `wav` and `mpg` .

```php
Customizer::field( 'audio-uploader', [
   'id'          => 'audiodb1',
   'label'       => 'Select Audio',
   'description' => 'Description Here.',
   'section'     => 'section_id',
   'default'     => 123,
   'priority'    => 1,
   'placeholder' => 'Select Audio',
   'extensions'  => [ 'mp3', 'wav' ]
] );
```

#### Usage

The `get_theme_mod()` function is recommended to retrieve data.

```php
wp_get_attachment_url(get_theme_mod('audiodb1'));
```

#### Button Set

The button-set lets you add a field for selecting data in a set of button.

#### Parameters

Here are the parameters in adding button-set.

__id__

_string | required_

A unique slug-like string to use as an id and also as index in saving data in database.

__label__

_string | optional_

The label of the field.

__description__

_string | optional_

The description of the field and display under the label.

__section__

_string | requiredl_

The section where the field will be displayed.

__default__

_string | optional_

The default value of the field.

Note: default value must exist in choices.

__priority__

_integer | optional_

Determines the order of fields in section.

__choices__

_array | optional_

List of choices.

#### Examples

```php
Customizer::field('button-set', [
   'id'          => 'buttonsetdb1',
   'label'       => 'List of Fruits',
   'description' => 'Fruit List Description',
   'section'     => 'section_id',
   'priority'    => 1,
   'choices'     => [
      'apple'    => 'Apple',
      'grape'    => 'Grape',
      'orange'   => 'Orange'
    ]
]);
```

Example with default value! note: default value must exist in choices.

```php
Customizer::field( 'button-set', [
   'id'          => 'buttonsetdb1',
   'label'       => 'List of Fruits',
   'description' => 'Fruit List Description',
   'section'     => 'section_id',
   'default'     => 'grape',
   'priority'    => 1,
   'choices'     => [
      'apple'    => 'Apple',
      'grape'    => 'Grape',
      'orange'   => 'Orange'
    ]
]);
```

#### Usage

The `get_theme_mod()` function is recommended to retrieve data.

```php
// Return a string
echo get_theme_mod('buttonsetdb1');
```

#### Checkbox

The `checkbox` lets you add a field checkbox.

#### Parameters

Here are the parameters in adding checkbox.

__id__

_string | required_

A unique slug-like string to use as an id and also as index in saving data in database.

__label__

_string | optional_

The label of the field.

__description__

_string | optional_

The description of the field and display under the label.

__section__

_string | requiredl_

The section where the field will be displayed.

__default__

_boolean | optional_

The default value of the field.

Note: default value must be provided boolean.

__priority__

_integer | optional_

Determines the order of fields in section.

#### Example

```php
Customizer::field('checkbox', [
    'id'          => 'checkboxdb1',
    'label'       => 'Are you single?',
    'description' => 'Select if your single',
    'section'     => 'section_id',
    'priority'    => 1,
]);
```

Example with `default` value! note: default value must be provided `boolean` .

```php
Customizer::field('checkbox', [
    'id'          => 'checkboxdb1',
    'label'       => 'Are you single?',
    'description' => 'Select if your single',
    'section'     => 'section_id',
    'default'     => true,
    'priority'    => 1,
]);
```

#### Usage

The `get_theme_mod()` function is recommended to retrieve data.

```php
// Return a boolean
$is_checked = get_theme_mod('checkboxdb1');
```

#### Checkbox Multiple

The `checkbox-multiple` lets you add a checkbox where you can check multiple checkbox.

#### Parameters

Here are the parameters in adding checkbox-multiple.

__id__

_string | required_

A unique slug-like string to use as an id and also as index in saving data in database.

__label__

_string | optional_

The label of the field.

__description__

_string | optional_

The description of the field and display under the label.

__section__

_string | requiredl_

The section where the field will be displayed.

__default__

_array | optional_

The default value of the field.

Note: default value must exist in choices.

__priority__

_integer | optional_

Determines the order of fields in section.

__choices__

_array | optional_

List of choices.

#### Example

```php
Customizer::field('checkbox-multiple', [
   'id'          => 'multiplecheckboxdb1',
   'label'       => 'List of Fruits',
   'description' => 'Fruit List Description',
   'section'     => 'section_id',
   'priority'    => 1,
   'choices'     => [
      'apple'    => 'Apple',
      'grape'    => 'Grape',
      'orange'   => 'Orange'
    ]
]);
```

Example with `default` value! note: default value must exist in `choices` .

```php
Customizer::field('checkbox-multiple', [
   'id'          => 'multiplecheckboxdb1',
   'label'       => 'List of Fruits',
   'description' => 'Fruit List Description',
   'section'     => 'section_id',
   'default'     => [ 'apple', 'grape' ],
   'priority'    => 1,
   'choices'     => [
      'apple'    => 'Apple',
      'grape'    => 'Grape',
      'orange'   => 'Orange'
    ]
]);
```

#### Usage

The `get_theme_mod()` function is recommended to retrieve data.

__NOTE:__ The choices will be returned in a comma seperated string of the keys e.g. "apple, orange"

```php
// Return a array
$choices = json_decode(get_theme_mod(('multiplecheckboxdb1')));
```

### Checkbox Pill

The `checkbox-pill` lets you add a field for selecting data.

Inline style.

Checkbox Pill Inline
List Style.

Checkbox Pill List
Parameters
Here are the parameters in adding checkbox-pill.

__id__

_string | required_

A unique slug-like string to use as an id and also as index in saving data in database.

__label__

_string | optional_

The label of the field.

__description__

_string | optional_

The description of the field and display under the label.

__section__

_string | required_

The section where the field will be displayed.

__default__

_array | optional_

The default value of the field.

Note: default value must exist in choices.

__priority__

_integer | optional_

Determines the order of fields in section.

__choices__

_array | optional_

List of choices.

__style__

_string | optional_

The style of the checkbox pill.

Note: style values are 'inline' and 'list' default is 'list'

#### Examples

```php
Customizer::field('checkbox-pill', [
   'id'            => 'checkboxpilldb1',
   'label'         => 'Select Fruits',
   'description'   => 'Fruit list description',
   'section'       => 'section_id',
   'priority'      => 1,
   'choices'       => [
      'apple'      => 'Apple',
      'orange'     => 'Orange',
      'grape'      => 'Grape',
      'mango'      => 'Mango',
      'cherry'     => 'Cherry',
      'berry'      => 'Berry',
      'melon'      => 'Melon'
   ]
]);
```

Example with `default` value! note: default value must exist in `choices` .

```php
Customizer::field('checkbox-pill', [
   'id'            => 'checkboxpilldb1',
   'label'         => 'Select Fruits',
   'description'   => 'Fruit list description',
   'section'       => 'section_id',
   'default'       => [ 'apple', 'orange' ],
   'priority'      => 1,
   'choices'       => [
      'apple'      => 'Apple',
      'orange'     => 'Orange',
      'grape'      => 'Grape',
      'mango'      => 'Mango',
      'cherry'     => 'Cherry',
      'berry'      => 'Berry',
      'melon'      => 'Melon'
   ]
]);
```

Example with `style` . Style can be `inline` or `list` .

```php
Customizer::field('checkbox-pill', [
   'id'            => 'checkboxpilldb1',
   'label'         => 'Select Fruits',
   'description'   => 'Fruit list description',
   'section'       => 'section_id',
   'default'       => [ 'apple', 'orange' ],
   'priority'      => 1,
   'style'         => 'inline',
   'choices'       => [
      'apple'      => 'Apple',
      'orange'     => 'Orange',
      'grape'      => 'Grape',
      'mango'      => 'Mango',
      'cherry'     => 'Cherry',
      'berry'      => 'Berry',
      'melon'      => 'Melon'
   ]
]);
```

#### Usage

The `get_theme_mod()` function is recommended to retrieve data.

```php
// Returns a array
$choices = json_decode(get_theme_mod('checkboxpilldb1'));
```

#### Code Editor

The `code-editor` lets you add a code editor field.

#### Parameters

Here are the parameters in adding code-editor.

__id__

_string | required_

A unique slug-like string to use as an id and also as index in saving data in database.

__label__

_string | optional_

The label of the field.

__description__

_string | optional_

The description of the field and display under the label.

__section__

_string | requiredl_

The section where the field will be displayed.

__default__

_string | optional_

The default value of the field.

__priority__

_integer | optional_

Determines the order of fields in section.

__language__

_string | optional | default: html_

Allowing to set programming language for the editor

Note: here are the list of allowed language [ 'html', 'css', 'javascript', 'php' ]

#### Example

```php
Customizer::field('code-editor', [
   'id'          => 'codedb1',
   'label'       => 'Add Your Code',
   'description' => 'Description Here.',
   'section'     => 'section_id',
   'priority'    => 1
]);
```

Example with `default` value! note: default value must exist in `choices` .

```php
Customizer::field('code-editor', [
   'id'          => 'codedb1',
   'label'       => 'Add Your Code',
   'description' => 'Description Here.',
   'section'     => 'section_id',
   'default'     => 'Hello World'
   'priority'    => 1
]);
```

Example with `langauage` ! note: here are the list of allowed language `html` , `css` , `javascript` and `php` .

```php
Customizer::field('code-editor', [
    'id'          => 'codedb1',
    'label'       => 'Add Your Code',
    'description' => 'Description Here.',
    'section'     => 'section_id',
    'default'     => 'console.log(\'Hello World\')',
    'priority'    => 1,
    'language'    => 'javascript'
]);
```

#### Usage

The `get_theme_mod()` function is recommended to retrieve data.

```php
// Return a string
echo get_theme_mod('codedb1');
```

#### Color Picker

The `color-picker` lets you add a field for selecting colors.

#### Parameters

Here are the parameters in adding color-picker.

__id__

_string | required_

A unique slug-like string to use as an id and also as index in saving data in database.

__label__

_string | optional_

The label of the field.

__description__

_string | optional_

The description of the field and display under the label.

__section__

_string | requiredl_

The section where the field will be displayed.

__default__

_string | optional_

The default value of the field.

__priority__

_integer | optional_

Determines the order of fields in section.

__format__

_string | required_

The format color return 'hex or rgba'.

Note: format only accept 'hex' and 'rgba'.

__opacity__

_boolean | optional_

Allow to add opacity control.

#### Examples

```php
Customizer::field('color-picker', [
   'id'          => 'colorpickerdb1',
   'label'       => 'Select your color',
   'description' => 'Please select a color',
   'section'     => 'section_id',
   'priority'    => 1,
   'format'      => 'hex',
]);
```

Example with `opacity` ! note: opacity value is `boolean` .

```php
Customizer::field('color-picker', [
   'id'          => 'colorpickerdb1',
   'label'       => 'Select your color',
   'description' => 'Please select a color',
   'section'     => 'section_id',
   'default'     => 'rgba( 0, 0, 0, 0.5 )',
   'priority'    => 1,
   'format'      => 'rgba',
   'opacity'     => true
]);
```

#### Usage

The `get_theme_mod()` function is recommended to retrieve data.

```php
// Return a string
echo get_theme_mod('colorpickerdb1');
```

#### Color Set

The `color-set` lets you add a field for selecting color.

#### Parameters

Here are the parameters in adding color-set.

__id__

_string | required_

A unique slug-like string to use as an id and also as index in saving data in database.

__label__

_string | optional_

The label of the field.

__description__

_string | optional_

The description of the field and display under the label.

__section__

_string | requiredl_

The section where the field will be displayed.

__default__

_string | required_

The default value of the field.

Note: default value must exist in colors.

__priority__

_integer | optional_

Determines the order of fields in section.

__colors__

_array | required_

The list array of colors to be used.

__shape__

_string | optional | default: square_

The actual shape of color radio.

Note: shape valid values are 'square' and 'circle'.

__size__

_integer | optional_

The actual size of color radio, unit size is "px".

#### Example

```php
Customizer::field( 'color-set', [
    'id'          => 'colorsetdb1',
    'label'       => 'Choose Color 1',
    'description' => 'Some description',
    'section'     => 'section_id',
    'default'     => '#000000',
    'priority'    => 14,
    'colors'      => [ '#000000', '#ffffff', '#eeeeee' ],
    'shape'       => 'square',
    'size'        => 20
] );
```

The Customizer provides material colors. Here are material color set : `all` , `primary` , `a100` , `a200` , `a400` , `a700` , `red` , `pink` , `purple` , `deepPurple` , `indigo` , `lightBlue` , `cyan` , `teal` , `green` , `lightGreen` , `lime` , `yellow` , `amber` , `orange` , `deepOrange` , `brown` , `grey` and `blueGrey` .

```php
use CustomizerFramework\Core\Customizer;
use CustomizerFramework\Lib\Util;

Customizer::field('color-set', [
    'id'          => 'colorsetdb1',
    'label'       => 'Choose Color 1',
    'description' => 'Some description',
    'section'     => 'sectisection_idon_1',
    'default'     => '#000000',
    'priority'    => 14,
    'colors'      => Util::_get_material_colors( 'all' ),
    'shape'       => 'square',
    'size'        => 20
]);
```

#### Usage

The `get_theme_mod()` function is recommended to retrieve data.

```php
// Return a string
echo get_theme_mod('colorsetdb1');
```

### Content Editor

The `content-editor` lets you add a Content Editor Field.

### Parameters

Here are the parameters in adding content-editor.

__id__

_string | required_

A unique slug-like string to use as an id and also as index in saving data in database.

__label__

_string | optional_

The label of the field.

__description__

_string | optional_

The description of the field and display under the label.

__section__

_string | requiredl_

The section where the field will be displayed.

__default__

_string | optional_

The default value of the field.

__priority__

_integer | optional_

Determines the order of fields in section.

__uploader__

_boolean | optional | default: false_

Add a media uploader button.

__toolbars__

_array | optional_

Allowing to add controls in toolbars.

Note: here are the list of toolbars available [ 'bold', 'italic', 'strikethrough', 'bullist', 'numlist', 'blockquote', 'hr', 'alignleft', 'aligncenter', 'alignright', 'link', 'unlink', 'wp_more', 'spellchecker', 'fullscreen', 'wp_adv', 'formatselect', 'underline', 'alignjustify', 'forecolor', 'pastetext', 'removeformat', 'charmap', 'outdent', 'indent', 'undo', 'redo', 'wp_help' ]

#### Examples

```php
Customizer::field( 'content-editor', [
   'id'          => 'editor1',
   'label'       => 'Write Your Content',
   'description' => 'Description Here.',
   'section'     => 'section_id',
   'priority'    => 1,
] );
```

Example with default value! note: default value can only be supplied of string or html.

```php
Customizer::field( 'content-editor', [
   'id'          => 'editor1',
   'label'       => 'Write Your Content',
   'description' => 'Description Here.',
   'section'     => 'section_id',
   'default'     => 'Hello World',
   'priority'    => 1,
] );
```

Example with uploader! note: uploader can be supplied only in boolean.

```php
Customizer::field( 'content-editor', [
   'id'          => 'editor1',
   'label'       => 'Write Your Content',
   'description' => 'Description Here.',
   'section'     => 'section_id',
   'default'     => 'Hello World',
   'priority'    => 1,
   'uploader'    => true
] );
```

Example with toolbars! here are the list of toolbars available bold, italic, strikethrough, bullist, numlist, blockquote, hr, alignleft, aligncenter, alignright, link, unlink, wp_more, spellchecker, fullscreen, wp_adv, formatselect, underline, alignjustify, forecolor, pastetext, removeformat, charmap, outdent, indent, undo, redo, wp_help.

```php
Customizer::field( 'content-editor', [
   'id'          => 'editor1',
   'label'       => 'Write Your Content',
   'description' => 'Description Here.',
   'section'     => 'section_id',
   'default'     => 'Hello World',
   'priority'    => 1,
   'uploader'    => true,
   'toolbars'    => [ 'bold', 'italic' ]
] );
```

### Usage

The `get_theme_mod()` function is recommended to retrieve data.

```php
// Return a string
echo get_theme_mod('editor1');
```

#### Date Picker

The `date-picker` lets you add a field for selecting date.

#### Parameters

Here are the parameters in adding button-set.

__id__

_string | required_

A unique slug-like string to use as an id and also as index in saving data in database.

__label__

_string | optional_

The label of the field.

__description__

_string | optional_

The description of the field and display under the label.

__section__

_string | requiredl_

The section where the field will be displayed.

__default__

_string | optional_

The default value of the field.

__priority__

_integer | optional_

Determines the order of fields in section.

__placeholder__

_string | optional_

Display placeholder in the field.

__mode__

_string | optional :: single | range_

Set the type of mode single or range.

__enable_time__

_boolean | optional | default : false_

Allows to add time in calendar.

Notes
1. The default value will be depending on the mode

if mode is set to single so the default value must be supplied string
if mode is set to range so the default value must be supplied array with two date the START DATE and END DATE
2. The date format in default value also depending on enable_time.

if enable_time is set to false the format will be Y-m-d YEAR-MONTH-DATE
if enable_time is set to true the format will be Y-m-d H:i YEAR-MONTH-DATE HOUR-MINUTE

#### Examples

```php
Customizer::field( 'date-picker', [
   'id'          => 'datepickerdb1',
   'label'       => 'Set The Date',
   'description' => 'Please add date you want.',
   'section'     => 'section_id',
   'default'     => '2020-05-30',
   'priority'    => 1,
   'placeholder' => 'Date',
   'mode'        => 'single',
] );
```

Example with mode: range and enable_time: true.

```php
Customizer::field( 'date-picker', [
   'id'          => 'datepickerdb1',
   'label'       => 'Set The Date',
   'description' => 'Please add date you want.',
   'section'     => 'section_id',
   'default'     => ['2020-01-05', '2020-01-10'],
   'mode'        => 'range',
   'priority'    => 1,
   'enable_time' => true,
   'placeholder' => 'Date',
] );
```

#### Usage

The `get_theme_mod()` function is recommended to retrieve data.

```php
// Return a array
$date = explode(',', get_theme_mod('datepickerdb1'));
```

#### Dropdown Custom Post

The `dropdown-custom-post` lets you add a select field where the options is custom post.

### Parameters

Here are the parameters in adding dropdown-custom-post.

__id__

_string | required_

A unique slug-like string to use as an id and also as index in saving data in database.

__label__

_string | optional_

The label of the field.

__description__

_string | optional_

The description of the field and display under the label.

__section__

_string | requiredl_

The section where the field will be displayed.

__default__

_integer | optional_

The default value of the field.

Note: default value must be a post id.

__priority__

_integer | optional_

Determines the order of fields in section.

__post_type__

_string | required_

Name of custom post type.

Note: post_type value must be existing custom post.

__order__

_string | optional_

Sets the order to ascending and descending.

Note: order only accept 'asc' and 'desc'.

### Example

```php
Customizer::field('dropdown-custom-post', [
   'id'          => 'dropdowncustompostdb1',
   'label'       => 'Select Custom Post',
   'description' => 'You can select a custom post in here.',
   'section'     => 'section_id',
   'priority'    => 1,
   'post_type'   => 'project',
   'order'       => 'asc'
]);
```

Example with default value! note: default value must existing post id.

```php
Customizer::field('dropdown-custom-post', [
   'id'          => 'dropdowncustompostdb1',
   'label'       => 'Select Custom Post',
   'description' => 'You can select a custom post in here.',
   'section'     => 'section_id',
   'default'     => 100,
   'priority'    => 1,
   'post_type'   => 'project',
   'order'       => 'asc'
]);
```

### Usage

The `get_theme_mod()` function is recommended to retrieve data.

```php
// Get the post by id
$post = get_post(get_theme_mod('dropdowncustompostdb1'));
```

#### Dropdown Page

The `dropdown-page` lets you add a select field with list of pages.

#### Parameters

Here are the parameters in adding dropdown-page.

__id__

_string | required_

A unique slug-like string to use as an id and also as index in saving data in database.

__label__

_string | optional_

The label of the field.

__description__

_string | optional_

The description of the field and display under the label.

__section__

_string | requiredl_

The section where the field will be displayed.

__default__

_integer | optional_

The default value of the field.

Note: default value must be a page id.

__priority__

_integer | optional_

Determines the order of fields in section.

__order__

_string | optional_

Sets the order to ascending and descending.

Note: order only accept 'asc' and 'desc'.

#### Example

```php
Customizer::field('dropdown-page', [
   'id'          => 'dropdownpagedb1',
   'label'       => 'Select Page',
   'description' => 'You can select a page in here.',
   'section'     => 'section_id',
   'priority'    => 1,
   'order'       => 'asc'
]);
```

Example with default value! note: default value must existing page id.

```php
Customizer::field('dropdown-page', [
   'id'          => 'dropdownpagedb1',
   'label'       => 'Select Page',
   'description' => 'You can select a page in here.',
   'section'     => 'section_id',
   'default'     => 100,
   'priority'    => 1,
   'order'       => 'desc'
]);
```

#### Usage

The `get_theme_mod()` function is recommended to retrieve data.

```php
// Get the page by id
$page = get_post(get_theme_mod('dropdownpagedb1'));
```

#### Dropdown Post

The `dropdown-post` lets you add a select field with list of posts.

#### Parameters

Here are the parameters in adding dropdown-post.

__id__

_string | required_

A unique slug-like string to use as an id and also as index in saving data in database.

__label__

_string | optional_

The label of the field.

__description__

_string | optional_

The description of the field and display under the label.

__section__

_string | requiredl_

The section where the field will be displayed.

__default__

_integer | optional_

The default value of the field.

Note: default value must be a post id.

__priority__

_integer | optional_

Determines the order of fields in section.

__order__

_string | optional_

Sets the order to ascending and descending.

Note: order only accept 'asc' and 'desc'.

#### Examples

```php
Customizer::field('dropdown-post', [
   'id'          => 'dropdownpostdb1',
   'label'       => 'Select Post',
   'description' => 'You can select a page in here.',
   'section'     => 'section_id',
   'priority'    => 1,
   'order'       => 'asc'
]);
```

Example with `default` value! note: default value must existing `post id` .

```php
Customizer::field('dropdown-post', [
   'id'          => 'dropdownpostdb1',
   'label'       => 'Select Post',
   'description' => 'You can select a post in here.',
   'section'     => 'section_id',
   'default'     => 100,
   'priority'    => 1,
   'order'       => 'desc'
]);
```

#### Usage

The `get_theme_mod()` function is recommended to retrieve data.

```php
// Get the post by id
$post = get_post(get_theme_mod('dropdownpostdb1'));
```

#### Email

The `email` lets you add a email field.

#### Parameters

Here are the parameters in adding email.

__id__

_string | required_

A unique slug-like string to use as an id and also as index in saving data in database.

__label__

_string | optional_

The label of the field.

__description__

_string | optional_

The description of the field and display under the label.

__section__

_string | requiredl_

The section where the field will be displayed.

__default__

_string | optional_

The default value of the field.

Note: default value must be provided with a valid email.

__priority__

_integer | optional_

Determines the order of fields in section.

__placeholder__

_string | optional_

Display placeholder in the control.

#### Examples

```php
Customizer::field('email', [
   'id'          => 'emaildb1',
   'label'       => 'Enter Email',
   'description' => 'Write your valid email address.',
   'section'     => 'section_id',
   'priority'    => 1,
   'placeholder' => 'Email Address'
]);
```

Example with default value! note: default value must be a valid email.

```php
Customizer::field('email', [
   'id'          => 'emaildb1',
   'label'       => 'Enter Email',
   'description' => 'Write your valid email address.',
   'section'     => 'section_id',
   'default'     => 'name@email.com',
   'priority'    => 1,
   'placeholder' => 'Email Address'
]);
```

#### Usage

The `get_theme_mod()` function is recommended to retrieve data.

```php
// Returns a string
echo get_theme_mod('emaildb1');
```

#### File Uploader

The `file-uploader` lets you add a field for uploading and selecting document files in WordPress Media Library.

#### Parameters

Here are the parameters in adding file-uploader.

__id__

_string | required_

A unique slug-like string to use as an id and also as index in saving data in database.

__label__

_string | optional_

The label of the field.

__description__

_string | optional_

The description of the field and display under the label.

__section__

_string | requiredl_

The section where the field will be displayed.

__default__

_integer | optional_

The default value of the field.

Note: default value must be valid or existing "attachment ID"

__priority__

_integer | optional_

Determines the order of fields in section.

__placeholder__

_string | optional_

Display placeholder in the field.

__extensions__

_array | optional_

Allowing to set the allowed file extensions.

Note: here are the list of allowed extensions [ 'pdf', 'doc', 'docx', 'ppt', 'pptx', 'pps', 'ppsx', 'odt', 'xls', 'xlsx', 'psd' ]

#### Examples

```php
Customizer::field('file-uploader', [
   'id'          => 'filedb1',
   'label'       => 'Select File',
   'description' => 'Description Here.',
   'section'     => 'section_id',
   'priority'    => 1,
   'placeholder' => 'Select File'
]);
```

Example with default value! note: default value can only be supplied of the attachment ID.

```php
Customizer::field('file-uploader', [
   'id'          => 'filedb1',
   'label'       => 'Select File',
   'description' => 'Description Here.',
   'section'     => 'section_id',
   'default'     => 123,
   'priority'    => 1,
   'placeholder' => 'Select File'
]);
```

Example with extensions! Note: here are the list of allowed extensions pdf, doc, docx, ppt, pptx, pps, ppsx, odt, xls, xlsx, psd.

```php
Customizer::field('file-uploader', [
   'id'          => 'filedb1',
   'label'       => 'Select File',
   'description' => 'Description Here.',
   'section'     => 'section_id',
   'default'     => 123,
   'priority'    => 1,
   'placeholder' => 'Select File',
   'extensions'  => [ 'pdf', 'doc' ]
]);
```

#### Usage

The `get_theme_mod()` function is recommended to retrieve data.

```php
// Getting the url
wp_get_attachement_url(get_theme_mod('filedb1'));
```

#### Image Uploader

The `image-uploader` lets you add a field for uploading and selecting images in WordPress Media Library.

#### Parameters

Here are the parameters in adding image-uploader.

__id__

_string | required_

A unique slug-like string to use as an id and also as index in saving data in database.

__label__

_string | optional_

The label of the field.

__description__

_string | optional_

The description of the field and display under the label.

__section__

_string | requiredl_

The section where the field will be displayed.

__default__

_integer | optional_

The default value of the field.

Note: default value must be valid or existing "attachment ID"

__priority__

_integer | optional_

Determines the order of fields in section.

__placeholder__

_string | optional_

Display placeholder in the field.

__extensions__

_array | optional_

Allowing to set the allowed audio extensions.

Note: here are the list of allowed extensions [ 'png', 'jpg', 'jpeg', 'ico', 'gif' ]

#### Examples

```php
Customizer::field('image-uploader', [
   'id'          => 'imageuploaderdb1',
   'label'       => 'Select Image',
   'description' => 'Description Here.',
   'section'     => 'section_id',
   'priority'    => 1,
   'placeholder' => 'Select Image'
]);
```

Example with default value! note: default value can only be supplied of the attachment ID.

```php
Customizer::field('image-uploader', [
   'id'          => 'imageuploaderdb1',
   'label'       => 'Select Image',
   'description' => 'Description Here.',
   'section'     => 'section_id',
   'default'     => 123,
   'priority'    => 1,
   'placeholder' => 'Select Image'
]);
```

Example with extensions value! note: here are the list of allowed extensions png, jpg, jpeg, ico, gif.

```php
Customizer::field('image-uploader', [
   'id'          => 'imageuploaderdb1',
   'label'       => 'Select Image',
   'description' => 'Description Here.',
   'section'     => 'section_id',
   'default'     => 123,
   'priority'    => 1,
   'placeholder' => 'Select Image',
   'extensions'  => [ 'png', 'ico' ]
]);
```

#### Usage

The `get_theme_mod()` function is recommended to retrieve data.

```php
// Getting the url
wp_get_attachement_url(get_theme_mod('imageuploaderdb1'));
```

#### Markup

The `markup` lets you add a HTML in Theme Customizer Sizebar.

#### Parameters

Here are the parameters in adding markup.

__id__

_string | required_

A unique slug-like string to use as an id.

__section__

_string | required_

The section where the field will be displayed.

__priority__

_integer | optional_

Determines the order of fields in section.

__html__

_string | required_

Html code to be display in Theme Customizer Sidebar.

Note: add html markup in here.

#### Examples

```php
Customizer::field('markup', [
   'id'       => 'markup1',
   'section'  => 'section_1',
   'priority' => 1,
   'html'     => 'HTML Markup in here...'
]);
```

#### Usage

The `get_theme_mod()` function is recommended to retrieve data.

```php
// Returns a string
echo get_theme_mod('markup1');
```

#### Numeric

The `numeric` lets you add a field for number.

#### Parameters

Here are the parameters in adding numeric.

__id__

_string | required_

A unique slug-like string to use as an id and also as index in saving data in database.

__label__

_string | optional_

The label of the field.

__description__

_string | optional_

The description of the field and display under the label.

__section__

_string | requiredl_

The section where the field will be displayed.

__default__

_integer | optional_

The default value of the field.

__priority__

_integer | optional_

Determines the order of fields in section.

__options__

_array | optional_

Set of options.

__options['min']__

_integer | required_

Minimum value set.

__options['max']__

_integer | required_

Maximum value set.

__options['step']__

_int | optional_

Stepper value.

#### Examples

```php
Customizer::field('numeric', [
   'id'          => 'numericdb1',
   'label'       => 'Enter Number',
   'description' => 'Some description',
   'section'     => 'section_id',
   'priority'    => 1,
   'options' => [
      'min'  => 0,
      'max'  => 100,
      'step' => 1
   ]
]);
```

Example with `default` value.

Note: The `default` value must be numeric type.

```php
Customizer::field('numeric', [
   'id'          => 'numericdb1',
   'label'       => 'Enter Number',
   'description' => 'Some description',
   'section'     => 'section_id',
   'default'     => 50,
   'priority'    => 1,
   'options' => [
      'min'  => 0,
      'max'  => 100,
      'step' => 1
   ]
]);
```

#### Usage

The `get_theme_mod()` function is recommended to retrieve data.

```php
// Returns a string
echo get_theme_mod('numericdb1');
```

#### Radio

The `radio` lets you add a field radio.

#### Parameters

Here are the parameters in adding radio.

__id__

_string | required_

A unique slug-like string to use as an id and also as index in saving data in database.

__label__

_string | optional_

The label of the field.

__description__

_string | optional_

The description of the field and display under the label.

__section__

_string | required_

The section where the field will be displayed.

__default__

_string | optional_

The default value of the field.

Note: default value must exist within the choices.

__priority__

_integer | optional_

Determines the order of fields in section.

__choices__

_array | required_

List of choices.

#### Examples

```php
Customizer::field('radio', [
   'id'             => 'radiodb1',
   'label'          => 'Choose your country',
   'description'    => 'Select your country.',
   'section'        => 'section_id',
   'priority'       => 1,
   'choices'        => [
      'america'     => __( 'America' ),
      'philippines' => __( 'Philippines' ),
      'peru'        => __( 'Peru' )
   ]
]);
```

Example with default value! note: default value must exist in choices.

```php
Customizer::field('radio', [
   'id'             => 'radiodb1',
   'label'          => 'Choose your country',
   'description'    => 'Select your country.',
   'section'        => 'section_id',
   'default'        => 'philippines',
   'priority'       => 1,
   'choices'        => [
      'america'     => __( 'America' ),
      'philippines' => __( 'Philippines' ),
      'peru'        => __( 'Peru' )
   ]
]);
```

#### Usage

The `get_theme_mod()` function is recommended to retrieve data.

```php
// Returns a string
echo get_theme_mod('radiodb1');
```

#### Range

The `range` lets you add a range field.

#### Parameters

Here are the parameters in adding range.

__id__

_string | required_

A unique slug-like string to use as an id and also as index in saving data in database.

__label__

_string | optional_

The label of the field.

__description__

_string | optional_

The description of the field and display under the label.

__section__

_string | requiredl_

The section where the field will be displayed.

__default__

_integer | optional_

The default value of the field.

__priority__

_integer | optional_

Determines the order of fields in section.

__options__

_array | optional_

Set of options.

__options['min']__

_integer | required_

Minimum value set.

__options['max']__

_integer | required_

Maximum value set.

__options['step']__

_int | optional_

Stepper value.

Stepper value.

#### Examples

```php
Customizer::field('range', [
   'id'          => 'rangedb1',
   'label'       => 'Set Limit Of Visitor',
   'description' => 'Limit Number Of Visitor.',
   'section'     => 'section_id',
   'priority'    => 1,
   'options' => [
       'min'   => 0,
       'max'   => 100,
       'step'  => 1
   ]
]);
```

Example with default value! note: default value must be numeric.

```php
Customizer::field('range', [
   'id'          => 'rangedb1',
   'label'       => 'Set Limit Of Visitor',
   'description' => 'Limit Number Of Visitor.',
   'section'     => 'section_id',
   'default'     => 50,
   'priority'    => 1,
   'options' => [
       'min'   => 0,
       'max'   => 100,
       'step'  => 1
   ]
]);
```

#### Usage

The `get_theme_mod()` function is recommended to retrieve data.

```php
// Return a integer
echo get_theme_mod('rangedb1');
```

#### Select

The `select` lets you add a select field.

#### Parameters

Here are the parameters in adding select.

__id__

_string | required_

A unique slug-like string to use as an id and also as index in saving data in database.

__label__

_string | optional_

The label of the field.

__description__

_string | optional_

The description of the field and display under the label.

__section__

_string | requiredl_

The section where the field will be displayed.

__default__

_string | optional_

The default value of the field.

Note: default value must exist in choices.

__priority__

_integer | optional_

Determines the order of fields in section.

__choices__

_array | required_

List of choices

#### Examples

```php
Customizer::field('select', [
   'id'           => 'selectdb1',
   'label'        => 'Select Fruits',
   'description'  => 'Select your favorite fruits.',
   'section'      => 'section_id',
   'priority'     => 1,
   'choices'      => [
      'apple'  => 'Apple',
      'orange' => 'Orange',
      'grape'  => 'Grape'
   ]
]);
```

Example with default value! note: default value must exist in choices.

```php
Customizer::field('select', [
   'id'           => 'selectdb1',
   'label'        => 'Select Fruits',
   'description'  => 'Select your favorite fruits.',
   'section'      => 'section_id',
   'default'      => 'apple',
   'priority'     => 1,
   'choices'      => [
      'apple'  => 'Apple',
      'orange' => 'Orange',
      'grape'  => 'Grape'
   ]
]);
```

#### Usage

The `get_theme_mod()` function is recommended to retrieve data.

```php
// Return a integer
echo get_theme_mod('selectdb1');
```

#### Size

The `size` lets you add a input field for size.

#### Parameters

Here are the parameters in adding size.

__id__

_string | required_

A unique slug-like string to use as an id and also as index in saving data in database.

__label__

_string | optional_

The label of the field.

__description__

_string | optional_

The description of the field and display under the label.

__section__

_string | requiredl_

The section where the field will be displayed.

__default__

_string | optional_

The default value of the field.

__priority__

_integer | optional_

Determines the order of fields in section.

__units__

_array | required_

List of valid units 'px', 'em', 'ex', 'ch', 'rem', 'vw', 'vh', 'vmin', 'vmax', '%'.

Note: units value must be valid

__placeholder__

_string | optional_

This will be display as placeholder.

#### Examples

```php
Customizer::field('size', [
   'id'          => 'sizedb1',
   'label'       => 'Enter Padding Size',
   'description' => 'Add size in here.',
   'section'     => 'section_id',
   'priority'    => 1,
   'placeholder' => 'Enter size',
   'units'       => [ 'px', 'em' ],
]);
```

Example of default value!

```php
Customizer::field('size', [
   'id'          => 'sizedb1',
   'label'       => 'Enter Padding Size',
   'description' => 'Add size in here.',
   'section'     => 'section_id',
   'default'     => '2em',
   'priority'    => 1,
   'placeholder' => 'Enter size',
   'units'       => [ 'px', 'em' ],
]);
```

#### Usage

The `get_theme_mod()` function is recommended to retrieve data.

```php
// Return a integer
echo get_theme_mod('sizedb1');
```

#### Switch

The `switch` lets you add a field switch.

#### Parameters

Here are the parameters in adding switch.

__id__

_string | required_

A unique slug-like string to use as an id and also as index in saving data in database.

__label__

_string | optional_

The label of the field.

__description__

_string | optional_

The description of the field and display under the label.

__section__

_string | requiredl_

The section where the field will be displayed.

__default__

_boolean | optional_

The default value of the field.

__priority__

_integer | optional_

Determines the order of fields in section.

#### Examples

```php
Customizer::field('switch', [
    'id'          => 'switchdb1',
    'label'       => 'Do you want to show?',
    'description' => 'Some description',
    'section'     => 'section_id',
    'priority'    => 1,
]);
```

Example with default value! note: default value must be provided boolean.

```php
Customizer::field('switch', [
    'id'          => 'switchdb1',
    'label'       => 'Do you want to show?',
    'description' => 'Some description',
    'section'     => 'section_id',
    'default'     => true,
    'priority'    => 1,
]);
```

#### Usage

The `get_theme_mod()` function is recommended to retrieve data.

```php
// Returns boolean
$is_checked = get_theme_mod('switchdb1');
```

#### Text

The `text` lets you add a text field.

#### Parameters

Here are the parameters in adding text.

__id__

_string | required_

A unique slug-like string to use as an id and also as index in saving data in database.

__label__

_string | optional_

The label of the field.

__description__

_string | optional_

The description of the field and display under the label.

__section__

_string | requiredl_

The section where the field will be displayed.

__default__

_string | optional_

The default value of the field.

__priority__

_integer | optional_

Determines the order of fields in section.

__placeholder__

_string | optional_

Display placeholder in field.

#### Examples

```php
Customizer::field('text', [
   'id'          => 'textdb1',
   'label'       => 'Short Story',
   'description' => 'Write short story in here.',
   'section'     => 'section_id',
   'priority'    => 1,
   'placeholder' => 'Your story in here...'
]);
```

Example with default value.

```php
Customizer::field('text', [
   'id'          => 'textdb1',
   'label'       => 'Short Story',
   'description' => 'Write short story in here.',
   'section'     => 'section_id',
   'default'     => 'hello world',
   'priority'    => 1,
   'placeholder' => 'Your story in here...'
]);
```

#### Usage

The `get_theme_mod()` function is recommended to retrieve data.

```php
// Return a string
echo get_theme_mod('textdb1');
```

#### Textarea

The `textarea` lets you add a textarea field.

#### Parameters

Here are the parameters in adding textarea.

__id__

_string | required_

A unique slug-like string to use as an id and also as index in saving data in database.

__label__

_string | optional_

The label of the field.

__description__

_string | optional_

The description of the field and display under the label.

__section__

_string | requiredl_

The section where the field will be displayed.

__default__

_string | optional_

The default value of the field.

__priority__

_integer | optional_

Determines the order of fields in section.

__placeholder__

_string | optional_

Display placeholder in field.

#### Examples

```php
Customizer::field('textarea', [
   'id'          => 'textareadb1',
   'label'       => 'Short Story',
   'description' => 'Write short story in here.',
   'section'     => 'section_id',
   'priority'    => 1,
   'placeholder' => 'Your story in here...'
]);
```

Example with default value.

```php
Customizer::field('textarea', [
   'id'          => 'textareadb1',
   'label'       => 'Short Story',
   'description' => 'Write short story in here.',
   'section'     => 'section_id',
   'default'     => 'hello world',
   'priority'    => 1,
   'placeholder' => 'Your story in here...'
]);
```

### Usage

The `get_theme_mod()` function is recommended to retrieve data.

```php
// Return a string
echo get_theme_mod('textareadb1');
```

#### Time Picker

The `time-picker` lets you add a time picker field.

#### Parameters

Here are the parameters in adding time-picker.

__id__

_string | required_

A unique slug-like string to use as an id and also as index in saving data in database.

__label__

_string | optional_

The label of the field.

__description__

_string | optional_

The description of the field and display under the label.

__section__

_string | required_

The section where the field will be displayed.

__default__

_string | optional_

The default value of the field.

__priority__

_integer | optional_

Determines the order of fields in section.

__placeholder__

_string | optional_

Display placeholder in field.

__military_format__

_boolean | optional | default : false_

Set if the time picker will be in military time format.

__Note__
The value will return string and in military format.
Default format must be in correct format "H:i" examples: 01:01, 12:30, 23:08 and also set as military time.

#### Examples

```php
Customizer::field('time-picker', [
   'id'          => 'timepickerdb1',
   'label'       => 'Set The Time',
   'description' => 'Please add time you want.',
   'section'     => 'section_id',
   'placeholder' => 'Time',
   'priority'    => 1
]);
```

Example with default and military_format.

```php
Customizer::field('time-picker', [
   'id'              => 'timepickerdb1',
   'label'           => 'Set The Time',
   'description'     => 'Please add time you want.',
   'section'         => 'section_id',
   'default'         => '01:00',
   'military_format' => true,
   'placeholder'     => 'Time',
   'priority'        => 1
]);
```

#### Usage

The `get_theme_mod()` function is recommended to retrieve data.

```php
// Return a string
echo get_theme_mod('timepickerdb1');
```

#### Toggle

The `toggle` lets you add a field toggle.

#### Parameters

Here are the parameters in adding toggle.

__id__

_string | required_

A unique slug-like string to use as an id and also as index in saving data in database.

__label__

_string | optional_

The label of the field.

__description__

_string | optional_

The description of the field and display under the label.

__section__

_string | requiredl_

The section where the field will be displayed.

__default__

_boolean | optional_

The default value of the field.

__priority__

_integer | optional_

Determines the order of fields in section.

#### Examples

```php
Customizer::field('toggle', [
    'id'          => 'toggledb1',
    'label'       => 'Do you want to show?',
    'description' => 'Some description',
    'section'     => 'section_id',
    'priority'    => 1,
]);
```

Example with default value! note: default value must be provided boolean.

```php
Customizer::field('toggle', [
    'id'          => 'toggledb1',
    'label'       => 'Do you want to show?',
    'description' => 'Some description',
    'section'     => 'section_id',
    'default'     => true,
    'priority'    => 1,
]);
```

#### Usage

The `get_theme_mod()` function is recommended to retrieve data.

```php
// Returns boolean
$is_checked = get_theme_mod('toggledb1');
```

#### Url

The `url` lets you add a url field.

#### Parameters

Here are the parameters in adding url.

__id__

_string | required_

A unique slug-like string to use as an id and also as index in saving data in database.

__label__

_string | optional_

The label of the field.

__description__

_string | optional_

The description of the field and display under the label.

__section__

_string | requiredl_

The section where the field will be displayed.

__default__

_string | optional_

The default value of the field.

Note: default value must be provided with a valid url.

__priority__

_integer | optional_

Determines the order of fields in section.

__placeholder__

_string | optional_

Display placeholder in the control.

#### Examples

```php
Customizer::field( 'url', [
   'id'          => 'urldb1',
   'label'       => 'Enter URL',
   'description' => 'Some description.',
   'section'     => 'section_id',
   'priority'    => 1,
   'placeholder' => 'Enter Your URL'
]);
```

Example with default value! note: default value must be a valid url.

```php
Customizer::field( 'url', [
   'id'          => 'urldb1',
   'label'       => 'Enter URL',
   'description' => 'Some description.',
   'section'     => 'section_id',
   'default'     => 'https://www.facebook.com',
   'priority'    => 1,
   'placeholder' => 'Enter Your URL'
]);
```

#### Usage

The `get_theme_mod()` function is recommended to retrieve data.

```php
// Returns a string
echo get_theme_mod('urldb1');
```

#### Video Uploader

The `video-uploader` lets you add a field for uploading and selecting video files in WordPress Media Library.

#### Parameters

Here are the parameters in adding video-uploader.

__id__

_string | required_

A unique slug-like string to use as an id and also as index in saving data in database.

__label__

_string | optional_

The label of the field.

__description__

_string | optional_

The description of the field and display under the label.

__section__

_string | requiredl_

The section where the field will be displayed.

__default__

_integer | optional_

The default value of the field.

Note: default value must be valid or existing "attachment ID"

__priority__

_integer | optional_

Determines the order of fields in section.

__placeholder__

_string | optional_

Display placeholder in the field.

__extensions__

_array | optional_

Allowing to set the allowed audio extensions.

Note: here are the list of allowed extensions [ 'mp4', 'm4v', 'mov', 'wmv', 'avi', 'mpg', 'ogv', '3gp', '3g2', 'webm', 'mkv' ]

#### Examples

```php
Customizer::field('video-uploader', [
   'id'          => 'videuploaderdb1',
   'label'       => 'Select Video',
   'description' => 'Description Here.',
   'section'     => 'section_id',
   'priority'    => 1,
   'placeholder' => 'Select Video'
]);
```

Example with default value! note: default value can only be supplied of the attachment ID.

```php
Customizer::field('video-uploader', [
   'id'          => 'videuploaderdb1',
   'label'       => 'Select Video',
   'description' => 'Description Here.',
   'section'     => 'section_id',
   'default'     => 123,
   'priority'    => 1,
   'placeholder' => 'Select Video'
]);
```

Example with extensions value! note: here are the list of allowed extensions mp4, m4v, mov, wmv, avi, mpg, ogv, 3gp, 3g2, webm, mkv.

```php
Customizer::field('video-uploader', [
   'id'          => 'videuploaderdb1',
   'label'       => 'Select Video',
   'description' => 'Description Here.',
   'section'     => 'section_id',
   'default'     => 123,
   'priority'    => 1,
   'placeholder' => 'Select Video',
   'extensions'  => [ 'mp4', 'mkv' ]
]);
```

#### Usage

The `get_theme_mod()` function is recommended to retrieve data.

```php
// Getting the url
wp_get_attachement_url(get_theme_mod('videuploaderdb1'));
```

### Show/Hide Conditionally

#### Active Callback

The active_callback can be use to set if field will be display under a condition. For more information you can read Customizer APIs.

#### Examples

In this example the text field will be display if toggle is equal to true.

```php
/**
 * Creating a toggle field
 */
Customizer::field('toggle', [
   'id'          => 'toggledb1c',
   'label'       => 'Do you want to show text field ?',
   'description' => 'If you want to display the text.',
   'section'     => 'section_id',
   'priority'    => 1
]);

/**
 * Creating a text field
 *
 * Only Show textdb1c field if toggledb1c is equal to true
 */
Customizer::field('text', [
   'id'              => 'textdb1c',
   'label'           => 'Text',
   'section'         => 'active',
   'priority'        => 2,
   'active_callback' => fn () => (get_theme_mod('toggledb1c') === true );
]);
```

Example 2: in this example the text field will only show at front page.

```php
/**
 * Creating text field
 */
Customizer::field( 'text', [
   'id'              => 'textdb1c',
   'label'           => 'Text',
   'section'         => 'active',
   'priority'        => 2,
   'active_callback' => fn () => (is_front_page() == true)
]);
```

### Utilities

The Customizer Framework also provide useful methods that will help in common tasks.

#### Gets an array of pages

The `Util::_get_pages()` returns all the pages in an array

```php
use CustomizerFramework\Core\Customizer;
use CustomizerFramework\Lib\Util;

$pages = Util::_get_pages(); // this will return the page id and page title

/**
 * Using in field
 *
 * In this example we will going to use this in select field in choices
 */
Customizer::field('select', [
   'id'           => 'selectdb1',
   'label'        => 'Select Page',
   'section'      => 'section_id',
   'priority'     => 1,
   'choices'      => Util::_get_pages()
]);
```

#### Gets an array of posts

The `Util::_get_posts()` returns all the posts in an array.

```php
use CustomizerFramework\Core\Customizer;
use CustomizerFramework\Lib\Util;

/**
 * Lets assume that we have a custom post "project"
 */
$projects = Util::_get_post('project'); // this will return the post id and post title in post "project"

/**
 * Using in field
 *
 * In this example we will going to use this in select field in choices
 */
Customizer::field('select', [
   'id'           => 'selectdb1',
   'label'        => 'Select Projects',
   'section'      => 'section_id',
   'priority'     => 1,
   'choices'      => Util::_get_post( 'project' )
]);
```

#### Gets all available taxonomy

The `Util::_get_taxonomies()` returns taxonomy slug and name.

```php
use CustomizerFramework\Core\Customizer;
use CustomizerFramework\Lib\Util;

$taxonomies = Util::_get_taxonomies(); // this will return the taxonomy slug and name

/**
 * Using in field
 *
 * In this example we will going to use this in select field in choices
 */
Customizer::field('select', [
   'id'           => 'selectdb1',
   'label'        => 'Select Taxonomy',
   'section'      => 'section_id',
   'priority'     => 1,
   'choices'      => Util::_get_taxonomies()
]);
```

#### Gets all available post types

The `Util::_get_post_types()` returns post type slug and name.

```php
use CustomizerFramework\Core\Customizer;
use CustomizerFramework\Lib\Util;

$post_types = Util::_get_post_types(); // this will return post type slug and name

/**
 * Using in field
 *
 * In this example we will going to use this in select field in choices
 */
Customizer::field( 'select', [
   'id'           => 'selectdb1',
   'label'        => 'Select Post Type',
   'section'      => 'section_id',
   'priority'     => 1,
   'choices'      => Util::_get_post_types()
]);
```

#### Gets material colors

The `Util::_get_material_colors($type)` returns a set of material colors. It has 1 parameter `$type` and here are the valid types `all` , `primary` , `a100` , `a200` , `a400` , `a700` , `red` , `pink` , `purple` , `deepPurple` , `indigo` , `lightBlue` , `cyan` , `teal` , `green` , `lightGreen` , `lime` , `yellow` , `amber` , `orange` , `deepOrange` , `brown` , `grey` , `blueGrey` .

```php
use CustomizerFramework\Core\Customizer;
use CustomizerFramework\Lib\Util;

/**
 * In this example we will going to use in color set field
 */

// Example 1: return all material color
Customizer::field( 'color-set', [
    'id'          => 'colorsetdb1',
    'label'       => 'Choose Color 1',
    'description' => 'Some description',
    'section'     => 'sectisection_idon_1',
    'default'     => '#000000',
    'priority'    => 14,
    'colors'      => Util::_get_material_colors( 'all' ), // returns all the material color
    'shape'       => 'square',
    'size'        => 20
]);

// Example 2: return primary color only
Customizer::field( 'color-set', [
    'id'          => 'colorsetdb1',
    'label'       => 'Choose Color 1',
    'description' => 'Some description',
    'section'     => 'sectisection_idon_1',
    'default'     => '#000000',
    'priority'    => 14,
    'colors'      => Util::_get_material_colors( 'primary' ), // returns all the primary color
    'shape'       => 'square',
    'size'        => 20
]);

// Example 3: return purple color only
Customizer::field( 'color-set', [
    'id'          => 'colorsetdb1',
    'label'       => 'Choose Color 1',
    'description' => 'Some description',
    'section'     => 'sectisection_idon_1',
    'default'     => '#000000',
    'priority'    => 14,
    'colors'      => Util::_get_material_colors( 'purple' ), // returns all the purple color
    'shape'       => 'square',
    'size'        => 20
]);
```

### Validation

The `validations` allows you to add validation to a certain field. It will print an error message regarding on the validation you set. For more information you can read in Customizer APIs.

Example a text field added required validation, the error message will print if the text field is empty.

#### How to add validation?

Its easy to add a validation all you need is to add validations and supply it with validations.

```php
Customizer::field('text', [
   'id'          => 'firstnamedb1',
   'label'       => 'Enter Your Firstname',
   'description' => 'Some description',
   'priority'    => 1,
   'validations' => [ 'required' ]
]);
```

Example 2: multiple validations, you can add validations as many as you can.

```php
/**
 * This example we will going to use the Customizer Framework's built in validation rules.
 * required - print error message if the field is empty
 * is_integer - print error message if the field value is not integer
 * less_than[18] - print error message if the field value is greater than or equal to "parameter" 18
 */
Customizer::field( 'text', [
   'id'          => 'agedb1',
   'label'       => 'Enter Age',
   'description' => 'Some description',
   'priority'    => 1,
   'validations' => [ 'required', 'is_integer', 'less_than[18]' ]
]);
```

You can also create your own custom function for validations. Note the custom function name must end with _customizer_validation example is_number_customizer_validation.

```php
/**
 * In this example we will going to print error message if
 * the field value is equal to "John"
 */
Customizer::field('text', [
   'id'          => 'name',
   'label'       => 'Enter Your Name',
   'description' => 'Some description',
   'priority'    => 1,
   'validations' => [ 'required', 'is_valid_name_customizer_validation' ]
]);

/**
 * Note dont for get to add "_customizer_validation" in the end custom function name.
 * @param object      $validity        holds your custom error message
 * @param any         $value           the value of the field
 * @return $validity  error message
 */
function is_valid_name_customizer_validation( $validity, $value ) {
   if( $value == 'John' ) {
      // printing error message
      $validity->add( 'error', 'John is invalid name.' );
   }
   // dont for get to return $validity
   return $validity;
}
```

#### Validation Rules

Here are the list of available validation rules.
The following are the list of all native validations that are available to use.

__required__

parameter: (none)
error message: "Required Field"

Print error message is the value is empty

__valid_email__

parameter: (none)
error message: "Invalid email address"

Print error message if the value is not valid email

__valid_url__

parameter: (none)
error message: "Invalid url"

Print error message if the value is invalid url

__valid_ip__

parameter: (none)
error message: "Invalid IP address"

Print error message if the value is invalid IP Address

__numeric__

parameter: (none)
error message: "Value must be numeric"
Print error message if the value is invalid number

__is_integer__

parameter: (none)
error message: "Invalid integer"
Print error message if the value contains not integer

__min_length__

parameter: (integer)
error message: "Characters must not lesser #parameter#"
example: min_length[10]

Print error message if character length is less than #parameter#

__max_length__

parameter: (integer)
error message: "Characters must not exceed #parameter#"
example: max_length[10]

print error message if character length is greater than #parameter#

__exact_length__

parameter (integer)
error message - "Characters must not exceed #parameter#"
example: exact_length[10]

print error message if character length is not equal to #parameter#

__greater_than__

parameter (float)
error message - "Value must greater than #parameter#"
example: greater_than[10]

print error message if value is less than or equal to #parameter#
note: can be only used to number value

__greater_than_equal_to__

parameter (float)
error message - "Value must greater than #parameter#"
example: greater_than_equal_to[10]

print error message if value is less than to #parameter#
note: can be only used to number value

__less_than__

parameter (float)
error message - "Value must less than #parameter#"
example: less_than[10]

print error message if value is greater than or equal to #parameter#
note: can be only used to number value

__less_than_equal_to__

parameter (float)
error message - "Value must less than #parameter#"
example: less_than_equal_to[10]

print error message if value is greater than to #parameter#
note: can be only used to number value

__in_list__

parameter (string)
error message - "Value must be in predermined list #parameter#"
example: in_list[apple, grapes, mango]

print error message if value is not in predetermined list value

__not_in_list__

parameter (string)
error message - "Total words must be exactly #parameter#"
example: not_in_list[apple, grapes, mango]
print error message if value is in predetermined list value

__total_words__

parameter (integer)
error message - "Total words must be exactly #parameter#"
example: total_words[2]

value total word count is not equal to #parameter#

__total_words_greater_than__

parameter (integer)
error message - "Total words must be greater than #parameter#"
example: total_words_greater_than[2]

value total word count is less than to #parameter#

__equal_to_setting__

parameter (string)
error message - "Value must equal to setting #setting_value#"
example: equal_to_setting[fullname]

value is not equal to set #settings#
Note: the parameter is the field id.

__not_equal_to_setting__

parameter (string)
error message - "Value must not equal to setting #setting_value#"
example: not_equal_to_setting[fullname]

value is equal to set #settings#
Note: the parameter is the field id.

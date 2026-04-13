# Formify

![license](https://img.shields.io/github/license/PHPShip/Formify) ![issues](https://img.shields.io/github/issues/PHPShip/Formify)

Welcome to Formify, a streamlined PHP library that simplifies generating HTML5 forms. This library has been designed to
ensure rapid form creation while removing repetitive tasks.

Like our work? Please consider starring ⭐ the repository!

## Features

- Generate HTML5 forms programmatically
- Customizable form attributes (POST/GET methods, enctype, etc.)
- Multiple element types: input fields, textareas, selects, buttons, checkboxes, and radio groups
- Fieldset and legend support for grouping related fields
- CSRF token protection
- Get your form as a string with `toHtml()` or echo it directly with `render()`
- TailwindCSS classes support for styling

## Requirements

- PHP 8.0 or higher
- `ext-dom`

## Installation

```bash
composer require polarnix/formify
```

## Quick Start

Formify allows for easy creation of HTML5 forms in a PHP environment. Follow the steps below to generate your first
form:

1. **Require Vendor Autoload**
    - Add the statement `require 'vendor/autoload.php';`, which loads PHP Composer's autoload file to manage
      dependencies.

2. **Import the Form Class**
    - Use the statement `use Formify\Form;` to import the Formify Form class.

3. **Create a Form Configuration**
    - Define a configuration array with relevant settings such as 'action', 'method', and 'enctype'.

4. **Instantiate the Form Class**
    - Create a new instance of the Form class passing the configuration array as an argument.

5. **Add Fields and Render**
    - Use the fluent builder methods to add fields, then call `render()` to output the form.

```php
require 'vendor/autoload.php';
use Formify\Form;

$config = [
    'action' => 'action.php',
    'method' => 'POST',
    'enctype' => 'multipart/form-data'
];

$form = new Form($config);

$form->field()
     ->name('emailAddress')
     ->type('email')
     ->style('border border-blue-100') // TailwindCSS classes supported!
     ->placeholder('Enter your email address')
     ->value('example@gmail.com');

$form->render();
```

## Element Types

Formify supports several element types beyond basic input fields. Each element is created through a factory method on
the Form instance and supports fluent method chaining.

**Textarea**

```php
$form->textarea()
     ->name('message')
     ->placeholder('Enter your message')
     ->rows(6)
     ->cols(40)
     ->content('Default text here');
```

**Select Dropdown**

```php
$form->select()
     ->name('country')
     ->options([
         'us' => 'United States',
         'nl' => 'Netherlands',
         'de' => 'Germany',
     ]);
```

**Checkbox Group**

```php
$form->checkbox('interests', [
    'coding' => 'Coding',
    'design' => 'Design',
    'music'  => 'Music',
]);
```

**Radio Group**

```php
$form->radio('gender', [
    'male'   => 'Male',
    'female' => 'Female',
    'other'  => 'Other',
]);
```

**Button**

```php
$form->button('Send')
     ->style('bg-blue-500 text-white px-4 py-2 rounded');
```

## Fieldsets

You can group related fields together using fieldsets with an optional legend.

```php
$fieldset = $form->fieldset()->legend('Personal Information');
$fieldset->field()->name('firstName')->type('text')->placeholder('First name');
$fieldset->field()->name('lastName')->type('text')->placeholder('Last name');
```

## CSRF Protection

Add a hidden CSRF token field to your form by calling `csrf()` on the form instance. The token will be rendered as a
hidden input named `_token` at the top of the form.

```php
$form->csrf('your-csrf-token-here');
```

## Rendering

You can render the form in two ways:

- `render()` outputs the HTML directly.
- `toHtml()` returns the HTML as a string, which is useful when you need to store or manipulate the output before
  displaying it.

```php
$form->render();

$html = $form->toHtml();
```

## Contributions

Contributions, issues, and feature requests are all welcome! Feel free to open a new issue with the "feature request"
tag or submit a Pull Request.

## Documentation

Looking for more detailed information? Please visit our [Documentation Page](DOCS.md).

## License

Formify is [MIT licensed](LICENSE).

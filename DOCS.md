# Formify - Documentation

Formify is a simple HTML5 form generator library designed to make form creation manageable and scalable. It significantly reduces the redundant tasks involved in HTML form creation with the support of TailwindCSS for styling elements.

## Installation

Use Composer to install the library.

```bash
composer require fuziion/formify
```

## Usage

Create a Formify configuration array with relevant form values and instantiate the Form class. You can then add elements and render the form.

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
     ->placeholder('Enter your e-mail')
     ->style('border border-blue-100')
     ->value('example@gmail.com');

$form->render();
```

## Form Configuration

The Form constructor accepts a configuration array with the following keys:

| Key       | Type   | Default              | Description                      |
|-----------|--------|----------------------|----------------------------------|
| `action`  | string | `''`                 | The URL the form submits to.     |
| `method`  | string | `'POST'`             | The HTTP method (POST or GET).   |
| `enctype` | string | `'multipart/form-data'` | The form encoding type.       |

### Form Methods

- `field(): Field` - Creates a new input field and adds it to the form.
- `textarea(): Textarea` - Creates a new textarea and adds it to the form.
- `select(): Select` - Creates a new select dropdown and adds it to the form.
- `button(string $text = 'Submit'): Button` - Creates a new button with the given text.
- `checkbox(string $name, array $options): CheckboxGroup` - Creates a group of checkboxes.
- `radio(string $name, array $options): RadioGroup` - Creates a group of radio buttons.
- `fieldset(): Fieldset` - Creates a fieldset for grouping related fields.
- `csrf(string $token): self` - Sets a CSRF token on the form.
- `toHtml(): string` - Returns the form HTML as a string.
- `render(): void` - Outputs the form HTML directly.

## Element Types

All element types support fluent method chaining. Every setter returns the element instance so you can chain calls together.

### Field (Input)

The basic input element. Supports all standard HTML input types like text, email, number, password, etc.

```php
$form->field()
     ->name('emailAddress')
     ->type('email')
     ->placeholder('Enter your e-mail')
     ->style('border border-blue-100')
     ->value('example@gmail.com');
```

**Available methods:**

| Method                            | Description                                                |
|-----------------------------------|------------------------------------------------------------|
| `name(string $name)`              | Sets the field name attribute.                             |
| `type(string $type)`              | Sets the input type (e.g., 'text', 'email', 'number').     |
| `placeholder(string $placeholder)`| Sets the placeholder text.                                 |
| `style(string $style)`            | Sets the CSS class attribute (TailwindCSS classes work).   |
| `value(string $value)`            | Sets the default value.                                    |

### Textarea

A multi-line text input element with configurable dimensions.

```php
$form->textarea()
     ->name('message')
     ->placeholder('Enter your message')
     ->rows(6)
     ->cols(40)
     ->style('border border-gray-300')
     ->content('Hello, world!');
```

**Available methods:**

| Method                            | Description                                              |
|-----------------------------------|----------------------------------------------------------|
| `name(string $name)`              | Sets the textarea name attribute.                        |
| `placeholder(string $placeholder)`| Sets the placeholder text.                               |
| `style(string $style)`            | Sets the CSS class attribute.                            |
| `rows(int $rows)`                 | Sets the number of visible rows. Defaults to 4.          |
| `cols(int $cols)`                 | Sets the number of visible columns. Defaults to 50.      |
| `content(string $content)`        | Sets the default text content of the textarea.           |

### Select (Dropdown)

A dropdown menu with a list of options. Options are passed as an associative array where the keys are the values and the array values are the display labels.

```php
$form->select()
     ->name('country')
     ->style('border border-gray-300')
     ->options([
         'us' => 'United States',
         'nl' => 'Netherlands',
         'de' => 'Germany',
         'fr' => 'France',
     ]);
```

**Available methods:**

| Method                  | Description                                                          |
|-------------------------|----------------------------------------------------------------------|
| `name(string $name)`   | Sets the select name attribute.                                      |
| `style(string $style)` | Sets the CSS class attribute.                                        |
| `options(array $options)` | Sets the options as a `value => label` associative array.          |

### Button

A button element. Defaults to type "submit" with the text "Submit" if no arguments are provided.

```php
$form->button('Send')
     ->type('submit')
     ->style('bg-blue-500 text-white px-4 py-2 rounded');
```

**Available methods:**

| Method                  | Description                                                  |
|-------------------------|--------------------------------------------------------------|
| `text(string $text)`   | Sets the button text content.                                |
| `type(string $type)`   | Sets the button type ('submit', 'reset', or 'button').       |
| `style(string $style)` | Sets the CSS class attribute.                                |
| `name(string $name)`   | Sets the button name attribute.                              |

### CheckboxGroup

Renders a group of checkbox inputs, each with an associated label. The field name is automatically suffixed with `[]` so that selected values are submitted as an array.

```php
$form->checkbox('interests', [
    'coding' => 'Coding',
    'design' => 'Design',
    'music'  => 'Music',
]);
```

Each checkbox gets a unique `id` in the format `{name}_{value}`, and the label's `for` attribute is set to match.

**Available methods:**

| Method                     | Description                                               |
|----------------------------|-----------------------------------------------------------|
| `name(string $name)`      | Sets the group name attribute.                            |
| `style(string $style)`    | Sets the CSS class on the container div.                  |
| `options(array $options)` | Sets the options as a `value => label` associative array. |

### RadioGroup

Renders a group of radio button inputs, each with an associated label. All radio inputs share the same name so only one can be selected at a time.

```php
$form->radio('gender', [
    'male'   => 'Male',
    'female' => 'Female',
    'other'  => 'Other',
]);
```

Each radio input gets a unique `id` in the format `{name}_{value}`, and the label's `for` attribute is set to match.

**Available methods:**

| Method                     | Description                                               |
|----------------------------|-----------------------------------------------------------|
| `name(string $name)`      | Sets the group name attribute.                            |
| `style(string $style)`    | Sets the CSS class on the container div.                  |
| `options(array $options)` | Sets the options as a `value => label` associative array. |

## Fieldsets

Fieldsets allow you to group related fields together with an optional legend. The fieldset has its own `field()` method, so fields added through it will be rendered inside the `<fieldset>` element.

```php
$fieldset = $form->fieldset()->legend('Personal Information');
$fieldset->field()->name('firstName')->type('text')->placeholder('First name');
$fieldset->field()->name('lastName')->type('text')->placeholder('Last name');
```

**Available methods:**

| Method                  | Description                                             |
|-------------------------|---------------------------------------------------------|
| `legend(string $text)` | Sets the legend text displayed at the top of the group. |
| `field(): Field`       | Creates a new input field inside the fieldset.          |

## CSRF Protection

You can add a hidden CSRF token field to your form by calling `csrf()`. This will inject a hidden input named `_token` as the first element inside the form, before any other fields.

```php
$form->csrf('your-csrf-token-here');
```

This renders as:

```html
<input type="hidden" name="_token" value="your-csrf-token-here">
```

## Rendering

Formify provides two ways to get the generated HTML from your form:

- `render()` outputs the HTML directly using `echo`. Use this when you want to print the form straight to the page.
- `toHtml()` returns the HTML as a string. Use this when you need to store, manipulate, or pass the form output to a template engine.

```php
$form->render();

$html = $form->toHtml();
```

## Errors and Exception Handling

Formify uses PHP's built-in DOMDocument to create and append HTML elements. During rendering, if any issues occur (such as a DOMException), each element catches the exception and handles it gracefully:

- Individual elements (fields, textareas, selects, etc.) will echo an error message and return `null`. The form will skip any element that returns `null` and continue rendering the rest.
- The `toHtml()` method on the Form class returns an empty string if an error occurs, without echoing anything.

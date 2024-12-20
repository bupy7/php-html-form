php-html-form
===

This is fork of [adamwathan/form](https://github.com/adamwathan/form). There is just HTML-elements builder
without any framework support. Extension are supporting PHP from 5.6 up to newest!


[![Stable Version](https://poser.pugx.org/bupy7/php-html-form/v/stable)](https://packagist.org/packages/bupy7/php-html-form)
[![Build status](https://github.com/bupy7/php-html-form/actions/workflows/build.yml/badge.svg)](https://github.com/bupy7/php-html-form/actions/workflows/build.yml)
[![Coverage Status](https://coveralls.io/repos/github/bupy7/php-html-form/badge.svg?branch=master)](https://coveralls.io/github/bupy7/php-html-form?branch=master)
[![Total Downloads](https://poser.pugx.org/bupy7/php-html-form/downloads)](https://packagist.org/packages/bupy7/php-html-form)
[![License](https://poser.pugx.org/bupy7/php-html-form/license)](https://packagist.org/packages/bupy7/php-html-form)

Boring name for a boring package. Builds form HTML with a fluent-ish, hopefully intuitive syntax.

- [Installation](#installation)
- [Basic Usage](#basic-usage)
- [Error Messages](#error-messages)
- [CSRF Protection](#csrf-protection)
- [Data Binding](#data-binding)

Installation
---

You can install this package via Composer by running this command in your terminal in the root of your
project:

```bash
$ composer require bupy7/php-html-form
```

Basic Usage
---

- [Getting Started](#getting-started)
- [Opening a Form](#opening-a-form)
- [Text and Password Fields](#text-and-password-fields)
- [Textareas](#textareas)
- [Checkboxes and Radio Buttons](#checkboxes-and-radio-buttons)
- [Selects](#selects)
- [Buttons](#buttons)
- [Hidden Inputs](#hidden-inputs)
- [Labels](#labels)
- [Setting Attributes](#setting-attributes)

Getting Started
---

First, instantiate a FormBuilder...

```php
$builder = new AdamWathan\Form\FormBuilder;
```

Next, use the FormBuilder to build an element. For example:
```php
// <input type="text" name="email" value="example@example.com" required="required">
<?= $builder->text('email')->value('example@example.com')->required(); ?>
```

- All elements support method chaining, so you can add as many options to an element as you need.
- All elements implement `__toString()` so there is no need to manually render.


Opening a Form
---

```php
// <form method="POST">
<?= $builder->open(); ?>

// <form method="GET">
<?= $builder->open()->get(); ?>

// <form method="POST">
// <input type="hidden" name="_method" value="PUT">
<?= $builder->open()->put(); ?>

// <form method="POST">
// <input type="hidden" name="_method" value="DELETE">
<?= $builder->open()->delete(); ?>

// <form method="POST" action="/test">
<?= $builder->open()->action('/test'); ?>

// <form method="POST" action="" enctype="multipart/form-data">
<?= $builder->open()->multipart() ?>

// <form method="POST" action="" enctype="custom">
<?= $builder->open()->encodingType("custom") ?>
```

Text and Password Fields
---

Text and password fields share the same interface.

```php
// <input type="text" name="email">
<?= $builder->text('email'); ?>

// <input type="text" name="email" id="email_field">
<?= $builder->text('email')->id('email_field'); ?>

// <input type="password" name="password" class="required">
<?= $builder->password('password')->addClass('required'); ?>

// <input type="text" name="email" value="example@example.com" required="required">
<?= $builder->text('email')->value('example@example.com')->required(); ?>
```

Other available methods:

- `placeholder($string)`
- `optional()`
- `defaultValue($string)`
- `disable()`
- `enable()`

Textareas
---

Textareas share the same interface as regular text fields, with a couple of extra useful methods.

```php
// <textarea name="bio" rows="5" cols="50"></textarea>
<?= $builder->textarea('bio')->rows(5); ?>

// <textarea name="bio" rows="10" cols="20"></textarea>
<?= $builder->textarea('bio')->cols(20); ?>

// <textarea name="bio" rows="5" cols="20" class="important">My biography</textarea>
<?= $builder->textarea('bio')->rows(5)->cols(20)->addClass('important')->value('My biography'); ?>
```

Checkboxes and Radio Buttons
---

```php
// <input type="checkbox" name="terms" value="1">
<?= $builder->checkbox('terms'); ?>

// <input type="checkbox" name="terms" value="1" checked="checked">
<?= $builder->checkbox('terms')->check(); ?>

// <input type="checkbox" name="terms" value="1">
<?= $builder->checkbox('terms')->uncheck(); ?>

// <input type="checkbox" name="terms" value="1" checked="checked">
<?= $builder->checkbox('terms')->defaultToChecked(); ?>

// <input type="checkbox" name="terms" value="agree">
<?= $builder->checkbox('terms')->value('agree'); ?>

// <input type="radio" name="color" value="red">
<?= $builder->radio('color', 'red'); ?>
```

Selects
---

```php
// <select name="birth_year"></select>
<?= $builder->select('birth_year'); ?>

// <select name="birth_year">
//   <option value="0">1990</option>
//   <option value="1">1991</option>
//   <option value="2">1992</option>
// </select>
<?= $builder->select('birth_year', [1990, 1991, 1992]); ?>

// <select name="birth_year">
//   <option value="1990">1990</option>
//   <option value="1991">1991</option>
//   <option value="1992">1992</option>
// </select>
<?= $builder->select('birth_year', ['1990' => 1990, '1991' => 1991, '1992' => 1992]); ?>

// <select name="birth_year">
//   <optgroup label="Ontario">
//     <option value="toronto">Toronto</option>
//     <option value="ottawa">Ottawa</option>
//   </optgroup>
//   <optgroup label="Quebec">
//     <option value="montreal">Montreal</option>
//     <option value="quebec_city">Quebec City</option>
//   </optgroup>
// </select>
$options = [
	'Ontario' => [
		'toronto' => 'Toronto',
		'ottawa' => 'Ottawa',
	],
	'Quebec' => [
		'montreal' => 'Montreal',
		'quebec_city' => 'Quebec City',
	]
];

<?= $builder->select('birth_year', $options); ?>

// <select name="birth_year">
//   <option value="1">1990</option>
// </select>
<?= $builder->select('birth_year')->addOption('1', 1990); ?>

// <select name="birth_year">
//   <option value="1">1990</option>
//   <option value="2">1991</option>
//   <option value="3" selected>1992</option>
// </select>
<?= $builder->select('birth_year', ['1' => 1990, '2' => 1991, '3' => 1992])->select('3'); ?>
```

Buttons
---

```php
// <button type="button">Click Me</button>
<?= $builder->button('Click Me'); ?>

// <button type="submit">Sign Up</button>
<?= $builder->submit('Sign Up'); ?>

// <button type="reset">Reset Form</button>
<?= $builder->reset('Reset Form'); ?>

// <button type="submit" class="js-submit">Sign Up</button>
<?= $builder->submit('Sign Up')->addClass('js-submit'); ?>
```

Hidden Inputs
---

```php
// <input type="hidden" name="secret" value="my-secret-value">
<?= $builder->hidden('secret')->value('my-secret-value'); ?>
```

Labels
---

**Basic Label**
```php
// <label>Email</label>
<?= $builder->label('Email'); ?>

// <label for="email">Email</label>
<?= $builder->label('Email')->forId('email'); ?>
```

**Wrapping another element**
```php
// <label>Email<input type="text" name="email"></label>
<?= $builder->label('Email')->before($emailElement); ?>

// <label><input type="text" name="email">Email</label>
<?= $builder->label('Email')->after($emailElement); ?>
```

Setting Attributes
---

```php
// Attributes can be set with attribute(...)
// <input type="text" name="foobar" min="4">
<?= $builder->text('foobar')->attribute('min', 4); ?>

// Or by calling the attribute name as a method
// <input type="text" name="foobar" min="4">
<?= $builder->text('foobar')->min(4); ?>

// Setting data-* attributes
// <input type="text" data-foo="bar" name="foobar">
<?= $builder->text('foobar')->data('foo', 'bar'); ?>

// Multiple data-* attributes can be set at once
// <input type="text" data-foo="bar" data-bar="foo" name="foobar">
<?= $builder->text('foobar')->data(['foo' => 'bar', 'bar' => 'foo']); ?>
```

Error Messages
---

FormBuilder also allows you to easily retrieve error messages for your form elements. To do so, just
implement the `ErrorStoreInterface` and pass it to the FormBuilder:

```php
$builder->setErrorStore($myErrorStore);

// Check if the form has an error for an element
$builder->hasError('email');

// Retrieve the error message for an element
$builder->getError('email');
```

You can also supply a `format` parameter to `getError()` to cleanup your markup. Instead of doing this:

```php
<?php if ($builder->hasError('email')): ?>
	<span class="error"><?= $builder->getError('email'); ?></span>
<?php endif; ?>
```

...you can simply do this, which will display the formatted message if it exists, or nothing otherwise.
```php
<?= $builder->getError('email', '<span class="error">:message</span'); ?>
```

<a href="#csrf-protection"></a>
## CSRF Protection

Assuming you set a CSRF token when instantiating the FormBuilder, add a CSRF
token to your form easily like so:

```php
<?= $builder->token(); ?>
```

Data Binding
---

Sometimes you might have a form where all of the fields match properties on some sort of object or array
in your system, and you want the user to be able to edit that data. Data binding makes this really easy by
allowing you to bind an object or array to your form that will be used to automatically provide all of the
default values for your fields.

```php
$model->first_name = "John";
$model->last_name = "Doe";
$model->email = "john@example.com";

<?= $builder->open(); ?>
<?= $builder->bind($model); ?>
<?= $builder->text('first_name'); ?>
<?= $builder->text('last_name'); ?>
<?= $builder->email('email'); ?>
<?= $builder->close(); ?>
```

> Note: Be sure to `bind` before creating any other form elements.

Testing
---

Run tests:

```
$ ./vendor/bin/phpunit --no-coverage
```

Run tests with coverage:

```
$ XDEBUG_MODE=coverage ./vendor/bin/phpunit
```

HTML coverage path: `build/coverage/index.html`

Code style
---

To fix code style, run:

```
~/.composer/vendor/bin/php-cs-fixer fix --verbose
```

You have to install [PHP CS Fixer](https://github.com/PHP-CS-Fixer/PHP-CS-Fixer) at first, if you
don't use build-in Docker image:

```
composer global require friendsofphp/php-cs-fixer
```

License
---

php-html-form is released under the [MIT License](LICENSE.md).

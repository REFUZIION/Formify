<?php declare(strict_types=1);

require 'vendor/autoload.php';

use Formify\Form;

$config = [
    'action' => 'action.php',
    'method' => 'POST',
    'enctype' => 'multipart/form-data'
];

$form = new Form($config);
$form->csrf('abc123token');

$form->field()
     ->name('emailAddress')
     ->type('email')
     ->placeholder('Enter your e-mail')
     ->style('border border-blue-100') // tailwindcss classes work here!
     ->value('example@gmail.com');

$form->field()
     ->name('fullName')
     ->type('text')
     ->placeholder('Enter your name')
     ->style('border border-blue-100')
     ->value('polarnix');

$form->field()->name('randomFieldTest');

$form->textarea()
     ->name('message')
     ->placeholder('Enter your message')
     ->rows(6)
     ->cols(40)
     ->style('border border-gray-300')
     ->content('Hello, world!');

$form->select()
     ->name('country')
     ->style('border border-gray-300')
     ->options([
         'us' => 'United States',
         'nl' => 'Netherlands',
         'de' => 'Germany',
         'fr' => 'France',
     ]);

$form->checkbox('interests', [
    'coding' => 'Coding',
    'design' => 'Design',
    'music' => 'Music',
]);

$form->radio('gender', [
    'male' => 'Male',
    'female' => 'Female',
    'other' => 'Other',
]);

$form->button('Send')
     ->style('bg-blue-500 text-white px-4 py-2 rounded');

$form->render();

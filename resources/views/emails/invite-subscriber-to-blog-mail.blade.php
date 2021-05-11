@component('mail::message')
# Bienvenido!

Gracias por subscribirte al newsletter, puedes ingresar a nuestro blog para ver tips y snippets en Laravel.

@component('mail::button', ['url' => route('blog')])
Ir al Blog
@endcomponent

Gracias,<br>
{{ config('app.name') }}
@endcomponent

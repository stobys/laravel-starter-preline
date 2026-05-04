@props(['name', 'class' => 'w-5 h-5'])

@svg(str('heroicon-o-')->append($name), $attributes->merge(['class' => $class]))

@blaze()
@props([
	'id'	=> str()->random(5),
	'type'	=> 'default',
])

@php
	$types = ['default', 'gray', 'teal', 'gray-dark', 'red', 'yellow', 'plain'];
	$type = in_array($type, $types) ? $type : 'default';
@endphp

<span @class([
	'inline-flex items-center gap-x-1.5 py-1.5 px-3 rounded-full text-xs font-medium',
	'bg-gray-900 dark:bg-white text-white dark:text-neutral-800' 	=> $type == 'default',
	'bg-gray-500 dark:bg-neutral-500 text-white' 					=> $type == 'gray',
	'bg-teal-500 text-white' 										=> $type == 'teal',
	'bg-gray-800 dark:bg-white text-white dark:text-neutral-800'	=> $type == 'dark-gray',
	'bg-red-500 text-white'											=> $type == 'red',
	'bg-yellow-500 text-white'										=> $type == 'yellow',
	'bg-plain text-gray-800 dark:text-neutral-950'					=> $type == 'plain',
])>
	{{ $slot }}
</span>
{{--
// -- soft colors
  <span class="inline-flex items-center gap-x-1.5 py-1.5 px-3 rounded-full text-xs font-medium bg-surface text-surface-foreground">Badge</span>
  <span class="inline-flex items-center gap-x-1.5 py-1.5 px-3 rounded-full text-xs font-medium bg-muted text-muted-foreground-1">Badge</span>
  <span class="inline-flex items-center gap-x-1.5 py-1.5 px-3 rounded-full text-xs font-medium bg-teal-100 text-teal-800 dark:bg-teal-500/20 dark:text-teal-400">Badge</span>
  <span class="inline-flex items-center gap-x-1.5 py-1.5 px-3 rounded-full text-xs font-medium bg-primary-100 text-primary-800 dark:bg-primary-500/20 dark:text-primary-400">Badge</span>
  <span class="inline-flex items-center gap-x-1.5 py-1.5 px-3 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-500/20 dark:text-red-400">Badge</span>
  <span class="inline-flex items-center gap-x-1.5 py-1.5 px-3 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-500/20 dark:text-yellow-400">Badge</span>
  <span class="inline-flex items-center gap-x-1.5 py-1.5 px-3 rounded-full text-xs font-medium bg-plain/10 text-foreground-inverse">Badge</span>


// -- outline colors
  <span class="inline-flex items-center gap-x-1.5 py-1.5 px-3 rounded-full text-xs font-medium border border-gray-800 dark:border-neutral-100 text-gray-800 dark:text-neutral-200">Badge</span>
  <span class="inline-flex items-center gap-x-1.5 py-1.5 px-3 rounded-full text-xs font-medium border border-gray-500 dark:border-neutral-400 text-gray-500 dark:text-neutral-400">Badge</span>
  <span class="inline-flex items-center gap-x-1.5 py-1.5 px-3 rounded-full text-xs font-medium border border-teal-500 text-teal-500">Badge</span>
  <span class="inline-flex items-center gap-x-1.5 py-1.5 px-3 rounded-full text-xs font-medium border border-gray-800 dark:border-white text-gray-800 dark:text-white">Badge</span>
  <span class="inline-flex items-center gap-x-1.5 py-1.5 px-3 rounded-full text-xs font-medium border border-red-500 text-red-500">Badge</span>
  <span class="inline-flex items-center gap-x-1.5 py-1.5 px-3 rounded-full text-xs font-medium border border-yellow-500 text-yellow-500">Badge</span>
  <span class="inline-flex items-center gap-x-1.5 py-1.5 px-3 rounded-full text-xs font-medium border border-white text-white">Badge</span>


<div class="inline-flex flex-wrap gap-2">
  <span class="inline-flex items-center gap-x-1.5 py-1.5 px-3 rounded-md text-xs font-medium bg-layer border border-layer-line text-layer-foreground shadow-2xs">Badge</span>
  <span class="inline-flex items-center gap-x-1.5 py-1.5 px-3 rounded-full text-xs font-medium bg-layer border border-layer-line text-layer-foreground shadow-2xs">Badge</span>
</div>

// -- indicator
<span class="size-1.5 inline-block rounded-full bg-primary-800 dark:bg-primary-400"></span> --}}

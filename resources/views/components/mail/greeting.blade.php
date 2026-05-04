@blaze()
@props([
	'name'	=> null,
])

{{-- Greeting --}}
<p style="margin: 0 0 24px 0; font-size: 16px; color: #111827; font-weight: 600;">
	Cześć, {{ $name ?? '...' }},
</p>

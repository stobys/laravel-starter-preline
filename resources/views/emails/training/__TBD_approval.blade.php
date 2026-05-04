@component('mail::message')
# Szkolenie wymaga akceptacji

Pracownik **{{ $training->user->name }}** zgłosił szkolenie wymagające Twojej akceptacji.

**Szkolenie:** {{ $training->name }}
**Data:** {{ $training->start_date->format('d.m.Y') }}
**Koszt:** {{ number_format($training->cost, 2) }} PLN

@component('mail::button', ['url' => route('trainings.show', $training)])
Przejdź do szkolenia
@endcomponent

@endcomponent
{{--
<x-mail::message>
# Introduction

The body of your message.

<x-mail::button :url="''">
Button Text
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message> --}}

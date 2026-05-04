@extends('layout.mail')

@section('status-bar')
	<p style="background-color: #059669; padding: 12px 40px; text-align: center; margin: 0; font-size: 13px; font-weight: 600; color: #ffffff; letter-spacing: 0.3px;">
		📅 &nbsp; Oceny do wykonania
	</p>
@endsection

@section('content')

	<x-mail.greeting :name="$managerName" />

    <p>
        Poniżej znajdują się zaplanowane oceny oczekujące na realizację (stan na {{ now()->format('d.m.Y') }}).
    </p>

	<table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color: #f9fafb; border-radius: 8px; border: 1px solid #e5e7eb; margin-bottom: 28px;">
		<tr>
			<td style="padding: 24px;">

				{{-- Training name --}}
				<table width="100%" cellpadding="4" cellspacing="2" border="0" style="margin-bottom: 12px;">
					<tr>
						<x-mail.th width="20%" style="text-align: left;">Szkolenie</x-mail.th>
						<x-mail.th width="20%" style="text-align: left;">Pracownik</x-mail.th>
						<x-mail.th width="20%" style="text-align: left;">Planowana Data</x-mail.th>
						<x-mail.th width="20%" style="text-align: left;">Dni po terminie</x-mail.th>
						<x-mail.th width="5%" style="text-align: left;">Link</x-mail.th>
            		</tr>

					@foreach($evaluations as $index => $evaluation)
					<tr>
						<x-mail.td width="20%">{{ $evaluation->training->title }}</x-mail.td>
						<x-mail.td width="20%">{{ $evaluation->participant->full_name }}</x-mail.td>
						<x-mail.td width="20%">{{ $evaluation->available_at?->format('Y-m-d') }}</x-mail.td>
						<x-mail.td width="20%">{{ format_as_number(now()->diffInDays($evaluation->available_at)) }}</x-mail.td>
						<x-mail.td width="5%">
							<a href="{{ route('trainings.evaluate', [$evaluation->training_id, $evaluation->id]) }}" style="text-decoration:none">
								🔗 {{-- ➡️ 🔗 --}}
							</a>
						</x-mail.td>
					</tr>
					@endforeach
				</table>

			</td>
		</tr>
	</table>

@endsection

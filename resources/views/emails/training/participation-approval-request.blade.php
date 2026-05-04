@extends('layout.mail')

@section('status-bar')
	<p style="background-color: #059669; padding: 12px 40px; text-align: center; margin: 0; font-size: 13px; font-weight: 600; color: #ffffff; letter-spacing: 0.3px;">
		👍 &nbsp; Prośba o akceptację
	</p>
@endsection

@section('content')

	<x-mail.greeting :name="$manager->first_name" />

    <p>
        Do realizacji zostało przekazane szkolenie, w którym biorą udział Twoi pracownicy stąd prośba o akceptację.
    </p>

	<table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color: #f9fafb; border-radius: 8px; border: 1px solid #e5e7eb; margin-bottom: 28px;">
		<tr>
			<td style="padding: 24px;">

				{{-- Training name --}}
				<table width="100%" cellpadding="4" cellspacing="2" border="0" style="margin-bottom: 12px;">
					<tr>
						<x-mail.th width="45%" style="text-align: left;">Pracownik</x-mail.th>
						<x-mail.th width="45%" style="text-align: left;">Szkolenie</x-mail.th>
						<x-mail.th width="10%" style="text-align: left;">Link</x-mail.th>
            		</tr>

					@foreach($participants as $index => $participant)
					<tr>
						<x-mail.td width="45%">{{ $participant->full_name }}</x-mail.td>
						<x-mail.td width="45%">{{ $training->title }}</x-mail.td>
						<x-mail.td width="10%">
							<a href="{{ route('trainings.index-participants') }}" style="text-decoration:none">
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

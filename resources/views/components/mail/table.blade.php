<table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color: #f9fafb; border-radius: 8px; border: 1px solid #e5e7eb; margin-bottom: 28px;">
	<tr>
		<td style="padding: 24px;">

			<p style="margin: 0 0 16px 0; font-size: 11px; font-weight: 600; color: #6b7280; text-transform: uppercase; letter-spacing: 1px;">
				Szczegóły szkolenia
			</p>

			{{-- Training name --}}
			<table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-bottom: 12px;">
				<tr>
					<td width="36%" style="font-size: 13px; color: #6b7280; padding-bottom: 10px; vertical-align: top;">Szkolenie</td>
					<td width="64%" style="font-size: 13px; color: #111827; font-weight: 600; padding-bottom: 10px; vertical-align: top;">{{ $training->title }}</td>
				</tr>
				<tr>
					<td style="border-top: 1px solid #e5e7eb;" colspan="2"></td>
				</tr>
				<tr>
					<td width="36%" style="font-size: 13px; color: #6b7280; padding-top: 10px; padding-bottom: 10px; vertical-align: top;">Data</td>
					<td width="64%" style="font-size: 13px; color: #111827; font-weight: 500; padding-top: 10px; padding-bottom: 10px; vertical-align: top;">{{ $training->scheduled_at?->format('Y-m-d') }}</td>
				</tr>
				<tr>
					<td style="border-top: 1px solid #e5e7eb;" colspan="2"></td>
				</tr>
				<tr>
					<td width="36%" style="font-size: 13px; color: #6b7280; padding-top: 10px; padding-bottom: 10px; vertical-align: top;">Lokalizacja</td>
					<td width="64%" style="font-size: 13px; color: #111827; font-weight: 500; padding-top: 10px; padding-bottom: 10px; vertical-align: top;">{{ $training->location ?? 'Do ustalenia' }}</td>
				</tr>
				<tr>
					<td style="border-top: 1px solid #e5e7eb;" colspan="2"></td>
				</tr>
				<tr>
					<td width="36%" style="font-size: 13px; color: #6b7280; padding-top: 10px; vertical-align: top;">Przełożony</td>-
					<td width="64%" style="font-size: 13px; color: #111827; font-weight: 500; padding-top: 10px; vertical-align: top;">{{ $manager?->full_name }}</td>
				</tr>
			</table>

		</td>
	</tr>
</table>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{ config('app.name', 'Laravel') }} | TPMS - Training Plan Management System</title>
</head>
<body style="margin: 0; padding: 0; background-color: #f3f4f6; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif; -webkit-font-smoothing: antialiased;">

    {{-- Wrapper --}}
    <table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color: #f3f4f6; padding: 40px 16px;">
        <tr>
            <td align="center">

                {{-- Card --}}
                <table width="100%" cellpadding="0" cellspacing="0" border="0" style="max-width: 800px; background-color: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 1px 3px rgba(0,0,0,0.08), 0 1px 2px rgba(0,0,0,0.06);">

                    {{-- Header --}}
                    <tr>
                        <td style="background-color: #111827; padding: 32px 40px; text-align: center;">
                            <p style="margin: 0; font-size: 22px; font-weight: 700; color: #ffffff; letter-spacing: -0.3px;">
                                HeRMeS
                            </p>
                            <p style="margin: 6px 0 0 0; font-size: 12px; color: #9ca3af; text-transform: uppercase; letter-spacing: 1.5px; font-weight: 500;">
                                System zarządzania szkoleniami
                            </p>
                        </td>
                    </tr>

                    {{-- Status bar --}}
                    <tr>
                        <td style="">
							@yield('status-bar')
                        </td>
                    </tr>

                    {{-- Body --}}
                    <tr>
                        <td style="padding: 40px 40px 32px 40px;">

							@yield('content')

                            {{-- Divider --}}
                            <table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-bottom: 24px;">
                                <tr>
                                    <td style="border-top: 1px solid #e5e7eb;"></td>
                                </tr>
                            </table>

                            {{-- Footer note --}}
                            <p style="margin: 0; font-size: 13px; color: #9ca3af; line-height: 1.6; text-align: center;">
                                Ta wiadomość została wygenerowana automatycznie przez system HeRMeS.<br>
                                Prosimy nie odpowiadać na tego maila.
                            </p>

                        </td>
                    </tr>

                    {{-- Footer --}}
                    <tr>
                        <td style="background-color: #f9fafb; border-top: 1px solid #e5e7eb; padding: 20px 40px; text-align: center;">
                            <p style="margin: 0; font-size: 12px; color: #9ca3af;">
                                © {{ date('Y') }} <a href="{{ url('/') }}">HeRMeS</a> · Adient
                            </p>
                        </td>
                    </tr>

                </table>
                {{-- End Card --}}

            </td>
        </tr>
    </table>
</body>
</html>


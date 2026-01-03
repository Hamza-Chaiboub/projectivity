{{-- resources/views/mail/ebook.blade.php --}}
@php
    $brandName      = $brandName ?? config('app.name', 'Projectivity');
    $name           = $name ?? 'there';
    $supportEmail   = $supportEmail ?? 'contact@projectivity.ma';
    $year           = now()->year;

    $attachmentName = 'Projectivity-Ebook.pdf';

    $logoPath = public_path('images/logo/logo.jpg');
    $paperclipPath = public_path('images/misc/paperclip.png');
@endphp

    <!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <meta name="x-apple-disable-message-reformatting" />
    <meta name="color-scheme" content="light only" />
    <title>{{ $brandName }} Ebook</title>

    <style>
        @media (max-width: 620px) {
            .container { width: 100% !important; }
            .px { padding-left: 18px !important; padding-right: 18px !important; }
            .h1 { font-size: 24px !important; line-height: 32px !important; }
            .stack { display:block !important; width:100% !important; }
        }
    </style>
</head>

<body style="margin:0; padding:0; font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Arial,sans-serif;">
<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="padding:28px 0;">
    <tr>
        <td align="center">

            <table role="presentation" width="600" cellpadding="0" cellspacing="0" class="container"
                   style="width:600px; max-width:600px; background:#ffffff; border-radius:18px; overflow:hidden; box-shadow:0 14px 40px rgba(0,0,0,.35);">

                {{-- Header (modern gradient strip) --}}
                <tr>
                    <td style="padding:0; background:linear-gradient(135deg,#f59e0b 0%, #ec4899 60%, #a855f7 100%);">
                        <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
                            <tr>
                                <td class="px" style="padding:22px 28px;">
                                    <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
                                        <tr>
                                            <td align="left" class="stack">
                                                <table role="presentation" cellpadding="0" cellspacing="0">
                                                    <tr>
                                                        <td style="background:#ffffff; border-radius:999px; padding:10px 14px;">
                                                            <table role="presentation" cellpadding="0" cellspacing="0">
                                                                <tr>
                                                                    <td style="padding-right:10px;">
                                                                        @if (file_exists($logoPath))
                                                                            <img src="{{ $message->embed($logoPath) }}" width="26" height="26" alt="{{ $brandName }}"
                                                                                 style="display:block; border-radius:8px;" />
                                                                        @else
                                                                            <span style="display:inline-block; width:26px; height:26px; border-radius:8px; background:#111827;"></span>
                                                                        @endif
                                                                    </td>
                                                                    <td style="font-weight:900; font-size:14px; color:#111827;">
                                                                        {{ $brandName }}
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>

                                            <td align="right" class="stack" style="color:rgba(255,255,255,.9); font-size:12px; padding-top:6px;">
                                                {{ now()->format('M j, Y') }}
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>

                {{-- Body --}}
                <tr>
                    <td class="px" style="padding:30px 28px 18px;">
                        <div class="h1" style="font-size:30px; line-height:38px; font-weight:950; color:#0f172a;">
                            Your Project Management ebook is attached
                        </div>

                        <div style="margin-top:10px; font-size:15px; line-height:24px; color:#334155;">
                            Hi <strong>{{ $name }}</strong>!<br />
                            Welcome to Projectivity and here’s your project management eBook as promised. You’ll find the PDF attached to this email
                        </div>

                        {{-- Attachment card --}}
                        <table role="presentation" width="100%" cellpadding="0" cellspacing="0"
                               style="margin-top:18px; background:#f8fafc; border:1px solid #e2e8f0; border-radius:16px;">
                            <tr>
                                <td style="padding:14px;">
                                    <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
                                        <tr>
                                            <td width="56" valign="top">
                                                <table role="presentation" cellpadding="0" cellspacing="0" style="background:#ec4899; border-radius:14px;">
                                                    <tr>
                                                        <td style="padding:14px; line-height:0;">
                                                            <img src="{{ $message->embed($paperclipPath) }}" width="26" height="26" alt="Attachment"
                                                                 style="display:block; border-radius:8px;" />
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>

                                            <td valign="top" style="padding-left:12px;">
                                                <div style="font-size:13px; font-weight:950; color:#0f172a;">Attachment</div>
                                                <div style="margin-top:4px; font-size:13px; color:#475569;">
                                                    {{ $attachmentName }} <span style="color:#94a3b8;">• PDF</span>
                                                </div>
                                                <div style="margin-top:6px; font-size:12px; color:#64748b;">
                                                    If you don’t see it, check your spam/quarantine folder.
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>

                        {{-- Highlights --}}
                        <div style="margin-top:22px; font-size:14px; font-weight:950; color:#0f172a;">
                            What’s inside?
                        </div>

                        <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="margin-top:10px;">
                            @foreach ([
                              ['title' => 'Why project management matters', 'desc' => 'A clear, practical overview of how project management helps you deliver results, gain credibility and grow professionally.'],
                              ['title' => 'Project management as a woman', 'desc' => 'Real talk on navigating confidence, visibility, leadership and stakeholder dynamics with strategies to help you lead with impact.'],
                              ['title' => 'Practical tools you can use right away', 'desc' => 'Templates and checklists you can reuse for real projects (work, business, or community).'],
                              ['title' => 'PMP & CAPM certification guidance', 'desc' => 'Common questions answered, plus the step-by-step process to become certified and choose the right path for your goals.'],
                            ] as $item)
                                <tr>
                                    <td valign="top" width="16" style="padding-top:4px;">
                                        <span style="display:inline-block; width:10px; height:10px; background:#a855f7; border-radius:999px;"></span>
                                    </td>
                                    <td style="padding:0 0 12px 8px;">
                                        <div style="font-size:14px; font-weight:900; color:#1e293b;">{{ $item['title'] }}</div>
                                        <div style="margin-top:2px; font-size:14px; line-height:20px; color:#475569;">
                                            {{ $item['desc'] }}
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </table>

                        <div style="margin-top:14px; border-top:1px solid #e2e8f0; padding-top:16px;">
                            <div style="font-size:13px; font-weight:950; color:#0f172a;">Quick tip</div>
                            <div style="margin-top:6px; font-size:13px; line-height:20px; color:#64748b;">
                                Add <a href="mailto:{{ $supportEmail }}" style="color:#2563eb; text-decoration:underline;">{{ $supportEmail }}</a>
                                to your contacts so future resources and invitations land safely in your inbox.
                            </div>

                            <div style="margin-top:12px; font-size:13px; line-height:20px; color:#64748b;">
                                If you have any questions, just reply to this email — I read every message.<br>
                                Warmly,<br>
                                Projectivity Team<br>
                                <a href="mailto:{{ $supportEmail }}" style="color:#2563eb; text-decoration:underline;">{{ $supportEmail }}</a>
                            </div>
                        </div>
                    </td>
                </tr>

                {{-- Footer --}}
                <tr>
                    <td class="px" style="padding:16px 28px 22px; border-top:1px solid #e2e8f0;">
                        <div style="font-size:11px; line-height:18px; color:#64748b;">
                            You received this email because you requested the {{ $brandName }} ebook.
                            If you didn’t request it, you can ignore this message.
                        </div>
                        <div style="margin-top:10px; font-size:11px; color:#94a3b8;">
                            © {{ $year }} {{ $brandName }}
                        </div>
                    </td>
                </tr>

            </table>

        </td>
    </tr>
</table>
</body>
</html>

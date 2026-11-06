<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>New inquiry</title>
</head>
<body style="margin:0;padding:32px;background:#05070d;color:#e2e8f0;font-family:ui-monospace,SFMono-Regular,Menlo,monospace;">
    <div style="max-width:640px;margin:0 auto;border:1px solid #1e293b;border-radius:16px;overflow:hidden;background:#0b1120;">
        <div style="padding:24px 28px;border-bottom:1px solid #1e293b;background:linear-gradient(120deg,rgba(0,255,156,.12),rgba(34,211,238,.12));">
            <p style="margin:0 0 8px;font-size:11px;letter-spacing:.24em;text-transform:uppercase;color:#00ff9c;">Portfolio3d · inbound transmission</p>
            <h1 style="margin:0;font-size:22px;color:#f8fafc;">{{ $inquiry->subject }}</h1>
        </div>
        <div style="padding:28px;">
            <p style="margin:0 0 18px;color:#94a3b8;font-size:13px;">
                <strong style="color:#e2e8f0;">{{ $inquiry->name }}</strong>
                &lt;{{ $inquiry->email }}&gt;
                @if ($inquiry->budget)
                    · budget {{ $inquiry->budget }}
                @endif
            </p>
            <div style="padding:20px;border-radius:12px;background:#020617;border:1px solid #1e293b;color:#cbd5e1;font-size:14px;line-height:1.7;white-space:pre-line;">{{ $inquiry->message }}</div>
            <p style="margin:24px 0 0;">
                <a href="{{ route('admin.inquiries.show', $inquiry) }}" style="display:inline-block;padding:12px 18px;border-radius:999px;background:#00ff9c;color:#04120b;font-weight:700;text-decoration:none;font-size:13px;">Open in control center</a>
            </p>
        </div>
    </div>
</body>
</html>

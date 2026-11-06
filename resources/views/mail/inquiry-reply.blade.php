<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Reply to your inquiry</title>
</head>
<body style="margin:0;padding:32px;background:#05070d;color:#e2e8f0;font-family:ui-monospace,SFMono-Regular,Menlo,monospace;">
    <div style="max-width:640px;margin:0 auto;border:1px solid #1e293b;border-radius:16px;overflow:hidden;background:#0b1120;">
        <div style="padding:24px 28px;border-bottom:1px solid #1e293b;background:linear-gradient(120deg,rgba(34,211,238,.12),rgba(0,255,156,.12));">
            <p style="margin:0 0 8px;font-size:11px;letter-spacing:.24em;text-transform:uppercase;color:#22d3ee;">Portfolio3d · reply</p>
            <h1 style="margin:0;font-size:22px;color:#f8fafc;">Re: {{ $inquiry->subject }}</h1>
        </div>
        <div style="padding:28px;">
            <p style="margin:0 0 18px;color:#94a3b8;font-size:13px;">Hi {{ $inquiry->name }},</p>
            <div style="padding:20px;border-radius:12px;background:#020617;border:1px solid #1e293b;color:#cbd5e1;font-size:14px;line-height:1.7;white-space:pre-line;">{{ $inquiry->reply_message }}</div>
            <p style="margin:24px 0 0;color:#64748b;font-size:12px;">Sent from the Portfolio3d control center. Reply to this email to continue the conversation.</p>
        </div>
    </div>
</body>
</html>

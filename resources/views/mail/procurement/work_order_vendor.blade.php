<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $subjectLine }}</title>
</head>
<body style="margin:0;padding:0;background:#f4f6f8;font-family:Arial,Helvetica,sans-serif;color:#1f2937;">
    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="background:#f4f6f8;padding:24px 0;">
        <tr>
            <td align="center">
                <table role="presentation" width="680" cellspacing="0" cellpadding="0" style="max-width:680px;background:#ffffff;border:1px solid #e5e7eb;border-radius:8px;overflow:hidden;">
                    <tr>
                        <td style="background:#155724;color:#ffffff;padding:16px 24px;">
                            <h2 style="margin:0;font-size:20px;">Work Order Notification</h2>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:20px 24px;">
                            <p style="margin:0 0 12px;">Dear Vendor,</p>
                            <p style="margin:0 0 16px;">Please find the work order details below for your acknowledgement and execution.</p>

                            <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="border-collapse:collapse;margin-bottom:16px;">
                                <tr>
                                    <td style="padding:8px 10px;border:1px solid #e5e7eb;background:#f9fafb;width:180px;"><strong>Requisition Title</strong></td>
                                    <td style="padding:8px 10px;border:1px solid #e5e7eb;">{{ $requisition->title }}</td>
                                </tr>
                                <tr>
                                    <td style="padding:8px 10px;border:1px solid #e5e7eb;background:#f9fafb;"><strong>Procurement Type</strong></td>
                                    <td style="padding:8px 10px;border:1px solid #e5e7eb;">{{ $requisition->type }}</td>
                                </tr>
                                <tr>
                                    <td style="padding:8px 10px;border:1px solid #e5e7eb;background:#f9fafb;"><strong>Status</strong></td>
                                    <td style="padding:8px 10px;border:1px solid #e5e7eb;">{{ str_replace('_', ' ', $requisition->status) }}</td>
                                </tr>
                            </table>

                            <div style="margin:0 0 16px;line-height:1.6;">
                                {!! $bodyHtml !!}
                            </div>

                            <p style="margin:0;">Regards,<br>Procurement Team</p>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:14px 24px;font-size:12px;color:#6b7280;border-top:1px solid #e5e7eb;">
                            This is a system-generated procurement email.
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>

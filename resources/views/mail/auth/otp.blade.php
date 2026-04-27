<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>OTP Verification</title>
</head>
<body style="margin:0; padding:0; background-color:#f4f6f8; font-family:Arial, sans-serif;">

<table width="100%" cellpadding="0" cellspacing="0" border="0" style="background:#f4f6f8; padding:20px 0;">
    <tr>
        <td align="center">

            <!-- Main Container -->
            <table width="500" cellpadding="0" cellspacing="0" border="0" style="background:#ffffff; border-radius:8px; overflow:hidden;">

                <!-- Header -->
                <tr>
                    <td style="background:#00477A; color:#ffffff; text-align:center; padding:20px;">
                        <h2 style="margin:0;">Login Verification</h2>
                    </td>
                </tr>

                <!-- Body -->
                <tr>
                    <td style="padding:30px; color:#333333; font-size:14px; line-height:1.6;">

                        <p style="margin-top:0;">Hello,</p>

                        <p>Please use the following One-Time Password (OTP) to complete your login:</p>

                        <!-- OTP Box -->
                        <table width="100%" cellpadding="0" cellspacing="0" border="0">
                            <tr>
                                <td align="center">
                                    <div style="
                                        display:inline-block;
                                        background:#f0f6fa;
                                        border:2px dashed #00477A;
                                        padding:15px 25px;
                                        font-size:30px;
                                        font-weight:bold;
                                        letter-spacing:4px;
                                        color:#00477A;
                                        border-radius:6px;
                                        user-select:all;
                                    ">
                                        {{ $otp }}
                                    </div>
                                </td>
                            </tr>
                        </table>

                        <!-- <p style="text-align:center; font-size:12px; color:#888888; margin-top:10px;">
                            Tap and hold to copy
                        </p> -->

                        <p>This OTP is valid for <strong>5 minutes</strong>.</p>

                        <p>If you did not request this login, please ignore this email.</p>

                    </td>
                </tr>

                <!-- Footer -->
                <tr>
                    <td style="background:#f9f9f9; text-align:center; padding:15px; font-size:12px; color:#888888;">
                        This is an automated email. Please do not reply.
                    </td>
                </tr>

            </table>

        </td>
    </tr>
</table>

</body>
</html>
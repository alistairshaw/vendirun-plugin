<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <title>Message from your Website</title>
    <style type="text/css">
        body {
            margin: 0;
            padding: 0;
        !important;
        }

        body {
            background-color: #F5F6F8;
        }

        a:link {
            color: #3F99DD;
        }

        a:visited {
            color: #3F99DD;
        }
    </style>
</head>

<body>
<table border="0" cellspacing="0" cellpadding="0" style="width: 100%;">
    <tr>
        <td align="center" valign="top" bgcolor="#cbd2e3">
            <table border="0" align="center" cellpadding="0" cellspacing="0" style="width: 700px;">
                <tr>
                    <td width="700" height="25" align="center" valign="middle" bgcolor="#cbd2e3" style="font-family: 'Century Gothic', Arial, sans-serif; color: #909191; font-size: 11px;"></td>
                </tr>
                <tr>
                    <td width="700" align="left" valign="top">
                        <table border="0" cellspacing="0" cellpadding="0" style="width: 700px;">
                            <tr>
                                <td width="50" align="left" valign="top">&nbsp;</td>
                                <td width="600" align="left" valign="top">
                                    <table width="600" border="0" cellpadding="0" cellspacing="0" style="width: 600px;">
                                        <tr>
                                            <td width="246" height="50" bgcolor="#cbd2e3">&nbsp;</td>
                                            <td width="108" rowspan="2" bgcolor="#f00f00" align="center">
                                                <img style="font-family: 'Century Gothic', Arial, sans-serif; color: #3E9ADD; font-size: 18px; display: block;" src="{{ asset('vendor/vendirun/images/emails/stamp.png') }}" alt="Vendirun" width="110" height="109" hspace="0" vspace="0" border="0">
                                            </td>
                                            <td width="246" height="50" bgcolor="#cbd2e3">&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td width="246" height="58" bgcolor="#FEFEFE">&nbsp;</td>
                                            <td width="246" height="58" bgcolor="#FFFFFF">&nbsp;</td>
                                        </tr>

                                    </table>
                                </td>
                                <td width="50" align="left" valign="top">&nbsp;</td>
                            </tr>
                            <tr>
                                <td height="28" align="left" valign="top"></td>
                                <td height="28" align="left" valign="top" bgcolor="#FFFFFF"></td>
                                <td height="28" align="left" valign="top"></td>
                            </tr>
                            <tr>
                                <td width="50" align="left" valign="top">&nbsp;</td>
                                <td width="600" align="left" valign="top" bgcolor="#FFFFFF">
                                    <table width="600" border="0" cellpadding="0" cellspacing="0" style="width: 600px;">
                                        <tr>
                                            <td width="40" align="left" valign="top">&nbsp;</td>
                                            <td width="520" align="center" valign="top" style="font-family: 'Century Gothic', Arial, sans-serif; color: #4c4d4f; font-size: 30px;">Registration Form Submission</td>
                                            <td width="40" align="left" valign="top">&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td width="40" align="left" valign="top">&nbsp;</td>
                                            <td width="520" align="center" valign="top" style="font-family: 'Century Gothic', Arial, sans-serif; color: #4c4d4f; font-size: 14px;"></td>
                                            <td width="40" align="left" valign="top">&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td width="40" align="left" valign="top">&nbsp;</td>
                                            <td width="520" align="left" valign="top" style="font-family: 'Century Gothic', Arial, sans-serif; color: #4c4d4f; font-size: 14px;">
                                                <p>Someone is trying to register online for your website</p>
                                            </td>
                                            <td width="40" align="left" valign="top">&nbsp;</td>
                                        </tr>
                                    </table>
                                    @if (isset($mailData))
                                        <table width="600" border="0" cellpadding="0" cellspacing="0" style="width: 600px;">
                                            <tr>
                                                <td width="40" align="left" valign="top">&nbsp;</td>
                                                <td width="520" align="left" valign="top" style="border: 1px solid #9d9d9d; font-family: 'Century Gothic', Arial, sans-serif; color: #4c4d4f; font-size: 14px; padding: 20px;">
                                                    @foreach ($mailData as $key => $value)
                                                        <strong>{{ ucwords($key) }}</strong><br>
                                                        {!! $value !!}<br><br>
                                                    @endforeach
                                                </td>
                                                <td width="40" align="left" valign="top">&nbsp;</td>
                                            </tr>
                                        </table>
                                    @endif
                                    @if (!isset($hideApiMessage) || $hideApiMessage == false)
                                        <table width="600" border="0" cellpadding="0" cellspacing="0" style="width: 600px;">
                                            <tr>
                                                <td width="40" align="left" valign="top">&nbsp;</td>
                                                <td width="520" align="center" valign="top" style="font-family: 'Century Gothic', Arial, sans-serif; color: #4c4d4f; font-size: 14px;"></td>
                                                <td width="40" align="left" valign="top">&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td width="40" align="left" valign="top">&nbsp;</td>
                                                <td width="520" align="center" valign="top" style="font-family: 'Century Gothic', Arial, sans-serif; color: #4c4d4f; font-size: 30px;">API Interface Error!</td>
                                                <td width="40" align="left" valign="top">&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td width="40" align="left" valign="top">&nbsp;</td>
                                                <td width="520" align="center" valign="top" style="font-family: 'Century Gothic', Arial, sans-serif; color: #4c4d4f; font-size: 14px;"></td>
                                                <td width="40" align="left" valign="top">&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td width="40" align="left" valign="top">&nbsp;</td>
                                                <td width="520" align="left" valign="top" style="font-family: 'Century Gothic', Arial, sans-serif; color: #4c4d4f; font-size: 14px;">
                                                    <p>
                                                        <small>
                                                            You are receiving this email because the interface between your website
                                                            and the Vendirun application is not working. In this instance the system
                                                            sends an automated email with any details submitted by your users
                                                            so no information is lost.
                                                        </small>
                                                    </p>
                                                    <p>
                                                        <small>
                                                            Please login to your Vendirun system and make sure your account is up to
                                                            date. The support team has also been notified of the problem.
                                                        </small>
                                                    </p>
                                                    <p>&nbsp;</p>
                                                </td>
                                                <td width="40" align="left" valign="top">&nbsp;</td>
                                            </tr>
                                        </table>
                                    @endif
                                </td>
                                <td width="50" align="left" valign="top">&nbsp;</td>
                            </tr>
                            <tr>
                                <td width="50" height="40" align="left" valign="top">&nbsp;</td>
                                <td width="600" height="40" align="left" valign="top" bgcolor="#FFFFFF">&nbsp;</td>
                                <td width="50" height="40" align="left" valign="top">&nbsp;</td>
                            </tr>
                            <tr>
                                <td width="50" height="24" align="left" valign="top">&nbsp;</td>
                                <td width="600" height="24" align="left" valign="top">
                                    <img style="display:block" src="{{ asset('vendor/vendirun/images/emails/shadow.png') }}" alt="" width="600" height="25" hspace="0" vspace="0" border="0"/>
                                </td>
                                <td width="50" height="24" align="left" valign="top">&nbsp;</td>
                            </tr>
                            <tr>
                                <td width="50" align="left" valign="top">&nbsp;</td>
                                <td width="600" align="left" valign="top">
                                    <table width="600" border="0" cellpadding="0" cellspacing="0" style="width: 600px;">
                                        <tr>
                                            <td height="50" align="center" valign="middle" style="font-family: 'Century Gothic', Arial, sans-serif; color: #909191; font-size: 12px;">
                                                <a href="http://www.vendirun.com"><img src="{{ asset('vendor/vendirun/images/emails/mini-logo.png') }}" width="116" height="25" border="0"></a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td height="50" align="center" valign="middle" style="font-family: 'Century Gothic', Arial, sans-serif; color: #909191; font-size: 12px;">  &copy; 2015 Vendirun, All Rights Reserved.<br>
                                                <a href="http://vendirun.com">vendirun.com</a>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                                <td width="50" align="left" valign="top">&nbsp;</td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td width="700" height="30" align="left" valign="top">&nbsp;</td>
                </tr>
            </table>
        </td>
    </tr>

</table>
</body>
</html>
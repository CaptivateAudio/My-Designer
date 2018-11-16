<div style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box;background-color:#f5f8fa;color:#9a9a9a;height:100%;line-height:1.4;margin:0;width:100%!important;word-break:break-word">
<table width="100%" cellpadding="0" cellspacing="0" style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box;background-color:#f5f8fa;margin:0;padding:0;width:100%">
    <tbody>
        <tr>
            <td style="text-align: center; padding:30px; color:#9a9a9a;"><h1>{{ $site_title }}</h1></td>
        </tr>
        <tr>
            <td style="background: #ffffff;">
                <table width="100%" cellpadding="0" cellspacing="0" style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box;background-color:#ffffff;color:#464646;margin:0 auto;padding:0;width:540px;">
                    <tbody>
                        <tr><td><h3>{{ $emailContent['heading'] }}</h3></td></tr>
                        <tr><td><p>Designer: {{ $emailContent['designer'] }}</p></td></tr>
                        <tr><td><p>Completion Date: {{ $emailContent['completion_date'] }}</p></td></tr>
                        <tr>
                            <td style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box">
                                <p><a href="{{ $emailContent['button_url'] }}" style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box;border-radius:3px;color:#fff;display:inline-block;text-decoration:none;background-color:#3097d1;border-top:10px solid #3097d1;border-right:18px solid #3097d1;border-bottom:10px solid #3097d1;border-left:18px solid #3097d1" target="_blank">{{ $emailContent['button_text'] }}</a></p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
        <tr>
            <td style="text-align: center; padding:30px; color:#9a9a9a;">&copy; {{ now()->year }} {{ $site_title }}. All rights reserved.</h1></td>
        </tr>
    </tbody>
</table>
</div>
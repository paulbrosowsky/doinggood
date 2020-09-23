<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    </head>
    <body style="margin: 0;padding: 0;font-family: 'Poppins',Helvetica,Arial,Lucida,sans-serif;">
        
        <table align="center" border="0" cellpadding="0" cellspacing="0" width="600">
            <tr>
                <td>
                <img src="https://doinggoodchallenge.de/wp-content/uploads/2019/07/rgbklein.jpg" alt="Doing Good Logo" width="50%">
                </td>
            </tr>
            
            <tr>
                <td style="padding: 40px 30px 40px 30px;">
                  <table border="0" cellpadding="0" cellspacing="0" width="100%">
                    {{ Illuminate\Mail\Markdown::parse($slot) }}

                    {{ $subcopy ?? '' }}
                  </table>
                </td>
            </tr>
        </table>
    </body>
</html>

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Message Us</title>
</head>
<body style="font-family: 'Segoe UI', Arial, Tahoma, Geneva, Verdana, sans-serif; width: 100%; box-sizing: border-box; margin: 0; padding: 0;">
    <section class="messageus-mail" style="width: 100%; margin: 0; padding-inline: 15px; box-sizing: border-box;">
            <h2 style="color: dodgerblue">New Message</h2>
            <div class="content" style="border: 0.5px solid rgba(0, 0, 0, 0.096); box-shadow: 4px 4px 14px rgba(0, 0, 0, 0.096); box-sizing: border-box; 
            border-radius: 8px; padding: 35px 25px; max-width: 600px;
            ">
                <ul style="list-style: none; margin: 0; padding: 0;">
                    <li style="width: 100%;">
                        <b>Name</b>
                        <span>-</span>
                        <span>{{$name ?? "No name"}}</span>
                    </li>
                    <li style="width: 100%; margin-block: 12px;">
                        <b>Email</b>
                        <span>-</span>
                        <span>{{$email ?? "No email"}}</span>
                    </li>
                    <li style="width: 100%; margin-block: 12px;">
                        <b>Phone number</b>
                        <span>-</span>
                        <span>{{$phone_number ?? "No number"}}</span>
                    </li>
                    <li style="width: 100%; margin-block: 12px;">
                        <b>Subject</b>
                        <span>-</span>
                        <span>{{$subject ?? "No subject"}}</span>
                    </li>
                    <li style="width: 100%; margin-block: 12px;">
                        <p><b>Message</b></p>
                        <div>{{$messagex ?? "No message"}}</div>
                    </li>
                </ul>
            </div>

    </section>
</body>
</html>
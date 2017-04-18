# Slack-Phone-Status

Pretty rudimentary status updater. You can call it from Windows using the cygwin wget executable using a command like below.

```wget.exe -b -q "https://YOURDOMAIN.com/slack-status.php?token=AUTHTOKEN&first_name=FIRSTNAME&last_name=LASTNAME&status=phone" -O NUL 2>NUL```

As it is setup right now, status = phone will change the status icon to a phone, and status = off will clear it. You can expand this further by modifying the if block at line 24 of slack-status.php, just modify the emoji and text lines.
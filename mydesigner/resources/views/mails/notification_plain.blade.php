Hello {{ $notification->receiver }},
This is a notification email for testing purposes! Also, it's the HTML version.
 
Demo object values:
 
Demo One: {{ $notification->demo_one }}
Demo Two: {{ $notification->demo_two }}
 
Values passed by With method:
 
testVarOne: {{ $testVarOne }}
testVarOne: {{ $testVarOne }}
 
Thank You,
{{ $notification->sender }}
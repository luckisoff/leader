<!DOCTYPE html>
<html>
<head>
    <title>Redirecting...</title>
</head>
<body onLoad="document.forms[0].submit();">
<CENTER ><FONT size="5" color="#3b4455">Transaction is being processed,<BR/>Please wait ...</FONT></CENTER>
    <form action="https://esewa.com.np/epay/main" method="POST">
        <input value="1000" name="tAmt" type="hidden">
        <input value="1000" name="amt" type="hidden">
        <input value="0" name="txAmt" type="hidden">
        <input value="0" name="psc" type="hidden">
        <input value="0" name="pdc" type="hidden">
        <input value="NP-ES-SRBN" name="scd" type="hidden">
        <input value="LEADERAUDITION-SRBN-{{$id}}" name="pid" type="hidden">
        <input value="{{env('APP_URL').'/web/audition/esewa/success'}}" type="hidden" name="su">
        <input value="{{env('APP_URL').'/web/audition/esewa/failure'}}" type="hidden" name="fu">
    </form>
</body>
</html>

@component('mail::message')
# <h2 style="text-align: center">Verification Code</h2>
<h1 style="font-size: 2.5rem;text-align:center">
    <?= $code ?>
</h1>
<h3 style="text-align: center">
    Here is your verification code.<br> 
    It will expire in 2 minutes.<br>
    <br>
    <small style="font-weight: normal">
        <i>If you didn't ask to verify this address, you can ignore this email.</i>
    </small>
</h3>

Thanks,<br>
Redd One Digital
@endcomponent

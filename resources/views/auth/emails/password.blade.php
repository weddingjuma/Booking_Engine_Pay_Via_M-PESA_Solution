Dear User,
<p>
    We have received an email reset notification form you. Kindly click on the link to reset your password: <a href="{{ $link = url('password/reset', $token).'?email='.urlencode($user->getEmailForPasswordReset()) }}"> {{ $link }} </a>
</p>

<p>
    If you did not request for this service, kindly ignore this email.
    </p>
<p>
    Regards,</p>
    Sisimsha Support.
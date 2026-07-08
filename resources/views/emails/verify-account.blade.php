<x-mail::message>
# Olá, {{ $name }}!

Obrigado por criar sua conta no **{{ $appName }}**.

Clique no botão abaixo para confirmar seu e-mail e ativar o acesso ao painel.

<x-mail::button :url="$verificationUrl">
Ativar minha conta
</x-mail::button>

Se você não criou esta conta, ignore este e-mail.

Equipe {{ $appName }}
</x-mail::message>
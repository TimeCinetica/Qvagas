<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

@include('shared.head', [
'js' => ['js/auth/newPassword.js'],
'css' => ['css/auth/newPassword.css']
])

<body id="newPassword-page">
    <div class="row" style="height: 100%;">
        <div class="col-8"></div>
        <div class="col-4 d-flex flex-column justify-content-center align-items-center sided-form">
            <div class="row">
                <h1>Troque sua senha</h1>
            </div>
            <div class="row">
                <form method="POST" id="newPassword-form" onsubmit="sendPassword(event)" novalidate>
                    <div class="form-group">
                        <label for="name">CPF *</label>
                        <input type="text" maxlength="14" class="form-control" id="cpf" aria-describedby="nameHelp" placeholder="123.456.789-10" required>
                        @include('components.form.validation', ['invalidMessage' => "CPF é obrigatório"])
                    </div>
                    <div class="form-group">
                        <label for="name">Código *</label>
                        <input type="text" maxlength="6" minlength="6" class="form-control" id="code" aria-describedby="nameHelp" placeholder="123456" required>
                        @include('components.form.validation', ['invalidMessage' => "Código de 6 digitos é obrigatório"])
                    </div>
                    <div class="form-group">
                        <label for="password">Senha *</label>
                        <input type="password" class="form-control" id="password" placeholder="******" minlength="6" required>
                        @include('components.form.validation', ['invalidMessage' => "Senha precisa de 6 caracteres"])
                    </div>
                    <div class="form-group">
                        <label for="password-confirm">Confirmar senha *</label>
                        <input type="password" class="form-control" id="password-confirm" placeholder="******" minlength="6" required>
                        @include('components.form.validation', ['invalidMessage' => "Confirmação de senha precisa de 6 caracteres"])
                    </div>
                    <div class="d-grid gap-2 col-12 mx-auto button-position">
                        <button id="newPassword-button" type="submit" class="btn btn-primary">Confirmar</button>
                    </div>
                    <div class="d-flex justify-content-center">
                        <a href="forgot-password"><small>Voltar e gerar novo código</small></a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @include('components.toast.default-toast');
</body>

</html>
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

@include('shared.head', [
'js' => ['js/auth/login.js'],
'css' => ['css/auth/login.css'],
'title' => 'QVagas | Entrar'
])

<body id="login-page">
    <div class="sided-form">
        <div class="sided-content">
            <div class="row">
                <h1>Entre agora!</h1>
            </div>
            <div class="row">
                <form method="POST" id="login-form" onsubmit="login(event)" novalidate>
                    <div class="form-group">
                        <label for="name">CPF *</label>
                        <input type="tel" inputmode="tel" maxlength="14" class="form-control" id="cpf" aria-describedby="nameHelp" placeholder="123.456.789-10" required>
                        @include('components.form.validation', ['invalidMessage' => "CPF é obrigatório"])
                    </div>
                    <div class="form-group">
                        <label for="password">Senha *</label>
                        <input type="password" class="form-control" id="password" placeholder="******" minlength="6" required>
                        @include('components.form.validation', ['invalidMessage' => "Senha precisa de 6 caracteres"])
                    </div>
                    <div class="d-grid gap-2 col-12 mx-auto button-position">
                        <button id="login-button" type="submit" class="btn btn-primary">Entrar</button>
                    </div>
                    <div class="d-flex justify-content-center">
                        <a href="signup"><small>Ou crie sua conta.</small></a>
                    </div>
                    <div class="d-flex justify-content-center">
                        <a href="forgot-password"><small>Esqueceu a senha?</small></a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @include('components.toast.default-toast');
</body>

</html>
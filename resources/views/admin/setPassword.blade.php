<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

@include('shared.head', [
'js' => ['js/admin/setPassword.js'],
'css' => ['css/admin/setPassword.css']
])

<body id="set-password-page">
    @include('shared.nav')
    <div class="container">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <h3>Redefinir senha</h3>
                    </div>
                    <form method="POST" onsubmit="setPassword(event)" id="set-password-form" novalidate>
                        <div class="form-group">
                            <label for="email">E-mail</label>
                            <input type="email" class="form-control" name="email" id="email" value="{{$user->email}}" disabled>
                            @include('components.form.validation', ['invalidMessage' => "E-mail obrigatório"])
                        </div>
                        <div class="form-group">
                            <label for="cpf">CPF</label>
                            <input type="cpf" class="form-control" name="cpf" id="cpf" value="{{$user->cpf}}" disabled>
                            @include('components.form.validation', ['invalidMessage' => "CPF obrigatório"])
                        </div>
                        <div class="form-group">
                            <label for="password">Nova senha</label>
                            <input type="password" class="form-control" name="password" id="password" minlength="6" required>
                            @include('components.form.validation', ['invalidMessage' => "Senha precisa ter no mínimo 6 caracteres"])
                        </div>
                        <div class="form-group">
                            <label for="password-confirm">Confirmar nova senha</label>
                            <input type="password" class="form-control" name="password-confirm" id="password-confirm" required>
                            @include('components.form.validation', ['invalidMessage' => "Confirmação de senha precisa ser igual à nova senha"])
                        </div>
                        <div class="buttons">
                            <button type="submit" id="confirm-button" class="btn btn-primary">Confirmar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @include('components.toast.default-toast')
</body>

</html>
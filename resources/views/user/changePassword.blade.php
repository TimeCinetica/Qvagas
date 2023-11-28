<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

@include('shared.head', [
'js' => ['js/user/changePassword.js'],
'css' => ['css/user/changePassword.css']
])

<body id="change-password-page">
    @include('shared.nav')
    <div class="container">
        <div class="row">
            <h1>Alterar senha</h1>
        </div>
        <div class="row justify-content-center">
            <div class="card card-shadow">
                <div class="card-body">
                    <div class="row">
                        <form id="change-password-form" novalidate>
                            <div class="form-group">
                                <label for="password">Nova senha de acesso *</label>
                                <input name="password" id="password" type="password" class="form-control" placeholder="******" required>
                            </div>
                            <div class="form-group">
                                <label for="password-confirm">Confirmar nova senha de acesso *</label>
                                <input name="passwordConfirm" id="password-confirm" type="password" class="form-control" placeholder="******" required>
                            </div>
                        </form>
                    </div>
                    <div class="d-flex justify-content-center">
                        <button id="change-button" class="btn btn-primary" onclick="changePassword(@json(auth()->user()->id))">Confirmar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('components.toast.default-toast')
</body>

</html>
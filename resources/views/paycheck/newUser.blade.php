<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

@include('shared.head', [
'js' => ['js/paycheck/new.js'],
'css' => ['css/admin/new.css']
])

<body id="new-admin-page">
    @include('shared.nav')
    <div class="container">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <h3>Novo Colaborador</h3>
                    </div>
                    <form method="POST" onsubmit="storeAdmin(event)" id="new-admin-form" novalidate>
                        <div class="form-group">
                            <label for="name">Admin </label>
                            <input type="text" id="admin_responsed" name="admin_responsed" class="form-control" value="{{ $paycheckArmazem }}" readonly required>
                            @include('components.form.validation', ['invalidMessage' => "Nome obrigatório"])
                        </div>
                        <div class="form-group">
                            <label for="name">Nome *</label>
                            <input type="text" id="name" name="name" class="form-control" required>
                            @include('components.form.validation', ['invalidMessage' => "Nome obrigatório"])
                        </div>
                        <div class="form-group">
                            <label for="cpf">CPF *</label>
                            <input type="text" class="form-control" name="cpf" id="cpf" required minlength="14" maxlength="14">
                            @include('components.form.validation', ['invalidMessage' => "CPF é obrigatório"])
                        </div>
                        <div class="form-group">
                            <label for="email">E-mail *</label>
                            <input type="email" class="form-control" name="email" id="email" required>
                            @include('components.form.validation', ['invalidMessage' => "E-mail obrigatório"])
                        </div>
                        <div class="form-group">
                            <label for="tel">Telefone *</label>
                            <input type="tel" class="form-control" name="tel" id="tel" required>
                            @include('components.form.validation', ['invalidMessage' => "E-mail obrigatório"])
                        </div>
                        <div class="form-group">
                            <label for="date">Data de Admissão *</label>
                            <input type="date" class="form-control" name="date" id="date" required>
                            @include('components.form.validation', ['invalidMessage' => "E-mail obrigatório"])
                        </div>
                        <div class="form-group">
                            <label for="km">Cargo *</label>
                            <input type="text" class="form-control" name="job" id="job" required>
                            @include('components.form.validation', ['invalidMessage' => "E-mail obrigatório"])
                        </div>
                        <div class="form-group">
                            <label for="role">Perfil *</label>
                            <select id="role" name="role" class="form-select">
                                <option value="4" selected>Colaborador</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="password">Senha provisória *</label>
                            <input type="password" class="form-control" name="password" id="password" minlength="6" required>
                            @include('components.form.validation', ['invalidMessage' => " Senha precisa ter no mínimo 6 caracteres"])
                        </div>
                        <div class="form-group">
                            <label for="password-confirm">Confirmar senha provisória *</label>
                            <input type="password" class="form-control" name="password-confirm" id="password-confirm" required>
                            @include('components.form.validation', ['invalidMessage' => "Confirmação de senha precisa ser igual à senha provisória"])
                        </div>
                        <div class="buttons">
                            <button type="submit" id="new-button" class="btn btn-primary">Cadastrar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @include('components.toast.default-toast')
</body>

</html>





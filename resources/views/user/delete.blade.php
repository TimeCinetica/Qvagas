<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

@include('shared.head', [
'js' => ['js/user/delete.js'],
'css' => ['css/user/delete.css']
])

<body id="delete-page">
    @include('shared.nav')
    <div class="container">
        <div class="row">
            <h1>Exclusão de cadastro e currículo</h1>
        </div>
        <div class="row justify-content-center">
            <div class="card card-shadow">
                <div class="card-body">
                    <div class="row">
                        <p>Olá profissional!</p>
                        <p>Ao excluir seu cadastro do site não terá mais os nossos benefícios de vagas de emprego verificadas, vagas com prazo de validade e entre outros.</p>
                        <p>
                            Para ter acesso novamente precisará entrar em nosso site e refazer todo o Cadastro de currículo.
                            Caso você confirme a exclusão, todos os seus dados serão <b>PERMANENTE</b> apagados do sistema. Deseja prosseguir com a exclusão mesmo assim?
                        </p>
                    </div>
                    <div class="d-flex justify-content-center">
                        <button id="delete-button" class="btn btn-primary" onclick="deleteUser(@json(auth()->user()->id))">Confirmar exclusão</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
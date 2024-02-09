<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

@include('shared.head', [
'js' => ['js/paycheck/list.js', 'js/shared/datatable.js'],
'css' => ['css/occupations/index.css', 'css/shared/datatable.css', 'css/user/home.css']
])

<body id="paycheck-collaborate-page">
    @include('shared.nav')
    <div class="container">
        <div class="col">
            <div class="row justify-content-center welcome">
                <div class="card card-shadow">
                    <div class="card-body">
                        <h2 class="card-title">Seja Bem Vindo(a)!</h2>
                        <div class="card-text">
                            <p>
                                Aqui é onde você verá todos os seus contracheques!
                            </p>

                        </div>
                    </div>
                </div>
            </div>
            @foreach ($paychecks as $paycheck)
            <div class="paycheck">
                <a href="{{ Storage::url($paycheck->paycheckpdf) }}" target="_blank">Ver Contracheque</a>
            </div>
            @endforeach
        </div>

    </div>
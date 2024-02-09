<?php
    setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
    date_default_timezone_set('America/Sao_Paulo');
    
    function monthName($date) {
        $date = DateTime::createFromFormat('m/Y', $date);
        if ($date instanceof DateTime) {
            return strftime('%B', $date->getTimestamp());
        } else {
            // Retorne algum valor padrão ou manipule o erro como achar melhor
            return 'Data inválida';
        }
    }
    
    
?>

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

@include('shared.head', [
'js' => ['js/paycheck/list.js', 'js/shared/datatable.js'],
'css' => ['css/occupations/index.css', 'css/shared/datatable.css', 'css/user/home.css']
])

<body id="paycheck-collaborate-page">
    @include('shared.nav')
    <div class="container">
        <div class="col mt-5">
            <div class="row justify-content-center welcome">
                <div class="card card-shadow">
                    <div class="card-body">
                        <h2 class="card-title">Olá, {{ $name }}!</h2>
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
                    <a class=" btn btn-primary btn-dft mt-2" href="{{ Storage::url($paycheck->paycheckpdf)}}" target="_blank">{{ monthName($paycheck->month_year) }}</a>
                </div>
            @endforeach
        </div>

    </div>
<?php
    function translateMonth($monthName) {
        $months = [
            'January' => 'Janeiro',
            'February' => 'Fevereiro',
            'March' => 'Março',
            'April' => 'Abril',
            'May' => 'Maio',
            'June' => 'Junho',
            'July' => 'Julho',
            'August' => 'Agosto',
            'September' => 'Setembro',
            'October' => 'Outubro',
            'November' => 'Novembro',
            'December' => 'Dezembro'
        ];
        
        return $months[$monthName] ?? $monthName;
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
                        <h2 class="card-title"><strong>Olá, {{ $user->name }}!</strong></h2>
                        <div class="card-text">
                            <p>
                                Bem-vindo à plataforma QContraCheque, facilitando a visualização do seu contracheque. 
                                Para esclarecimentos sobre pagamentos, sinta-se à vontade para contatar o setor de 
                                Recursos Humanos da sua empresa. Estamos aqui para ajudar.
                            </p>

                        </div>
                    </div>
                </div>
            </div>
            <table id="list-paychecks-table" class="table table-striped fast-table">
                <thead>
                    <tr>
                        <th class="text-center">Contracheques</th>             
                    </tr>
                </thead>
                <tbody>
                @foreach ($paychecksByYear as $year => $paychecks)
                    <tr data-toggle="collapse" data-target="#year-{{ $year }}" class="accordion-toggle" style="cursor: pointer;">
                        <td colspan="6" class="text-center">
                            <div class="d-flex align-items-center justify-content-between px-3">
                                <div><strong>{{ $year }}</strong></div>
                                <div><i class="bi bi-chevron-down arrow-icon" id="arrow-{{ $year }}"></i></div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="6" style="padding: 0 !important;">
                            <div class="collapse" id="year-{{ $year }}">
                                <div class="container p-3">
                                    <div class="row">
                                        @foreach ($paychecks as $index => $paycheck)
                                            <div class="col-md-3">
                                                <center>
                                                    <a class="btn btn-primary btn-dft w-100 my-1" href="{{ Storage::url($paycheck->paycheckpdf) }}" target="_blank">{{ translateMonth($paycheck->month_name) }}</a>
                                                </center>
                                            </div>
                                            
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

    </div>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

    <script>
    document.querySelectorAll('.accordion-toggle').forEach(function(userRow) {
        userRow.addEventListener('click', function() {
            var arrowIcon = this.querySelector('i');
            arrowIcon.classList.toggle('bi-chevron-down');
            arrowIcon.classList.toggle('bi-chevron-up');
        });
    });
</script>

</body>
</html>
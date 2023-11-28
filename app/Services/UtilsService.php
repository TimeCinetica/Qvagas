<?php

namespace App\Services;

use App\Models\City;
use App\Models\State;

class UtilsService
{
    protected $states;
    protected $cities;
    protected $users;

    public function __construct(
        State $states,
        City $cities
    ) {
        $this->states = $states;
        $this->cities = $cities;
    }

    /**
     * 
     */
    public function indexStates()
    {
        return $this->states->all();
    }

    /**
     * 
     */
    public function indexCitiesByState($stateId)
    {
        return $this->cities->where('stateId', $stateId)->get();
    }

    /**
     * Valida o cpf da request
     */
    public function validateCpf($cpf)
    {
        //https://gist.github.com/rafael-neri/ab3e58803a08cb4def059fce4e3c0e40
        // Extrai somente os números
        $cpf = preg_replace('/[^0-9]/is', '', $cpf);

        // Verifica se foi informado todos os digitos corretamente
        if (strlen($cpf) != 11) {
            abort(400, "CPF não é válido!");
        }

        // Verifica se foi informada uma sequência de digitos repetidos. Ex: 111.111.111-11
        if (preg_match('/(\d)\1{10}/', $cpf)) {
            abort(400, "CPF não é válido!");
        }

        // Faz o calculo para validar o CPF
        for ($t = 9; $t < 11; $t++) {
            for ($d = 0, $c = 0; $c < $t; $c++) {
                $d += $cpf[$c] * (($t + 1) - $c);
            }
            $d = ((10 * $d) % 11) % 10;
            if ($cpf[$c] != $d) {
                abort(400, "CPF não é válido!");
            }
        }
        return true;
    }

    /**
     * Gera um codigo aleatoria de 6 digitos que sera enviado para usuario recuperar a senha
     */
    public function generateCode()
    {
        return str_pad(rand(0, 999999), 6, 0, STR_PAD_LEFT);
    }
}

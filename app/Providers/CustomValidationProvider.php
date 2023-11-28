<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class CustomValidationProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->UniqueExceptSelf();
    }

    /**
     * 
     */
    private function UniqueExceptSelf()
    {
        Validator::extend(
            'unique_except_self',
            function ($attribute, $value, $parameters, $validator) {
                if (count($parameters) < 3) {
                    throw new \Exception('table, id, skipNormalize params required for unique_except_self validation.');
                }

                $table = $parameters[0];
                $id = $parameters[1];
                $skipNormalize = (bool) $parameters[2];
                if (!$skipNormalize) {
                    $value = $this->normalizeValue($value);
                }

                $isUnique = DB::table($table)->where($attribute, $value)->where('id', '<>', $id)->count() == 0;
                return $isUnique;
            }
        );
    }

    // Normaliza campos numericos, como cpf, cnpj, telefone, etc.
    private function normalizeValue($value)
    {
        return preg_replace('/[^0-9]/', '', $value);
    }
}

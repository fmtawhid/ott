<?php

namespace App\Currency;
 use Modules\Currency\Models\Currency;

class CurrencyChange
{
    public $defaultCurrency;

    public $currencyList;

    public function __construct()
    {
        $this->currencyList = Currency::all();
        $this->defaultCurrency = $this->currencyList->where('is_primary', 1)->first();

    }

    public function getDefaultCurrency($array = false)
    {
        if ($array && isset($this->defaultCurrency)) {
            return $this->defaultCurrency->toArray() ?? [];
        }

        return $this->defaultCurrency;
    }

    public function defaultSymbol()
    {
        return $this->defaultCurrency->currency_symbol ?? '';
    }

    public function format($amount)
    {

        $noOfDecimal = $this->defaultCurrency->no_of_decimal ?? 2;
        $decimalSeparator = $this->defaultCurrency->decimal_separator ?? '';
        $thousandSeparator = $this->defaultCurrency->thousand_separator ?? '';
        $currencyPosition = $this->defaultCurrency->currency_position ?? 'left';
        $currencySymbol = $this->defaultCurrency->currency_symbol ?? '';

        return formatCurrency($amount, $noOfDecimal, $decimalSeparator, $thousandSeparator, $currencyPosition, $currencySymbol);
    }
}

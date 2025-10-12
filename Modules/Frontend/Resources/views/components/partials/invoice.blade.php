
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    {{-- <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet"> --}}
    <style>
        h1,h2, h3, h4, h5, h6 {
            margin: 0;
            color: #010A0F;
            font-weight: 500;
        }
        p {
            margin: 0;
        }
        body {
            /* font-family: "Roboto", sans-serif; */
            font-family: 'DejaVu Sans', 'NotoSansBengali', sans-serif;
            color: #6B6B6B;
            font-size: 16px;
        }
        .header {
            display: block;
        }
        .text-black {
            color: #010A0F;
        }
        .c-row {
            display: flex;
            flex-wrap: wrap;
        }
        .c-align-center {
            align-items: center;
        }
        .c-justify-between {
            justify-content: space-between;
        }
        .c-col-6 {
            flex: 0 0 auto;
            width: 50%;
        }
        .c-col-7 {
            flex: 0 0 auto;
            width: 58.33333333%;
        }
        .c-col-5 {
            flex: 0 0 auto;
            width: 41.66666667%;
        }
        .p-badge {
            background-color: #32A071;
            color: #ffffff;
            padding: 6px 10px;
            border-radius: 6px;
        }
        .c-text-end {
            text-align: right;
        }
        ul {
            margin: 0;
            padding: 0;
            list-style-type: none;
        }
        ul li:not(:last-child) {
            margin-bottom: 5px;
        }
        table {
            width: 100%;
            text-align: left;
            margin: 50px 0 30px;
            border: 1px solid #CCCCCC;
            border-radius: 6px;
        }
        table thead {
            background-color: #F2F2F2;
        }

        table thead th {
            color: #010A0F;
        }

        table th,
        table td {
            padding: 10px;
        }
        table, th, td {
        border: 1px solid #CCCCCC;
        border-collapse: collapse;
        }

        hr {
            margin: 25px 0;
            border-color: #CCCCCC;
        }
    </style>
</head>
<body>

  <div class="header">
    <div class="main-logo" style="float: left">
        @include('frontend::components.partials.logo') 
    </div>
    <div style="float: right">
        <p>{{ __('frontend.invoice_date') }} - <span class="text-black">{{ now()->format('d/m/Y') }}</span> <span style="padding-left: 10px;">{{ __('frontend.invoice_id') }} -  <span class="text-black">#{{ $data->id }}</span></span></p>
    </div>
  </div>

  <div style="clear: both">
    <hr>
  </div>

  <div class="main-content">
    <div class="c-row c-align-center c-justify-between" style="padding: 35px 0 70px;">
        <div class="c-col-6" style="float: left">
            <p>{{ __('frontend.thanks_payment') }}</p>
        </div>

        <div class="c-col-6 c-text-end" style="float: right">
            <div class="">
                <span>{{ __('frontend.payment_status') }}:</span>
                <span class="p-badge" style="margin-left: 10px;">{{ optional($data->subscription_transaction)->payment_status }}</span>
            </div>
        </div>
    </div>
  </div>

  <div class="header-content" style="clear: both">
    <div class="c-row">
        <div class="left-content c-col-7" style="float: left">
            <h3>{{ $settingValue = App\Models\Setting::where('name', 'app_name')->value('val') ?? '-'}}</h3>
        </div>
        <div class="right-content c-col-5" style="text-align: right; float: right">
            <p>{{ App\Models\Setting::where('name','inquriy_email')->value('val') ?? 'info@tihd.tv' }}</p>
            <p style="margin: 10px 0 0;">{{ App\Models\Setting::where('name','helpline_number')->value('val') ?? '-'}}</p>
        </div>
    </div>
  </div>

  <div style="clear: both">
    <hr>
  </div>

  <div class="c-row">
    <div class="left-content c-col-7">
        <h4>{{ __('frontend.customer_detail') }}:</h4>
        <div style="width: 50%; margin-top: 10px;">
            <ul>
                <li>{{$data->user->full_name ??  default_user_name()}}</li>
                <li>{{$data->user->email }}</li>
                <li>{{$data->user->mobile }}</li>
            </ul>
        </div>
    </div>
  </div>

  <table>
    <thead>
        <tr>
            <th>{{ __('frontend.plan_name') }}</th>
            <th>{{ __('frontend.plan_price') }}</th>
            <th>{{ __('frontend.tax_name') }}</th>
            <th>{{ __('frontend.tax_amount') }}</th>
            <th class="c-text-end">{{ __('frontend.total') }}</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>{{$data->name }} - {{ $data->duration }} {{ $data->type }}</td>
            <td>{{ number_format($data->amount, 2) }} tk</td>

            <td>-</td>
            <td>-</td>
            <td class="c-text-end"> {{ number_format($data->amount, 2) }} tk</td>
        </tr>

        @php
        $amount_after_discount = 0;
        @endphp

        @if($data->discount_percentage >0)
          @php
              $discount_amount= $data->amount*$data->discount_percentage/100;
              $amount_after_discount = $data->amount - $discount_amount;
          @endphp
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td>Discount ({{ $data->discount_percentage }}%)</td>
            <td class="c-text-end"> {{ number_format($discount_amount, 2) }} tk</td>
        </tr>
        @endif

        @php
        $taxData = json_decode(optional($data->subscription_transaction)->tax_data, true);
        if(!empty($taxData) && count($taxData) > 0){
            $totalTaxAmount = 0;
            foreach ($taxData as $tax) {
                if (strtolower($tax['type']) == 'percentage') {
                    $totalTaxAmount += ($amount_after_discount * $tax['value']) / 100;
                } elseif (strtolower($tax['type']) == 'fixed') {
                    $totalTaxAmount += $tax['value'];
                }
            }
        }
        @endphp

        @if(!empty($taxData) && count($taxData) > 0)
        @foreach ($taxData as $tax)
            @php
                if (strtolower($tax['type']) == 'percentage') {
                    $taxAmount = ($amount_after_discount * $tax['value']) / 100;
                } elseif (strtolower($tax['type']) == 'fixed') {
                    $taxAmount = $tax['value'];
                } else {
                    $taxAmount = 0;
                }
            @endphp
            <tr>
                <td></td>
                <td></td>
                <td>{{ $tax['title'] }}</td>
                <td>{{ number_format($taxAmount, 2) }} tk </td>
                @if ($loop->first)
                    <td rowspan="{{ count($taxData)  }}" class="c-text-end">{{ number_format($totalTaxAmount, 2) }} tk</td>
                @endif
            </tr>
        @endforeach
        @endif
    </tbody>
  </table>

  <table style="border: none;">
    <thead>
        <tr>
            <th style="border: none; text-align: left;">{{ __('frontend.grand_total') }}</th>
            <th style="border: none;" class="c-text-end">{{ number_format($data->total_amount, 2) }} tk </th>
        </tr>
    </thead>
  </table>

</body>
</html>

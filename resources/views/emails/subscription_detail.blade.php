<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subscription Details</title>
    <!-- Include Bootstrap 5 CSS -->
</head>
<body>
    <div class="container">
        <h2>Subscription Details</h2>

        <p>User: {{ optional($subscriptionDetail->user)->first_name .' '. optional($subscriptionDetail->user)->last_name }}</p>
        <p>Email: {{ optional($subscriptionDetail->user)->email ?? '-' }}</p> 
        <p>Contact No: {{ optional($subscriptionDetail->user)->mobile ?? '-' }}</p> 

        <table style="border:1px solid black;width:100%">
            <thead>
                <tr>
                    <th style="border:1px solid black">Plan</th>
                    <th style="border:1px solid black">End Date</th>
                    <th style="border:1px solid black">Amount</th>
                    <th style="border:1px solid black">Tax Amount</th>
                    <th style="border:1px solid black">Total Amount</th>
                    <th style="border:1px solid black">Duration</th>
                    <th style="border:1px solid black">Status</th>
                </tr>
            </thead>
            <tbody>
             
                    <tr>
                        <td style="border:1px solid black">{{ $subscriptionDetail->name ?? '-' }}</td>
                        <td style="border:1px solid black">{{ \Carbon\Carbon::parse($subscriptionDetail->end_date)->format('Y-m-d') ?? '-'}}</td>
                        <td style="border:1px solid black">{{ $subscriptionDetail->amount ?? '-'}}</td>
                        <td style="border:1px solid black">{{ $subscriptionDetail->tax_amount ?? '-' }}</td>
                        <td style="border:1px solid black">{{ $subscriptionDetail->total_amount ?? '-' }}</td>
                        <td style="border:1px solid black">{{ $subscriptionDetail->duration . ' ' . $subscriptionDetail->type  ?? '-'}}</td>
                        <td style="border:1px solid black">{{ $subscriptionDetail->status ?? '-' }}</td>
                    </tr>
               
            </tbody>
        </table>

    
    </div>
  
</body>
</html>


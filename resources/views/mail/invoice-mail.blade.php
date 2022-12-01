<!doctype html>
<html lang="en" dir="ltr">
<head>
    <!-- favicon -->
    <link rel="shortcut icon" href="assets/images/favicon.ico"/>
    <!-- Font -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700&amp;display=swap" rel="stylesheet">
</head>

<body style="font-family: Nunito, sans-serif; font-size: 15px; font-weight: 400; color: #161c2d;">

<!-- Hero Start -->
<div style="margin-top: 50px;">
    <table cellpadding="0" cellspacing="0"
           style="font-family: Nunito, sans-serif; font-size: 15px; font-weight: 400; max-width: 600px;
           border: none; margin: 0 auto; border-radius: 6px; overflow: hidden;
           background-color: #fff; box-shadow: 0 0 3px rgba(60, 72, 88, 0.15);">
        <thead>
        <tr style="background-color: #2f55d4; padding: 3px 0; line-height: 68px; text-align: center;
        color: #fff; font-size: 24px; letter-spacing: 1px;">
            <th scope="col">
                {{--                <img src="assets/images/logo-light.png" height="24" alt="">--}}
                <h1 style="color: white; margin-left: 40%">Shopify</h1>
            </th>
        </tr>
        </thead>

        <tbody>
        <tr>
            <td style="padding: 24px 24px 0;">
                <table cellpadding="0" cellspacing="0" style="border: none;">
                    <tbody>
                    <tr>
                        <td style="min-width: 130px; padding-bottom: 8px;">Invoice No. :</td>
                        <td style="color: #8492a6;">{{$invoice->invoice_no}}</td>
                    </tr>
                    <tr>
                        <td style="min-width: 130px; padding-bottom: 8px;">Name :</td>
                        <td style="color: #8492a6;">{{ $customer->first_name.' '.$customer->last_name  }}</td>
                    </tr>
                    <tr>
                        <td style="min-width: 130px; padding-bottom: 8px;">Address :</td>
                        <td style="color: #8492a6;">{{$customer->home_address}}</td>
                    </tr>
                    <tr>
                        <td style="min-width: 130px; padding-bottom: 8px;">Date :</td>
                        <td style="color: #8492a6;">{{ date('M d, Y', strtotime($invoice->created_at))  }}</td>
                    </tr>
                    </tbody>
                </table>
            </td>
        </tr>

        <tr>
            <td style="padding: 24px;">
                <div
                    style="display: block; overflow-x: auto; -webkit-overflow-scrolling: touch;
                     border-radius: 6px; box-shadow: 0 0 3px rgba(60, 72, 88, 0.15);">
                    <table cellpadding="0" cellspacing="0">
                        <thead class="bg-light">
                        <tr>
                            <th scope="col"
                                style="text-align: left; vertical-align: bottom;
                                 border-top: 1px solid #dee2e6; padding: 12px;">
                                No.
                            </th>
                            <th scope="col"
                                style="text-align: left; vertical-align: bottom; border-top: 1px solid #dee2e6;
                                 padding: 12px; width: 250px;">
                                Item
                            </th>
                            <th scope="col"
                                style="text-align: end; vertical-align: bottom; border-top: 1px solid #dee2e6; padding: 12px;">
                                Total
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($invoice->order as $key => $order)
                            <tr>
                                <th scope="row" style="text-align: left; padding: 12px; border-top: 1px solid #dee2e6;">
                                    {{ $key + 1 }}
                                </th>
                                <td style="text-align: left; padding: 12px; border-top: 1px solid #dee2e6;">
                                    {{ $order->product->name  }}
                                </td>
                                <td style="text-align: end; padding: 12px; border-top: 1px solid #dee2e6;">{{ number_format($order->price)  }}</td>
                            </tr>
                        @endforeach
                        <tr style="background-color: rgba(47, 85, 212, 0.2); color: #2f55d4; overflow-x: hidden;">
                            <th scope="row"
                                style="text-align: left; padding: 12px; border-top: 1px solid rgba(47, 85, 212, 0.2);">
                                Total
                            </th>
                            <td colspan="2"
                                style="text-align: end; font-weight: 700; font-size: 18px; padding: 12px; border-top: 1px solid rgba(47, 85, 212, 0.2);">
                                {{ number_format($invoice->sub_total)  }}
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </td>
        </tr>

        <tr>
            <td style="padding: 16px 8px; color: #8492a6; background-color: #f8f9fc; text-align: center;">
                ©
                <script>document.write(new Date().getFullYear())</script>
                Shopify.
            </td>
        </tr>
        </tbody>
    </table>
</div>
<!-- Hero End -->
</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mail</title>
    <style>
        .mail-box{
            width: 600px;
            margin: auto;
            font-family: sans-serif;
            text-align: center;
            color: #808080;
        }
        .mail-header{
            background-color: #F58823;
            padding: 45px 20px;
        }
        .mail-header h2{
            margin: 0;
            color: white;
            font-size: 38px;
        }
        .mail-body{
            padding: 20px 20px;
            border: 1px solid #c5c5c5;
            border-top: none;
        }
        .mail-body h3{
            color: #F58823;
            margin-bottom: 20px;
        }
        .mail-body table{
            width: 60%;
            margin: auto;
            /* font-size: 18px; */
        }
        .product-td{
            text-align: left;
            padding: 8px 10px;
        }
        .price-td{
            text-align: right;
        }
        .discount-tr{
            color: #F58823;
            font-weight: bold;
        }
        .total-tr{
            font-weight: bold;
        }
        .order-details-p{
            padding: 25px 0px;
            border-top: 1px solid gainsboro;
            margin-top: 20px;
        }
        .order-details-p p{
            margin: 0;
            line-height: 1.5;
            font-size: 15px;
        }
        .view-btn{
            padding: 12px 35px;
            color: white;
            background-color: #F58823;
            border: none;
            border-radius: 3px;
            font-size: 18px;
            margin-bottom: 10px;
        }
        .footer-p{
            font-size: 18px;
        }
        @media screen and (max-width: 650px) {
            .mail-box{
                width: 100%;
            }
        }
        @media screen and (max-width: 576px) {
            .mail-body table{
                width: 100%;
            }
            .mail-header h2{
                font-size: 30px;
            }
        }
    </style>
</head>
<body>
<section class="mail-sec">
    <div class="mail-box">
        <div class="mail-header">
            <h2>Thanks For Your Order</h2>
        </div>
        <div class="mail-body">
            <h3>Your order from {{$details['username']}}</h3>
            <table>
                <tbody>
                @foreach($details['products'] as $product)
                <tr>
                    <td class="product-td">{{$product->product->product_name}}</td>
                    <td class="price-td">{{$product->type==1?$product->product->refill_price:$product->product->new_price}}</td>
                </tr>
                @endforeach
{{--                <tr class="discount-tr">--}}
{{--                    <td class="product-td">Gem Discount</td>--}}
{{--                    <td class="price-td"> -0.500</td>--}}
{{--                </tr>--}}
                <tr class="discount-tr">
                    <td class="product-td">Total</td>
                    <td class="price-td">{{$details['total']}}</td>
                </tr>
                </tbody>
            </table>
            <div class="order-details-p">
                <p>Your Order ID: {{$details['invoice_id']}}</p>
                <p>Delivering to: {{$details['address']}}</p>
                <p>Time of Order: {{$details['order_date']}}</p>
                <p>Payment by: {{$details['payment_method']}}</p>
            </div>

            <Button class="view-btn">View Receipt</Button>

            <p class="footer-p">Looks like you have made great choice, Enjoy!</p>
        </div>
    </div>
</section>
</body>
</html>

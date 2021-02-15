<?php
$title = "Invoice";
$blank = true;
?>

@extends('layout')

@section('title',$title)


@section('content')
<?php
$pd = $o['pd'];
$sd = $o['sd'];
$customer = $o['user'];
$cname = $customer['fname']." ".$customer['lname'];

$payment_method = "Credit Card/Debit Card";
$shipping_method = "Free Shipping";
?>
<div class="row">
                        <div class="offset-xl-2 col-xl-8 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="card">
                                <div class="card-header p-4">
                                     <a class="pt-2 d-inline-block" href="javascript:void(0)">Invoice</a>
                                   
                                    <div class="float-right"> <h3 class="mb-0">Order #{{$o['reference']}}</h3>
                                    Date: {{$o['date']}}</div>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive-sm mb-5">
									
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th colspan="2">Order Details</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td class="center">
													  <h3 class="text-dark mb-1">Mobile Buzz</h3>                                            
                                                      <div>478 Collins Avenue</div>
                                                      <div>Canal Winchester, OH 43110</div><br><br>
                                                      <div>Email: info@mobilebuzz.co.uk</div>
                                                      <div>Phone: +614-837-8483</div>
                                                      <div>Website: <a href="http://localhost:8000">http://localhost:8000</a></div>
													</td>
													<td class="center">                                       
                                                      <div><span class="text-dark mr-5">Date added</span> {{$o['date']}}</div>
                                                      <div><span class="text-dark mr-5">Order ID</span> {{$o['reference']}}</div>
                                                      <div><span class="text-dark mr-5">Payment method</span> {{$payment_method}}</div>
                                                      <div><span class="text-dark mr-5">Shipping method</span> {{$shipping_method}}</div>
													</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
									<div class="table-responsive-sm mb-5">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                   
                                                    <th>Payment Address</th>
                                                    <th>Shipping Address</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>
													  <div>{{strtoupper($pd['fname']." ".$pd['lname'])}}</div>
													  <div>{{strtoupper($pd['address_1'])}}</div>
													  @if($pd['address_2'] != "") <div>{{strtoupper($pd['address_2'])}}</div>@endif
													  <div>{{strtoupper($pd['city']." ".$pd['zip'])}}</div>
													  <div>{{ucwords($pd['region'])}}</div>
													  <div>{{ucwords($countries[$pd['country']])}}</div>
													</td>
													<td>
													  <div>{{strtoupper($sd['fname']." ".$sd['lname'])}}</div>
													  <div>{{strtoupper($sd['address_1'])}}</div>
													  @if($sd['address_2'] != "") <div>{{strtoupper($sd['address_2'])}}</div>@endif
													  <div>{{strtoupper($sd['city']." ".$sd['zip'])}}</div>
													  <div>{{ucwords($sd['region'])}}</div>
													  <div>{{ucwords($countries[$sd['country']])}}</div>
													</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
									<div class="table-responsive-sm mb-5">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th class="center">#</th>
                                                    <th>Item</th>
                                                    <th>Description</th>
                                                    <th class="right">Unit Cost</th>
                                                    <th class="center">Qty</th>
                                                    <th class="right">Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td class="center">1</td>
                                                    <td class="left strong">Origin License</td>
                                                    <td class="left">Extended License</td>
                                                    <td class="right">$1500,00</td>
                                                    <td class="center">1</td>
                                                    <td class="right">$1500,00</td>
                                                </tr>
                                                <tr>
                                                    <td class="center">2</td>
                                                    <td class="left">Custom Services</td>
                                                    <td class="left">Instalation and Customization (cost per hour)</td>
                                                    <td class="right">$110,00</td>
                                                    <td class="center">20</td>
                                                    <td class="right">$22.000,00</td>
                                                </tr>
                                                <tr>
                                                    <td class="center">3</td>
                                                    <td class="left">Hosting</td>
                                                    <td class="left">1 year subcription</td>
                                                    <td class="right">$309,00</td>
                                                    <td class="center">1</td>
                                                    <td class="right">$309,00</td>
                                                </tr>
                                                <tr>
                                                    <td class="center">4</td>
                                                    <td class="left">Platinum Support</td>
                                                    <td class="left">1 year subcription 24/7</td>
                                                    <td class="right">$5.000,00</td>
                                                    <td class="center">1</td>
                                                    <td class="right">$5.000,00</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-4 col-sm-5">
                                        </div>
                                        <div class="col-lg-4 col-sm-5 ml-auto">
                                            <table class="table table-clear">
                                                <tbody>
                                                    <tr>
                                                        <td class="left">
                                                            <strong class="text-dark">Subtotal</strong>
                                                        </td>
                                                        <td class="right">$28,809,00</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="left">
                                                            <strong class="text-dark">Discount (20%)</strong>
                                                        </td>
                                                        <td class="right">$5,761,00</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="left">
                                                            <strong class="text-dark">VAT (10%)</strong>
                                                        </td>
                                                        <td class="right">$2,304,00</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="left">
                                                            <strong class="text-dark">Total</strong>
                                                        </td>
                                                        <td class="right">
                                                            <strong class="text-dark">$20,744,00</strong>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer bg-white">
                                    <p class="mb-0">2983 Glenview Drive Corpus Christi, TX 78476</p>
                                </div>
                            </div>
                        </div>
                    </div>
@stop
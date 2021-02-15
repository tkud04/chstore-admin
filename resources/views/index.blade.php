<?php
$title = "Dashboard";
$subtitle = "Admin dashboard";

$rbrcData = $stats['rbrcData'];
$trmData = $stats['trmData'];
$trmData2 = $stats['trmData2'];

?>

@extends('layout')

@section('scripts')
<link href="{{asset('lib/morris-bundle/morris.css')}}" rel="stylesheet">
<script src="{{asset('lib/morris-bundle/raphael.min.js')}}"></script>
<script src="{{asset('lib/morris-bundle/morris.js')}}"></script>
<script src="{{asset('lib/morris-bundle/morris-init.js')}}"></script>
<script>
let rbrcData = [
<?php

 $opts4 = [
								'studio' => "Studio",
												    '1bed' => "1 bedroom",
												    '2bed' => "2 bedrooms",
												    '3bed' => "3 bedrooms",
												    'penthouse' => "Penthouse apartment",
					  ];

foreach($rbrcData as $k => $v)
{
?>
{value: {{$v}}, label: "{{$opts4[$k]}}"},
<?php
}
?>
];

let trmData = [

<?php

$ctr = 0;

foreach($trmData as $k => $v)
{
?>
{x: "{{$k}}", y: {{$v}},}@if($ctr < count($trmData)),@endif
<?php
++$ctr;
}
?>
        ];
		
console.log(trmData);
</script>
@stop

@section('title',$title)
@section('content')
 <div class="ecommerce-widget">

                        <div class="row">
						<?php
						 //total products
						 $tp = $stats['total_sales'];
						 if($tp == 0)
						 {
							 $tpp = 0;
						 }
						 else
						 {
							 $tpp = (($tp - 2) / $tp) * 100;
						     $toClass = "text-success";
						     $tpIcon = "<span><i class='fa fa-fw fa-arrow-up'></i></span>";
						 }
						 
						 
						 if($tpp < 0)
						 {
							 $toClass = "text-secondary";
							 $tpIcon = "<span><i class='fa fa-fw fa-arrow-down'></i></span>";
						 }
						 else if($tpp == 0)
						 {
							 $toClass = "text-primary";
							 $tpIcon = "";
						 }
						 
						 //total orders
						 $to = $stats['total_orders'];
						 $top = 0;
						 $toClass = "text-success";
						 $toIcon = "<span><i class='fa fa-fw fa-arrow-up'></i></span>";
						 
						 if($top < 0)
						 {
							 $toClass = "text-secondary";
							 $toIcon = "<span><i class='fa fa-fw fa-arrow-down'></i></span>";
						 }
						 else if($top == 0)
						 {
							 $toClass = "text-primary";
							 $toIcon = "";
						 }
						 
						 //total users
						 $tu = $stats['total_users'];
						 $tup = 0;
						 $tuClass = "text-success";
						 $tuIcon = "<span><i class='fa fa-fw fa-arrow-up'></i></span>";
						 
						 if($tup < 0)
						 {
							 $tuClass = "text-secondary";
							 $tuIcon = "<span><i class='fa fa-fw fa-arrow-down'></i></span>";
						 }
						 else if($tup == 0)
						 {
							 $tuClass = "text-primary";
							 $tuIcon = "";
						 }
						?>
                           
                            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="text-muted">Total Orders</h5>
                                        <div class="metric-value d-inline-block">
                                            <h1 class="mb-1">{{$to}}</h1>
                                        </div>
                                        <div class="metric-label d-inline-block float-right {{$toClass}} font-weight-bold">
                                            {!! $toIcon !!}<span>{{$top}}%</span>
                                        </div>
                                    </div>
                                    <div id="sparkline-revenue3"></div>
                                </div>
                            </div>
							 <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="text-muted">Total Sales</h5>
                                        <div class="metric-value d-inline-block">
                                            <h1 class="mb-1">&#0163;{{number_format($tp,2)}}</h1>
                                        </div>
                                        <div class="metric-label d-inline-block float-right {{$toClass}} font-weight-bold">
										{!! $tpIcon !!}<span>{{ceil($tpp)}}%</span>
                                        </div>
                                    </div>
                                    <div id="sparkline-revenue"></div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="text-muted">Total Customers</h5>
                                        <div class="metric-value d-inline-block">
                                            <h1 class="mb-1">{{$tu}}</h1>
                                        </div>
                                        <div class="metric-label d-inline-block float-right {{$tuClass}} font-weight-bold">
                                            {!! $tuIcon !!}<span>{{$tup}}%</span>
                                        </div>
                                    </div>
                                    <div id="sparkline-revenue4"></div>
                                </div>
                            </div>
                        </div>
                        
                            <!-- ============================================================== -->
                      
                            <!-- ============================================================== -->

                                          <!-- recent orders  -->
                            <!-- ============================================================== -->
                            <div class="row">
							<div class="col-xl-9 col-lg-12 col-md-6 col-sm-12 col-12">
                                <div class="card">
                                    <h5 class="card-header">Latest Orders</h5>
                                    <div class="card-body p-0">
                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead class="bg-light">
                                                    <tr class="border-0">
                                                        <th class="border-0">Order ID</th>
                                                        <th class="border-0">Customer</th>
												        <th class="border-0">Status</th>
                                                        <th class="border-0">Total</th>
                                                        <th class="border-0">Date added</th>
                                                        <th class="border-0">Date modified</th>
                                                        <th class="border-0">Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
												
									   <?php
										  
										   if(count($orders) > 0)
										   {
											    $ordersLength = count($orders) > 5 ? 5 : count($orders);
											  for($i = 0; $i < $ordersLength; $i++)
											   {
												   $o = $orders[$i];
												 $customer = $o['user'];
											   $totals = $o['totals'];
											   $uu = url('order')."?xf=".$o['id'];
											   $sss = $o['status'];
												
												   $arr = url('order')."?xf=".$o['id']."&type=edit";
												   $dr = url('remove-order')."?xf=".$o['id'];
												   #$ar = $a['rating'];
												   $ar = 3;
										  ?>
                                            <tr>
                                               <td><a href="{{$uu}}"><h4>{{$o['reference']}}</a></td> 
											   <td>{{ucwords($customer['fname']." ".$customer['lname'])}}</td> 
												<td>{{strtoupper($o['status'])}}</h4></td>	
                                                <td>&#163;{{number_format($totals['subtotal'],2)}}</td>
												<td>{{$o['date']}}</td>
												<td>{{$o['updated']}}</td>
                                                <td>
												 <a class="btn btn-info btn-sm" href="{{$arr}}">Edit</a>
												 <a class="btn btn-danger btn-sm" href="{{$dr}}">Remove</a>
												 </td>
                                            </tr>
									     <?php
											   }
										   }
										 ?>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- ============================================================== -->
                            <!-- end recent orders  -->		
							
							<div class="col-xl-3 col-lg-12 col-md-6 col-sm-12 col-12">
                                <!-- ============================================================== -->
                                <!-- top perfomimg  -->
                                <!-- ============================================================== -->
                                <div class="card">
                                    <h5 class="card-header">Top Performing Products</h5>
                                    <div class="card-body p-0">
                                        <div class="table-responsive">
                                            <table class="table no-wrap p-table">
                                                <thead class="bg-light">
                                                    <tr class="border-0">
                                                        <th class="border-0">Product</th>
                                                        <th class="border-0">Revenue</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
												<?php
												if(count($tph) > 0)
												{
													$tphLength = count($tph) > 5 ? 5 : count($tph);
													for($i = 0; $i < $tphLength; $i++)
													{
														$t = $tph[$i];
													
												?>
                                                    <tr>
                                                        <td>{{$t['name']}}</td>
                                                        <td>{{$t['apartments']}}</td>
                                                        <td>&#8358;{{number_format($t['revenue'],2)}}</td>
                                                    </tr>
												<?php
													}
												}
												?>
                                                    <tr>
                                                        <td colspan="3">
                                                            <a href="{{url('tph')}}" class="btn btn-outline-light float-right">View more</a>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <!-- ============================================================== -->
                                <!-- end top perfomimg  -->
                                <!-- ============================================================== -->
								
								<!-- ============================================================== -->
                                <!-- subscription plans  -->
                                <!-- ============================================================== -->
                                <div class="card">
                                    <h5 class="card-header">Subscription Plans</h5>
                                    <div class="card-body p-0">
                                        <div class="table-responsive">
                                            <table class="table no-wrap p-table">
                                                <thead class="bg-light">
                                                    <tr class="border-0">
                                                        <th class="border-0">Name</th>
                                                        <th class="border-0">Price</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
												<?php
												if(count($plans) > 0)
												{
													$pLength = count($plans) > 5 ? 5 : count($plans);
													for($i = 0; $i < $pLength; $i++)
													{
														$p = $plans[$i];
													
												?>
                                                    <tr>
                                                        <td>{{$p['name']}}</td>
                                                        <td>&#8358;{{number_format($p['amount'],2)}}/{{$p['frequency']}}</td>
                                                    </tr>
												<?php
													}
												}
												?>
                                                    <tr>
                                                        <td colspan="3">
                                                            <a href="{{url('plans')}}" class="btn btn-outline-light float-right">View more</a>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <!-- ============================================================== -->
                                <!-- end subscription plans  -->
                                <!-- ============================================================== -->
								
								<!-- ============================================================== -->
                                <!-- apartment tips -->
                                <!-- ============================================================== -->
                                <div class="card">
                                    <h5 class="card-header">Apartment Tips</h5>
                                    <div class="card-body p-0">
                                        <div class="row">
                                            <div class="col-md-12">
											 <center>
											  <h4>{{count($tips)}} apartment tip(s) added.</h4>
											   <a href="{{url('apartment-tips')}}" class="btn btn-outline-light float-right">View more</a>
											 </center>
											</div> 
                                        </div>
                                    </div>
                                </div>
                                <!-- ============================================================== -->
                                <!-- end apartment tips  -->
                                <!-- ============================================================== -->
							</div>
							</div>
							
							<div class="row">
                            <!-- ============================================================== -->
                            <!-- total revenue  -->
                            <!-- ============================================================== -->
  
                            
                            <!-- ============================================================== -->
                            <!-- ============================================================== -->
                            <!-- category revenue  -->
                            <!-- ============================================================== -->
                            <div class="col-xl-5 col-lg-5 col-md-12 col-sm-12 col-12">
                                <div class="card">
                                    <h5 class="card-header">Revenue Category</h5>
                                    <div class="card-body">
                                        <div id="revenue_by_room_category" style="height: 420px;"></div>
                                    </div>
                                </div>
                            </div>
                            <!-- ============================================================== -->
                            <!-- end category revenue  -->
                            <!-- ============================================================== -->

                            <div class="col-xl-7 col-lg-7 col-md-12 col-sm-12 col-12">
                                <div class="card">
                                    <h5 class="card-header"> Total Revenue</h5>
                                    <div class="card-body">
                                        <div id="total_revenue_month"></div>
                                    </div>
                                    <div class="card-footer">
                                        <!--<p class="display-7 font-weight-bold"><span class="text-primary d-inline-block">&#8358;26,000</span><span class="text-success float-right">+9.45%</span></p>-->
                                    </div>
                                </div>
                            </div>
                        </div>
							
							</div>
							
@stop

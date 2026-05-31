@extends('admin.index')



@section('content')

<?php 

$date=date_create($Post[0]->created_at);

?>

	<form action="donhang/edit/{{$Post[0]->id}}" method="post">
			
			<div class="boxwhite">

				<div class="row">

					<div class="col-md-8">

                    	<div class="form-group">

							<label><i class="fa fa-check-circle-o" aria-hidden="true"></i>Mả đơn hàng </label>

							<div class="form-control" >{{$Post[0]->CodeOrder}}</div>

						</div>

                    	<div class="form-group">

							<label><i class="fa fa-check-circle-o" aria-hidden="true"></i>Tên</label>

							<input type="text" required="required" 	class="form-control"  value="{{$Post[0]->users->name}}" name="name"  />

						</div>

                    	<div class="form-group">

							<label><i class="fa fa-check-circle-o" aria-hidden="true"></i> Email</label>

							<div class="form-control" >{{$Post[0]->users->email}}</div>

							

						</div> 

						<div class="form-group">

							<label><i class="fa fa-check-circle-o" aria-hidden="true"></i> Số điện thoại</label>

							<input type="text" class="form-control" value="{{$Post[0]->users->Phone}}"  name="Phone"  />

						</div> 

						<div class="form-group">

							<label><i class="fa fa-check-circle-o" aria-hidden="true"></i>Địa chỉ</label>

							<input type="text" class="form-control" value="{{$Post[0]->users->Address}}"  name="Address"  />

						</div> 

						<div class="form-group">

							<label><i class="fa fa-check-circle-o" aria-hidden="true"></i> Ngày đặt hàng</label>

							<div class="form-control" >{{date_format($date,"d/m/Y H:i:s")}}</div>

							

						</div> 

						<div class="form-group">

							<label><i class="fa fa-check-circle-o" aria-hidden="true"></i>Trạng thái</label>

							<select name="status" class="form-control" >

								<option value="0" <?php echo ($Post[0]->status=="0") ? "selected" : "" ?>>Mới</option>

								

								<option value="1" <?php echo ($Post[0]->status=="1") ? "selected" : "" ?>>Đang được vận chuyển</option>

								<option value="2" <?php echo ($Post[0]->status=="2") ? "selected" : "" ?>>Hoàn thành</option>

								<option value="3" <?php echo ($Post[0]->status=="3") ? "selected" : "" ?>>Hủy</option>								

							</select>

						</div> 

                         

                            

                       

					</div>

					<div class="col-md-4">

                    	

                        

                    

                                       

					</div>

				</div>

				<div >

					<label><i class="fa fa-check-circle-o" aria-hidden="true"></i> Danh sách sản phẩm</label>	

					<table border="1" width="100%">

						<tr class="font-weight-bold">

							<td align="center" class="py-2">Hình</td>

							<td align="center">Tên sản phẩm</td>

							<td align="center">Số lượng</td>

							<td align="center">Giá tiền</td>

							

							<td align="center">Thành tiền</td>

						</tr>

						<?php  $dem = 0; 

							$giamgiaall = 0;

							$giamgiasingle = 0;
$subtotal = 0;
						?>

					@foreach ($Post[0]->order_coupons_product as $coupons_product)

					<?php $count_price_same_product = 0; ?>

					@foreach ($Post[0]->order_product->where("order_coupons_products_id",$coupons_product->id) as $v)

					 <?php 

					 $count_product = $Post[0]->order_product->where("order_coupons_products_id",$coupons_product->id)->count();

						$dem++; $image = explode(",", $v->Image); 

					 	$count_same_product = $Post[0]->order_product->where("order_coupons_products_id",$v->order_coupons_products_id)->count();



					 ?>

						<tr>

							<td width="15%" align="center"><img src="https://sensenest.vn/{{$image[0]}}" width="150" ></td>

							<td width="20%" class="px-2">

								<strong>{{$v->Product_title}}</strong>

								@if ($v->Color!="rong")

									<div>Loại: {{$v->Color}}</div>

								@endif								

								

								

							</td>

							<td width="5%" align="center">{{$v->Soluong}}</td>

							<td width="15%" align="center">

								<?php if($v->Sale>0) { ?>

								<small style="text-decoration: line-through;

    								color: #c9c9c9;"><?=number_format($v->Price, 0, '', ',').",000 đ"?></small> <br>

    							

								<?=number_format($v->Sale, 0, '', ',').",000 đ"?>

								<?php } else { 
									echo number_format($v->curent_price, 0, '', ',').",000 đ";
								

								 } ?>

							</td>

							

							<?php 

								if($dem==$count_same_product){$dem=0;}

							  ?>

							<td width="15%" class="px-2" ><?=number_format($v->sub_total, 0, '', ',').",000 đ"?></td>		

						</tr>
						<?php $subtotal  = $subtotal + $v->sub_total; ?>
						@endforeach	

						

					@endforeach

					

				

						

						

						<tr class="">

							<td colspan="3"></td>

							<td align="center">Tổng tiền</td>

							<td class="px-2 py-2"><strong class="tongtien"><?=number_format($subtotal, 0, '', ',').",000 đ"?></strong></td>

						</tr>

					</table>

				</div>



			</div>

			



           

    <div class="form-action">

				<button type="submit" name="btn_save"><i class="fa fa-floppy-o" aria-hidden="true"></i> Lưu</button>

				<a href="donhang/list"><i class="fa fa-times" aria-hidden="true"></i> Hủy</a>

			</div>

			@csrf

			

		</form>



@endsection

@section('js')

	<script type="text/javascript">

			

	</script>

@endsection
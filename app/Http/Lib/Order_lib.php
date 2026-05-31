<?php 
namespace App\Http\Lib;
use App\Models\Order;
use App\Models\order_product;
use App\Models\User;
use App\Models\Size;
use App\Models\Color;
use App\Models\Posts;
use App\Models\Coupon;
use App\Models\order_coupons;
use App\Models\Order_Coupons_Product;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Gloudemans\Shoppingcart\Facades\Cart;
use Carbon\Carbon;
class Order_lib
{
	public function insert($request,$cart)
	{
		try{
			//
				
			
			$password = Str::random(5);
			if(User::where("email",$request["tt_mail"])->doesntExist())
			{
				$user = User::Create([
					"name" => 	$request["tt_name"],
					"email" => $request["tt_mail"],
					"password" => bcrypt($password),					
					"Address" =>$request["tt_diachi"],
					"Phone" =>$request["tt_phone"],	
					"Level" => 0				
				]);	
				$users_id = $user->id;
			}
			else
			{

				$user = User::where("email",$request["tt_mail"])->get()->first();
				$user->Address = $request["tt_diachi"];
				$user->Phone= $request["tt_phone"];
				$user->save();
				$users_id = $user->id;
			}
			//return $users_id;
			$CodeOrder = Order::orderBy('id', 'DESC')->pluck("CodeOrder")->first();

		        if($CodeOrder == null or $CodeOrder == ""){		       
		        	$CodeOrder = "0000000001";
		        }
		        else{
		       		 $CodeOrder = (int)str_replace("DH-","",$CodeOrder) + 1;
		      }		     
		        $demchuoi = strlen($CodeOrder);
		      
		        $chuoi="";
		        for($i=$demchuoi; $i<10; $i++)
		        {
		            $chuoi.= 0;
		        }	

		     $item_cart = $cart;
		     $count_price = 0;
	        foreach ($item_cart[0]->sanpham as $key => $product) {
	          foreach ($product->option as $key => $options) {
	              $count_price = $count_price + $options->sub_total;
	          }
	        
	        } 
	        $code_order_number = "DH-".$chuoi.$CodeOrder; 
	        $Total = $count_price;
	        if(isset($item_cart[0]->discount))
	        {
	        	$Total = $count_price - $item_cart[0]->discount;
	        }
	        // if($Total<75)
	        // {
	        // 	$Total = $Total + 25;
	        // }
			$Order = Order::Create([
				"CodeOrder" => "DH-".$chuoi.$CodeOrder,
				"Total" =>  round($Total,2),
				"users_id"=>$users_id,
				"Note" => $request["tt_noidung"]
			]);
			$Order_id =  $Order->id;
 

			foreach ($cart[0]->sanpham as $key => $product) {

				$coupons_id = $Code = $Name = $PriceNumber = $PricePercent = $Typediscount = $MaxPricediscount = $NumberOfUse = $MinPriceuse = $Status = $StartDay = $EndDay = NULL;

				if(isset($product->coupon_active))
				{
					$coupons_id = $product->coupon_active[0]->id;
					$Code = $product->coupon_active[0]->Code;
					$Name = $product->coupon_active[0]->Name;
					$PriceNumber = $product->coupon_active[0]->PriceNumber;
					$PricePercent = $product->coupon_active[0]->PricePercent;
					$Typediscount = $product->coupon_active[0]->Typediscount;
					$MaxPricediscount = $product->coupon_active[0]->MaxPricediscount;
					$NumberOfUse = $product->coupon_active[0]->NumberOfUse;
					$MinPriceuse = $product->coupon_active[0]->MinPriceuse;
					$Status = $product->coupon_active[0]->Status;
					$StartDay = $product->coupon_active[0]->StartDay;
					$EndDay = $product->coupon_active[0]->EndDay;	
					$NumberOfUse2 = Coupon::find($coupons_id);
					Coupon::where('id',$coupons_id)->update(array("NumberOfUse"=> $NumberOfUse2->NumberOfUse - 1));
								
				}
				 //dd($product->id."-".$coupons_id."-".$Code."-".$Name."-".$PriceNumber."-".$PricePercent."-".$Typediscount."-".$MaxPricediscount."-".$NumberOfUse."-".$MinPriceuse."-".$Status."-".$StartDay."-".$EndDay."-".$Order_id);
				 $discount = 0; 
				if(isset($product->discount))
				{
					$discount = $product->discount;
				}
				$Order_Coupons_Product = Order_Coupons_Product::Create([
					'product_id'=>$product->id,
					'coupons_id'=>$coupons_id,
					'discount'=>$discount,
					'Code'=>$Code,
					'Name'=>$Name,
					'PriceNumber'=>$PriceNumber,
					'PricePercent'=>$PricePercent,
					'Typediscount'=>$Typediscount,
					'MaxPricediscount'=> $MaxPricediscount,
					'NumberOfUse'=> $NumberOfUse,
					'MinPriceuse'=> $MinPriceuse,
					'Status'=> $Status,
					'StartDay'=> $StartDay,
					'EndDay'=> $EndDay,
					'orders_id'=> $Order_id
				]);
$Order_Coupons_Product_id = $Order_Coupons_Product->id;	
				

				foreach ($product->option as $key => $options) {

					$color = Color::find($options->color);
					$size = Size::find($options->size);
					$product = Posts::find($product->id);    	
				//dd($color);
				
		    	$a = $product->Color()->where("colors_id",$color->id)->where("sizes_id", $size->id)->get()->first();    	
				$soluong = $a->pivot->soluong - $options->soluong;	
				$product->Color()->where("colors_id",$color->id)->where("sizes_id",$size->id)->update(array("soluong" => $soluong));
				/*dd($options->name."-".(int)$options->soluong."-".(int)$options->price."-".(int)$options->sale."-".$options->image."-".$color->Name."-".$size->Name."-".(int)$options->curent_price."-".(int)$options->sub_total."-".$Order_Coupons_Product_id);*/
				$orderpoduct = order_product::Create([
					"Product_title" => $options->name,
					"Soluong" => (int)$options->soluong,
					"Price" => (float)$options->price,
					"Sale" => (int)$options->sale,
					"Image" => $options->image,
					"Color" => $color->Name,
					"Size" => $size->Name,
					"curent_price" => (float)$options->curent_price, 
					"sub_total" => (float)$options->sub_total,
					"order_coupons_products_id" => $Order_Coupons_Product_id
				]);
				//dd($orderpoduct);
				}
				
			}	
			if(isset($cart[0]->coupon_active))
			{
				order_coupons::Create([					
					'coupons_id'=>$cart[0]->coupon_active->id,
					'discount'=>$cart[0]->discount,
					'Code'=>$cart[0]->coupon_active->Code,
					'Name'=>$cart[0]->coupon_active->Name,					
					'PriceNumber'=>$cart[0]->coupon_active->PriceNumber,
					'PricePercent'=>$cart[0]->coupon_active->PricePercent,
					'Typediscount'=>$cart[0]->coupon_active->Typediscount,
					'MaxPricediscount'=>$cart[0]->coupon_active->MaxPricediscount,
					'NumberOfUse'=>$cart[0]->coupon_active->NumberOfUse,
		            'Status'=>$cart[0]->coupon_active->Status,
		    		'StartDay'=>$cart[0]->coupon_active->StartDay,
		    		'EndDay'=>$cart[0]->coupon_active->EndDay,
					'total_price'=>$cart[0]->coupon_active->total_curen_price,		
					'orders_id'=>$Order_id
				]);
				$NumberOfUse = Coupon::find($cart[0]->coupon_active->id);
				Coupon::where('id',$cart[0]->coupon_active->id)->update(array("NumberOfUse"=> $NumberOfUse->NumberOfUse - 1));
			}	
			self::html_order_confirmation($request,$cart,$code_order_number);	
		}
		catch(\Exception $err)
		{
			return false;
			/*return array(
				'success'=>false,
				'error'=>$err->getMessage()
			);*/
			
		}
		return true;
	}
	public function update($id,$request)
	{
		try{
		$id->users->name = $request->input("name");
		$id->users->Address = $request->input("Address");
		$id->users->Phone = $request->input("Phone");
		$id->status = $request->input("status");		
		$id->save();
		$id->users->save();
		Session::flash('success', "Sửa thành công");
		}
		catch(\Exception $err)
		{
			Session::flash('error', $err->getMessage());
			return false;
		}
		return true;
	}
	public function html_order_confirmation($request,$cart,$code_order_number)
	{
		//dd($request);
		$mytime = Carbon::now();
		$message = '';
		$message.= '
			<html>
			<head>
			  <style>#outlook a {padding:0;}
            body{width:100% !important; -webkit-text-size-adjust:100%; -ms-text-size-adjust:100%; margin:0; padding:0; font-family: Helvetica, arial, sans-serif;}
            .ExternalClass {width:100%;}
            .ExternalClass, .ExternalClass p, .ExternalClass span, .ExternalClass font, .ExternalClass td, .ExternalClass div {line-height: 100%;}
            .backgroundTable {margin:0; padding:0; width:100% !important; line-height: 100% !important;}
            .main-temp table { border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt; font-family: Helvetica, arial, sans-serif;}
            .main-temp table td {border-collapse: collapse;}</style>
			</head>
			<body>
			 <table width="100%" cellpadding="0" cellspacing="0" border="0" class="backgroundTable main-temp" style="background-color: #d5d5d5;">
            <tbody>
                <tr>
                    <td>
                        <table width="600" align="center" cellpadding="15" cellspacing="0" border="0" class="devicewidth" style="background-color: #ffffff;">
                            <tbody>
                                <!-- Start header Section -->
                                <tr>
                                    <td style="padding-top: 30px;">
                                        <table width="560" align="center" cellpadding="0" cellspacing="0" border="0" class="devicewidthinner" style="border-bottom: 1px solid #eeeeee; text-align: center;">
                                            <tbody>
                                                <tr>
                                                    <td style="padding-bottom: 10px;">
                                                        <a href="'.env('APP_URL').'"><img src="'.env('APP_URL').df1.'" alt="PapaChina" style="max-width:200px" /></a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="font-size: 14px; line-height: 18px; color: #666666;">
                                                       '.df23.'
                                                    </td>
                                                </tr>
                                               
                                                <tr>
                                                    <td style="font-size: 14px; line-height: 18px; color: #666666;">
                                                        Số điện thoại: '.df2.' | Email: '.df8.'
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="font-size: 14px; line-height: 18px; color: #666666; padding-bottom: 25px;">
                                                        <strong>Mà đơn hàng:</strong> '.$code_order_number.' | <strong>Ngày đặt hàng:</strong> '.$mytime->format("d/m/Y h:i:s A").'
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                               
                                <tr>
                                    <td style="padding-top: 0;">
                                        <table width="560" align="center" cellpadding="0" cellspacing="0" border="0" class="devicewidthinner" style="border-bottom: 1px solid #bbbbbb;">
                                            <tbody>
                                                <tr>
                                                    
                                                    <td style=" font-size: 16px; font-weight: bold; color: #666666; padding-bottom: 5px;">
                                                        Địa chỉ nhận hàng
                                                    </td>
                                                </tr>
                                                <tr>
                                                    
                                                    <td style=" font-size: 14px; line-height: 18px; color: #666666;">
                                                       '.$request["tt_name"].'
                                                    </td>
                                                </tr>
                                                <tr>
                                                   
                                                    <td style=" font-size: 14px; line-height: 18px; color: #666666;">
                                                       '.$request["tt_diachi"].'
                                                    </td>
                                                </tr>
                                                <tr>                                                  
                                                    <td style=" font-size: 14px; line-height: 18px; color: #666666; padding-bottom: 10px;">
                                                       '.$request["tt_phone"].'
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>';
                               $subtotal = 0; 
         //                    foreach ($cart[0]->sanpham as $key => $v) {
         //                    	foreach ($v->option as $key => $p) {
         //                    		$color = Color::find($p->color);
									// $size = Size::find($p->size);
									// $product = Posts::find($v->id); 
         //                    $image = explode(",", $p->image) ;
              $product = Order::where('CodeOrder',$code_order_number)->with('order_product')->get();
              	foreach ($product[0]->order_product as $p) {
              		$image = explode(",", $p->Image) ;
                            $message.= '<tr>
                                    <td style="padding-top: 0;">
                                        <table width="560" align="center" cellpadding="0" cellspacing="0" border="0" class="devicewidthinner" style="border-bottom: 1px solid #eeeeee;">
                                            <tbody>
                                                <tr>
                                                    <td width="100" align="center" style="padding-right: 10px; padding-bottom: 10px;">
                                                        <img style="height: 80px;" src="'.env('APP_URL').$image[0].'" alt="Product Image" />
                                                    </td>
                                                    <td  >
                                                       <div style="font-size: 14px; font-weight: bold; color: #666666; padding-bottom: 5px;">'.$p->Product_title.'</div>
                                                       <div style="    margin-bottom: 5px;"> Số lượng: '.$p->Soluong.' </div>
                                                       <div style="    margin-bottom: 5px;"> Loại: '.$p->Color.' </div>
                                                    </td>';
                                                    $message.= '<td align="right">';
                                                    $price = 0;
                                                    if($p->Sale > 0)
                                                    {
                                                    	
                                                    $message.= '
                                                    	<div style=" margin-bottom: 5px;" >
                                                       <span style="text-decoration: line-through;">'.number_format($p->Price, 0, '', ',').',000 đ </span> <br> '.number_format($p->Sale, 0, '', ',').',000 đ 
                                                       </div>
                                                    ';
                                                    $price = $p->Sale;
                                                	}
                                                	else
                                                	{
                                                		
                                                    $message.= '<div style=" margin-bottom: 5px;" >
                                                        '.number_format($p->Price, 0, '', ',').',000 đ 
                                                    	</div>';
                                                    	$price = $p->Price;
                                                	}
                                                    $message.='
                                                     <b style="color: #666666;">Thành tiền '.number_format($price*$p->Soluong, 0, '', ',').',000 đ </b> 


                                                    </td>
                                                </tr>';
                                               
                                                    
                                               $message.='
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>';
                                $subtotal = $subtotal + ($price*$p->Soluong);
                 //     }
                 // }
                            }
                               	# code...
                    		$discount = 0;
                          
                               
                            $message.= '    <tr>
                                    <td style="padding-top: 0;">
                                        <table width="560" align="center" cellpadding="0" cellspacing="0" border="0" class="devicewidthinner" style="border-bottom: 1px solid #bbbbbb; margin-top: -5px;">
                                            <tbody>
                                               ';
                          
                                                                   
                                                    $message.= ' 
                                               
                                                <tr>
                                               
                                                    <td style="font-size: 14px; font-weight: bold; line-height: 18px; color: #666666; padding-top: 10px;">
                                                        Tổng tiền 
                                                    </td>
                                                    <td style="font-size: 14px; font-weight: bold; line-height: 18px; color: #666666; padding-top: 10px; text-align: right;">
                                                        '.number_format($subtotal, 0, '', ',').',000 đ
                                                    </td>
                                                </tr>
                                                
                                                
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>';
                               
                                
                                
                              
                    $message.= '         </tbody>
                        </table>
                    </td>
                </tr>
            </tbody>
        </table>
			</body>
			</html>
		';
		$array = array(
			"email"=> $request["tt_mail"],
			"subject" => "Xác nhận đơn hàng SENSE NEST",
			"body"=>$message
		);
		//dd($array);
		app('App\Http\Controllers\MailerController')->SendEmailall($array);
		//return true;
	}
}
?>
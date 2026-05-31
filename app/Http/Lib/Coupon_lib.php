<?php 
namespace App\Http\Lib;
use App\Models\Coupon;
use Illuminate\Support\Facades\Session;
class Coupon_lib
{
	public function insert($request)
	{		
		try{
			$check_usepopup = (integer) $request->input('UsePopup');
			 if($check_usepopup==1)
			 {
			 	Coupon::query()->update(["UsePopup"=>0]);			 	
			 }
			 $coupon = Coupon::Create([
			'Code'=> (string) $request->input('ma'),
			'Name'=>(string) $request->input('name'),			
	  		'PriceNumber'=> (integer) str_replace(",","",$request->input('menhgia')),
	  		'PricePercent'=>(integer) $request->input('menhgiaphantram'),
	  		'Typediscount'=>(integer) $request->input('loaigiamgia'),
	  		'MaxPricediscount'=>(integer) str_replace(",","",$request->input('sotientoidaduocgiam')),
	  		'NumberOfUse'=> (integer) $request->input('solansudung'),
	  		
	  		'Status'=> (integer) $request->input('AnHien'),
	  		'UsePopup'=> (integer) $request->input('UsePopup'),
	  		'StartDay'=> $request->input('ngaytao'),
	  		'EndDay'=> $request->input('ngayhethang')
	  		
			]);	
			//dd($coupon->toarray());

			Session::flash('success', "Thêm thành công");
		}
		catch(\Exception $err)
		{
			Session::flash('error', $err->getMessage());
			return false;
		}
		return true;
	}
	public function update($request,$id)
	{		
		try{
			
			
			$id->Code= (string) $request->input('ma');
			$id->Name=(string) $request->input('name');			
	  		$id->PriceNumber= (integer) str_replace(",","",$request->input('menhgia'));
	  		$id->PricePercent=(integer) $request->input('menhgiaphantram');
	  		$id->Typediscount=(integer) $request->input('loaigiamgia');
	  		$id->MaxPricediscount=(integer) str_replace(",","",$request->input('sotientoidaduocgiam'));
	  		$id->NumberOfUse= (integer) $request->input('solansudung');
	  		
	  		$id->Status= (integer) $request->input('AnHien');
	  		$id->UsePopup= (integer) $request->input('UsePopup');
	  		$id->StartDay= $request->input('ngaytao');
	  		$id->EndDay= $request->input('ngayhethang');
	  		$id->save();			
			Session::flash('success', "Sữa thành công");
		}
		catch(\Exception $err)
		{
			Session::flash('error', $err->getMessage());
			return false;
		}
		return true;
	}
}
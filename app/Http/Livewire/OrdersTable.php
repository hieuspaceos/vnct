<?php

namespace App\Http\Livewire;

use App\Models\Order;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\DateColumn;
use Illuminate\Support\Facades\Auth;
class OrdersTable extends LivewireDatatable
{
    //public $model = Order::where('users_id',Auth::id());
    //public $hideable = 'select';
   // public $exportable = true;
   
    public function builder()
	{
	    return Order::where('users_id',Auth::id());
	}
    public function columns()
    {
        return [
        	Column::name("CodeOrder")->searchable(),
        	Column::callback('Total', function ($value) {
                return $value."$";
            })
                ->label('Total')->searchable(),                                     
        	DateColumn::name("created_at"),
        	Column::callback('status', function ($value) {
        		if($value==0)$value = "Not approved";
        	
        		else if($value==1) $value = "Being transported";
        		else if($value==2) $value = "Completed";
        		else if($value==3) $value = "Order canceled";
                return $value;
            }) ->label('Status')->searchable(), 
        	Column::name('id')->link('/user/donhang/{{id}}','Xem chi tiết')->label('Detail')
        ];
    }
}
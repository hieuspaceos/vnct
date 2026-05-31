<?php
namespace App\Http\Controllers\admin;
use App\Http\Controllers\Controller;

use App\Models\Portfolio;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\App;
use App\Models\language;
class PortfolioController extends Controller
{
    public function index()
    {
        $portfolios = Portfolio::with('member')->latest()->paginate(10);
        $title = "Danh sách portfolio";
        return view('admin.page.portfolio.index', compact('portfolios','title'));
    }

    public function create()
    {
        $members = Member::all();
        $title = "Thêm portfolio";
        return view('admin.page.portfolio.create', compact('members','title'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'member_id' => 'required|exists:members,id',
            'name' => 'required|string|max:255',
            'avatar' => 'nullable|string|max:500',
            'email' => 'nullable|email',
        ]);

        $data = $request->all();

        Portfolio::create($data);

        return redirect()->route('portfolio.index')
            ->with('success', 'Thêm portfolio thành công!');
    }

    public function edit(Portfolio $portfolio)
    {
        if($portfolio->lang != App::getLocale())
        {
            $lang = language::find($portfolio->lang);
            $redirectUrl = url("admin/portfolio/{$portfolio->id}/edit");

            return redirect()->route("admin.changelanguages", [
                "lang" => $lang->Name,
                "redirect" => $redirectUrl
            ]);
            //return redirect()->route("admin.changelanguages",["lang"=>$lang->Name]);
        }
        $members = Member::all();
        $title = "sửa portfolio";
        return view('admin.page.portfolio.edit', compact('portfolio', 'members','title'));
    }
    public function copyLang($lang, Portfolio $portfolio)
    {
        //dd($member);
        $title = "Thêm bản dịch";
        $members = Member::withoutGlobalScopes()->where("lang",$lang)->get();
        return view('admin.page.portfolio.copylang',compact('members','portfolio','title','lang'));   
    }
    public function update(Request $request, Portfolio $portfolio)
    {
        $request->validate([
            'member_id' => 'required|exists:members,id',
            'name' => 'required|string|max:255',
            'avatar' => 'nullable|string|max:500',
            'email' => 'nullable|email',
        ]);

        $data = $request->all();

        

        $portfolio->update($data);

        return redirect()->route('portfolio.index')
            ->with('success', 'Cập nhật portfolio thành công!');
    }

   
    public function destroy(Portfolio $portfolio)
    {
        // Xóa bản gốc và tất cả bản dịch
        $originId = $portfolio->origin_id ?? $portfolio->id;
        Portfolio::withoutGlobalScopes()
            ->where(function($query) use ($originId) {
                $query->where('id', $originId)->orWhere('origin_id', $originId);
            })
            ->delete(); 
        
        return redirect()->route('portfolio.index')
            ->with('success', 'Xóa portfolio và tất cả bản dịch thành công!');
    }
}

?>
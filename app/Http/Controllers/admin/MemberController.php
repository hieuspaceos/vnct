<?php
namespace App\Http\Controllers\admin;
use App\Http\Controllers\Controller;
use App\Models\Member;
use Illuminate\Http\Request;
use App\Models\language;
use Illuminate\Support\Facades\App;
class MemberController extends Controller
{
    public function index()
    {
       
        $members = Member::withCount('portfolios')->latest()->paginate(10);
        $title = "Danh sách members";
        return view('admin.page.members.index', compact('members','title'));
    }

    public function create()
    {
        $title = "Thêm members";
        return view('admin.page.members.create',compact('title'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Member::create($request->all());

        return redirect()->route('members.index')
            ->with('success', 'Thêm member thành công!');
    }

    public function edit(Member $member)
    {
         //dd("ok");
        if($member->lang != App::getLocale())
        {
            $lang = language::find($member->lang);
            $redirectUrl = url("admin/members/{$member->id}/edit");

            return redirect()->route("admin.changelanguages", [
                "lang" => $lang->Name,
                "redirect" => $redirectUrl
            ]);
            //return redirect()->route("admin.changelanguages",["lang"=>$lang->Name]);
        }
        $title = "sửa members";
        return view('admin.page.members.edit', compact('member','title'));
    }
    public function copyLang($lang, Member $member)
    {
        //dd($member);
        $title = "Thêm bản dịch";
        return view('admin.page.members.copylang',compact('member','title','lang'));   
    }
    public function update(Request $request, Member $member)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $member->update($request->all());

        return redirect()->route('members.index')
            ->with('success', 'Cập nhật member thành công!');
    }

    public function destroy(Member $member)
    {
        // Xóa bản gốc và tất cả bản dịch
        $originId = $member->origin_id ?? $member->id;
        $members = Member::withoutGlobalScopes()
            ->where(function($query) use ($originId) {
                $query->where('id', $originId)->orWhere('origin_id', $originId);
            })
            ->delete(); 
        //dd($members);
        return redirect()->route('members.index')
            ->with('success', 'Xóa member và tất cả bản dịch thành công!');
    }
}
?>
<?php

namespace App\Http\Controllers;

use App\Models\Friend;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use function Symfony\Component\String\s;

class FriendController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth']);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     * @throws \Exception
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Auth::user()->friends;
            $dataTable = Datatables::of($data)
                ->addColumn('action', function ($row) {
                    $button = '<a class="btn btn-success" style="min-width:100px;" href="' . route("friends.edit", ["friend" => $row]) . '"> Düzenle </a>';
                    $button .= '<button type="submit" style="min-width:100px;margin-left:10px;" class="btn btn-danger" data-toggle="modal" data-target="#DeleteModal" onclick="deleteRecord(' . $row->id . ')">Sil</button>';
                    return $button;
                });

            return $dataTable->rawColumns(['action'])->make('true');
        }

        return view('friend.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function create()
    {
        return view('friend.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'telephone' => 'required|regex:/^0([0-9]{10})$/',
        ]);

        $friend = new Friend();
        $this->storeOrAddUser($request,$friend);


        return redirect(route('friends.index'))->with('message','Yeni Bir Arkadaş Rehberine Eklendi');
    }

    public function storeOrAddUser(Request $request,$friend){
        $friend->owner = Auth::user()->id;
        $friend->name = $request->name;
        $friend->telephone = $request->telephone;

        $friend->save();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function edit(Friend $friend)
    {
        return view('friend.edit', compact('friend'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Routing\Redirector
     */
    public function update(Request $request, Friend $friend)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'telephone' => 'required|regex:/^0([0-9]{10})$/',
        ]);

        $this->storeOrAddUser($request,$friend);

        return redirect(route('friends.index'))->with('message','Arkadaşının Bilgileri Güncellendi');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Friend $friend)
    {
        $friend->delete();
        return redirect()->back()->withErrors("Arkadaşı Silinmiş");
    }
}

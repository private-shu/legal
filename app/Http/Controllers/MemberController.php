<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use Illuminate\Support\Facades\Log;

use \App\Models\ContractType;
use \App\Models\ResidenceType;
use \App\Models\PaymentMethod;
use \App\Models\Contract;
use \App\Models\Member;
use \App\Models\Role;
use \App\Models\User;
use \App\Models\ApplicationStatus;
use DB;

class MemberController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * @param int $member_id
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function detail(Request $request, $member_id)
    {
        if (!Auth::check()) {
            return view('login');
        }

        $users = User::all();
        $roles = Role::all();
        $current_residence_types = ResidenceType::whereIn('category', [1, 2, 3, 4])->get();
        $member = Member::where('id', '=', $member_id)->first();

        return view('member', compact('users', 'roles', 'current_residence_types', 'member'));
    }

    /**
     * 
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function update(Request $request)
    {
        if (!Auth::check()) {
            return view('login');
        }

        $member = Member::find($request->memberId);
        if ($member) {
            try {
                $member->name = $request->name;
                $member->gender = $request->gender;
                $member->birth_date = $request->birthDate;
                $member->tel = $request->tel;
                $member->current_residence = $request->currentResidence;
                $member->company = $request->company;
                $member->related_personnel = $request->relatedPersonnel;
                $member->detailed_information = $request->detailedInformation;
                $member->updated_by = Auth::user()->id;
                $member->save();
            } catch(\Exception $e){
                Log::error($e);
                throw $e;
            }
        }

        return redirect()->route('member.detail', ['id' => $member->id])->with(['message' => '更新処理を完了しました']);
    }
}

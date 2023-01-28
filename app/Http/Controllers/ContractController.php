<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

use \App\Models\ContractType;
use \App\Models\ResidenceType;
use \App\Models\PaymentMethod;
use \App\Models\Contract;
use \App\Models\Member;
use \App\Models\Role;
use \App\Models\User;
use \App\Models\ApplicationStatus;
use DB;

class ContractController extends Controller
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
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function create()
    {
        if (!Auth::check()) {
            return view('login');
        }

        $contract_types = ContractType::all();
        $current_residence_types = ResidenceType::whereIn('category', [1, 2, 3, 4])->get();
        $application_residence_types = ResidenceType::whereIn('category', [1, 2])->get();
        $payment_methods = PaymentMethod::all();
        $users = User::all();
        $roles = Role::all();
        $application_statuses = ApplicationStatus::all();

        return view('contract', compact('contract_types', 'current_residence_types', 'application_residence_types', 'payment_methods', 'users', 'roles', 'application_statuses'));
    }

    /**
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function store(Request $request)
    {
        if (!Auth::check()) {
            return view('login');
        }

        $roles = Role::all();

        try {
            $member_id = Member::create([
                             'name' => $request->name,
                             'gender' => $request->gender,
                             'birth_date' => $request->birthDate,
                             'tel' => $request->tel,
                             'current_residence' => $request->currentResidence,
                             'company' => $request->company,
                             'related_personnel' => $request->relatedPersonnel,
                             'detailed_information' => $request->detailedInformation,
                             'created_by' => Auth::user()->id,
                             'updated_by' => Auth::user()->id])->id;

            if ($member_id) {
                for ($i = 0; $i < $request->contractCount; $i++) {
                    Contract::create([
                        'member_id' => $member_id,
                        'management_number' => $request->managementNumber[$i],
                        'contract_type_id' => $request->contactType[$i],
                        'residence_type_id' => $request->residenceType[$i],
                        'start_fee_payment_amount' => $request->startFeePaymentAmount[$i],
                        'start_fee_payment_method_id' => $request->startFeePaymentMethod[$i],
                        'start_fee_payment_date' => $request->startFeePaymentDate[$i],
                        'start_fee_total_amount' => $request->startFeeTotalAmount[$i],
                        'start_fee_payment_comment' => $request->startFeePaymentComment[$i],
                        'success_fee_payment_amount' => $request->successFeePaymentAmount[$i],
                        'success_fee_payment_method_id' => $request->successFeePaymentMethod[$i],
                        'success_fee_payment_date' => $request->successFeePaymentDate[$i],
                        'success_fee_total_amount' => $request->successFeeTotalAmount[$i],
                        'success_fee_payment_comment' => $request->successFeePaymentComment[$i],
                        'application_number' => $request->applicationNumber[$i],
                        'application_date' => $request->applicationDate[$i],
                        'application_document' => $request->applicationDocumente[$i],
                        'additional_document' => $request->additionalDocument[$i],
                        'application_status_id' => $request->applicationStatus[$i],
                        'receptionist' => $request->receptionist ? $request->receptionist : $request->loginUser,
                        'reception_date' => $request->receptionDate,
                        'created_by' => Auth::user()->id,
                        'updated_by' => Auth::user()->id]);
                };
            }
        } catch(\Exception $e){
            Log::error($e);
            throw $e;
        }

        return redirect()->route('contract.list')->with(['message' => '新規契約の作成を完了しました']);
    }

    /**
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function list()
    {
        if (!Auth::check()) {
            return view('login');
        }

        $contract_types = ContractType::all();
        $current_residence_types = ResidenceType::whereIn('category', [1, 2, 3, 4])->get();
        $application_residence_types = ResidenceType::whereIn('category', [1, 2])->get();
        $payment_methods = PaymentMethod::all();
        $application_statuses = ApplicationStatus::all();
        $users = User::all();
        $roles = Role::all();

        $login_user_role = Auth::user()->role_id;
        $login_user_id = Auth::user()->id;

        $contracts = DB::table('contracts')
                        ->select('contracts.*', 'current_residence_types.name as current_residence_type_name', 'contract_types.name as contract_name', 'application_residence_types.name as application_residence_name', 'application_statuses.name as application_status', 'members.id as member_id', 'members.name as member_name','members.tel as tel', 'members.current_residence as current_residence', 'receptionist.name as receptionist', 'updated_by_users.name as updated_by')
                        ->join('members', 'contracts.member_id', '=', 'members.id')
                        ->leftjoin('contract_types', 'contracts.contract_type_id', '=', 'contract_types.id')
                        ->leftjoin('residence_types as application_residence_types', 'contracts.residence_type_id', '=', 'application_residence_types.id')
                        ->leftJoin('residence_types as current_residence_types', 'current_residence_types.id', '=', 'members.current_residence')
                        ->leftJoin('application_statuses', 'contracts.application_status_id', '=', 'application_statuses.id')
                        ->leftjoin('users as receptionist', 'receptionist.id', '=', 'contracts.receptionist')
                        ->leftjoin('users as updated_by_users', 'updated_by_users.id', '=', 'contracts.updated_by')
                        ->when($login_user_role <> 1, function ($query) use ($login_user_id) {
                            return $query->where('contracts.receptionist',  '=', $login_user_id);
                        })
                        ->where("contracts.deleted_at")
                        ->orderBy("contracts.id", "desc")
                        ->paginate(30);

        $count = count($contracts);

        return view('contract', compact('contract_types', 'current_residence_types', 'application_residence_types', 'payment_methods', 'application_statuses', 'users', 'roles', 'contracts', 'count'));
    }

    /**
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function search(Request $request)
    {
        if (!Auth::check()) {
            return view('login');
        }

        $receptionist = $request->filled('searchReceptionist') ? $request->input('searchReceptionist') : null;
        $reception_date = $request->filled('searchReceptionDate') ? $request->input('searchReceptionDate') : null;
        $contract_type = $request->filled('searchContractType') ? $request->input('searchContractType') : null;
        $residence_type = $request->filled('searchApplicationResidenceType') ? $request->input('searchApplicationResidenceType') : null;
        $start_fee_payment_date = $request->filled('searchStartFeePaymentDate') ? $request->input('searchStartFeePaymentDate') : null;
        $success_fee_payment_date = $request->filled('searchSuccessFeePaymentDate') ? $request->input('searchSuccessFeePaymentDate') : null;
        $wildcard_content = $request->filled('searchWildcardContent') ? $request->input('searchWildcardContent') : null;
        $application_date = $request->filled('searchApplicationDate') ? $request->input('searchApplicationDate') : null;
        $application_status = $request->filled('searchApplicationStatus') ? $request->input('searchApplicationStatus') : null;

        // $member_name = $request->filled('searchMemberName') ? $request->input('searchMemberName') : null;
        // $member_tel = $request->filled('searchMemberTelephoneNumber') ? $request->input('searchMemberTelephoneNumber') : null;
        // $member_company = $request->filled('searchMemberCompany') ? $request->input('searchMemberCompany') : null;
        // $member_related_personnel = $request->filled('searchMemberelatedPersonnel') ? $request->input('searchMemberelatedPersonnel') : null;
        // $management_number = $request->filled('searchManagementNumber') ? $request->input('searchManagementNumber') : null;
        // $application_number = $request->filled('searchApplicatioNumber') ? $request->input('searchApplicatioNumber') : null;

        $contracts = DB::table('contracts')
                        ->select('contracts.*', 'current_residence_types.name as current_residence_type_name', 'contract_types.name as contract_name', 'application_residence_types.name as application_residence_name', 'application_statuses.name as application_status', 'members.id as member_id', 'members.name as member_name','members.tel as tel', 'members.current_residence as current_residence', 'receptionist.name as receptionist', 'updated_by_users.name as updated_by')
                        ->join('members', 'contracts.member_id', '=', 'members.id')
                        ->leftjoin('contract_types', 'contracts.contract_type_id', '=', 'contract_types.id')
                        ->leftjoin('residence_types as application_residence_types', 'contracts.residence_type_id', '=', 'application_residence_types.id')
                        ->leftJoin('residence_types as current_residence_types', 'current_residence_types.id', '=', 'members.current_residence')
                        ->leftJoin('application_statuses', 'contracts.application_status_id', '=', 'application_statuses.id')
                        ->leftjoin('users as receptionist', 'receptionist.id', '=', 'contracts.receptionist')
                        ->leftjoin('users as updated_by_users', 'updated_by_users.id', '=', 'contracts.updated_by')
                        ->when($receptionist, function ($query) use ($receptionist) {
                            return $query->where('receptionist', '=', $receptionist);
                        })
                        ->when($reception_date, function ($query) use ($reception_date) {
                            return $query->where('reception_date', '=', $reception_date);
                        })
                        ->when($contract_type, function ($query) use ($contract_type) {
                            return $query->where('contract_type_id',  '=', $contract_type);
                        })
                        ->when($residence_type, function ($query) use ($residence_type) {
                            return $query->where('residence_type_id',  '=', $residence_type);
                        })
                        ->when($start_fee_payment_date, function ($query) use ($start_fee_payment_date) {
                            return $query->where('start_fee_payment_date',  '=', $start_fee_payment_date);
                        })
                        ->when($success_fee_payment_date, function ($query) use ($success_fee_payment_date) {
                            return $query->where('success_fee_payment_date',  '=', $success_fee_payment_date);
                        })
                        ->when($wildcard_content, function ($query) use ($wildcard_content) {
                            return $query->where('members.name', 'LIKE', "%$wildcard_content%")
                                            ->orWhere('members.tel', 'LIKE', "%$wildcard_content%")
                                            ->orWhere('members.company', 'LIKE', "%$wildcard_content%")
                                            ->orWhere('members.related_personnel', 'LIKE', "%$wildcard_content%")
                                            ->orWhere('management_number', 'LIKE', "%$wildcard_content%")
                                            ->orWhere('application_number', 'LIKE', "%$wildcard_content%");
                        })
                        ->when($application_date, function ($query) use ($application_date) {
                            return $query->where('application_date', '=', $application_date);
                        })
                        ->when($application_status, function ($query) use ($application_status) {
                            return $query->where('application_status_id',  '=', $application_status);
                        })
                        // ->when($member_name, function ($query) use ($member_name) {
                        //     return $query->where('members.name', 'LIKE', "%$member_name%");
                        // })
                        // ->when($member_tel, function ($query) use ($member_tel) {
                        //     return $query->where('members.tel', 'LIKE', "%$member_tel%");
                        // })
                        // ->when($member_company, function ($query) use ($member_company) {
                        //     return $query->where('members.company', 'LIKE', "%$member_company%");
                        // })
                        // ->when($member_related_personnel, function ($query) use ($member_related_personnel) {
                        //     return $query->where('members.related_personnel',  'LIKE', "%$member_related_personnel%");
                        // })
                        // ->when($management_number, function ($query) use ($management_number) {
                        //     return $query->where('management_number',  'LIKE', "%$management_number%");
                        // })

                        // ->when($application_number, function ($query) use ($application_number) {
                        //     return $query->where('application_number',  'LIKE', "%$application_number%");
                        // })
                        ->where("contracts.deleted_at")
                        ->orderBy("contracts.id", "desc")
                        ->paginate(30);

        // 検索条件をroute urlに設定する
        $contracts->appends([
            'searchReceptionist' => $receptionist,
            'searchReceptionDate' => $reception_date,
            'searchContractType' => $contract_type,
            'searchApplicationResidenceType' => $residence_type,
            'searchSuccessFeePaymentDate' => $start_fee_payment_date,
            'searchSuccessFeePaymentDate' => $success_fee_payment_date,
            'searchWildcardContent' => $wildcard_content,
            'searchApplicationDate' => $application_date,
            'searchApplicationStatus' => $application_status,
            // 'searchMemberName' => $member_name,
            // 'searchMemberTelephoneNumber' => $member_tel,
            // 'searchMemberCompany' => $member_company,
            // 'searchMemberelatedPersonnel' => $member_related_personnel,
            // 'searchManagementNumber' => $management_number,
            // 'searchApplicatioNumber' => $application_number,
        ]);

        return response()->json([
            'status' => true,
            'html' => view('layouts.parts.contents.contract.search_result_list', compact('contracts'))->render(),
            'total' => $contracts->total(),
            '$receptionist' => $receptionist,
            'message' => 'Data get successfully.',
        ]);
    }

    /**
     * @param int $contract_id
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function detail(Request $request, $contract_id)
    {
        if (!Auth::check()) {
            return view('login');
        }

        $contract_types = ContractType::all();
        $application_residence_types = ResidenceType::where('category', '=', 1)->get();
        $payment_methods = PaymentMethod::all();
        $users = User::all();
        $roles = Role::all();
        $application_statuses = ApplicationStatus::all();

        $contract = Contract::where('id', '=', $contract_id)->first();

        return view('contract', compact('contract', 'contract_types', 'application_residence_types', 'payment_methods', 'users', 'roles', 'application_statuses'));
    }

    /**
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function update(Request $request)
    {
        if (!Auth::check()) {
            return view('login');
        }

        $contract = Contract::find($request->contractId);
        if ($contract) {
            try {
                $contract->management_number = $request->managementNumber;
                $contract->contract_type_id = $request->contactType;
                $contract->residence_type_id = $request->residenceType;
                $contract->start_fee_payment_amount = $request->startFeePaymentAmount;
                $contract->start_fee_payment_method_id = $request->startFeePaymentMethod;
                $contract->start_fee_payment_date = $request->startFeePaymentDate;
                $contract->start_fee_total_amount = $request->startFeeTotalAmount;
                $contract->start_fee_payment_comment = $request->startFeePaymentComment;
                $contract->success_fee_payment_amount = $request->successFeePaymentAmount;
                $contract->success_fee_payment_method_id = $request->successFeePaymentMethod;
                $contract->success_fee_payment_date = $request->successFeePaymentDate;
                $contract->success_fee_total_amount = $request->successFeeTotalAmount;
                $contract->success_fee_payment_comment = $request->successFeePaymentComment;
                $contract->application_number = $request->applicationNumber;
                $contract->application_date = $request->applicationDate;
                $contract->application_document = $request->applicationDocumente;
                $contract->additional_document = $request->additionalDocument;
                $contract->application_status_id = $request->applicationStatus;
                $contract->receptionist = $request->receptionist;
                $contract->reception_date = $request->receptionDate;
                $contract->updated_by = Auth::user()->id;
                $contract->save();
            } catch(\Exception $e){
                Log::error($e);
                throw $e;
            }
        }

        return redirect()->route('contract.detail', ['id' => $contract->id])->with(['message' => '更新処理を完了しました']);
    }

    /**
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function delete(Request $request)
    {
        if (!Auth::check()) {
            return view('login');
        }

        try {
            Contract::where('id', $request->contractId)->delete();
        } catch(\Exception $e){
            Log::error($e);
            throw $e;
        }

        return redirect()->route('contract.list')->with(['message' => '削除処理を完了しました']);
    }

    /**
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function summary(Request $request)
    {
        if (!Auth::check()) {
            return view('login');
        }

        $users = User::all();
        $roles = Role::all();
        $application_residence_types = ResidenceType::whereIn('category', [1, 2])->get();

        return view('contract', compact('users', 'roles', 'application_residence_types'));
    }

    /**
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getSummaryByYear(Request $request)
    {
        if (!Auth::check()) {
            return view('login');
        }

        $users = User::all();
        $roles = Role::all();
        $contract_types = ContractType::all();
        $application_residence_types = ResidenceType::whereIn('category', [1, 2])->get();

        $summary_year = $request->filled('summaryYear') ? $request->input('summaryYear') : null;
        $receptionist = $request->filled('receptionist') ? $request->input('receptionist') : null;
        $application_residence_type = $request->filled('applicationResidenceType') ? $request->input('applicationResidenceType') : null;

        $application_residence_type_name = $application_residence_type ? ResidenceType::select('name')->where('id', '=', $application_residence_type)->first()->name : "全て";
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 月別、契約種別単位のお客様数集計(当年度内の着手金支払日を基準とする)
        $member_summary_by_contract_type_by_month_db = DB::table('contracts')
                                                        ->select(DB::raw('DATE_FORMAT(contracts.start_fee_payment_date, "%Y-%m") AS date'),
                                                                'contract_types.name AS contractTypeName',
                                                                DB::raw('count(distinct members.id) AS memberTotal'))
                                                        ->join('members', 'members.id', '=', 'contracts.member_id')
                                                        ->join('contract_types', 'contracts.contract_type_id', '=', 'contract_types.id')
                                                        ->where(DB::raw('DATE_FORMAT(contracts.start_fee_payment_date, "%Y")'), '=', $summary_year)
                                                        ->when($receptionist, function ($query) use ($receptionist) {
                                                            return $query->where('contracts.receptionist',  '=', $receptionist);
                                                        })
                                                        ->when($application_residence_type, function ($query) use ($application_residence_type) {
                                                            return $query->where('contracts.residence_type_id',  '=', $application_residence_type);
                                                        })
                                                        ->where("contracts.deleted_at")
                                                        ->groupByRaw('date, contracts.contract_type_id')
                                                        ->get();
        // １２っ月分のデータを配列化
        $member_summary_by_contract_type_by_month = array();
        for ($i=1; $i<=12; $i++) {
            $date = date('Y-m', mktime(0, 0, 0, $i, 1, $summary_year));
            // 各月の各契約内容空配列作成
            $member_summary_by_contract_type_by_month[$date]["totalMemberPerMonth"] = 0;
            $member_summary_by_contract_type_by_month[$date]["memberPercentByYear"] = 0;
            foreach ($contract_types as $contract_type) {
                // 各契約内容の空配列作成
                $member_summary_by_contract_type_by_month[$date]["contract"][$contract_type->name]["memberTotal"] = 0;
            }
        }

        // DBからの集計結果がある場合のみ、配列内容を上書きする
        if (count($member_summary_by_contract_type_by_month_db)) {
            // 契約ことの詳細設定
            foreach ($member_summary_by_contract_type_by_month_db as $detail) {
                $member_summary_by_contract_type_by_month[$detail->date]["contract"][$detail->contractTypeName]["memberTotal"] = $detail->memberTotal;
            }
            // 契約ことのことの月別集計
            $totalMemberYear = 0;
            foreach ($member_summary_by_contract_type_by_month as $date => $member_summary_info_detail) {
                $totalMemberPerMonth = 0;
                foreach ($member_summary_info_detail["contract"] as $contract_type => $info) {
                    $totalMemberPerMonth += $info["memberTotal"];
                }
            
                $member_summary_by_contract_type_by_month[$date]["totalMemberPerMonth"] = $totalMemberPerMonth;
                $totalMemberYear += $totalMemberPerMonth;
            }
            // 月別パーセント集計
            foreach ($member_summary_by_contract_type_by_month as $date => &$member_summary_info) {
                $member_summary_info["memberPercentByYear"] = number_format($member_summary_info["totalMemberPerMonth"] / $totalMemberYear * 100, 2);
            }
        }

// ここまで=> $member_summary_by_contract_type_by_month
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 月別、契約種別単位の収入金額集計(当年度内の着手金支払日もしくは成功金支払日を条件とする、該当レコードの支払日は当年度であれば、加算する)
        // 1. 着手金集計
        $start_fee_payment_by_contract_type_by_month_db = DB::table('contracts')
                                                            ->select(DB::raw('DATE_FORMAT(contracts.start_fee_payment_date, "%Y-%m") AS date'),
                                                                    'contract_types.name AS contractTypeName',
                                                                    DB::raw('sum(contracts.start_fee_payment_amount) AS startFeePaymentTotal'))
                                                            ->join('contract_types', 'contracts.contract_type_id', '=', 'contract_types.id')
                                                            ->where(DB::raw('DATE_FORMAT(contracts.start_fee_payment_date, "%Y")'), '=', $summary_year)
                                                            ->when($receptionist, function ($query) use ($receptionist) {
                                                                return $query->where('contracts.receptionist',  '=', $receptionist);
                                                            })
                                                            ->when($application_residence_type, function ($query) use ($application_residence_type) {
                                                                return $query->where('contracts.residence_type_id',  '=', $application_residence_type);
                                                            })
                                                            ->where("contracts.deleted_at")
                                                            ->groupByRaw('date, contracts.contract_type_id')
                                                            ->get();

        // 2. 成功金集計
        $success_fee_payment_by_contract_type_by_month_db = DB::table('contracts')
                                                                ->select(DB::raw('DATE_FORMAT(contracts.success_fee_payment_date, "%Y-%m") AS date'),
                                                                        'contract_types.name AS contractTypeName',
                                                                        DB::raw('sum(contracts.success_fee_payment_amount) AS successFeePaymentTotal'))
                                                                ->join('contract_types', 'contracts.contract_type_id', '=', 'contract_types.id')
                                                                ->where(DB::raw('DATE_FORMAT(contracts.success_fee_payment_date, "%Y")'), '=', $summary_year)
                                                                ->when($receptionist, function ($query) use ($receptionist) {
                                                                    return $query->where('contracts.receptionist',  '=', $receptionist);
                                                                })
                                                                ->when($application_residence_type, function ($query) use ($application_residence_type) {
                                                                    return $query->where('contracts.residence_type_id',  '=', $application_residence_type);
                                                                })
                                                                ->where("contracts.deleted_at")
                                                                ->groupByRaw('date, contracts.contract_type_id')
                                                                ->get();

        // １２っ月分のデータを配列化
        $start_fee_payment_by_contract_type_by_month = array();
        $success_fee_payment_by_contract_type_by_month = array();
        $income_summary_by_contract_type_by_month = array();

        for ($i=1; $i<=12; $i++) {
            $date = date('Y-m', mktime(0, 0, 0, $i, 1, $summary_year));
            // 各月の各契約内容空配列作成
            $income_summary_by_contract_type_by_month[$date]["totalIncomePerMonth"] = 0;
            $income_summary_by_contract_type_by_month[$date]["incomePercentByYear"] = 0;
            foreach ($contract_types as $contract_type) {
                // 各契約内容の空配列作成
                $start_fee_payment_by_contract_type_by_month[$date]["contract"][$contract_type->name]["startFeePaymentTotal"] = 0;
                $success_fee_payment_by_contract_type_by_month[$date]["contract"][$contract_type->name]["successFeePaymentTotal"] = 0;
            }
        }

        if (count($start_fee_payment_by_contract_type_by_month_db)) {
            // 契約ことの詳細設定
            foreach ($start_fee_payment_by_contract_type_by_month_db as $detail) {
                $start_fee_payment_by_contract_type_by_month[$detail->date]["contract"][$detail->contractTypeName]["startFeePaymentTotal"] = $detail->startFeePaymentTotal;
            }
        }
        if (count($success_fee_payment_by_contract_type_by_month_db)) {
            // 契約ことの詳細設定
            foreach ($success_fee_payment_by_contract_type_by_month_db as $detail) {
                $success_fee_payment_by_contract_type_by_month[$detail->date]["contract"][$detail->contractTypeName]["successFeePaymentTotal"] = $detail->successFeePaymentTotal;
            }
        }
        // 着手金と成功金をマージする
        $income_summary_by_contract_type_by_month = array_merge_recursive($income_summary_by_contract_type_by_month, $start_fee_payment_by_contract_type_by_month, $success_fee_payment_by_contract_type_by_month);

        // DBからの集計結果がある場合のみ、配列内容を上書きする
        if (count($start_fee_payment_by_contract_type_by_month_db) || count($success_fee_payment_by_contract_type_by_month_db)) {
            // 契約ことのことの月別集計
            $totalIncomeYear = 0;
            foreach ($income_summary_by_contract_type_by_month as $date => $income_summary_info_detail) {
                $totalIncomePerMonth = 0;
                foreach ($income_summary_info_detail["contract"] as $contract_type => $info) {
                    $totalIncomePerMonth += $info["startFeePaymentTotal"] + $info["successFeePaymentTotal"];
                }
            
                $income_summary_by_contract_type_by_month[$date]["totalIncomePerMonth"] = $totalIncomePerMonth;
                $totalIncomeYear += $totalIncomePerMonth;
            }
            // 月別パーセント集計
            foreach ($income_summary_by_contract_type_by_month as $date => &$income_summary_info) {
                $income_summary_info["incomePercentByYear"] = number_format($income_summary_info["totalIncomePerMonth"] / $totalIncomeYear * 100, 2);
            }
        }

// ここまで=> $income_summary_by_contract_type_by_month
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 年間、契約種別単位の契約件数集計           
        $contract_summary_by_contract_type_by_year_db = DB::table('contracts')
                                                            ->select('contract_types.name AS contractTypeName',
                                                                    DB::raw('count(contracts.id) AS contractTotal'))
                                                            ->join('contract_types', 'contracts.contract_type_id', '=', 'contract_types.id')
                                                            ->where(DB::raw('DATE_FORMAT(contracts.start_fee_payment_date, "%Y")'), '=', $summary_year)
                                                            ->when($receptionist, function ($query) use ($receptionist) {
                                                                return $query->where('contracts.receptionist',  '=', $receptionist);
                                                            })
                                                            ->when($application_residence_type, function ($query) use ($application_residence_type) {
                                                                return $query->where('contracts.residence_type_id',  '=', $application_residence_type);
                                                            })
                                                            ->where("contracts.deleted_at")
                                                            ->groupByRaw('contracts.contract_type_id')
                                                            ->get();

        $contract_summary_by_contract_type_by_year = array();
        foreach ($contract_types as $contract_type) {
            // 各契約内容の空配列作成
            $contract_summary_by_contract_type_by_year["contract"][$contract_type->name]["contractTotal"] = 0;
            $contract_summary_by_contract_type_by_year["contract"][$contract_type->name]["contractPercentByYear"] = 0;
            $contract_summary_by_contract_type_by_year["contractTotal"] = 0;
        }
        // DBからの集計結果がある場合のみ、配列内容を上書きする
        if (count($contract_summary_by_contract_type_by_year_db)) {
            // 契約ことの詳細設定
            $totalContractYear = 0;
            foreach ($contract_summary_by_contract_type_by_year_db as $detail) {
                $contract_summary_by_contract_type_by_year["contract"][$detail->contractTypeName]["contractTotal"] = $detail->contractTotal;
                $totalContractYear += $detail->contractTotal;
            }

            $contract_summary_by_contract_type_by_year["contractTotal"] = $totalContractYear;
            // 月別パーセント集計
            foreach ($contract_summary_by_contract_type_by_year["contract"] as $contract_type_name => &$contract_summary_info) {
                $contract_summary_info["contractPercentByYear"] = number_format($contract_summary_info["contractTotal"] / $totalContractYear * 100, 2);
            }
        }

// ここまで=> $contract_summary_by_contract_type_by_year
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 年間、契約種別単位の収入集計
        // 1. 着手金集計
        $start_fee_payment_by_contract_type_by_year_db = DB::table('contracts')
                                                                ->select('contract_types.name AS contractTypeName',
                                                                        DB::raw('sum(contracts.start_fee_payment_amount) AS startFeePaymentTotal'))
                                                                ->join('contract_types', 'contracts.contract_type_id', '=', 'contract_types.id')
                                                                ->where(DB::raw('DATE_FORMAT(contracts.start_fee_payment_date, "%Y")'), '=', $summary_year)
                                                                ->when($receptionist, function ($query) use ($receptionist) {
                                                                    return $query->where('contracts.receptionist',  '=', $receptionist);
                                                                })
                                                                ->when($application_residence_type, function ($query) use ($application_residence_type) {
                                                                    return $query->where('contracts.residence_type_id',  '=', $application_residence_type);
                                                                })
                                                                ->where("contracts.deleted_at")
                                                                ->groupByRaw('contracts.contract_type_id')
                                                                ->get();
        // 2. 成功金集計
        $success_fee_payment_by_contract_type_by_year_db = DB::table('contracts')
                                                                ->select('contract_types.name AS contractTypeName',
                                                                        DB::raw('sum(contracts.success_fee_payment_amount) AS successFeePaymentTotal'))
                                                                ->join('contract_types', 'contracts.contract_type_id', '=', 'contract_types.id')
                                                                ->where(DB::raw('DATE_FORMAT(contracts.success_fee_payment_date, "%Y")'), '=', $summary_year)
                                                                ->when($receptionist, function ($query) use ($receptionist) {
                                                                    return $query->where('contracts.receptionist',  '=', $receptionist);
                                                                })
                                                                ->when($application_residence_type, function ($query) use ($application_residence_type) {
                                                                    return $query->where('contracts.residence_type_id',  '=', $application_residence_type);
                                                                })
                                                                ->where("contracts.deleted_at")
                                                                ->groupByRaw('contracts.contract_type_id')
                                                                ->get();

        $start_fee_payment_by_contract_type_by_year = array();
        $success_fee_payment_by_contract_type_by_year = array();
        $income_summary_by_contract_type_by_year = array();
        foreach ($contract_types as $contract_type) {
            // 各契約内容の空配列作成
            $start_fee_payment_by_contract_type_by_year["contract"][$contract_type->name]["startFeePaymentTotalByYear"] = 0;
            $success_fee_payment_by_contract_type_by_year["contract"][$contract_type->name]["successFeePaymentTotalByYear"] = 0;
            $income_summary_by_contract_type_by_year["contract"][$contract_type->name]["incomeTotalByYear"] = 0;
            $income_summary_by_contract_type_by_year["contract"][$contract_type->name]["incomePercentByYear"] = 0;
            $income_summary_by_contract_type_by_year["incomeTotal"] = 0;
        }

        // DBからの集計結果がある場合のみ、配列内容を上書きする
        $totalStartFeePaymentYear = 0;
        if (count($start_fee_payment_by_contract_type_by_year_db)) {
            // 契約ことの詳細設定
            foreach ($start_fee_payment_by_contract_type_by_year_db as $detail) {
                $start_fee_payment_by_contract_type_by_year["contract"][$detail->contractTypeName]["startFeePaymentTotalByYear"] = $detail->startFeePaymentTotal;
                $totalStartFeePaymentYear += $detail->startFeePaymentTotal;
            }
        }
        // DBからの集計結果がある場合のみ、配列内容を上書きする
        $totalSuccessFeePaymentYear = 0;
        if (count($success_fee_payment_by_contract_type_by_year_db)) {
            // 契約ことの詳細設定
            foreach ($success_fee_payment_by_contract_type_by_year_db as $detail) {
                $success_fee_payment_by_contract_type_by_year["contract"][$detail->contractTypeName]["successFeePaymentTotalByYear"] = $detail->successFeePaymentTotal;
                $totalSuccessFeePaymentYear += $detail->successFeePaymentTotal;
            }
        }
        // 着手金と成功金をマージする
        $income_summary_by_contract_type_by_year = array_merge_recursive($income_summary_by_contract_type_by_year, $start_fee_payment_by_contract_type_by_year, $success_fee_payment_by_contract_type_by_year);

        // 月別パーセント集計
        if (count($start_fee_payment_by_contract_type_by_year_db) || count($success_fee_payment_by_contract_type_by_year_db)) {
            $totalAmount = $totalStartFeePaymentYear + $totalSuccessFeePaymentYear;
            $income_summary_by_contract_type_by_year["incomeTotal"] = $totalAmount;
            foreach ($income_summary_by_contract_type_by_year["contract"] as $contract_type_name => $income_summary_info_by_year) {
                $income_summary_by_contract_type_by_year["contract"][$contract_type_name]["incomeTotalByYear"] = $income_summary_info_by_year["startFeePaymentTotalByYear"] + $income_summary_info_by_year["successFeePaymentTotalByYear"];
                $income_summary_by_contract_type_by_year["contract"][$contract_type_name]["incomePercentByYear"] = number_format(($income_summary_info_by_year["startFeePaymentTotalByYear"] + $income_summary_info_by_year["successFeePaymentTotalByYear"]) / $totalAmount  * 100, 2);
            }
        }
// ここまで=> $income_summary_by_contract_type_by_year
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 月別 受付担当案件一覧表(管理者権限)
        // 1. 件数集計
        $contract_count_summary_by_receptionist_by_month_db = DB::table('contracts')
                                                            ->select('users.name AS receptionistName',
                                                                    DB::raw('DATE_FORMAT(contracts.start_fee_payment_date, "%Y-%m") AS date'),
                                                                    DB::raw('count(contracts.id) AS contractTotal'))
                                                            ->join('users', 'contracts.receptionist', '=', 'users.id')
                                                            ->where(DB::raw('DATE_FORMAT(contracts.start_fee_payment_date, "%Y")'), '=', $summary_year)
                                                            ->where("contracts.deleted_at")
                                                            ->groupByRaw('contracts.receptionist, date')
                                                            ->get();
        // 2. 着手金集計
        $start_fee_payment_summary_by_receptionist_by_month_db = DB::table('contracts')
                                                            ->select('users.name AS receptionistName',
                                                                    DB::raw('DATE_FORMAT(contracts.start_fee_payment_date, "%Y-%m") AS date'),
                                                                    DB::raw('sum(contracts.start_fee_payment_amount) AS startFeePaymentTotal'))
                                                                    ->join('users', 'contracts.receptionist', '=', 'users.id')
                                                            ->where(DB::raw('DATE_FORMAT(contracts.start_fee_payment_date, "%Y")'), '=', $summary_year)
                                                            ->where("contracts.deleted_at")
                                                            ->groupByRaw('contracts.receptionist, date')
                                                            ->get();
        // 3. 成功金集計
        $success_fee_payment_summary_by_receptionist_by_month_db = DB::table('contracts')
                                                            ->select('users.name AS receptionistName',
                                                                    DB::raw('DATE_FORMAT(contracts.success_fee_payment_date, "%Y-%m") AS date'),
                                                                    DB::raw('sum(contracts.success_fee_payment_amount) AS successFeePaymentTotal'))
                                                                    ->join('users', 'contracts.receptionist', '=', 'users.id')
                                                            ->where(DB::raw('DATE_FORMAT(contracts.success_fee_payment_date, "%Y")'), '=', $summary_year)
                                                            ->where("contracts.deleted_at")
                                                            ->groupByRaw('contracts.receptionist, date')
                                                            ->get();

        $contract_summary_by_receptionist_by_month = array();
        // 削除済みの受付担当者も集計させる
        $users_del_included = DB::table('users')->get();
        foreach ($users_del_included as $user) {
            // 各ユーザーの配列作成
            $contract_summary_by_receptionist_by_month[$user->name]["contractTotalByYear"] = 0;
            $contract_summary_by_receptionist_by_month[$user->name]["startFeePaymentTotalByYear"] = 0;
            $contract_summary_by_receptionist_by_month[$user->name]["successFeePaymentTotalByYear"] = 0;
            for ($i=1; $i<=12; $i++) {
                $date = date('Y-m', mktime(0, 0, 0, $i, 1, $summary_year));
                $contract_summary_by_receptionist_by_month[$user->name]["date"][$date]["contractTotal"] = 0;
                $contract_summary_by_receptionist_by_month[$user->name]["date"][$date]["startFeePaymentTotal"] = 0;
                $contract_summary_by_receptionist_by_month[$user->name]["date"][$date]["successFeePaymentTotal"] = 0;
            }
        }

        // DBからの集計結果がある場合のみ、配列内容を上書きする
        if (count($contract_count_summary_by_receptionist_by_month_db)) {
            foreach ($contract_count_summary_by_receptionist_by_month_db as $detail) {
                $contract_summary_by_receptionist_by_month[$detail->receptionistName]["date"][$detail->date]["contractTotal"] = $detail->contractTotal;
            }
        }
        if (count($start_fee_payment_summary_by_receptionist_by_month_db)) {
            foreach ($start_fee_payment_summary_by_receptionist_by_month_db as $detail) {
                $contract_summary_by_receptionist_by_month[$detail->receptionistName]["date"][$detail->date]["startFeePaymentTotal"] = $detail->startFeePaymentTotal;
            }
        }
        if (count($success_fee_payment_summary_by_receptionist_by_month_db)) {
            foreach ($success_fee_payment_summary_by_receptionist_by_month_db as $detail) {
                $contract_summary_by_receptionist_by_month[$detail->receptionistName]["date"][$detail->date]["successFeePaymentTotal"] = $detail->successFeePaymentTotal;
            }
        }

        if (count($contract_count_summary_by_receptionist_by_month_db) || count($start_fee_payment_summary_by_receptionist_by_month_db) || count($success_fee_payment_summary_by_receptionist_by_month_db)) {
            foreach ($contract_summary_by_receptionist_by_month as $receptionist_name => $summary_info) {
                $quantity_total_by_year = 0;
                $start_fee_payment_total_by_year = 0;
                $success_fee_payment_total_by_year = 0;
                foreach ($summary_info["date"] as $date => $info) {
                    $quantity_total_by_year += $info["contractTotal"];
                    $start_fee_payment_total_by_year += $info["startFeePaymentTotal"];
                    $success_fee_payment_total_by_year += $info["successFeePaymentTotal"];
                }
                $contract_summary_by_receptionist_by_month[$receptionist_name]["contractTotalByYear"] = $quantity_total_by_year;
                $contract_summary_by_receptionist_by_month[$receptionist_name]["startFeePaymentTotalByYear"] = $start_fee_payment_total_by_year;
                $contract_summary_by_receptionist_by_month[$receptionist_name]["successFeePaymentTotalByYear"] = $success_fee_payment_total_by_year;
            }
        }

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 月別 申請内容別一覧表
        // 1. 件数集計
        $contract_count_summary_by_residence_type_by_month_db = DB::table('contracts')
                                                            ->select('residence_types.name AS residenceTypeName',
                                                                    DB::raw('DATE_FORMAT(contracts.start_fee_payment_date, "%Y-%m") AS date'),
                                                                    DB::raw('count(contracts.id) AS contractTotal'))
                                                            ->join('residence_types', 'contracts.residence_type_id', '=', 'residence_types.id')
                                                            ->where(DB::raw('DATE_FORMAT(contracts.start_fee_payment_date, "%Y")'), '=', $summary_year)
                                                            ->when($receptionist, function ($query) use ($receptionist) {
                                                                return $query->where('contracts.receptionist',  '=', $receptionist);
                                                            })
                                                            ->where("contracts.deleted_at")
                                                            ->groupByRaw('contracts.residence_type_id, date')
                                                            ->get();

        $contract_count_summary_by_residence_type_by_month = array();
        foreach ($application_residence_types as $residence_type) {
            for ($i=1; $i<=12; $i++) {
                $date = date('Y-m', mktime(0, 0, 0, $i, 1, $summary_year));
                $contract_count_summary_by_residence_type_by_month[$residence_type->name]["date"][$date]["contractTotal"] = 0;
                $contract_count_summary_by_residence_type_by_month[$residence_type->name]["contractQuantityByYear"] = 0;
                $contract_count_summary_by_residence_type_by_month[$residence_type->name]["contractPercentByYear"] = 0;
            }
        }

        // DBからの集計結果がある場合のみ、配列内容を上書きする
        if (count($contract_count_summary_by_residence_type_by_month_db)) {
            $contractQuantityTotal = 0;
            foreach ($contract_count_summary_by_residence_type_by_month_db as $detail) {
                $contract_count_summary_by_residence_type_by_month[$detail->residenceTypeName]["date"][$detail->date]["contractTotal"] = $detail->contractTotal;
                $contractQuantityTotal += $detail->contractTotal;
            }

            foreach ($contract_count_summary_by_residence_type_by_month as $residence_type => $detail_by_month) {
                $contractQuantityTotalByResidenceType = 0;
                foreach ($detail_by_month["date"] as $date => $info) {
                    $contractQuantityTotalByResidenceType += $info["contractTotal"];
                }

                $contract_count_summary_by_residence_type_by_month[$residence_type]["contractQuantityByYear"] = $contractQuantityTotalByResidenceType;
                $contract_count_summary_by_residence_type_by_month[$residence_type]["contractPercentByYear"] = number_format($contractQuantityTotalByResidenceType / $contractQuantityTotal * 100, 2);
            }
        }

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

        return response()->json([
            'status' => true,
            'html' => view('layouts.parts.contents.contract.summary_details', compact('summary_year', 'member_summary_by_contract_type_by_month', 'income_summary_by_contract_type_by_month', 'contract_summary_by_contract_type_by_year', 'income_summary_by_contract_type_by_year', 'application_residence_type_name', 'contract_summary_by_receptionist_by_month', 'contract_count_summary_by_residence_type_by_month'))->render(),
            'year' => $summary_year,
            // 月別、契約種別単位のお客様数集計
            'member_summary_by_contract_type_by_month' => $member_summary_by_contract_type_by_month,
            // 月別、契約種別単位の収入金額集計
            'income_summary_by_contract_type_by_month' => $income_summary_by_contract_type_by_month,
            // 年間、契約種別単位の契約件数集計
            'contract_summary_by_contract_type_by_year' => $contract_summary_by_contract_type_by_year,
            // 年間、契約種別単位の収入集計
            'income_summary_by_contract_type_by_year' => $income_summary_by_contract_type_by_year,
            // 月別 受付担当案件集計
            'contract_summary_by_receptionist_by_month' => $contract_summary_by_receptionist_by_month,
            // 月別 申請内容別一覧表
            'contract_count_summary_by_residence_type_by_month' => $contract_count_summary_by_residence_type_by_month,

            // 'summary_by_receptionist' => $summary_by_receptionist,
            'message' => 'Data get successfully.',
        ]);
    }
}

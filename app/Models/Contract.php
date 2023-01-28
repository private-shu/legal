<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contract extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'member_id',
        'management_number',
        'contract_type_id',
        'residence_type_id',
        'start_fee_payment_amount',
        'start_fee_payment_method_id',
        'start_fee_payment_date',
        'start_fee_total_amount',
        'start_fee_payment_comment',
        'success_fee_payment_amount',
        'success_fee_payment_method_id',
        'success_fee_payment_date',
        'success_fee_total_amount',
        'success_fee_payment_comment',
        'application_number',
        'application_date',
        'application_document',
        'additional_document',
        'application_status_id',
        'receptionist',
        'reception_date',
        'created_by',
        'updated_by'
    ];

    /**
     * モデルのタイムスタンプを更新するかの指示
     *
     * @var bool
     */
    public $timestamps = true;

    // タイムスタンプを保存するカラム名をカスタマイズする必要がある場合
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    protected $dates = ['deleted_at'];
}

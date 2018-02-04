<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Auth;




class PendingVoucher extends Authenticatable
{
    use Notifiable;
   
    protected $table = 'tbl_pendingvoucher';
    protected $primaryKey = 'id';
    

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'enquiry_id', 'voucher_id'
    ];



    /**
     * Add & update PendingVoucher addPendingVoucher
     *
     * @param array $models
     * @return $pendingvoucher
     */
    public function addPendingVoucher(array $models = [])
    {

        $pendingvoucher = new PendingVoucher;

        $pendingvoucher->enquiry_id = $models['enquiry_id'];
        $pendingvoucher->voucher_id = $models['voucher_id'];

        $pendingvoucher->created_at = date('Y-m-d H:i:s');
        $pendingvoucher->updated_at = date('Y-m-d H:i:s');
        $pendingvoucherId = $pendingvoucher->save();
        if ($pendingvoucherId) {
            return $pendingvoucher;
        } else {
            return false;
        }
    }

    /**
     * get PendingVoucher By fieldname getPendingVoucherByField
     *
     * @param mixed $id
     * @param string $field_name
     * @return mixed
     */
    public function getPendingVoucherByField($id, $field_name)
    {
        return PendingVoucher::where($field_name, $id)->first();
    }

    /**
     * update User Status
     *
     * @param array $models
     * @return boolean true | false
     */
    public function updateStatus(array $models = [])
    {
        $user = User::find($models['id']);
        $user->status = $models['status'];
        $user->updated_at = date('Y-m-d H:i:s');
        $userId = $user->save();
        if ($userId)
            return true;
        else
            return false;

    }

    /**
     * Delete Voucher
     *
     * @param int $id
     * @return boolean true | false
     */
    public function deletePendingVoucher($id)
    {
        $delete = Promo::where('id', $id)->delete();
        if ($delete)
            return true;
        else
            return false;

    }
}

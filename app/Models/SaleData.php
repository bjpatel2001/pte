<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;




class SaleData extends Authenticatable
{
    use Notifiable;
   
    protected $table = 'tbl_sale_data';
    protected $primaryKey = 'id';
    

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'enquiry_id', 'voucher_id', 'payment_code', 'rate','amount_paid','number_of_voucher'
    ];

    

    /**
     * Get all User getCollection
     *
     * @return mixed
     */
    public function getCollection()
    {

         $saledata = SaleData::select('tbl_sale_data.*');

        return $saledata->get();
    }

    /**
     * Get all User with role and ParentUser relationship
     *
     * @return mixed
     */
    public function getDatatableCollection()
    {
       return SaleData::select('tbl_sale_data.*');
    }

    /**
     * Query to get saledata total count
     *
     * @param $dbObject
     * @return integer $saledataCount
     */
    public static function getSaleDataCount($dbObject)
    {
        $saledataCount = $dbObject->count();
        return $saledataCount;
    }

    /**
     * Scope a query to get all data
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @param  Request $request
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeGetSaleDataData($query, $request)
    {
        return $query->skip($request->start)->take($request->length)->get();
    }

    /**
     * scopeGetFilteredData from App/Models/SaleData
     * get filterred saledatas
     *
     * @param  object $query
     * @param  \Illuminate\Http\Request $request
     * @return mixed
     */
    public function scopeGetFilteredData($query, $request)
    {
        $filter = $request->filter;
        $Datefilter = $request->filterDate;
        $filterSelect = $request->filterSelect;

        /**
         * @param string $filter  text type value
         * @param string $Datefilter  date type value
         * @param string $filterSelect select value
         *
         * @return mixed
         */
        return $query->Where(function ($query) use ($filter, $Datefilter, $filterSelect) {
            if (count($filter) > 0) {
                foreach ($filter as $key => $value) {
                    if ($value != "") {
                        $query->where($key, 'LIKE', '%' . trim($value) . '%');
                    }
                }
            }

            if (count($Datefilter) > 0) {
                foreach ($Datefilter as $dtkey => $dtvalue) {
                    if ($dtvalue != "") {
                        $query->where($dtkey, 'LIKE', '%' . date('Y-m-d', strtotime(trim($dtvalue))) . '%');
                    }
                }
            }

            if (count($filterSelect) > 0) {
                foreach ($filterSelect as $Sekey => $Sevalue) {
                    if ($Sevalue != "") {
                        $query->whereRaw('FIND_IN_SET(' . trim($Sevalue) . ',' . $Sekey . ')');
                    }
                }
            }

        });

    }

    /**
     * Scope a query to sort data
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @param  Request $request
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSortSaleDataData($query, $request)
    {

        return $query->orderBy(config('constant.saledataDataTableFieldArray')[$request->order['0']['column']], $request->order['0']['dir']);

    }

    /**
     * Scope a query to sort data
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @param  string $column
     * @param  string $dir
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSortDefaultDataByRaw($query, $column, $dir)
    {
        return $query->orderBy($column, $dir);
    }

    /**
     * Add & update SaleData addSaleData
     *
     * @param array $models
     * @return $saledata
     */
    public function addSaleData(array $models = [])
    {

        $saledata = new SaleData;
        $saledata->created_at = date('Y-m-d H:i:s');
        $saledata->voucher_id = $models['voucher_id'];
        $saledata->voucher_code = $models['voucher_code'];
        $saledata->instamojo_fee = $models['instamojo_fee'];
        $saledata->enquiry_id = $models['enquiry_id'];
        $saledata->payment_code = $models['payment_code'];
        $saledata->rate = $models['rate'];
        $saledata->amount_paid = $models['amount_paid'];
        $saledata->number_of_voucher = $models['number_of_voucher'];
        $saledata->updated_at = date('Y-m-d H:i:s');
        $saledataId = $saledata->save();

        if ($saledataId) {
            return $saledata;
        } else {
            return false;
        }
    }

    /**
     * get SaleData By fieldname getSaleDataByField
     *
     * @param mixed $id
     * @param string $field_name
     * @return mixed
     */
    public function getSaleDataByField($id, $field_name)
    {
        return SaleData::where($field_name, $id)->first();
    }

    /**
     * update SaleData Status
     *
     * @param array $models
     * @return boolean true | false
     */
    public function updateStatus(array $models = [])
    {
        $saledata = SaleData::find($models['id']);
        $saledata->status = $models['status'];
        $saledata->updated_at = date('Y-m-d H:i:s');
        $saledataId = $saledata->save();
        if ($saledataId)
            return $saledata;
        else
            return false;

    }

    /**
     * Delete SaleData
     *
     * @param int $id
     * @return boolean true | false
     */
    public function deleteSaleData($id)
    {
        $delete = SaleData::where('id', $id)->delete();
        if ($delete)
            return true;
        else
            return false;

    }

    /**
     * Get the count of unused voucher
     *
     * @return $return
     */
    public function getUnusedVoucher()
    {
        $return = SaleData::where('status', 0)->count();
        return $return;
    }

    /**
     * Get the count of unused voucher
     * @param $count
     * @return $return
     */
    public function getVoucherByCount($count)
    {
        $return = SaleData::where('status', 0)->take($count)->get();
        return $return;
    }

}

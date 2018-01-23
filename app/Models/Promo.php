<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\PromoLog;
use App\Models\Machine;
use Auth;
use Illuminate\Database\Eloquent\SoftDeletes;

class Promo extends Model
{
    protected $table = 'tbl_promo_voucher';
    protected $primaryKey = 'id';
    use SoftDeletes;


    public function Machine()
    {
        return $this->hasMany('App\Models\Machine','promo_id','id')->where('status',1);
    }

    /**
     * Get all Promos getCollection
     *
     * @param array $models
     * @return mixed
     */
    public function getCollection(array $models = [])
    {
        $promo = Promo::with('Machine')->select('tbl_promo_voucher.*');
        if(isset($models['check_status']) && $models['check_status'] == 1){
            $promo->where('status',1);
        }
        return $promo->get();
    }

    /**
     * Get all Promo with promo & User relationship
     *
     * @return mixed
     */
    public function getDatatableCollection()
    {
        return Promo::select('tbl_promo_voucher.*');
    }

    /**
     * Query to get promo total count
     *
     * @param $dbObject
     * @return integer $promoCount
     */
    public static function getPromoCount($dbObject)
    {
        $promoCount = $dbObject->count();
        return $promoCount;
    }

    /**
    * get Machine By promo wise
    *
    * @param mixed $id
    *
    * @return response
    */
        public function getProductByPromoId($id)
        {
            return Machine::where('promo_id',$id)->select('machine_name','id')->get()->toArray();
        }

    /**
     * Scope a query to get all data
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @param  Request $request
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeGetPromoData($query, $request)
    {
        return $query->skip($request->start)->take($request->length)->get();
    }

    /*
     *    scopeGetFilteredData from App/Models/Promo
     *   get filterred promos
     *
     *  @param  object $query
     *  @param  \Illuminate\Http\Request $request
     *  @return mixed
     * */
    public function scopeGetFilteredData($query, $request)
    {
        $filter = $request->filter;
        $Datefilter = $request->filterDate;
        $filterSelect = $request->filterSelect;
        /*
         * @param string $filter  text type value
         * @param string $Datefilter  date type value
         * @param string $filterSelect select value
         *
         *  @return mixed
         * */
        return $query->Where(function ($query) use ($filter, $Datefilter, $filterSelect) {
                if (count($filter) > 0) {
                    foreach ($filter as $key => $value) {
                        if ($value != "") {
                            $query->where($key, 'LIKE', '%' . $value . '%');
                        }
                    }
                }

                if (count($Datefilter) > 0) {
                    foreach ($Datefilter as $dtkey => $dtvalue) {
                        if ($dtvalue != "") {
                            $query->where($dtkey, 'LIKE', '%' . date('Y-m-d', strtotime($dtvalue)) . '%');
                        }
                    }
                }

                if (count($filterSelect) > 0) {
                    foreach ($filterSelect as $Sekey => $Sevalue) {
                        if ($Sevalue != "") {
                            $query->whereRaw('FIND_IN_SET(' . $Sevalue . ',' . $Sekey . ')');
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
    public function scopeSortPromoData($query, $request)
    {

        return $query->orderBy(config('constant.promoDataTableFieldArray')[$request->order['0']['column']], $request->order['0']['dir']);

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
     * Add & update Promo addPromo
     *
     * @param array $models
     * @return boolean true | false
     */
    public function addPromo(array $models = [])
    {
        $promoLog = new PromoLog();
        if (isset($models['id'])) {
            $promo = Promo::find($models['id']);
            $promoLog->action = "Update";
        } else {
            $promo = new Promo;
            $promoLog->created_by = $promo->created_by = Auth::id();
            $promoLog->action = "Add";
        }

        $promoLog->promo_name = $promo->promo_name = $models['promo_name'];
        $promoLog->created_by = $promoLog->updated_by = $promo->updated_by = Auth::id();
        if (isset($models['status'])) {
            $promoLog->status = $promo->status = $models['status'];
        } else {
            $promoLog->status = $promo->status = 0;
        }

        $promoId = $promo->save();
        $promoLog->promo_id = $promo->id;
        $promoLog->save();

        if ($promoId)
            return true;
        else
            return false;
    }

    /**
     * get Promo By fieldname getPromoByField
     *
     * @param mixed $id
     * @param string $field_name
     * @return mixed
     */
    public function getPromoByField($id, $field_name)
    {
        return Promo::where($field_name, $id)->first();
    }

    /**
     * update Promo Status
     *
     * @param array $models
     * @return boolean true | false
     */
    public function updateStatus(array $models = [])
    {
        $promoLog = new PromoLog();

        $promo = Promo::find($models['id']);
        $promoLog->status = $promo->status = $models['status'];
        $promoLog->created_by = $promoLog->updated_by = $promo->updated_by = Auth::id();
        $promoLog->action = "Change Password";
        $promoId = $promo->save();
        $promoLog->promo_id = $promo->id;
        $promoLog->save();


        if ($promoId)
            return true;
        else
            return false;

    }

    /**
     * Delete Promo
     *
     * @param int $id
     * @return boolean true | false
     */
    public function deletePromo($id)
    {
        $promoData = Machine::where('promo_id',$id)->first();
        if(count($promoData)>0){
            return false;
        }
        $promoLog = new PromoLog();
        $promoLog->created_by = $promoLog->updated_by = Auth::id();
        $promoLog->action = "Delete";
        $delete = Promo::where('id', $id)->delete();
        $promoLog->promo_id = $id;
        $promoLog->save();

        if ($delete)
            return true;
        else
            return false;

    }

    /**
     * get Machine By promo wise
     *
     * @param mixed $id
     *
     * @return response
     */
    public function getMachineByPromo($id)
    {
        return Promo::with('Machine')->where('id',$id)->get();
    }

}
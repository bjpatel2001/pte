<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Auth;




class OfflinePayment extends Authenticatable
{
    use Notifiable;
   
    protected $table = 'tbl_offline_agent';
    protected $primaryKey = 'id';
    

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email', 'name','mobile','state', 'created_by', 'updated_by'
    ];

    

    /**
     * Get all User getCollection
     *
     * @return mixed
     */
    public function getCollection()
    {

         $offlinePayment = OfflinePayment::select('tbl_offline_agent.*');
        return $offlinePayment->get();
    }

    /**
     * Get all User with role and ParentUser relationship
     *
     * @return mixed
     */
    public function getDatatableCollection()
    {
       return OfflinePayment::select('tbl_offline_agent.*');
    }

    /**
     * Query to get offlinePayment total count
     *
     * @param $dbObject
     * @return integer $offlinePaymentCount
     */
    public static function getOfflinePaymentCount($dbObject)
    {
        $offlinePaymentCount = $dbObject->count();
        return $offlinePaymentCount;
    }

    /**
     * Scope a query to get all data
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @param  Request $request
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeGetOfflinePaymentData($query, $request)
    {
        return $query->skip($request->start)->take($request->length)->get();
    }

    /**
     * scopeGetFilteredData from App/Models/OfflinePayment
     * get filterred offlinePayments
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
    public function scopeSortOfflinePaymentData($query, $request)
    {

        return $query->orderBy(config('constant.offlinePaymentDataTableFieldArray')[$request->order['0']['column']], $request->order['0']['dir']);

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
     * Add & update OfflinePayment addOfflinePayment
     *
     * @param array $models
     * @return boolean true | false
     */
    public function addOfflinePayment(array $models = [])
    {

        // For Storing the Agent Data
        $offlinePayment = new OfflinePayment;
        $offlinePayment->email = $models['email'];
        $offlinePayment->name = $models['name'];
        $offlinePayment->mobile = $models['mobile'];
        $offlinePayment->created_at = date('Y-m-d H:i:s');
        $offlinePayment->created_by = Auth::user()->id;
        $offlinePayment->updated_by = Auth::user()->id;
        $offlinePayment->updated_at = date('Y-m-d H:i:s');

        $offlinePaymentId = $offlinePayment->save();

        if ($offlinePaymentId) {
            return $offlinePayment;
        } else {
            return false;
        }
    }

    /**
     * Add & update OfflinePayment addOfflinePayment
     *
     * @param array $models
     * @return boolean true | false
     */
    public function storeNewAgentPayment(array $models = [])
    {

        //For Storing the Enquiry first
        $enquiry = new Enquiry();
        $enquiry_data = $enquiry->addEnquiry($models);


        //For Storing the new agent information

        $offlinePayment = new OfflinePayment;
        $offlinePayment->created_at = date('Y-m-d H:i:s');
        $offlinePayment->created_by = Auth::user()->id;
        $offlinePayment->email = $models['email'];
        $offlinePayment->name = $models['name'];
        $offlinePayment->mobile = $models['mobile'];
        $offlinePayment->state = $models['state'];

        $offlinePayment->updated_by = Auth::user()->id;
        $offlinePayment->updated_at = date('Y-m-d H:i:s');
        $offlinePaymentId = $offlinePayment->save();

        if ($offlinePaymentId) {
            return $offlinePayment;
        } else {
            return false;
        }
    }

    /**
     * Add & update OfflinePayment addOfflinePayment
     *
     * @param array $models
     * @return boolean true | false
     */
    public function storeExistingAgentPayment(array $models = [])
    {
        $agent_data = '';
        //For fetching the current agent detail
        if(!empty($models['user_id'])) {
            $agent_data = $this->getOfflinePaymentByField($models['user_id'],'id');
        }else {
            return false;
        }

        $models['name'] = $agent_data->name;
        $models['email'] = $agent_data->email;
        $models['state'] = $agent_data->state;
        $models['mobile'] = $agent_data->mobile;
        //For Storing the Enquiry first
        $enquiry = new Enquiry();
        $enquiry_data = $enquiry->addEnquiry($models);

        //For Adding it to sales data
        $saleData = new SaleData();
        $sale_data = $saleData->addSaleData($models);

        if ($enquiry_data) {
            return $enquiry_data;
        } else {
            return false;
        }

    }

    /**
     * Add & update Promo addPromo
     *
     * @param array $models
     * @return boolean true | false
     */
    public function updateAgent(array $models = [])
    {
        if (isset($models['id'])) {
            $agent_data = OfflinePayment::find($models['id']);
        } else {
            $agent_data = new OfflinePayment();
            $agent_data->created_at = date('Y-m-d H:i:s');
            $agent_data->created_by = Auth::user()->id;

        }
        $agent_data->name = $models['name'];
        $agent_data->email = $models['email'];
        $agent_data->mobile = $models['mobile'];
        $agent_data->state = $models['state'];



        $agent_data->updated_at = date('Y-m-d H:i:s');
        $agent_data->updated_by = Auth::user()->id;
        $promoId = $agent_data->save();

        if ($promoId) {
            return $agent_data;
        } else {
            return false;
        }
    }

    /**
     * get OfflinePayment By fieldname getOfflinePaymentByField
     *
     * @param mixed $id
     * @param string $field_name
     * @return mixed
     */
    public function getOfflinePaymentByField($id, $field_name)
    {
        return OfflinePayment::where($field_name, $id)->first();
    }


    /**
     * Delete OfflinePayment
     *
     * @param int $id
     * @return boolean true | false
     */
    public function deleteAgent($id)
    {
        $delete = OfflinePayment::where('id', $id)->delete();
        if ($delete)
            return true;
        else
            return false;

    }

}

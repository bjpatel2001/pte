<?php

namespace App\Http\Controllers\Admin;

use App\Models\PromoLog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Promo;
use Illuminate\Support\Facades\Input;
use Validator;

class PromoController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    protected $promo;
    protected $promo_log;

    public function __construct(Promo $promo, PromoLog $promo_log)
    {
        $this->middleware('auth');
        $this->promo = $promo;
        $this->promo_log = $promo_log;
    }

    /**
     * Display a listing of the promo.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {

        /*
         *  getCollection from App/Models/Promo
         *
         *  @return mixed
         * */


        $data['productManagementTab'] = "active open";
        $data['promoTab'] = "active";
        return view('admin.promo.promolist', $data);
    }

    public function datatable(Request $request)
    {
        // default count of promo $promoCount
        $promoCount = 0;

        /*
         *    getDatatableCollection from App/Models/Promo
         *   get all promos
         *
         *  @return mixed
         * */
        $promoData = $this->promo->getDatatableCollection();

        /*
         *    scopeGetFilteredData from App/Models/Promo
         *   get filterred promos
         *
         *  @return mixed
         * */
        $promoData = $promoData->GetFilteredData($request);

        /*
         *    getPromoCount from App/Models/Promo
         *   get count of promos
         *
         *  @return integer
         * */
        $promoCount = $this->promo->getPromoCount($promoData);

        //  Sorting promo data base on requested sort order
        if (isset(config('constant.promoDataTableFieldArray')[$request->order['0']['column']])) {
            $promoData = $promoData->SortPromoData($request);
        } else {
            $promoData = $promoData->SortDefaultDataByRaw('tbl_promo_voucher.id', 'desc');
        }

        /*
         *  get paginated collection of promo
         *
         * @param  \Illuminate\Http\Request $request
         * @return mixed
         * */
        $promoData = $promoData->GetPromoData($request);

        $appData = array();
        foreach ($promoData as $promoData) {
            $row = array();
            $row[] = $promoData->voucher_code;
            $appData[] = $row;
        }

        return [
            'draw' => $request->draw,
            'recordsTotal' => $promoCount,
            'recordsFiltered' => $promoCount,
            'data' => $appData,
        ];
    }

    /**
     * Show the form for creating a new promo.
     *
     * @return \Illuminate\Http\Response
     */

    public function create($flag = null)
    {
        $data['productManagementTab'] = "active open";
        $data['promoTab'] = "active";
        if($flag != ""){
            $data['flag'] = $flag;
        }
        return view('admin.promo.add', $data);
    }

    /**
     * Display the specified promo.
     *
     * @param  integer $id
     * @return \Illuminate\Http\Response
     */

    public function edit($id, $flag = null)
    {

        /*
         *  get details of the specified promo. from App/Models/Promo
         *
         * @param mixed $id
         * @param string (id) fieldname
         *  @return mixed
         * */
        $data['details'] = $this->promo->getPromoByField($id, 'id');
        if($flag != ""){
            $data['flag'] = $flag;
        }
        $data['masterManagementTab'] = "active open";
        $data['promoTab'] = "active";
        return view('admin.promo.edit', $data);
    }


    /**
     * Validation of add and edit action customeValidate
     *
     * @param array $data
     * @param string $mode
     * @return mixed
     */


    public function customeValidate($data, $mode)
    {
        $rules = array(
            'promo_name' => 'required|max:50',
        );

        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {
            $errorRedirectUrl = "admin/promo/add";
            if ($mode == "edit") {
                $errorRedirectUrl = "admin/promo/edit/" . $data['id'];
            }
            return redirect($errorRedirectUrl)->withInput()->withErrors($validator);
        }
        return false;
    }

    /**
     * Store a newly created promo in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(request $request)
    {

        $validations = $this->customeValidate($request->all(), 'add');
        if ($validations) {
            return $validations;
        }

        $addpromo = $this->promo->addPromo($request->all());
        if ($addpromo) {
            $request->session()->flash('alert-success', trans('app.promo_add_success'));
            if (isset($request->quotation_flag) && $request->quotation_flag != null){
                return redirect('admin/quotation/list');
            }else{
                return redirect('admin/promo/list');
            }
        } else {
            $request->session()->flash('alert-danger', trans('app.promo_error'));
            return redirect('admin/promo/add')->withInput();
        }
    }

    /**
     * Update the specified promo in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function update(request $request)
    {
        $validations = $this->customeValidate($request->all(), 'edit');
        if ($validations) {
            return $validations;
        }

        $addpromo = $this->promo->addPromo($request->all());
        if ($addpromo) {
            $request->session()->flash('alert-success', trans('app.promo_edit_success'));
            if (isset($request->quotation_flag) && $request->quotation_flag != null){
                return redirect('admin/quotation/list');
            }else{
                return redirect('admin/promo/list');
            }
        } else {
            $request->session()->flash('alert-danger', trans('app.promo_error'));
            return redirect('admin/promo/edit/' . $request->get('id'))->withInput();
        }
    }

    /**
     * Update status to the specified user in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function changeStatus(request $request)
    {
        $updatePromo = $this->promo->updateStatus($request->all());
        if ($updatePromo) {
            $request->session()->flash('alert-success', trans('app.promo_status_success'));
        } else {
            $request->session()->flash('alert-danger', trans('app.promo_error'));
        }
        echo 1;
    }

    /**
     * Delete the specified promo in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  integer $id
     * @return \Illuminate\Http\Response
     */
    public function delete(request $request)
    {

        $deleteUser = $this->promo->deletePromo($request->id);
        if ($deleteUser) {
            $request->session()->flash('alert-success', trans('app.promo_delete_success'));
        } else {
            $request->session()->flash('alert-danger', trans('app.promo_error'));
        }
        echo 1;
    }

    /**
     * log the specified promo in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  integer $id
     * @return \Illuminate\Http\Response
     */
    public function log(request $request)
    {
        $data['details'] = $this->promo_log->getCollection($request->id);
        $data['productManagementTab'] = "active open";
        $data['promoTab'] = "active";
        return view('admin.promo.promolog', $data);
    }

}
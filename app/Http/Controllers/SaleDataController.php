<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\SaleData;
use App\Models\Role;
use Illuminate\Support\Facades\Auth;
use Validator;
use Event;
use Hash;
use App\Events\SendMail;
use DB;

class SaleDataController extends Controller
{

    protected $saledata;
    protected $role;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(SaleData $saledata, Role $role)
    {
        $this->middleware(['auth', 'checkRole']);
        $this->saledata = $saledata;
        $this->role = $role;
    }

    /**
     * Display a listing of the saledata.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        /**
         * getCollection from App/Models/SaleData
         *
         * @return mixed
         */
        $data['saledataData'] = $this->saledata->getCollection();
        $data['saledataManagementTab'] = "active open";
        $data['saledataTab'] = "active";
        return view('saledata.saledatalist', $data);
    }

    public function datatable(Request $request)
    {
        // default count of saledata $saledataCount
        $saledataCount = 0;

        /**
         * getDatatableCollection from App/Models/SaleData
         * get all saledatas
         *
         * @return mixed
         */
        $saledataData = $this->saledata->getDatatableCollection();

        /**
         * scopeGetFilteredData from App/Models/SaleData
         * get filterred saledatas
         *
         * @return mixed
         */
        $saledataData = $saledataData->GetFilteredData($request);

        /**
         * getSaleDataCount from App/Models/SaleData
         * get count of saledatas
         *
         * @return integer
         */
        $saledataCount = $this->saledata->getSaleDataCount($saledataData);

        // Sorting saledata data base on requested sort order
        if (isset(config('constant.saledataDataTableFieldArray')[$request->order['0']['column']])) {
            $saledataData = $saledataData->SortSaleDataData($request);
        } else {
            $saledataData = $saledataData->SortDefaultDataByRaw('tbl_sale_data.id', 'desc');
        }

        /**
         * get paginated collection of saledata
         *
         * @param  \Illuminate\Http\Request $request
         * @return mixed
         */
        $saledataData = $saledataData->GetSaleDataData($request);
        $appData = array();
        foreach ($saledataData as $saledataData) {
            $row = array();
            $row[] = date("d-m-Y H:i:s", strtotime($saledataData->created_at));
            $row[] = ($saledataData->Enquiry) ? $saledataData->Enquiry->name : "---";
            $row[] = ($saledataData->Enquiry) ? $saledataData->Enquiry->email : "---";
            $row[] = ($saledataData->Enquiry) ? $saledataData->Enquiry->mobile : "---";
            $row[] = $saledataData->voucher_code;
            $row[] = $saledataData->payment_code;
            $row[] = $saledataData->rate;
            $row[] = $saledataData->amount_paid;
            $row[] = $saledataData->number_of_voucher;
            $appData[] = $row;
        }

        return [
            'draw' => $request->draw,
            'recordsTotal' => $saledataCount,
            'recordsFiltered' => $saledataCount,
            'data' => $appData,
        ];
    }

    /**
     * Display a listing of the invoicedata
     *
     * @return \Illuminate\Http\Response
     */
    public function invoiceList()
    {

        /**
         * getCollection from App/Models/SaleData
         *
         * @return mixed
         */
        $data['saledataData'] = $this->saledata->getCollection();
        $data['saledataManagementTab'] = "active open";
        $data['invoicedataTab'] = "active";
        return view('saledata.invoicedatalist', $data);
    }
    public function invoiceDatatable(Request $request)
    {
        // default count of saledata $saledataCount
        $saledataCount = 0;

        /**
         * getDatatableCollection from App/Models/SaleData
         * get all saledatas
         *
         * @return mixed
         */
        $saledataData = $this->saledata->getDatatableCollection();

        /**
         * scopeGetFilteredData from App/Models/SaleData
         * get filterred saledatas
         *
         * @return mixed
         */
        $saledataData = $saledataData->GetFilteredData($request);

        /**
         * getSaleDataCount from App/Models/SaleData
         * get count of saledatas
         *
         * @return integer
         */
        $saledataCount = $this->saledata->getSaleDataCount($saledataData);

        // Sorting saledata data base on requested sort order
        if (isset(config('constant.invoicedataDataTableFieldArray')[$request->order['0']['column']])) {
            $saledataData = $saledataData->SortSaleDataData($request);
        } else {
            $saledataData = $saledataData->SortDefaultDataByRaw('tbl_sale_data.id', 'desc');
        }

        /**
         * get paginated collection of saledata
         *
         * @param  \Illuminate\Http\Request $request
         * @return mixed
         */
        $saledataData = $saledataData->GetSaleDataData($request);
        $appData = array();
        foreach ($saledataData as $saledataData) {

            $row = array();
            $amount_paid = $saledataData->amount_paid;
            $row[] = date("d-m-Y H:i:s", strtotime($saledataData->created_at));
            $row[] = (isset($saledataData->Enquiry)) ? $saledataData->Enquiry->name : "---";
            $row[] = (isset($saledataData->Enquiry)) ? $saledataData->Enquiry->email : "---";
            $row[] = (isset($saledataData->Enquiry)) ? $saledataData->Enquiry->mobile : "---";
            $row[] = $saledataData->voucher_code;
            $row[] = $saledataData->payment_code;
            $row[] = $saledataData->amount_paid * 0.18;
            $row[] = $saledataData->amount_paid;
            $row[] = (isset($saledataData->Enquiry) && $saledataData->Enquiry->state == 5) ? 'SGST:'.$saledataData->amount_paid * 0.18 : 'SGST:'.$amount_paid * 0.09.'<br>'.'CGST:'.$amount_paid * 0.09 ;
            $appData[] = $row;
        }

        return [
            'draw' => $request->draw,
            'recordsTotal' => $saledataCount,
            'recordsFiltered' => $saledataCount,
            'data' => $appData,
        ];
    }


}

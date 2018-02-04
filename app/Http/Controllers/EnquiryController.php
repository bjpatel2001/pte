<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Enquiry;
use App\Models\Role;

class EnquiryController extends Controller
{

    protected $enquiry;
    protected $role;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Enquiry $enquiry, Role $role)
    {
        $this->middleware(['auth', 'checkRole']);
        $this->enquiry = $enquiry;
        $this->role = $role;
    }

    /**
     * Display a listing of the enquiry.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        /**
         * getCollection from App/Models/Enquiry
         *
         * @return mixed
         */
        $data['enquiryData'] = $this->enquiry->getCollection();
        $data['enquiryManagementTab'] = "active open";
        $data['enquiryTab'] = "active";
        return view('enquiry.enquirylist', $data);
    }

    public function datatable(Request $request)
    {
        // default count of enquiry $enquiryCount
        $enquiryCount = 0;

        /**
         * getDatatableCollection from App/Models/Enquiry
         * get all enquirys
         *
         * @return mixed
         */
        $enquiryData = $this->enquiry->getDatatableCollection();

        /**
         * scopeGetFilteredData from App/Models/Enquiry
         * get filterred enquirys
         *
         * @return mixed
         */
        $enquiryData = $enquiryData->GetFilteredData($request);

        /**
         * getEnquiryCount from App/Models/Enquiry
         * get count of enquirys
         *
         * @return integer
         */
        $enquiryCount = $this->enquiry->getEnquiryCount($enquiryData);

        // Sorting enquiry data base on requested sort order
        if (isset(config('constant.enquiryDataTableFieldArray')[$request->order['0']['column']])) {
            $enquiryData = $enquiryData->SortEnquiryData($request);
        } else {
            $enquiryData = $enquiryData->SortDefaultDataByRaw('tbl_enquiry.id', 'desc');
        }

        /**
         * get paginated collection of enquiry
         *
         * @param  \Illuminate\Http\Request $request
         * @return mixed
         */
        $enquiryData = $enquiryData->GetEnquiryData($request);
        $appData = array();
        foreach ($enquiryData as $enquirysData) {
            $row = array();
            $row[] = $enquirysData->email;
            $row[] = $enquirysData->name;
            $row[] = $enquirysData->mobile;
            $row[] = $enquirysData->number_of_voucher;
            $row[] = $enquirysData->rate;
            $row[] = $enquirysData->payment_request_id;
            $appData[] = $row;
        }

        return [
            'draw' => $request->draw,
            'recordsTotal' => $enquiryCount,
            'recordsFiltered' => $enquiryCount,
            'data' => $appData,
        ];
    }

  



}

<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\parameter;
use Auth;

class ParameterController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    private function check_access(){
        if(Auth::user()->usertype != "Admin" && Auth::user()->BPI == false){
            echo "<h1>Access Denied</h1>";
            die;
        }
    }

    public function index()
    {
        $this->check_access();
        $tbl494 = parameter::find("1");
        return view('parameter',compact('tbl494'));
    }
    public function update(Request $request)
    {
        $this->check_access();
        $tbl494 = parameter::find("1");
        $tbl494->CWI_Z = $request->get('CWI_Z');
        $tbl494->CWI_d = $request->get('CWI_d');
        $tbl494->CCEI_a = $request->get('CCEI_a');
        $tbl494->CCEI_b = $request->get('CCEI_b');
        $tbl494->CCEI_taSe = $request->get('CCEI_taSe');
        $tbl494->CCEI_n = $request->get('CCEI_n');
        $tbl494->CCEI_Xb = $request->get('CCEI_Xb');
        $tbl494->CCEI_Sxx = $request->get('CCEI_Sxx');
        $tbl494->FPR = $request->get('FPR');
        $tbl494->REF_NAFT = $request->get('REF_NAFT');
        $tbl494->REF_NATT = $request->get('REF_NATT');
        $tbl494->REF_MRP = $request->get('REF_MRP');
        $tbl494->REF_MBM = $request->get('REF_MBM');
        $tbl494->REF_MSL = $request->get('REF_MSL');
        $tbl494->REF_DTP = $request->get('REF_DTP');
        $tbl494->REF_SMB = $request->get('REF_SMB');
        $tbl494->save();
        return redirect('/parameter')->with('message', 'Settings Saved Successfully');
    }
        
}

	
	
	

	
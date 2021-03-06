<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\rhplatform;
use App\Formulae;
use App\TrackerSMS;
use App\tbl137;
use App\tbl136;
use App\Billbox;
use App\SMSFleetops;
use Session;
use PDF;

class DriverController extends Controller
{
    public function index()
    {
        $time = array();
        $time['current_date'] = date("Y-m-d");
        $time['current_time'] = date("H.i");
        return view('driver.index',compact('time'));
    }

    public function drivervno()
    {
        return view('driver.drivervno');
    } 

    public function driverlogin()
    {
        $VNO = "";
        $password = "";
        $error_msg = "";        
        return view('driver.driverlogin',compact('VNO','password','error_msg'));
    }

     public function validate_login(Request $request)
    {
        $VNO = trim($request->get("VNO"));
        $password = trim($request->get("password"));
        $VNO = str_replace(' ', '', $VNO);        
        $VNO = str_replace('-', '', $VNO);
        $sql = "SELECT a.*,b.DCN,b.DNM,b.DSN FROM vehicle a,driver b where a.driver_id=b.id and replace(VNO, '-', '') = '$VNO' and password='$password' and VTV=1";
        $valid = DB::select(DB::raw($sql));
        if(count($valid) > 0){
            $VNO = $valid[0]->VNO;
            $driver_id = $valid[0]->driver_id;
            $DCN = $valid[0]->DCN;
            $DNM = $valid[0]->DNM." ".$valid[0]->DSN;
            $login_time = date("Y-m-d H:i:s");
            $otp = rand(1001,9999);
            //$otp = "1234";
            $msg = "Your fleetops account login otp is ".$otp;
            $sql = "insert into driver_login (VNO,driver_id,login_time,otp) values ('$VNO','$driver_id','$login_time','$otp')";
            DB::insert($sql);
            SMSFleetops::send($DCN,$msg);
            $DAT = date("Y-m-d");
            $TIM = date("H:i:s");
            $CTX = "OTP";
            $sql = "insert into sms_log (PHN,MSG,DAT,TIM,CTX,NAM) values ('$DCN','$msg','$DAT','$TIM','$CTX','$DNM')";
            DB::insert($sql);
            Session::put('VNO', $VNO);
            Session::put('driver_id', $driver_id);
            return redirect('/otp');
            //return view('driver.otp',compact('VNO'));
        }else{
            $error_msg = 'Please check the Vehicle Reg No and password';
            return view('driver.driverlogin',compact('VNO','password','error_msg'));
        }    
    }


     public function otp(Request $request)
    {
        $error_msg = "";
        return view('driver.otp',compact('error_msg'));
    }

    public function validate_otp(Request $request)
    {
        $VNO = trim($request->get("VNO"));
        $OTP = trim($request->get("OTP"));
        $sql = "select a.OTP,c.VBM,c.DNM,c.DSN,c.DCN from driver_login a,vehicle b,driver c where a.VNO=b.VNO and b.driver_id=c.id and a.id = (select max(id) from driver_login where VNO='$VNO')";
        $result = DB::select(DB::raw($sql));
        if(count($result) > 0){
            if($OTP == $result[0]->OTP){
                return redirect()->route('myaccount');
            }else{
                $error_msg = 'Invalid OTP';
                return view('driver.otp',compact('error_msg'));
            }
        }
    }


     public function myaccount()
     {
        $acceptance_code = "";
        $status = "";
        $handover_id = "";
        $VNO = Session::get('VNO');
        $driver_id = Session::get('driver_id');
        $sql = "select status from vehicle where VNO='$VNO'";
        $result = DB::select(DB::raw($sql));
        if(count($result) > 0){
            $status = $result[0]->status;
        }
        $sql = "select * from driver where  id=$driver_id";
        $result = DB::select(DB::raw($sql));
        if(count($result) > 0){
            $VBM = $result[0]->VBM;
            $DNM = $result[0]->DNM . " " . $result[0]->DSN;
            $DCN = $result[0]->DCN;
            $VCC = $result[0]->VCC;
        }
        $sql = "select acceptance_code,accepted from handover where VNO='$VNO' and driver_id=$driver_id order by id desc limit 1";
        $result = DB::select(DB::raw($sql));
        if(count($result) > 0){
            if($result[0]->accepted == 1){
                $acceptance_code = $result[0]->acceptance_code;
            }
        }
        if($status == "assigned"){
            $sql = "select acceptance_code from driver_upload where VNO='$VNO' and driver_id=$driver_id and approved=1 order by id desc limit 1";
            $result = DB::select(DB::raw($sql));
            if(count($result) > 0){
                $acceptance_code = $result[0]->acceptance_code;
            }
        }

        $sql = "select handover_id from vehicle where VNO='$VNO'";
        $result = DB::select(DB::raw($sql));
        if(count($result) > 0){
            $handover_id = $result[0]->handover_id;
        }
        return view('driver.myaccount',compact('VNO','VBM','DNM','DCN','acceptance_code','VCC','handover_id'));
     }

    public function tasks()
    {
        $VNO = Session::get('VNO');
        $LEX = 0;
        $IEX = 0;
        $REX = 0;
        $CEX = 0;
        $LEXD = "";
        $IEXd = "";
        $REXD = "";
        $CEXD = "";
        $LDT = "";
        $file_name = "";
        $SSD ="";
        $SVE ="";
        $ISD ="";
        $IVE ="";
        $insurance_approved = 1;
        $roadworthy_approved = 1;
        $licence_approved = 1;
        $contract_approved = 1;
        $service_approved = 1;
        $inspection_approved = 1;
        $assign_approved = 1;
        $sql = "select c.VBM,c.DNM,c.DSN,c.DCN,c.DNO from vehicle b,driver c where  b.driver_id=c.id and b.VNO='$VNO'";
        $result = DB::select(DB::raw($sql));
        if(count($result) > 0){
            $VBM = $result[0]->VBM;
            $DNM = $result[0]->DNM . " " . $result[0]->DSN;
            $DCN = $result[0]->DCN;
            $DNO = $result[0]->DNO;
            $today = date("Y-m-d");
            $lstatus = "";
            $cstatus = "";
            $istatus = "";
            $rstatus = "";
            $lexpiry_flag = "";
            $rexpiry_flag = "";
            $iexpiry_flag = "";
            $cexpiry_flag = "";
            $sql = "select b.LEX from driver_upload a,driver b where VNO = '$VNO' and a.driver_id=b.id and doc_type='Licence' and approved=0";
            $result = DB::select(DB::raw($sql));
            if(count($result) > 0){
               $licence_approved = 0;
               $LEX = 1; 
               $LEXD = $result[0]->LEX;
               $lexpiry_flag = 0;
               if($LEXD > $today){
                $lstatus="Expires on";
               }else{
                $lexpiry_flag = 1;
                $lstatus="Expired on";
               } 
            }else{
                $sql = "select b.LEX from vehicle a,driver b where VNO = '$VNO'  and a.driver_id = b.id";
                $result = DB::select(DB::raw($sql));
                if(count($result) > 0){
                    $LEXD = $result[0]->LEX;
                }
            }

            $sql = "select b.REX from driver_upload a,vehicle b where a.VNO = '$VNO' and a.driver_id=b.driver_id and doc_type='RdWCert' and approved=0";
            $result = DB::select(DB::raw($sql));
            if(count($result) > 0){
               $roadworthy_approved = 0;
               $REX = 1; 
               $REXD = $result[0]->REX;
               $rexpiry_flag = 0;
               if($REXD > $today)
                $rstatus="Expires on";
               else
                $rexpiry_flag = 1;
                $rstatus="Expired on"; 
            }else{
                $sql = "select a.REX from vehicle a,driver b where VNO = '$VNO'  and a.driver_id = b.id";
                $result = DB::select(DB::raw($sql));
                if(count($result) > 0){
                    $REXD = $result[0]->REX;
                }
            }

            $sql = "select b.IEX from driver_upload a,vehicle b where a.VNO = '$VNO' and a.driver_id=b.driver_id and doc_type='Insurance' and approved=0";
            $result = DB::select(DB::raw($sql));
            if(count($result) > 0){
               $insurance_approved = 0;
               $IEX = 1; 
               $IEXD = $result[0]->IEX;
               $iexpiry_flag = 0;
               if($IEXD > $today)
                $istatus="Expires on";
               else
                $iexpiry_flag = 1;
                $istatus="Expired on"; 
            }else{
                $sql = "select a.IEX from vehicle a,driver b where VNO = '$VNO'  and a.driver_id = b.id";
                $result = DB::select(DB::raw($sql));
                if(count($result) > 0){
                    $IEXD = $result[0]->IEX;
                }
            }

            $sql = "select * from driver_upload a,driver b where VNO = '$VNO' and a.driver_id=b.id and doc_type='Contract' and a.status='' and approved=0";
            $result = DB::select(DB::raw($sql));
            if(count($result) > 0){
               $contract_approved = 0; 
               $CEX = 1; 
               $CEXD = $result[0]->CEX;
               $cexpiry_flag = 0;
               if($CEXD > $today)
                $cstatus="Expires on";
               else
                $cexpiry_flag = 1;
                $cstatus="Expired on"; 
               $file_name = $result[0]->file_name;
            }else{
                $sql = "select b.CEX from vehicle a,driver b where VNO = '$VNO'  and a.driver_id = b.id";
                $result = DB::select(DB::raw($sql));
                if(count($result) > 0){
                    $CEXD = $result[0]->CEX;
                }
            }

            $sql = "select a.id,a.expired_date,a.venue from driver_upload a,driver b where VNO = '$VNO' and a.driver_id=b.id and doc_type='Service' and approved=0";
            $result = DB::select(DB::raw($sql));
            if(count($result) > 0){
               $service_approved = 0;
               $SSD = $result[0]->expired_date;
               $SVE = $result[0]->venue;
            }

            $inspection_id=0;
            $sql = "select a.id,a.expired_date,a.venue from driver_upload a,driver b where VNO = '$VNO' and a.driver_id=b.id and doc_type='Inspection'  and a.status='' and approved=0";
            $result = DB::select(DB::raw($sql));
            if(count($result) > 0){
               $inspection_approved = 0;
               $inspection_id = $result[0]->id;
               $ISD = $result[0]->expired_date;
               $IVE = $result[0]->venue;
            }

            $inspection = 0;
            $sql = "select * from manager_inspect where upload_id=$inspection_id";
            $result = DB::select(DB::raw($sql));
            if(count($result) > 0){
               $inspection = 1;
            }

            $sql = "select c.LDT from handover a,vehicle b,vehicle_log c where a.driver_id=b.driver_id and a.VNO=b.VNO and a.log_id=c.id and a.accepted=0 and a.VNO='$VNO'";
            //echo $sql;die;
            $result = DB::select(DB::raw($sql));
            if(count($result) > 0){
               $assign_approved = 0;
               $LDT = $result[0]->LDT;
            }
        return view('driver.tasks',compact('VNO','VBM','DNM','DCN','DNO','LEX','REX','IEX','CEX','LEXD','REXD','IEXD','CEXD','file_name','inspection','SSD','SVE','ISD','IVE','insurance_approved','roadworthy_approved','licence_approved','contract_approved','service_approved','inspection_approved','assign_approved','LDT','cstatus','istatus','lstatus','rstatus','lexpiry_flag','rexpiry_flag','iexpiry_flag','cexpiry_flag'));
        }
    }
    
    public function agreement()
    {
        $VNO = Session::get('VNO');
        $sql = "select b.VNO,c.VBM,c.VPD,c.PPR,c.PDP,c.SDP,c.VAM,c.VPF,c.CEX,c.EPD,c.NOD,c.PAM,c.PAT from vehicle b,driver c where  b.driver_id=c.id and b.VNO='$VNO'";
        $result = DB::select(DB::raw($sql));
        if(count($result) > 0){
            $VBM = $result[0]->VBM;
            $PPR = $result[0]->PPR;
            $PDP = $result[0]->PDP;
            $SDP = $result[0]->SDP;
            $VAM = $result[0]->VAM;
            $VPF = $result[0]->VPF;
            $VPD = $result[0]->VPD;
            $CEX = $result[0]->CEX;
            $EPD = $result[0]->EPD == 1 ? "Yes" : "No";
            $NOD = $result[0]->NOD;
            $PAM = $result[0]->PAM;
            $PAT = $result[0]->PAT;

            $installments = Formulae::get_installments($PPR,$VAM);
            $last_date = Formulae::get_last_date($VPD,$installments,$VPF);
            $term = Formulae::get_term($VPD,$last_date,$VPF);

            return view('driver.agreement',compact('VNO','VBM','PPR','PDP','SDP','VAM','VPF','CEX','EPD','NOD','PAM','PAT','installments','last_date','term','VPD'));
        }
     }
     
    public function salesreport()
    {
        $VNO = Session::get('VNO');
        $DNM = "";
        $VBM = "";
        $VMK = "";
        $sql = "select a.SDT,a.RMT,d.RHN,a.SPF,a.TPF,a.RST,b.VMK,b.VMD,c.VBM,c.DNM,c.DSN,c.DCN,c.VPF from tbl137 a,vehicle b,driver c,tbl361 d where a.VNO = b.VNO and b.driver_id=c.id and b.VNO='$VNO' and a.VNO='$VNO' and a.VBM='Ride Hailing' and a.RHN = d.id and a.RST=1 order by SDT desc";
        $result = DB::select(DB::raw($sql));
        if(count($result) > 0){
            $DNM = $result[0]->DNM . " " . $result[0]->DSN;
            $VBM = $result[0]->VBM;
            $VMK = $result[0]->VMK . " " . $result[0]->VMD;
        }
        $sql = "select a.*,c.RHN from sales_audit a,tbl136 b,tbl361 c where a.RHN=c.id and b.VNO = '$VNO' and a.DCR = b.id order by ADT desc";
        $result2 = DB::select(DB::raw($sql));
        return view('driver.salesreport',compact('result','result2','VNO','DNM','VBM','VMK'));
    }

    public function buyerstatement()
    {
        $VNO = Session::get('VNO');
        $DNM = "";
        $VBM = "";
        $VMK = "";
        $PPR = "";
        $PDP = "";
        $SDP = "";
        $VPD = "";
        $sql = "select c.PPR,c.PDP,c.SDP,c.VPD,a.SDT,a.RMT,a.RNO,b.VMK,b.VMD,c.VBM,c.DNM,c.DSN,c.VPF from tbl137 a,vehicle b,driver c where a.VNO = b.VNO and b.driver_id=c.id and b.VNO='$VNO' and a.VBM='Hire Purchase' and a.RST=1 order by SDT";
        $result = DB::select(DB::raw($sql));
        if(count($result) > 0){
            $DNM = $result[0]->DNM . " " . $result[0]->DSN;
            $VBM = $result[0]->VBM;
            $VMK = $result[0]->VMK . " " . $result[0]->VMD;
            $PPR = $result[0]->PPR;
            $PDP = $result[0]->PDP;
            $SDP = $result[0]->SDP;
            $VPD = $result[0]->VPD;
        }
        return view('driver.buyerstatement',compact('result','VNO','DNM','VBM','VMK','PPR','PDP','SDP','VPD'));
    }

    public function receipts()
    {
        $VNO = Session::get('VNO');
        $DNM = "";
        $VBM = "";
        $VMK = "";
        $sql = "select a.SDT,a.RMT,a.RNO,b.VMK,b.VMD,c.VBM,c.DNM,c.DSN,c.DCN,c.VPF from tbl137 a,vehicle b,driver c where a.VNO = b.VNO and b.driver_id=c.id and b.VNO='$VNO' and a.VNO='$VNO' and a.RST = 1 order by SDT desc";
        $result = DB::select(DB::raw($sql));
        if(count($result) > 0){
            $DNM = $result[0]->DNM . " " . $result[0]->DSN;
            $VBM = $result[0]->VBM;
            $VMK = $result[0]->VMK . " " . $result[0]->VMD;
        }
        return view('driver.receipts',compact('result','VNO','DNM','VBM','VMK'));
    }

    public function uploadlicence()
    {
        $VNO = Session::get('VNO');
        $sql = "select c.DNM,c.DSN,b.driver_id from vehicle b,driver c where  b.driver_id=c.id and b.VNO='$VNO'";
        $result = DB::select(DB::raw($sql));
        if(count($result) > 0){
            $DNM = $result[0]->DNM . " " . $result[0]->DSN;
            return view('driver.uploadlicence',compact('DNM'));
        }
    } 

     public function savelicence(Request $request)
     {
        $VNO = Session::get('VNO');
        $driver_id = Session::get('driver_id');
        $LEX = $request->get('LEX'); 
        $sql = "select a.id,b.LEX from driver_upload a,driver b where VNO = '$VNO' and a.driver_id=b.id and doc_type='Licence' and approved=0";
        $result = DB::select(DB::raw($sql));
        $filepath = public_path('uploads'.DIRECTORY_SEPARATOR.'driver'.DIRECTORY_SEPARATOR);
        $upload_time = date("Y-m-d H:i:s");        
        if(count($result) > 0){
            $id = $result[0]->id;
            $DLD =  $id.'_front.'.$request->DLD->extension(); 
            move_uploaded_file($_FILES['DLD']['tmp_name'], $filepath.$DLD);
            $DLD2 =  $id.'_back.'.$request->DLD2->extension(); 
            move_uploaded_file($_FILES['DLD2']['tmp_name'], $filepath.$DLD2);
            $sql = "update driver_upload set rejected=0,file_name='$DLD',file_name2='$DLD2',doc_expiry='$LEX',upload_time='$upload_time' where id=$id";
            DB::update(DB::raw($sql));    
        }
        return redirect('/tasks')->with('success', 'Licence uploaded successfully');
     } 

     public function uploadinsurance()
     {
        $VNO = Session::get('VNO');
         $sql = "select c.DNM,c.DSN from vehicle b,driver c where  b.driver_id=c.id and b.VNO='$VNO'";
        $result = DB::select(DB::raw($sql));
        if(count($result) > 0){
            $DNM = $result[0]->DNM . " " . $result[0]->DSN;
        return view('driver.uploadinsurance',compact('DNM'));
       }
     }

     public function saveinsurance(Request $request)
     {
        $VNO = Session::get('VNO');
        $driver_id = Session::get('driver_id');
        $IEX = $request->get('IEX'); 
        $sql = "select a.id,b.LEX from driver_upload a,driver b where VNO = '$VNO' and a.driver_id=b.id and doc_type='Insurance' and approved=0";
        $result = DB::select(DB::raw($sql));
        $filepath = public_path('uploads'.DIRECTORY_SEPARATOR.'driver'.DIRECTORY_SEPARATOR);
        $upload_time = date("Y-m-d H:i:s");        
        if(count($result) > 0){
            $id = $result[0]->id;
            $VID =  $id.'.'.$request->VID->extension(); 
            move_uploaded_file($_FILES['VID']['tmp_name'], $filepath.$VID);
            $sql = "update driver_upload set rejected=0,file_name='$VID',doc_expiry='$IEX',upload_time='$upload_time' where id=$id";
            DB::update(DB::raw($sql));    
        }
        return redirect('/tasks')->with('success', 'Insurance uploaded successfully');
     } 

     public function uploadroadworthy()
     {
        $VNO = Session::get('VNO');
         $sql = "select c.DNM,c.DSN from vehicle b,driver c where  b.driver_id=c.id and b.VNO='$VNO'";
        $result = DB::select(DB::raw($sql));
        if(count($result) > 0){
            $DNM = $result[0]->DNM . " " . $result[0]->DSN;
        return view('driver.uploadroadworthy',compact('DNM'));
         }
     }

     public function saveroadworthy(Request $request)
     {
        $VNO = Session::get('VNO');
        $driver_id = Session::get('driver_id');
        $REX = $request->get('REX'); 
        $sql = "select a.id from driver_upload a,driver b where VNO = '$VNO' and a.driver_id=b.id and doc_type='RdWCert' and approved=0";
        $result = DB::select(DB::raw($sql));
        $filepath = public_path('uploads'.DIRECTORY_SEPARATOR.'driver'.DIRECTORY_SEPARATOR);
        $upload_time = date("Y-m-d H:i:s");        
        if(count($result) > 0){
            $id = $result[0]->id;
            $VRD =  $id.'.'.$request->VRD->extension(); 
            move_uploaded_file($_FILES['VRD']['tmp_name'], $filepath.$VRD);
            $sql = "update driver_upload set rejected=0,file_name='$VRD',doc_expiry='$REX',upload_time='$upload_time' where id=$id";
            DB::update(DB::raw($sql));    
            DB::update(DB::raw($sql));  
        }
        return redirect('/tasks')->with('success', 'Roadworthy Certificate uploaded successfully');
     } 

     public function contract()
     {
        $VNO = Session::get('VNO');
        $sql = "SELECT a.*,b.DCN,b.DNM,b.DSN FROM driver_upload a,driver b where a.driver_id=b.id and VNO = '$VNO' and doc_type='Contract' and approved=0";
        $valid = DB::select(DB::raw($sql));
        if(count($valid) > 0){
            $VNO = $valid[0]->VNO;
            $DNM = $valid[0]->DNM." ".$valid[0]->DSN;
            $DCN = $valid[0]->DCN;
            $file_name = $valid[0]->file_name;
            return view('driver.contract',compact('file_name','DNM'));
        }
     }

     public function reject_contract(){
        $VNO = Session::get('VNO');
        $driver_id = Session::get('driver_id');
        $upload_id = 0;
        $sql = "select * from driver_upload where VNO = '$VNO' and driver_id=$driver_id and doc_type='Contract' and approved=0";
        $result = DB::select(DB::raw($sql));
        if(count($result) > 0){
            $upload_id = $result[0]->id;
            $sql = "update driver_upload set status = 'Rejected' where id = $upload_id";
            DB::update(DB::raw($sql)); 
            return redirect('/myaccount')->with('success', 'Rejected Successfully');
        }
     }

     public function reject_inspection(){
        $VNO = Session::get('VNO');
        $driver_id = Session::get('driver_id');
        $upload_id = 0;
        $sql = "select * from driver_upload where VNO = '$VNO' and driver_id=$driver_id and doc_type='Inspection' and approved=0";
        $result = DB::select(DB::raw($sql));
        if(count($result) > 0){
            $upload_id = $result[0]->id;
            $sql = "update driver_upload set status = 'Rejected' where id = $upload_id";
            DB::update(DB::raw($sql)); 
            return redirect('/myaccount')->with('success', 'Rejected Successfully');
        }
     }

     public function acceptcontract(Request $request)
     {
        $VNO = Session::get('VNO');
        $driver_id = Session::get('driver_id');
        $acceptance_code = trim($request->get("acceptance_code2"));
        $sql = "select * from driver_upload where VNO = '$VNO' and driver_id=$driver_id and doc_type='Contract' and approved=0";
        $result = DB::select(DB::raw($sql));
        if(count($result) > 0){
            $upload_id = $result[0]->id;
            $file_name = $result[0]->file_name;
            $doc_expiry = $result[0]->doc_expiry;
            if($acceptance_code == $result[0]->acceptance_code){
                $temp = explode(".",$file_name);
                $extension = $temp[1];
                $target_filename = $driver_id . "." . $extension;
                $source = public_path().DIRECTORY_SEPARATOR."uploads".DIRECTORY_SEPARATOR."driver".DIRECTORY_SEPARATOR.$file_name;
                $target = public_path().DIRECTORY_SEPARATOR."uploads".DIRECTORY_SEPARATOR."VCC".DIRECTORY_SEPARATOR.$target_filename;
                copy($source,$target);
                $sql = "update driver_upload set contract_accepted = 1,approved=1 where id = $upload_id";
                DB::update(DB::raw($sql)); 
                $sql = "update driver set CEX='$doc_expiry',VCC='$target_filename' where id=$driver_id";
                DB::update($sql);
                return redirect('/tasks')->with('success', 'You have successfully accepted the contract');
            }else{
                return redirect('/contract')->with('error', 'Invalid Acceptence Code');
            }
        }
    }
     
     public function reject_handover($id){
        $VNO = "";
        $sql = "select * from handover where id=$id";
        $result = DB::select(DB::raw($sql));
        if(count($result) > 0){
            $VNO = $result[0]->VNO;
        }
        $sql = "update vehicle set  status='',driver_id=NULL,handover_id = 0  where VNO = '$VNO'";
        DB::update($sql);
        $sql = "delete from handover where id=$id";
        DB::delete(DB::raw($sql));
        return redirect('/myaccount')->with('success', 'Rejected Successfully');
     }

     public function vehiclehandover()
     {
        $VNO = Session::get('VNO');
        $driver_id = Session::get('driver_id');
        $sql = "SELECT a.*,b.DNM,b.DSN,b.VCC,c.chassis_no,c.IEX,c.REX FROM handover a,driver b,vehicle c where a.driver_id=b.id and a.VNO = '$VNO' and a.driver_id=$driver_id and accepted=0 and c.handover_id=a.id";
        $result = DB::select(DB::raw($sql));
        if(count($result) > 0){
            $DNM = $result[0]->DNM." ".$result[0]->DSN;
            $VCC = $result[0]->VCC;
            $VNO = $result[0]->VNO;
            $chassis_no = $result[0]->chassis_no;
            $IEX = $result[0]->IEX;
            $REX = $result[0]->REX;
            $handover_id = $result[0]->id;
        return view('driver.vehiclehandover',compact('result','VCC','DNM','handover_id','VNO','chassis_no','IEX','REX')); 
        }
     }

     public function confirm_handover(Request $request){
        $VNO = Session::get('VNO');
        $driver_id = Session::get('driver_id');
        $acceptance_code = trim($request->get("acceptance_code"));
        $sql = "select * from handover where VNO = '$VNO' and driver_id=$driver_id and accepted=0";
        $result = DB::select(DB::raw($sql));
        if(count($result) > 0){
            $handover_id = $result[0]->id;
            $accepted_date = date("Y-m-d H:i:s");
            if($acceptance_code == $result[0]->acceptance_code){
                $sql = "update vehicle set status='assigned' where VNO='$VNO'";
                DB::update($sql);
                $sql = "update handover set accepted=1,accepted_date='$accepted_date' where id=$handover_id";
                DB::update($sql);
                self::save_pdf($handover_id);
                return redirect('/tasks')->with('success', 'You have successfully accepted the contract');
            }else{
                return redirect('/vehiclehandover')->with('error', 'Invalid Acceptence Code');
            }
        }
     }

      private function save_pdf($handover_id){
        $sql = "select a.*,b.chassis_no,b.IEX,b.REX,c.DNM,c.DSN from handover a,vehicle b,driver c where a.VNO=b.VNO and b.driver_id=c.id and a.id ='$handover_id'";
        $result = DB::select(DB::raw($sql));
        $pdf = PDF::loadView('handoverpdf', compact('result'));
        $pdf->save("uploads".DIRECTORY_SEPARATOR."handover".DIRECTORY_SEPARATOR.$handover_id.".pdf");
    }

    public function handoverpdf(){
        return view('handoverpdf');
    }

     public function accept_handover(Request $request)
     {
        $VNO = Session::get('VNO');
        $driver_id = Session::get('driver_id');
        $sql = "select a.id,b.DCN,b.DNM,b.DSN from handover a,driver b where VNO = '$VNO' and driver_id=$driver_id and a.driver_id=b.id and accepted=0";
        $result = DB::select(DB::raw($sql));
        if(count($result) > 0){
            $acceptance_code = rand(1001,9999);
            $handover_id = $result[0]->id;
            $DCN = $result[0]->DCN;
            $DNM = $result[0]->DNM." ".$result[0]->DSN;
            $id = $result[0]->id;
            $sql = "update handover set acceptance_code='$acceptance_code' where id=$handover_id";
            DB::update(DB::raw($sql));  
            $msg = "Hi $DNM, Your fleetops contract acceptance code is $acceptance_code";
            SMSFleetops::send($DCN,$msg);
            $DAT = date("Y-m-d");
            $TIM = date("H:i:s");
            $CTX = "Assign Vehicle Acceptance Code";
            $sql = "insert into sms_log (PHN,MSG,DAT,TIM,CTX,NAM) values ('$DCN','$msg','$DAT','$TIM','$CTX','$DNM')";
            DB::insert($sql);
            $response['message'] = "success";
            echo json_encode($response);
        }
     }

     public function acceptance_code()
     {
        $VNO = Session::get('VNO');
        $driver_id = Session::get('driver_id');
        $sql = "select a.file_name,a.id,b.DCN,b.DNM,b.DSN from driver_upload a,driver b where VNO = '$VNO' and a.driver_id=b.id and doc_type='Contract' and approved=0";
        $result = DB::select(DB::raw($sql));
        if(count($result) > 0){
            $acceptance_code = rand(1001,9999);
            $DCN = $result[0]->DCN;
            $file_name = $result[0]->file_name;
            $DNM = $result[0]->DNM." ".$result[0]->DSN;
            $id = $result[0]->id;
            $sql = "update driver_upload set acceptance_code='$acceptance_code' where id=$id";
            DB::update(DB::raw($sql));  
            $msg = "Hi $DNM, Your fleetops contract acceptance code is $acceptance_code";
            SMSFleetops::send($DCN,$msg);
            $DAT = date("Y-m-d");
            $TIM = date("H:i:s");
            $CTX = "Acceptance Code";
            $sql = "insert into sms_log (PHN,MSG,DAT,TIM,CTX,NAM) values ('$DCN','$msg','$DAT','$TIM','$CTX','$DNM')";
            DB::insert($sql);
            $response['message'] = "success";
            echo json_encode($response);
        } 
    }

    public function accept_code(Request $request)
     {
        $VNO = Session::get('VNO');
        $driver_id = Session::get('driver_id');
        $sql = "select a.id,b.DCN,b.DNM,b.DSN from driver_upload a,driver b where VNO = '$VNO' and a.driver_id=b.id and doc_type='Inspection' and approved=0";
        $result = DB::select(DB::raw($sql));
        if(count($result) > 0){
            $acceptance_code = rand(1001,9999);
            $DCN = $result[0]->DCN;
            $DNM = $result[0]->DNM." ".$result[0]->DSN;
            $id = $result[0]->id;

            //fixit
            $sql = "update driver_upload set acceptance_code='$acceptance_code' where id=$id";
            DB::update(DB::raw($sql));  
            $msg = "Hi $DNM, Your fleetops Inspection acceptance code is $acceptance_code";
            SMSFleetops::send($DCN,$msg);
            $DAT = date("Y-m-d");
            $TIM = date("H:i:s");
            $CTX = "Acceptance Code";
            $sql = "insert into sms_log (PHN,MSG,DAT,TIM,CTX,NAM) values ('$DCN','$msg','$DAT','$TIM','$CTX','$DNM')";
            DB::insert($sql);
            $response['message'] = "success";
            echo json_encode($response);
        } 
    }

    public function inspect()
     {
        $images = array();
        $VNO = Session::get('VNO');
        $sql = " SELECT a. *,b.driver_id,b.VNO,c.DNM,c.DSN from manager_inspect a,driver_upload b,driver c where a.upload_id=b.id and b.driver_id=c.id and VNO ='$VNO' and approved=0";
        $inspect = DB::select(DB::raw($sql));
        $sql = " SELECT a.* from manager_inspect_photo a,driver_upload b where a.upload_id=b.id and VNO ='$VNO'";
        $images = DB::select(DB::raw($sql));
        if(count($inspect) > 0){
            $VNO = $inspect[0]->VNO;
            $DNM = $inspect[0]->DNM." ".$inspect[0]->DSN;
            return view('driver.inspect',compact('images','inspect','DNM','VNO'));
        }
     }

    public function acceptinspection(Request $request)
     {
        $VNO = Session::get('VNO');
        $driver_id = Session::get('driver_id');
        $acceptance_code = trim($request->get("acceptance_code"));
        $sql = "select b.id as VID,a.id,acceptance_code from driver_upload a,vehicle b where a.VNO=b.VNO and a.VNO = '$VNO' and doc_type='Inspection' and approved=0";
        $result = DB::select(DB::raw($sql));
        if(count($result) > 0){
            $id = $result[0]->id;
            $VID = $result[0]->VID;
            if($acceptance_code == $result[0]->acceptance_code){
                $milsql="update mileage set mileage = 0 where VNO='$VNO' and context='inspection'";
                DB::update(DB::raw($milsql));
                $sql2 = "select ISD,ISM from manager_inspect where upload_id = $id";
                $result2 = DB::select(DB::raw($sql2));
                $ISD = $result2[0]->ISD;
                $ISM = $result2[0]->ISM;
                $sql = "update vehicle_inspect set ISD = '$ISD',ISM = $ISM where VID = $VID";
                DB::update(DB::raw($sql));
                $sql = "update driver_upload set contract_accepted = 1,approved=1 where id = $id";
                DB::update(DB::raw($sql)); 
                return redirect('/tasks')->with('success', 'You have successfully accepted the Inspection');
            }else{
                return redirect('/inspect')->with('error', 'Invalid Acceptence Code');
            }
        }
    }

    public function uploadservice()
    {
        $VNO = Session::get('VNO');
        $sql = "SELECT a.*,b.DNM,b.DSN FROM vehicle a,driver b where a.driver_id=b.id and VNO = '$VNO' and VTV=1";
        $valid = DB::select(DB::raw($sql));
        if(count($valid) > 0){
            $DNM = $valid[0]->DNM." ".$valid[0]->DSN;
            return view('driver.uploadservice',compact('DNM'));
       }
    }

    public function saveservicedriver(Request $request)
    {
        $VNO = Session::get('VNO');
        $driver_id = Session::get('driver_id');
        $current_mileage = $request->get('current_mileage');
        $sql = "select a.id from driver_upload a,driver b where VNO = '$VNO' and a.driver_id=b.id and doc_type='Service' and approved=0";
        $result = DB::select(DB::raw($sql));
        $filepath = public_path('uploads'.DIRECTORY_SEPARATOR.'driver'.DIRECTORY_SEPARATOR);
        $upload_time = date("Y-m-d H:i:s");    
        $SER = "";  
        if(count($result) > 0){
            $id = $result[0]->id;
            if(trim($_FILES['SER']['tmp_name']) != ""){
                $SER =  $id.'.'.$request->SER->extension(); 
                move_uploaded_file($_FILES['SER']['tmp_name'], $filepath.$SER);
            }
           
            $sql = "update driver_upload set file_name='$SER',current_mileage='$current_mileage',upload_time='$upload_time' where id=$id";
            DB::update(DB::raw($sql));
                
        }
        return redirect('/tasks')->with('success', 'Service details updated successfully');
     } 

    public function resend_otp(Request $request)
    {
        $VNO = Session::get('VNO');
        $sql = "SELECT a.*,b.DCN,b.DNM,b.DSN FROM vehicle a,driver b where a.driver_id=b.id and VNO = '$VNO' and VTV=1";
        $valid = DB::select(DB::raw($sql));
        if(count($valid) > 0){
            $VNO = $valid[0]->VNO;
            $driver_id = $valid[0]->driver_id;
            $DCN = $valid[0]->DCN;
            $DNM = $valid[0]->DNM." ".$valid[0]->DSN;
            $login_time = date("Y-m-d H:i:s");
            $otp = rand(1001,9999);
            $msg = "Your fleetops account login otp is ".$otp;
            $sql = "insert into driver_login (VNO,driver_id,login_time,otp) values ('$VNO','$driver_id','$login_time','$otp')";
            DB::insert($sql);
            SMSFleetops::send($DCN,$msg);
            $DAT = date("Y-m-d");
            $TIM = date("H:i:s");
            $CTX = "OTP";
            $sql = "insert into sms_log (PHN,MSG,DAT,TIM,CTX,NAM) values ('$DCN','$msg','$DAT','$TIM','$CTX','$DNM')";
            DB::insert($sql);
            $response = array();
            $response['message'] = "success";
            return response()->json($response);
        } 
    }

    public function drivervnovalid(Request $request)
    {
        $penalty = 0;
        $VNO = trim($request->get("VNO"));
        $sql = "select * from tbl136 where DECL=0 and VNO='$VNO' and DNW=1";
        $result = DB::select(DB::raw($sql));
        if(count($result) > 0){
            $DCR = $result[0]->id;
            return redirect("/balance/".$DCR);
        }
        $VNO = str_replace(' ', '', $VNO);        
        $VNO = str_replace('-', '', $VNO);        
        $DCN = trim($request->get("DCN"));
        //select * from vehicle where replace(VNO, '-', '') = 'GN712217';
        $sql = "SELECT a.*,b.VBM,b.DCN,b.VAM,b.VPF FROM vehicle a,driver b where a.driver_id=b.id and  replace(a.VNO, '-', '') = '$VNO' and a.VTV=1";
        $vehicle = DB::select(DB::raw($sql));
        if(count($vehicle) > 0){
            $vehicle = $vehicle[0];
            $vehicle->DCN = $DCN; 
            $driver_id = $vehicle->driver_id;
            if($vehicle->VBM == "Ride Hailing"){
                $DCR = 0; 
                $sql = "select * from tbl136 where replace(VNO, '-', '') = '$VNO' and DECL=0";
                $result = DB::select(DB::raw($sql));
                if(count($result) > 0){
                    $DCR = $result[0]->id;
                }
                $ADT = 0;
                $sql = "select * from sales_audit where DCR=$DCR";
                $result = DB::select(DB::raw($sql));
                if(count($result) > 0){
                    $ADT = 1;
                }
                if($ADT == 1){
                    return redirect("/balance/".$DCR);
                }else{
                    $rhplatforms = rhplatform::all();
                    $sql = "SELECT * FROM tbl361 where id <> 1 and id in (select PLF from driver_platform where driver_id = $driver_id)";
                    $rhplatforms = DB::select(DB::raw($sql));
                    return view('driver.driverrhsales', compact('rhplatforms','vehicle'));
                }
            }else{
                if($vehicle->VBM == "Hire Purchase" || $vehicle->VBM == "Rental"){
                    $DCR = 0; 
                    $sql = "select * from tbl136 where replace(VNO, '-', '') = '$VNO' and DECL=0";
                    $result = DB::select(DB::raw($sql));
                    if(count($result) > 0){
                        $vehicle->QTY = 1;
                        $vehicle->TOT = $vehicle->VAM;
                        $DCR = $result[0]->id;
                    }else{
                        return view('driver.nopending');
                    }
                    $penalty = Formulae::get_penalty($VNO);
                    $vehicle->penalty = $penalty;
                    $sql = "select SSA from sales_rental where DCR = $DCR";
                    $result = DB::select(DB::raw($sql));
                    $vehicle->VAM = 0;
                    $vehicle->QTY = 0;
                    $vehicle->TOT = 0;
                    if(count($result) > 0){
                        foreach($result as $res){
                            $vehicle->VAM = $res->SSA;
                            $vehicle->TOT = $vehicle->TOT + $res->SSA;
                            $vehicle->QTY = $vehicle->QTY + 1;
                        }
                    }
                    $vehicle->INS = $vehicle->TOT;
                    $vehicle->SSA = $vehicle->TOT + $vehicle->penalty;
                } 
                return view('driver.driverrental',compact('vehicle'));
            }
        }else{
			return redirect('/drivervnoerror')->with('error', 'Vehicle not found');
        }
    }

    public function driverrental()
    {
        return view('driver.driverrental');
    }

    public function driverrhsales()
    {
        return view('driver.driverrhsales');
    }

    public function drivervnoerror()
    {
        return view('driver.drivervnoerror');
    }

    public function driverhelp($VNO,$DCN)
    {
        $sales = array();
        $sales['VNO'] = $VNO;
        $sales['DCN'] = $DCN;
        return view('driver.driverhelp',compact('sales'));
    }

    public function driverhelp1($VNO,$DCN)
    {
        $sales = array();
        $sales['VNO'] = $VNO;
        $sales['DCN'] = $DCN;
        return view('driver.driverhelp1',compact('sales'));
    }

    public function driverhelp2($VNO,$DCN)
    {
        $sales = array();
        $sales['VNO'] = $VNO;
        $sales['DCN'] = $DCN;
        $DCR = 0;
        $sql = "select * from tbl136 where DECL=0 and VNO='$VNO'";
        $result = DB::select(DB::raw($sql));
        if(count($result) <= 0){
           return view('driver.nopending'); 
        }else{
            $DCR = $result[0]->id;
        }

        $sql = "update tbl136 set CRS=1 where id=$DCR";
        DB::update(DB::raw($sql));

        $PLF = 0;
        $sql=" select c.PLF from vehicle a,driver b,driver_platform c where a.driver_id=b.id and b.id=c.driver_id and a.VNO='$VNO'";
        $platform = DB::select(DB::raw($sql));
        if(count($platform) > 0){
            $PLF = $platform[0]->PLF;
        }
        $SDT = date('Y-m-d');
        $SDT_dMY = date('d-M-Y');
        $expected_sales = Formulae::EXPS2($DCR);
        $sales['SDT'] = $SDT;
        $sales['PLF'] = $PLF;
        $sales['SDT_dMY'] = $SDT_dMY;
        $sales['expected_sales'] = round($expected_sales,2);
        return view('driver.driverhelp2',compact('sales'));
    }

    public function driverpay(Request $request)
    {
        $SSR = $request->SSR;
        $VBM = $request->VBM;
        $plat_id_hidden = 0;
        $earning_hidden = 0;
        $cash_hidden = 0;
        $ins_hidden = 0;
        $penalty_hidden = 0;
        $trips_hidden = 0;
        if($VBM=="Ride Hailing"){
            $plat_id_hidden = trim($request->get("plat_id_hidden"));
            $earning_hidden = trim($request->get("earning_hidden"));
            $cash_hidden = trim($request->get("cash_hidden"));
            $ins_hidden = $cash_hidden;
            $trips_hidden = trim($request->get("trips_hidden"));
        }else{
            $ins_hidden = trim($request->get("INS"));
            $penalty_hidden = trim($request->get("penalty"));
            $cash_hidden = trim($request->get("SSA"));
        }
        $options = Billbox::listPayOptions();
        $sales = array();
        $sales['VBM'] = $VBM;
        $sales['VNO'] = trim($request->get("VNO"));
        $sales['DCN'] = trim($request->get("DCN"));
        $sales['plat_id_hidden'] = $plat_id_hidden;
        $sales['earning_hidden'] = $earning_hidden;
        $sales['ins_hidden'] = $ins_hidden;
        $sales['penalty_hidden'] = $penalty_hidden;
        $sales['cash_hidden'] = round($cash_hidden,2);
        $sales['trips_hidden'] = $trips_hidden;
        $sales['SSR'] = $SSR;
        return view('driver.driverpay',compact('sales','options'));
    }

    public function driverpaysave(Request $request)
    {
        $ROI = $request->options;
        $VNO = $request->VNO;
        $VBM = $request->VBM;
        $sql = "SELECT a.CAN,b.DNM,b.DSN FROM vehicle a,driver b where a.driver_id=b.id and a.VNO='$VNO' and a.VTV=1";
        $vehicle = DB::select(DB::raw($sql));
        $cust_name = $vehicle[0]->DNM . " " . $vehicle[0]->DSN;
        $CAN = $vehicle[0]->CAN;
        $SDT = date('Y-m-d');
        $RCN = $request->RCN;
        $VNO = $request->VNO;
        $RCN = $request->DCN;
        $RHN = $request->plat_id_hidden;
        $SPF = $request->earning_hidden;
        $CPF = $request->cash_hidden;
        $penalty_hidden = $request->penalty_hidden;
        $ins_hidden = $request->ins_hidden;
        $TPF = $request->trips_hidden;
        $SSR = $request->SSR;
        $DCR = 0;
        $CRS = 0;
        $sql = "SELECT * from tbl136 where DECL=0 and VNO='$VNO'";
        $result = DB::select(DB::raw($sql));
        if(count($result) > 0){        
            $DCR = $result[0]->id;
            $CRS = $result[0]->CRS;
            $requestId = uniqid();
            $requestId = $VNO . "-" .$requestId;
            $response = Billbox::payNow($requestId,$request->cash_hidden,$request->options,$request->DCN,$cust_name);
            if($response->statusCode=="SUCCESS"){
                $TIM = date("Y-m-d H:i:s");
                $sql = "insert into tbl137 (SDT,DCR,CAN,VNO,RCN,VBM,RHN,SPF,TPF,RMT,ROI,RST,SSR,RTN,TIM) values ('$SDT','$DCR','$CAN','$VNO','$RCN','$VBM','$RHN','$SPF','$TPF','$CPF','$ROI','0','$SSR','$requestId','$TIM')";
                DB::insert($sql);

                if($penalty_hidden != 0){
                    $sql = "update tbl136 set penalized = 1 where id = $DCR";
                    DB::update($sql);
                }

                if($CRS == 1){
                    $sql2 = "select * from notification where sms_id='SMSE11'";
                    $result2 = DB::select(DB::raw($sql2));
                    if(count($result2) > 0){
                        $msg = $result2[0]->sms_text;
                        $sql3 = "select name,UZS,UCN from users where UAN='$CAN'";
                        $result3 = DB::select(DB::raw($sql3));
                        $CZN = "";
                        $UCN = "";
                        if(count($result3) > 0){
                            $CZN = $result3[0]->name." ".$result3[0]->UZS;
                            $UCN = $result3[0]->UCN;
                        }
                        $msg = str_replace("#{CZN}#",$CZN,$msg);
                        $msg = str_replace("#{DNM}#",$cust_name,$msg);
                        $msg = str_replace("#{VNO}#",$VNO,$msg);
                        //$msg = str_replace("#{EXPS}#",$CPF,$msg);
                        //$FTP = round(Formulae::FTP($DCR),2);
                        //$msg = str_replace("#{FTP}#",$FTP,$msg);
                        SMSFleetops::send($UCN,$msg);
                        $DAT = date("Y-m-d");
                        $TIM = date("H:i:s");
                        $CTX = "Client";
                        $sql = "insert into sms_log (PHN,MSG,DAT,TIM,CTX,NAM) values ('$UCN','$msg','$DAT','$TIM','$CTX','$CZN')";
                        DB::insert($sql);
                    }
                }
                return view('driver.prompt');
            }else{
                $message = $response->statusMessage;
                return view('driver.error',compact('message'));
            }
        }else{
            return view('driver.nopending');
        }
  }

    public function balance($DCR)
    {
        $VNO = "";
        $RMT = 0;
        $CPF = 0;
        $BAL = 0;
        $RHN = 0;
        $RCN = "";
        $CPF = Formulae::EXPS2($DCR);
        $sql = "select * from tbl136 where id=$DCR";
        $result = DB::select(DB::raw($sql));
        if(count($result) > 0 ){
            $VNO = $result[0]->VNO;
        }

        $sql = "select * from sales_audit where DCR=$DCR";
        $result = DB::select(DB::raw($sql));
        if(count($result) > 0 ){
            if($result[0]->CPF != "" ) $CPF = $result[0]->CPF;
        }else{
            //return redirect('/driver');
        }
        $sql = "select RHN,RMT,RCN,VNO from tbl137 where DCR=$DCR and RST=1";
        $result = DB::select(DB::raw($sql));
        if(count($result) > 0){
            foreach($result as $res){
                $RMT = $RMT + $res->RMT;
                $VNO = $res->VNO;
                $RCN = $res->RCN;
                $RHN = $res->RHN;
            }
        }
        $BAL = $CPF - $RMT;
        if($BAL <= 0) return view('driver.nopending');
        return view('driver.balance',compact('VNO','DCR','RCN','BAL','RHN'));
    }


    public function driverhelp3($VNO,$DCN)
    {
       $sales = array();
        $sales['VNO'] = $VNO;
        $sales['DCN'] = $DCN;
        
        $SDT_dMY = date('d-M-Y', strtotime("-1 days"));
        $expected_sales = Formulae::expected_sales($VNO);
        $sales['SDT'] = $SDT;
        $sales['SDT_dMY'] = $SDT_dMY;
        $sales['expected_sales'] = $expected_sales;
        return view('driver.driverhelp3',compact('sales'));
    }

    public function driverpaysuccess()
    {
        return view('driver.driverpaysuccess');
    }

//http://fleetopsgh.com/billbox?status=1&transac_id=6109608da766c&cust_ref=8723498807290116&pay_token=5e455780-9c2b-47f2-8387-a024c577263c
    public function billbox(Request $request)
    {
        $query = $request->all();
        $RST = $query['status'];
        $RTN = $query['transac_id'];
        echo $RTN."\n";
        if($RST == 0){
            $sql = "SELECT a.*,b.VBC0,b.TSM from tbl137 a,vehicle b where a.VNO=b.VNO and a.RTN = '$RTN'";
            $result = DB::select(DB::raw($sql));
            if(count($result)>0){
                $DCR = $result[0]->DCR;
                $VNO = $result[0]->VNO;
                $SDT = $result[0]->SDT;
                $VBM = $result[0]->VBM;
                $RCN = $result[0]->RCN;
                $RMT = $result[0]->RMT;
                $VBC0 = $result[0]->VBC0; 
                $TSM = $result[0]->TSM;
                echo $RTN."\n";
                $sql = "update tbl137 set RST=1 where RTN = '$RTN'";
                DB::update($sql);
                if($VBM == "Ride Hailing"){
                    $EXPS = Formulae::EXPS($SDT,$VNO);
                    echo $EXPS."<br>";
                    $sql = "SELECT sum(RMT) as TOTDEC from tbl137 where RST = 1 and DCR ='$DCR'";
                    $result = DB::select(DB::raw($sql));
                    if(count($result)>0){
                        $TOTDEC = $result[0]->TOTDEC;
                        echo $TOTDEC."<br>";
                        if($TOTDEC >= $EXPS){
                            $sql = "update tbl136 set DECL = 1 where id = '$DCR'";
                            DB::update($sql);
                            $msg = "Thank you for a successful sales declaration.Fuel consumed for the sales declared and offline trips (if any) are being measured and shall be communicated to you in a separate message.";                  
                            //SMSFleetops::send($TSM,$VBC0);
                            //echo $msg."<br>";
                            $DAT = date("Y-m-d");
                            $TIM = date("H:i:s");
                            $CTX = "Sales Declaration";
                            $sql = "insert into sms_log (PHN,MSG,DAT,TIM,CTX) values ('$RCN','$msg','$DAT','$TIM','$CTX')";
                            DB::insert($sql);
                            SMSFleetops::send($RCN,$msg);
                        }else{
                            $sql = "update tbl136 set DECL = 1 where id = '$DCR'";
                            DB::update($sql);
                            $msg="Cash Declared is Incorrect. Further to our checks, the cash collected you have accounted for is incorrect. Please send remaining cash immediately else we shall be compelled to enforce the policy. The car owner has been notified of this issue accordingly.";
                            echo $msg."<br>";
                            $DAT = date("Y-m-d");
                            $TIM = date("H:i:s");
                            $CTX = "Sales Declaration";
                            $sql = "insert into sms_log (PHN,MSG,DAT,TIM,CTX) values ('$RCN','$msg','$DAT','$TIM','$CTX')";
                            DB::insert($sql);
                            SMSFleetops::send($RCN,$msg);
                        }
                    }
                }else{
                    //SMSFleetops::send($TSM,$VBC0);
                    $msg="Thank you for a successful payment of GHC ".$RMT.".";
                    echo $msg."<br>";
                    SMSFleetops::send($RCN,$msg);
                }           
                
            }
        }

        $cust_ref = $query['cust_ref'];
        $pay_token = $query['pay_token'];
        $callback_time = date("Y-m-d H:i");
        $sql = "insert into billbox (status,transac_id,cust_ref,pay_token,callback_time) values ('$RST','$RTN','$cust_ref','$pay_token','$callback_time')";
            DB::insert($sql);
    }

    public function driverpayerror()
    {
        return view('driver.driverpayerror');
    }
    
    public function driverhelpprev1($VNO,$DCN)
    {
        $sales = array();
        $sales['VNO'] = $VNO;
        $sales['DCN'] = $DCN;
        return view('driver.driverhelpprev1',compact('sales'));
    }

    public function driverhelpprev2($VNO,$DCN)
    {
        $sales = array();
        $SDT = date('Y-m-d', strtotime("-1 days"));
        $CML = 0;
        $DCR = 0;
        $sales['VNO'] = $VNO;
        $sales['DCN'] = $DCN;
        $sql = "select * from tbl136 where DECL=0 and VNO='$VNO'";
        $result = DB::select(DB::raw($sql));
        if(count($result) > 0){
            $CML = $result[0]->CML;
            $SDT = $result[0]->DDT;
            $DCR = $result[0]->id;
        }else{
           return view('driver.nopending'); 
        }
        $NWM = Formulae::NWM();
        $EXPS = Formulae::EXPS2($DCR);
        if($CML <= $NWM){
            $sql = "update tbl136 set DECL=1,attempts=0,alarm_off=1,alarm_off_attempts=0 where id = '$DCR'";
            DB::update($sql);
            return view('driver.driverhelpprev2',compact('sales'));
        }else{
            $DCN = "";
            $DNM = "";
            $sql = "UPDATE tbl136 set DNW=1 where id=$DCR";
            DB::update(DB::raw($sql));
            $sql = "SELECT c.DNM,c.DSN,c.DCN from vehicle b,driver c where b.driver_id=c.id and b.VNO ='$VNO'";
            $result = DB::select(DB::raw($sql));
            if(count($result)>0){
                $DCN = $result[0]->DCN;
                $DNM = $result[0]->DNM." ".$result[0]->DSN;
            }
            $CPF = round(Formulae::EXPS2($DCR),2);
            $msg = "Hi ".$DNM.". Unfortunately, your claim did not work previous day was not successful. System reset failed. Please proceed to pay an amount of GHC ".$CPF." http://fleetopsgh.com/balance/".$DCR;
            $DAT = date("Y-m-d");
            $TIM = date("H:i:s");
            $CTX = "Did not work claim failure";
            $sql = "insert into sms_log (PHN,MSG,DAT,TIM,CTX,NAM) values (?,?,?,?,?,?)";
            $values = [$DCN,$msg,$DAT,$TIM,$CTX,$DNM];
            DB::insert($sql,$values);
            SMSFleetops::send($DCN,$msg);
            return view('driver.driverhelpprev3',compact('sales'));
        }
    }
    
}

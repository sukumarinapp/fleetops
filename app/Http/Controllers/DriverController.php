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
            $otp = "1234";
            $msg = "Your fleetops account login otp is ".$otp;
            $sql = "insert into driver_login (VNO,driver_id,login_time,otp) values ('$VNO','$driver_id','$login_time','$otp')";
            DB::insert($sql);
            //SMSFleetops::send($DCN,$msg);
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
        $VNO = Session::get('VNO');
        $sql = "select c.VBM,c.DNM,c.DSN,c.DCN from vehicle b,driver c where  b.driver_id=c.id and b.VNO='$VNO'";
        $result = DB::select(DB::raw($sql));
        if(count($result) > 0){
            $VBM = $result[0]->VBM;
            $DNM = $result[0]->DNM . " " . $result[0]->DSN;
            $DCN = $result[0]->DCN;
            return view('driver.myaccount',compact('VNO','VBM','DNM','DCN'));
        }
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
        $sql = "select c.VBM,c.DNM,c.DSN,c.DCN,c.DNO from vehicle b,driver c where  b.driver_id=c.id and b.VNO='$VNO'";
        $result = DB::select(DB::raw($sql));
        if(count($result) > 0){
            $VBM = $result[0]->VBM;
            $DNM = $result[0]->DNM . " " . $result[0]->DSN;
            $DCN = $result[0]->DCN;
            $DNO = $result[0]->DNO;

            $sql = "select b.LEX from driver_upload a,driver b where VNO = '$VNO' and a.driver_id=b.id and doc_type='Licence' and approved=0";
            $result = DB::select(DB::raw($sql));
            if(count($result) > 0){
               $LEX = 1; 
               $LEXD = $result[0]->LEX;
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
               $REX = 1; 
               $REXD = $result[0]->REX;
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
               $IEX = 1; 
               $IEXD = $result[0]->IEX;
            }else{
                $sql = "select a.IEX from vehicle a,driver b where VNO = '$VNO'  and a.driver_id = b.id";
                $result = DB::select(DB::raw($sql));
                if(count($result) > 0){
                    $IEXD = $result[0]->IEX;
                }
            }

            $sql = "select * from driver_upload a,driver b where VNO = '$VNO' and a.driver_id=b.id and doc_type='Contract' and approved=0";
            $result = DB::select(DB::raw($sql));
            if(count($result) > 0){
               $CEX = 1; 
               $CEXD = $result[0]->CEX;
            }else{
                $sql = "select b.CEX from vehicle a,driver b where VNO = '$VNO'  and a.driver_id = b.id";
                $result = DB::select(DB::raw($sql));
                if(count($result) > 0){
                    $CEXD = $result[0]->CEX;
                }
            }
            return view('driver.tasks',compact('VNO','VBM','DNM','DCN','DNO','LEX','REX','IEX','CEX','LEXD','REXD','IEXD','CEXD'));
        }
    }
    
    public function agreement()
    {
        $VNO = Session::get('VNO');
        $sql = "select b.VNO,c.VBM,c.PPR,c.PDP,c.SDP,c.VAM,c.VPF,c.CEX,c.EPD,c.NOD,c.PAM,c.PAT from vehicle b,driver c where  b.driver_id=c.id and b.VNO='$VNO'";
        $result = DB::select(DB::raw($sql));
        if(count($result) > 0){
            $VBM = $result[0]->VBM;
            $PPR = $result[0]->PPR;
            $PDP = $result[0]->PDP;
            $SDP = $result[0]->SDP;
            $VAM = $result[0]->VAM;
            $VPF = $result[0]->VPF;
            $CEX = $result[0]->CEX;
            $EPD = $result[0]->EPD == 1 ? "Yes" : "No";
            $NOD = $result[0]->NOD;
            $PAM = $result[0]->PAM;
            $PAT = $result[0]->PAT;
            return view('driver.agreement',compact('VNO','VBM','PPR','PDP','SDP','VAM','VPF','CEX','EPD','NOD','PAM','PAT'));
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
        $sql = "select a.* from sales_audit a,tbl136 b where b.VNO = '$VNO' and a.DCR = b.id order by ADT desc";
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
        $sql = "select c.PPR,c.PDP,c.SDP,c.VPD,a.SDT,a.RMT,a.RNO,b.VMK,b.VMD,c.VBM,c.DNM,c.DSN,c.VPF from tbl137 a,vehicle b,driver c,tbl361 d where a.VNO = b.VNO and b.driver_id=c.id and b.VNO='$VNO' and a.VBM='Hire Purchase' and a.RST=1 order by SDT";
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
            $DLD =  $id.'.'.$request->DLD->extension(); 
            move_uploaded_file($_FILES['DLD']['tmp_name'], $filepath.$DLD);
            $sql = "update driver_upload set file_name='$DLD',doc_expiry='$LEX',upload_time='$upload_time' where id=$id";
            DB::update(DB::raw($sql));    
        }else{
            $today = date("Y-m-d");
            $doc_type = "Licence";
            $approved = 0;
            $sql = "insert into driver_upload (VNO,driver_id,expired_date,doc_type,approved) values ('$VNO','$driver_id','$today','$doc_type','$approved')";
            DB::insert(DB::raw($sql));
            $id = DB::getPdo()->lastInsertId();
            $DLD =  $id.'.'.$request->DLD->extension(); 
            move_uploaded_file($_FILES['DLD']['tmp_name'], $filepath.$DLD);
            $sql = "update driver_upload set file_name='$DLD',doc_expiry='$LEX',upload_time='$upload_time' where id=$id";
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
            $sql = "update driver_upload set file_name='$VID',doc_expiry='$IEX',upload_time='$upload_time' where id=$id";
            DB::update(DB::raw($sql));    
        }else{
            $today = date("Y-m-d");
            $doc_type = "Insurance";
            $approved = 0;
            $sql = "insert into driver_upload (VNO,driver_id,expired_date,doc_type,approved) values ('$VNO','$driver_id','$today','$doc_type','$approved')";
            DB::insert(DB::raw($sql));
            $id = DB::getPdo()->lastInsertId();
            $VID =  $id.'.'.$request->VID->extension(); 
            move_uploaded_file($_FILES['VID']['tmp_name'], $filepath.$VID);
            $sql = "update driver_upload set file_name='$VID',doc_expiry='$LEX',upload_time='$upload_time' where id=$id";
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
            $sql = "update driver_upload set file_name='$VRD',doc_expiry='$REX',upload_time='$upload_time' where id=$id";
            DB::update(DB::raw($sql));    
        }else{
            $today = date("Y-m-d");
            $doc_type = "RdWCert";
            $approved = 0;
            $sql = "insert into driver_upload (VNO,driver_id,expired_date,doc_type,approved) values ('$VNO','$driver_id','$today','$doc_type','$approved')";
            DB::insert(DB::raw($sql));
            $id = DB::getPdo()->lastInsertId();
            $VRD =  $id.'.'.$request->VRD->extension(); 
            move_uploaded_file($_FILES['VRD']['tmp_name'], $filepath.$VRD);
            $sql = "update driver_upload set file_name='$VRD',doc_expiry='$REX',upload_time='$upload_time' where id=$id";
            DB::update(DB::raw($sql));  
        }
        return redirect('/tasks')->with('success', 'Roadworthy Certificate uploaded successfully');
     } 

     public function contract()
     {
        $VNO = Session::get('VNO');
        $sql = "SELECT a.*,b.VCC,b.DCN,b.DNM,b.DSN FROM vehicle a,driver b where a.driver_id=b.id and VNO = '$VNO' and VTV=1";
        $valid = DB::select(DB::raw($sql));
        if(count($valid) > 0){
            $VNO = $valid[0]->VNO;
            $DNM = $valid[0]->DNM." ".$valid[0]->DSN;
            $DCN = $valid[0]->DCN;
            $VCC = $valid[0]->VCC;
            return view('driver.contract',compact('VCC','DNM'));
        }
     }

     public function acceptcontract(Request $request)
     {
        $VNO = Session::get('VNO');
        $driver_id = Session::get('driver_id');
        $acceptance_code = trim($request->get("acceptance_code"));
        $sql = "select id,acceptance_code from driver_upload where VNO = '$VNO' and doc_type='Contract' and approved=0";
        $result = DB::select(DB::raw($sql));
        if(count($result) > 0){
            $id = $result[0]->id;
            if($acceptance_code == $result[0]->acceptance_code){
                $sql = "update driver_upload set contract_accepted = 1 where id = $id";
                DB::update(DB::raw($sql)); 
                return redirect('/tasks')->with('success', 'You have successfully accepted the contract');
            }else{
                return redirect('/contract')->with('error', 'Invalid Acceptence Code');
            }
        }
    }
     

     public function acceptance_code()
     {
        $VNO = Session::get('VNO');
        $driver_id = Session::get('driver_id');
        $sql = "select a.id,b.DCN,b.DNM,b.DSN from driver_upload a,driver b where VNO = '$VNO' and a.driver_id=b.id and doc_type='Contract' and approved=0";
        $result = DB::select(DB::raw($sql));
        if(count($result) > 0){
            $acceptance_code = rand(1001,9999);
            $DCN = $result[0]->DCN;
            $DNM = $result[0]->DNM." ".$result[0]->DSN;
            $id = $result[0]->id;
            $sql = "update driver_upload set acceptance_code='$acceptance_code' where id=$id";
            DB::update(DB::raw($sql));  
            $msg = "Hi $DNM, Your flletops contract acceptance code is $acceptance_code";
            SMSFleetops::send($DCN,$msg);
            $DAT = date("Y-m-d");
            $TIM = date("H:i:s");
            $CTX = "Acceptance Code";
            $sql = "insert into sms_log (PHN,MSG,DAT,TIM,CTX,NAM) values ('$DCN','$msg','$DAT','$TIM','$CTX','$DNM')";
            DB::insert($sql);
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

    public function saveservice(Request $request)
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
        }else{
            $doc_type = "Service";
            $approved = 0;
            $sql = "insert into driver_upload (VNO,driver_id,doc_type,current_mileage,approved) values ('$VNO','$driver_id','$doc_type','$current_mileage','$approved')";
            DB::insert(DB::raw($sql));
            $id = DB::getPdo()->lastInsertId();
            if(trim($_FILES['SER']['tmp_name']) != ""){
                $SER =  $id.'.'.$request->SER->extension(); 
                move_uploaded_file($_FILES['SER']['tmp_name'], $filepath.$SER);
            }
            $sql = "update driver_upload set file_name='$SER',current_mileage='$current_mileage',upload_time='$upload_time' where id=$id";
            DB::update(DB::raw($sql));  
        }
        return redirect('/tasks')->with('success', 'Service details updated successfully');
     } 

    public function resend_otp($VNO)
    {
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
        } 
    }

    public function drivervnovalid(Request $request)
    {
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
        $trips_hidden = 0;
        if($VBM=="Ride Hailing"){
            $plat_id_hidden = trim($request->get("plat_id_hidden"));
            $earning_hidden = trim($request->get("earning_hidden"));
            $cash_hidden = trim($request->get("cash_hidden"));
            $trips_hidden = trim($request->get("trips_hidden"));
        }else{
            $cash_hidden = trim($request->get("SSA"));
        }
        $options = Billbox::listPayOptions();
        $sales = array();
        $sales['VBM'] = $VBM;
        $sales['VNO'] = trim($request->get("VNO"));
        $sales['DCN'] = trim($request->get("DCN"));
        $sales['plat_id_hidden'] = $plat_id_hidden;
        $sales['earning_hidden'] = $earning_hidden;
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

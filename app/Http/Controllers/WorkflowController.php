<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Auth;
use DB;
use App\SMSFleetops;
use Illuminate\Support\Facades\Hash;
use App\Formulae;

class WorkflowController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except('fuel_consumed');
    }

    private function check_access($BP){
        if($BP == "BPJ2"){
            if(Auth::user()->usertype=="Admin" || (Auth::user()->BPJ==1 && Auth::user()->BPJ2==1)){
            }else{
                echo "Access Denied";
                die;
            }            
        }
        if($BP == "BPJ1"){
            if(Auth::user()->usertype=="Admin" || (Auth::user()->BPJ==1 && Auth::user()->BPJ1==1)){
            }else{
                echo "Access Denied";
                die;
            }            
        }
    }

    public function index()
    {
        $this->check_access("BPJ2");
        $sql = "select d.id as vid,a.*,b.DNM,b.DSN from tbl136 a,driver b,vehicle d where a.driver_id=b.id and a.VNO=d.VNO and a.DECL=0 and a.DDT = (select max(DDT) from tbl136 c where a.VNO=c.VNO and DECL=0 group by VNO) order by DDT";
        $vehicles = DB::select(DB::raw($sql));
        foreach($vehicles as $vehicle){
            $DCR = $vehicle->id;
            $RMT = 0;
            $sql2 = "select sum(RMT) as PAID from tbl137 where DCR=$DCR and RST=1";
            $paid = DB::select(DB::raw($sql2));
            if(count($paid) > 0){
                if($paid[0]->PAID != "" ) $RMT = $paid[0]->PAID;
            }
            $vehicle->ADT = 0;
            $sql2 = "select * from sales_audit where DCR=$DCR";
            $result = DB::select(DB::raw($sql2));
            if(count($result) > 0){
                $vehicle->ADT = 1;
            }
            $CCEI = round(Formulae::CCEI2($DCR),2);
            $vehicle->RMT = $RMT;
            $vehicle->CCEI = $CCEI;
        }
        $sql = "select a.*,b.DNM,b.DSN from driver_upload a,driver b where a.driver_id=b.id and approved=0";
        $inspect = DB::select(DB::raw($sql));
        return view('workflow',compact('vehicles','inspect'));
    }

    public function workflowlog($from,$to)
    {
        $this->check_access("BPJ2");
        $title = 'Workflow Log';
        $sql = "select * from tbl140 where WST >= '$from' and WST <='$to'";
        $workflow = DB::select(DB::raw($sql));
        return view('workflowlog',compact('workflow','title','from','to'));
    }

    public function vehiclelog($from,$to)
    {
        $sql = "select a.*,b.DNM,b.DSN from vehicle_log a,driver b where LDT >= '$from' and LDT <='$to' and a.DID=b.id order by TIM desc";
        $title = 'Vehicle Assign Log';
        $vehiclelog = DB::select(DB::raw($sql));
        return view('vehiclelog',compact('vehiclelog','title','from','to'));
    }
    public function rhreport($from,$to)
    {
        $sql = "select a.*,b.DCN,b.id as driver_id from tbl136 a,driver b where a.driver_id=b.id and a.VBM = 'Ride Hailing' and DDT >='$from' and DDT <='$to' order by DDT desc";
        $title = 'RH Daily Report';
        $rhreport = DB::select(DB::raw($sql));
        $total_exps = 0;
        $total_ccei = 0;
        $total_sal = 0;
        $total_cpf = 0;
        $total_cml = 0;
        $total_chr = 0;
        $rh_sold = 0 ;
        foreach($rhreport as $sale){
            $rh_sold++;
            $total_cml = $total_cml + $sale->CML;
            $total_chr = $total_chr + $sale->CHR;
            $DCR = $sale->id;
            $VNO = $sale->VNO;
            $driver_id = $sale->driver_id;
            $sql2 = "select RHF from tbl361 a,driver_platform b where a.id=b.PLF and b.driver_id=$driver_id";
            $service = DB::select(DB::raw($sql2));
            $RHF = 0;
            if(count($service) > 0){
                $RHF = $service[0]->RHF;
            }
            $sql = "select max(SPF) as SPF2,sum(RMT) as CPF2,max(TPF) as TPF2 from tbl137 where DCR=$DCR and SSR='Driver' and RST=1";
            $tbl137 = DB::select(DB::raw($sql));
            if(count($tbl137) > 0 && $tbl137[0]->CPF2 != "" && $tbl137[0]->CPF2 != null){
                $sale->EXPS = round(Formulae::EXPS2($DCR),2);
                $sale->EXPS_EARNING = $sale->EXPS * (1 - $RHF/100);
                $sale->CCEI = round(Formulae::CCEI2($DCR),2);
                $total_exps = $total_exps + $sale->EXPS_EARNING;
                $total_ccei = $total_ccei + $sale->CCEI;
                $sale->FTP = round(Formulae::FTP($DCR),2);
                $sale->CWI = round(Formulae::CWI($DCR),2);
                $sale->SPF = $tbl137[0]->SPF2;
                $sale->CPF = $tbl137[0]->CPF2;
                $sale->TPF = $tbl137[0]->TPF2;
                $total_sal = $total_sal + $sale->SPF;
                $total_cpf = $total_cpf + $sale->CPF;
            }else{
                $sale->EXPS = "";
                $sale->EXPS_EARNING = "";
                $sale->CCEI = "";
                $sale->FTP = round(Formulae::FTP($DCR),2);
                $sale->CWI = round(Formulae::CWI($DCR),2);
                $sale->SPF = "";
                $sale->CPF = "";
                $sale->TPF = "";
            }

            $sql = "select * from tbl136 where id=$DCR and DNW=1";
            $tbl136 = DB::select(DB::raw($sql));
            if(count($tbl136) > 0){
                $sale->EXPS = round(Formulae::EXPS2($DCR),2);
                $sale->CCEI = "";
                $sale->FTP = round(Formulae::FTP($DCR),2);
                $sale->CWI = round(Formulae::CWI($DCR),2);
            }

            $sql = "select * from tbl136 where id=$DCR and CRS=1";
            $tbl136 = DB::select(DB::raw($sql));
            if(count($tbl136) > 0){
                $sale->EXPS = round(Formulae::EXPS2($DCR),2);
                $sale->CCEI = "";
                $sale->FTP = round(Formulae::FTP($DCR),2);
                $sale->CWI = round(Formulae::CWI($DCR),2);
            }
        }
        return view('rhreport',compact('rhreport','title','from','to','total_exps','total_ccei','total_sal','total_cpf','rh_sold','total_cml','total_chr'));
    }

    public function sales($from,$to)
    {
        $this->check_access("BPJ2");
        $title = 'Pending Sales (RT/HP)';
        $sql="select a.VBM,b.*,c.DNM,c.DSN from tbl136 a,sales_rental b,driver c where a.id=b.DCR and a.driver_id=c.id and b.SDT >='$from' and b.SDT <='$to' and DECL=0 and a.id not in (select DCR from tbl137 where RST=1) order by b.SDT desc";
        $sales = DB::select(DB::raw($sql));
        $total_sale = 0;
        $rt_sale = 0;
        $hp_sale = 0;
        $rt_sold = 0;
        $hp_sold = 0;
        foreach($sales as $sale){
            $total_sale = $total_sale + $sale->SSA;
            if($sale->VBM == "Rental"){
                $rt_sale = $rt_sale + $sale->SSA;
                $rt_sold++;
            }elseif($sale->VBM == "Hire Purchase"){
                $hp_sale = $hp_sale + $sale->SSA;
                $hp_sold++;
            }
        }
        return view('sales',compact('sales','title','from','to','total_sale','rt_sale','hp_sale','rt_sold','hp_sold'));
    }

    public function collection($from,$to)
    {
        $this->check_access("BPJ2");
        $title = 'General Sales Ledger';
        $sql = "select * from tbl137 where SDT >='$from' and SDT <='$to' order by SDT desc";
        $sales = DB::select(DB::raw($sql));
        $total_sale = 0;
        $rt_sale = 0;
        $rh_sale = 0;
        $hp_sale = 0;
        $rt_sold = 0;
        $rh_sold = 0;
        $hp_sold = 0;
        foreach($sales as $sale){
            if($sale->RST == 1) $total_sale = $total_sale + $sale->RMT;
            if($sale->VBM == "Ride Hailing" && $sale->RST == 1){
                $rh_sale = $rh_sale + $sale->RMT;
                $rh_sold++;
            }elseif($sale->VBM == "Rental" && $sale->RST == 1){
                $rt_sale = $rt_sale + $sale->RMT;
                $rt_sold++;
            }elseif($sale->VBM == "Hire Purchase" && $sale->RST == 1){
                $hp_sale = $hp_sale + $sale->RMT;
                $hp_sold++;
            }
        }
        return view('collection',compact('sales','title','from','to','total_sale','rt_sale','rh_sale','hp_sale','rt_sold','rh_sold','hp_sold'));
    }

    public function notificationslog($from,$to)
    {
        $this->check_access("BPJ2");
        $title = 'Notification Log';
        $sql = "select * from sms_log where DAT >='$from' and DAT <='$to' order by DAT desc";
        $logs = DB::select(DB::raw($sql));
        return view('notificationslog',compact('logs','title','from','to'));
    }

     public function telematicslog($from,$to)
    {
        //$from = date("Y-m-d", strtotime($from.' +1 day'));
        //$to = date("Y-m-d", strtotime($to.' +1 day'));
        $this->check_access("BPJ2");
        $title = 'Daily Telematics Log';
        $sql = "select c.DDT,c.CML,c.CHR,c.min_speed,c.max_speed,c.work_start,c.work_end,c.odometer,c.engine_idling,c.speeding,c.fuel_consumed,a.*,b.VBM,b.VPF,b.WDY,b.MDY,b.VPD,b.VAM from vehicle a,driver b,bgp1am c where a.VNO = c.VNO and c.DDT >= '$from' and c.DDT <= '$to' and a.driver_id=b.id";
        $vehicles = DB::select(DB::raw($sql));
        foreach($vehicles as $vehicle){
            //$vehicle->DDT = date("Y-m-d", strtotime($vehicle->DDT.' -1 days'));
            if($vehicle->VBM == "Rental"){
                $vehicle->VBM = "RT";
            }else if($vehicle->VBM == "Hire Purchase"){
                $vehicle->VBM = "HP";
            }else if($vehicle->VBM == "Ride Hailing"){
                $vehicle->VBM = "RH";
            }
        }
        //$from = date("Y-m-d", strtotime($from.' -1 days'));
        //$to = date("Y-m-d", strtotime($to.' -1 days'));
        return view('telematicslog',compact('vehicles','title','from','to'));
    }


    public function override($VNO)
    {
        $this->check_access("BPJ2");
        $id = $VNO;
        $sql = "SELECT d.alarm_off,d.DES,a.*,b.name,c.DNO,c.DNM,c.DSN  FROM vehicle a,users b,driver c,tbl136 d where d.DECL=0 and a.VNO=d.VNO and a.CAN=b.UAN and a.driver_id=c.id and a.id=$id";
        $vehicle = DB::select(DB::raw($sql));
        $vehicle = $vehicle[0];
        return view('override',compact('vehicle'));
    }

    public function saveoverride(Request $request)
    {
        $this->check_access("BPJ2");
        $email = trim($request->UAN);
        $password = $request->password;
        $CAN = $request->CAN;
        $WCI = $request->WCI;
        $VNO = $request->VNO;
        $OAC = $request->OAC;
        $VID = $request->VID;
        $sql = "SELECT * FROM users where email='$email' and UTV=1";
        $users = DB::select(DB::raw($sql));
        if(count($users) > 0){
            if (Hash::check($password, $users[0]->password)) {
                $sql = "SELECT * FROM tbl136 where VNO='$VNO' and DECL = 0";
                $tbl136 = DB::select(DB::raw($sql));
                $DCR = 0;
                $DES = "";
                $ODT = date("Y-m-d");
                $WST = date("Y-m-d");
                if(count($tbl136) > 0){
                    $DCR = $tbl136[0]->id;
                    $DES = $tbl136[0]->DES;
                    $WST = $tbl136[0]->DDT;
                }
                $UAN = $users[0]->UAN;                
                $OTT = date("H.i");
                $WTP = "";

                $curr_date = date("Y-m-d");
                $hour = date("H");
                if(($hour >= 10 and $hour < 11 and $WST == $curr_date) || $WST < $curr_date){
                    $sql = "update tbl136 set alarm_off = 1,alarm_off_attempts=0 where id = '$DCR'";
                    DB::update($sql);
                }else{
                    $sql = "update tbl136 set alarm_off = 1,alarm_off_attempts=3 where id = '$DCR'";
                    DB::update($sql);
                }
                if(($hour >= 12  || $WST < $curr_date) && $DES == 'A4'){
                    $sql = "update tbl136 set DECL = 1,attempts=0 where id = '$DCR'";
                    DB::update($sql);
                }else if($DES == 'A4'){
                    $sql = "update tbl136 set DECL = 1,attempts=3 where id = '$DCR'";
                    DB::update($sql);
                }

                if($DES == "A4"){
                    $WTP = "Vehicle Unblocked";
                }else{
                    $WTP = "Buzzer Turned Off";
                }
                
                $sql = "insert into tbl024 (DCR,ODT,OTT,CAN,VNO,UAN,OAC) values ($DCR,'$ODT','$OTT','$CAN','$VNO','$UAN','$OAC')";
                DB::insert($sql);
                $WNB = "WFL" . str_pad($DCR,3,'0',STR_PAD_LEFT);
                
                $sql = "insert into tbl140 (DCR,WST,WCI,UAN,CAN,VNO,WNB,WTP,WCD) values ($DCR,'$WST','$WCI','$UAN','$CAN','$VNO','$WNB','$WTP','$ODT')";
                DB::insert($sql);
                $sql = "SELECT a.*,b.DNM,b.DSN,b.DCN FROM vehicle a,driver b where a.driver_id=b.id and a.id=$VID";
                $vehicle = DB::select(DB::raw($sql));
                $VZC0 = $vehicle[0]->VZC0;
                $VBC0 = $vehicle[0]->VBC0; 
                $TSM = $vehicle[0]->TSM;
                $DNM = $vehicle[0]->DNM . " " . $vehicle[0]->DSN ;
                $DCN = $vehicle[0]->DCN;
                $TSM = $vehicle[0]->TSM;

                $DAT = date("Y-m-d");
                $TIM = date("H:i:s");

                if($DES == "A4"){
                    $CTX = "Vehicle Unblocked"; 
                    $MSG = "Hi ". $DNM." your vehicle has been unblocked successfully.";
                    
                    $sql = "insert into sms_log (PHN,MSG,DAT,TIM,CTX,NAM) values ('$DCN','$MSG','$DAT','$TIM','$CTX','$DNM')";
                    DB::insert($sql);
                    SMSFleetops::send($DCN,$MSG);
                    return redirect('/workflow')->with('message', 'Vehicle Mobilized Successfully');
                }else{
                    $CTX = "Buzzer Turned Off";

                    $MSG = "Hi ". $DNM." your vehicle buzzer has been turned off successfully.";
                    
                    $sql = "insert into sms_log (PHN,MSG,DAT,TIM,CTX,NAM) values ('$DCN','$MSG','$DAT','$TIM','$CTX','$DNM')";
                    DB::insert($sql);
                    SMSFleetops::send($DCN,$MSG);
                    return redirect('/workflow')->with('message', 'Vehicle Buzzer Turned off Successfully');
                }
            } else {
               return redirect('/override/'.$VID)->with('error', 'Invalid User Credentials')->withInput();
            }
        }else{
            return redirect('/override/'.$VID)->with('error', 'Username does not exist or inactive')->withInput();
        }
    }

    public function overrides($VNO)
    {
        $this->check_access("BPJ2");
        $id = $VNO;
        $sql = "SELECT a.*,b.name,c.DNO,c.DNM,c.DSN  FROM vehicle a,users b,driver c where a.CAN=b.UAN and a.driver_id=c.id and a.id=$id";
        $vehicle = DB::select(DB::raw($sql));
        $vehicle = $vehicle[0];
        return view('overrides',compact('vehicle'));
    }
    
    public function auditsrch()
    {
        $this->check_access("BPJ1");
        $sql = "SELECT a.* from vehicle a,driver b where a.driver_id=b.id and VTV=1 and b.VBM='Ride Hailing'";
        $vehicles = DB::select(DB::raw($sql));
        return view('auditsrch',compact('vehicles'));
        
    }

    public function auditing($VNO,$DCR)
    {
        $this->check_access("BPJ1");
        $id = $VNO;
        $sql = "SELECT d.PLF,e.RHN,a.*,b.UAN,b.name,c.DNO,c.DNM,c.DSN,c.DCN  FROM vehicle a,users b,driver c,driver_platform d,tbl361 e where a.CAN=b.UAN and a.driver_id=c.id and a.id=$id and c.id=d.driver_id and d.PLF=e.id";
        $vehicle = DB::select(DB::raw($sql));
        $vehicle = $vehicle[0];
        $VNO = $vehicle->VNO;
        $sql = "SELECT * from tbl137 where DCR=$DCR and id = (select max(id) from tbl137 where DCR=$DCR)";
        $result = DB::select(DB::raw($sql));
        $vehicle->RCN = $result[0]->RCN;
        return view('auditing',compact('vehicle'));
    }

    public function auditingsave(Request $request)
    {
        $this->check_access("BPJ1");
        $rhvisibility = ($request->get("rhvisibility") != null) ? 1 : 0;
        $VBM = "Ride Hailing";
        $VID = $request->VID;
        $VNO = $request->VNO;
        $CAN = $request->CAN;
        $UAN = $request->UAN;
        $RCN = $request->RCN;
        $SPF = $request->SPF;
        $TPF = $request->TPF;
        $CPF = $request->RMT;
        $RHN = $request->RHN;
        $USR = Auth::user()->UAN;
        $ADT = date('Y-m-d');
        $DCR = 0;
        $DCN = "";
        $DNM = "";
        $sql = "SELECT a.DDT,a.id,c.DNM,c.DSN,c.DCN from tbl136 a,vehicle b,driver c where a.VNO=b.VNO and b.driver_id=c.id and a.VNO ='$VNO' and DECL=0";
        $result = DB::select(DB::raw($sql));
        if(count($result)>0){
            $DCR = $result[0]->id;
            $DCN = $result[0]->DCN;
            $DNM = $result[0]->DNM." ".$result[0]->DSN;
        }
        
        $RMT = 0;
        $sql = "select RHN,RMT,RCN,VNO from tbl137 where DCR=$DCR and RST=1";
        $result = DB::select(DB::raw($sql));
        if(count($result) > 0){
            $RMT = $RMT + $result[0]->RMT;
        }

        $TIM = date("Y-m-d H:i:s");
        if($rhvisibility == 0){
            $RHV = 1;
            $sql = "insert into sales_audit (ADT,DCR,RHN,RHV,SPF,CPF,TPF,TIM,USR) values ('$ADT','$DCR','$RHN','$RHV','$SPF','$CPF','$TPF','$TIM','$USR')";
            DB::insert($sql);            
        }else{
           $RHV = 0; 
           $CPF = round(Formulae::EXPS2($DCR),2);; 
           $sql = "insert into sales_audit (ADT,DCR,RHN,RHV,SPF,CPF,TPF,TIM,USR) values ('$ADT','$DCR','$RHN','$RHV','0','$CPF','0','$TIM','$USR')";
            DB::insert($sql);
        }
        $BAL = $CPF - $RMT;
        $msg="";
        if($BAL >= 0){
            $msg = "Hi ".$DNM.". Cash Declared is Incorrect. Further to our checks, the cash collected you have accounted for is incorrect. Please send remaining cash GHC ".$BAL." immediately else we shall be compelled to enforce the policy. The car owner has been notified of this issue accordingly. Click here to pay. http://fleetopsgh.com/balance/".$DCR;
        }else{
            $msg = "Hi ".$DNM.",Thank you for a successful sales declaration of GHC ".$RMT;
            $sql = "update tbl136 set DECL = 1,attempts=0,alarm_off=1,alarm_off_attempts=0 where id = '$DCR'";
            DB::update($sql);

            $hour = date("H");
            if($hour >= 10 and $hour < 11){
                $sql = "update tbl136 set alarm_off = 1,alarm_off_attempts=0 where id = '$DCR'";
                DB::update($sql);
            }else{
                $sql = "update tbl136 set alarm_off = 1,alarm_off_attempts=3 where id = '$DCR'";
                DB::update($sql);
            }
            if($hour >= 12){
                $sql = "update tbl136 set DECL = 1,attempts=0 where id = '$DCR'";
                DB::update($sql);
            }else{
                $sql = "update tbl136 set DECL = 1,attempts=3 where id = '$DCR'";
                DB::update($sql);
            }

        }
        $DAT = date("Y-m-d");
        $TIM = date("H:i:s");
        $CTX = "Sales Audit";
        $sql = "insert into sms_log (PHN,MSG,DAT,TIM,CTX,NAM) values (?,?,?,?,?,?)";
        $values = [$RCN,$msg,$DAT,$TIM,$CTX,$DNM];
        DB::insert($sql,$values);
        SMSFleetops::send($RCN,$msg);
        return redirect('/workflow')->with('message', 'Driver Sales Audit Done Successfully')->withInput();

    }

    public function help()
    {
       return view('help'); 
    }

    public function rhresettesting($DCR){
        $total_exps = 0;
        $total_ccei = 0;
        
        $total_cml = 0;
        $total_chr = 0;
        $rh_sold = 0 ;
        $sql = "delete from tbl137 where DCR=$DCR";
        DB::delete($sql);
        $sql = "delete from sales_audit where DCR=$DCR";
        DB::delete($sql);
        $sql = "update tbl136 set DECL=0,CRS=0,DNW=0 where id=$DCR";
        DB::update($sql);
        
        $from = date('Y-m-d', strtotime('-6 days'));
        $to = date('Y-m-d');
        $sql = "select a.*,b.DCN from tbl136 a,driver b where a.driver_id=b.id and a.VBM = 'Ride Hailing' and DDT >='$from' and DDT <='$to' order by DDT desc";
        $title = 'RH Daily Report';
        $rhreport = DB::select(DB::raw($sql));
        foreach($rhreport as $sale){
            $DCR = $sale->id;
            $VNO = $sale->VNO;
            $sql = "select * from tbl137 where DCR=$DCR and SSR='Driver' and RST=1";
            $tbl137 = DB::select(DB::raw($sql));
            if(count($tbl137) > 0){
                $sale->EXPS = round(Formulae::EXPS2($DCR),2);
                $sale->CCEI = round(Formulae::CCEI2($DCR),2);
                $sale->FTP = round(Formulae::FTP($DCR),2);
                $sale->CWI = round(Formulae::CWI($DCR),2);
            }else{
                $sale->EXPS = "";
                $sale->CCEI = "";
                $sale->FTP = round(Formulae::FTP($DCR),2);
                $sale->CWI = round(Formulae::CWI($DCR),2);
            }
        }
        return view('rhreport',compact('rhreport','title','from','to','total_exps','total_ccei','rh_sold','total_cml','total_chr'));
    }

    public function resendsms($id){
        $sql = "select * from sms_log where id=$id";
        $sms = DB::select(DB::raw($sql));  
        if(count($sms) > 0){
            $DAT = date("Y-m-d");
            $TIM = date("H:i:s");
            $PHN = $sms[0]->PHN;
            $MSG = $sms[0]->MSG;
            $CTX = $sms[0]->CTX;
            $NAM = $sms[0]->NAM;
            $sql = "insert into sms_log (PHN,MSG,DAT,TIM,CTX,NAM) values (?,?,?,?,?,?)";
            $values = [$PHN,$MSG,$DAT,$TIM,$CTX,$NAM];
            DB::insert($sql,$values);
            SMSFleetops::send($PHN,$MSG);
            $from = date('Y-m-d', strtotime('-6 days'));
            $to   = date('Y-m-d');
            return redirect("/notificationslog/$from/$to")->with('message', 'SMS Resend Successfully');

        }
    }

    public function fuel_consumed($DCR){
        $FTP = round(Formulae::FTP($DCR),2);
        $response = array();
        $response['FTP'] = $FTP;
        echo json_encode($response);
    }

    public function vehicleinspection($id){
        $sql = "select a.*,b.DNM,b.DSN from driver_upload a,driver b where a.driver_id=b.id and a.id=$id and approved=0";
        $result = DB::select(DB::raw($sql));
        if(count($result) > 0){
            $VNO = $result[0]->VNO;
            $upload_id = $result[0]->id;
        return view('inspection',compact('result','VNO','upload_id'));
       }
    }

    public function saveservice(Request $request){
        $VNO = $request->get('VNO');
        $upload_id = $request->get('upload_id');
        $service_date = $request->get('service_date');
        $current_mileage = $request->get('current_mileage');
        $sql = "insert into manager_service (upload_id,service_date,current_mileage) values (upload_id,'$service_date','$current_mileage')";
        DB::insert($sql);

        $sql = "update driver_upload set approved=1 where id=$upload_id"; 
        DB::update($sql);
        return redirect('/workflow')->with('message', 'Vehicle Service Done Successfully');
    }

    public function saveinspection(Request $request){
        $VNO = $request->get('VNO');
        $upload_id = $request->get('upload_id');
        $VI01 = $request->get('VI01');
        $VI02 = $request->get('VI02');
        $VI03 = $request->get('VI03');
        $VI04 = $request->get('VI04');
        $VI05 = $request->get('VI05');
        $VI06 = $request->get('VI06');
        $VI07 = $request->get('VI07');
        $VI08 = $request->get('VI08');
        $VI09 = $request->get('VI09');
        $VI10 = $request->get('VI10');
        $VI11 = $request->get('VI11');
        $VI12 = $request->get('VI12');
        $VI13 = $request->get('VI13');
        $VI14 = $request->get('VI14');
        $VI15 = $request->get('VI15');
        $VI16 = $request->get('VI16');
        $VI17 = $request->get('VI17');
        $VI18 = $request->get('VI18');
        $VI19 = $request->get('VI19');
        $VI20 = $request->get('VI20');
        $VI21 = $request->get('VI21');
        $VI22 = $request->get('VI22');
        $VI23 = $request->get('VI23');
        $VI24 = $request->get('VI24');

        $CI01 = $request->get('CI01');
        $CI02 = $request->get('CI02');
        $CI03 = $request->get('CI03');
        $CI04 = $request->get('CI04');
        $CI05 = $request->get('CI05');
        $CI06 = $request->get('CI06');
        $CI07 = $request->get('CI07');
        $CI08 = $request->get('CI08');
        $CI09 = $request->get('CI09');
        $CI10 = $request->get('CI10');
        $CI11 = $request->get('CI11');
        $CI12 = $request->get('CI12');
        $CI13 = $request->get('CI13');
        $CI14 = $request->get('CI14');
        $CI15 = $request->get('CI15');
        $CI16 = $request->get('CI16');
        $CI17 = $request->get('CI17');
        $CI18 = $request->get('CI18');
        $CI19 = $request->get('CI19');
        $CI20 = $request->get('CI20');
        $CI21 = $request->get('CI21');
        $CI22 = $request->get('CI22');
        $CI23 = $request->get('CI23');
        $CI24 = $request->get('CI24');
        
        $sql = "update driver_upload set inspection=1 where id=$upload_id";
        DB::update(DB::raw($sql));

        $sql = "delete from manager_inspect where upload_id=$upload_id";
        DB::delete(DB::raw($sql));
        
        $sql = "insert into manager_inspect (upload_id,VI01,VI02,VI03,VI04,VI05,VI06,VI07,VI08,VI09,VI10,VI11,VI12,VI13,VI14,VI15,VI16,VI17,VI18,VI19,VI20,VI21,VI22,VI23,VI24,CI01,CI02,CI03,CI04,CI05,CI06,CI07,CI08,CI09,CI10,CI11,CI12,CI13,CI14,CI15,CI16,CI17,CI18,CI19,CI20,CI21,CI22,CI23,CI24) values ($upload_id,'$VI01','$VI02','$VI03','$VI04','$VI05','$VI06','$VI07','$VI08','$VI09','$VI10','$VI11','$VI12','$VI13','$VI14','$VI15','$VI16','$VI17','$VI18','$VI19','$VI20','$VI21','$VI22','$VI23','$VI24','$CI01','$CI02','$CI03','$CI04','$CI05','$CI06','$CI07','$CI08','$CI09','$CI10','$CI11','$CI12','$CI13','$CI14','$CI15','$CI16','$CI17','$CI18','$CI19','$CI20','$CI21','$CI22','$CI23','$CI24')";
        DB::insert($sql);

        $sql = "delete from manager_inspect_photo where upload_id=$upload_id";
        DB::delete(DB::raw($sql));
        $total = count($_FILES['VI25']['name']);
        for( $i=0 ; $i < $total ; $i++ ) {
            if($_FILES['VI25']['tmp_name'][$i] != ""){
                $sql = "insert into manager_inspect_photo (upload_id) values ($upload_id)";
                DB::insert($sql);
                $file_id = DB::getPdo()->lastInsertId();
                $extension = pathinfo($_FILES['VI25']['name'][$i], PATHINFO_EXTENSION);
                $target_filename = $file_id . "." . $extension;
                $tmpFilePath = $_FILES['VI25']['tmp_name'][$i];
                $filepath = public_path('uploads'.DIRECTORY_SEPARATOR.'inspection'.DIRECTORY_SEPARATOR);
                if ($tmpFilePath != ""){
                    $newFilePath = $filepath.$target_filename;
                    move_uploaded_file($tmpFilePath, $newFilePath);
                    $sql = "update manager_inspect_photo set filename='$target_filename' where id=$file_id";
                    DB::update($sql);
                }
            }
        }

        return redirect('/workflow')->with('message', 'Vehicle Inspection Done Successfully');
    }

    public function insurance($id){
        $sql = "select a.*,b.DNM,b.DSN from driver_upload a,driver b where a.driver_id=b.id and a.id=$id and approved=0";
        $result = DB::select(DB::raw($sql));
        if(count($result) > 0){
            $DNM = $result[0]->DNM . " " . $result[0]->DSN;
            $VNO = $result[0]->VNO;
            $upload_id = $result[0]->id;
            $doc_expiry = $result[0]->doc_expiry;
            $file_name = trim($result[0]->file_name);
            return view('insurance',compact('result','DNM','VNO','file_name','doc_expiry','upload_id'));
       }
    }

    public function approve_insurance($id){
        $sql = "select a.*,b.id as veid from driver_upload a,vehicle b where a.VNO=b.VNO and a.id=$id and approved=0";
        $result = DB::select(DB::raw($sql));
        if(count($result) > 0){
            $VNO = $result[0]->VNO;
            $upload_id = $result[0]->id;
            $veid = $result[0]->veid;
            $file_name = $result[0]->file_name;
            $temp = explode(".",$file_name);
            $extension = $temp[1];
            $target_filename = $veid . "." . $extension;
            $doc_expiry = $result[0]->doc_expiry;
            $source = public_path().DIRECTORY_SEPARATOR."uploads".DIRECTORY_SEPARATOR."driver".DIRECTORY_SEPARATOR.$file_name;
            $target = public_path().DIRECTORY_SEPARATOR."uploads".DIRECTORY_SEPARATOR."VID".DIRECTORY_SEPARATOR.$target_filename;
            copy($source,$target);
            $sql = "update vehicle set IEX='$doc_expiry',VID='$target_filename' where id=$veid";
            DB::update($sql);
            $sql = "update driver_upload set approved=1 where id = $upload_id";
            DB::update($sql);
       }
    }

    public function save_new_insurance(Request $request){
        $VNO = $request->get('VNO');
        $IEX = $request->get('IEX');
        $VNO = $request->get('VNO');
        $upload_id = $request->get('upload_id');
        $sql = "select id from vehicle where VNO='$VNO'";
        $result = DB::select(DB::raw($sql));
        if(count($result) > 0){
            $id = $result[0]->id;
            $VID =  $id.'.'.$request->VID->extension(); 
            $filepath = public_path('uploads'.DIRECTORY_SEPARATOR.'VID'.DIRECTORY_SEPARATOR);
            move_uploaded_file($_FILES['VID']['tmp_name'], $filepath.$VID);
            $sql = "update vehicle set IEX='$IEX',VID='$VID' where id=$id";
            DB::update($sql);
            $sql = "update driver_upload set approved=2 where id = $upload_id";
            DB::update($sql);

            return redirect('/workflow')->with('message', 'Vehicle Insurance Updated Successfully');
       }
    }

    public function roadworthy($id){
        $sql = "select a.*,b.DNM,b.DSN from driver_upload a,driver b where a.driver_id=b.id and a.id=$id and approved=0";
        $result = DB::select(DB::raw($sql));
        if(count($result) > 0){
            $DNM = $result[0]->DNM . " " . $result[0]->DSN;
            $VNO = $result[0]->VNO;
            $upload_id = $result[0]->id;
            $doc_expiry = $result[0]->doc_expiry;
            $file_name = trim($result[0]->file_name);
            return view('roadworthy',compact('result','DNM','VNO','file_name','doc_expiry','upload_id'));
       }
    }

    public function approve_roadworthy($id){
        $sql = "select a.*,b.id as veid from driver_upload a,vehicle b where a.VNO=b.VNO and a.id=$id and approved=0";
        $result = DB::select(DB::raw($sql));
        if(count($result) > 0){
            $VNO = $result[0]->VNO;
            $upload_id = $result[0]->id;
            $veid = $result[0]->veid;
            $file_name = $result[0]->file_name;
            $temp = explode(".",$file_name);
            $extension = $temp[1];
            $target_filename = $veid . "." . $extension;
            $doc_expiry = $result[0]->doc_expiry;
            $source = public_path().DIRECTORY_SEPARATOR."uploads".DIRECTORY_SEPARATOR."driver".DIRECTORY_SEPARATOR.$file_name;
            $target = public_path().DIRECTORY_SEPARATOR."uploads".DIRECTORY_SEPARATOR."VRD".DIRECTORY_SEPARATOR.$target_filename;
            copy($source,$target);
            $sql = "update vehicle set REX='$doc_expiry',VRD='$target_filename' where id=$veid";
            DB::update($sql);
            $sql = "update driver_upload set approved=1 where id = $upload_id";
            DB::update($sql);
       }
    }

    public function save_new_roadworthy(Request $request){
        $VNO = $request->get('VNO');
        $REX = $request->get('REX');
        $VNO = $request->get('VNO');
        $upload_id = $request->get('upload_id');
        $sql = "select id from vehicle where VNO='$VNO'";
        $result = DB::select(DB::raw($sql));
        if(count($result) > 0){
            $id = $result[0]->id;
            $VRD =  $id.'.'.$request->VRD->extension(); 
            $filepath = public_path('uploads'.DIRECTORY_SEPARATOR.'VRD'.DIRECTORY_SEPARATOR);
            move_uploaded_file($_FILES['VRD']['tmp_name'], $filepath.$VRD);
            $sql = "update vehicle set REX='$REX',VRD='$VRD' where id=$id";
            DB::update($sql);
            $sql = "update driver_upload set approved=2 where id = $upload_id";
            DB::update($sql);

            return redirect('/workflow')->with('message', 'Roadworthy Certificate Updated Successfully');
       }
    }

    public function licence($id){
        $sql = "select a.*,b.DNM,b.DSN from driver_upload a,driver b where a.driver_id = b.id and a.id=$id and approved=0";
        $result = DB::select(DB::raw($sql));
        if(count($result) > 0){
            $DNM = $result[0]->DNM . " " . $result[0]->DSN;
            $VNO = $result[0]->VNO;
            $driver_id = $result[0]->driver_id;
            $upload_id = $result[0]->id;
            $doc_expiry = $result[0]->doc_expiry;
            $file_name = trim($result[0]->file_name);
            $file_name2 = trim($result[0]->file_name2);
            return view('licence',compact('result','DNM','VNO','file_name','file_name2','doc_expiry','upload_id','driver_id'));
       }
    }

    public function approve_licence($id){
        $sql = "select a.*,b.id as veid from driver_upload a,driver b where a.driver_id=b.id and a.id=$id and approved=0";
        $result = DB::select(DB::raw($sql));
        if(count($result) > 0){
            $VNO = $result[0]->VNO;
            $upload_id = $result[0]->id;
            $veid = $result[0]->veid;
            $file_name1 = $result[0]->file_name;
            $temp1 = explode(".",$file_name1);
            $extension1 = $temp1[1];
            $target_filename1 = $veid . "_front." . $extension1;
            $file_name2 = $result[0]->file_name2;
            $temp2 = explode(".",$file_name2);
            $extension2 = $temp2[1];
            $target_filename2 = $veid . "_back." . $extension2;
            $doc_expiry = $result[0]->doc_expiry;
            $source1 = public_path().DIRECTORY_SEPARATOR."uploads".DIRECTORY_SEPARATOR."driver".DIRECTORY_SEPARATOR.$file_name1;
            $target1 = public_path().DIRECTORY_SEPARATOR."uploads".DIRECTORY_SEPARATOR."DLD".DIRECTORY_SEPARATOR.$target_filename1;
            copy($source1,$target1);
            $source2 = public_path().DIRECTORY_SEPARATOR."uploads".DIRECTORY_SEPARATOR."driver".DIRECTORY_SEPARATOR.$file_name2;
            $target2 = public_path().DIRECTORY_SEPARATOR."uploads".DIRECTORY_SEPARATOR."DLD".DIRECTORY_SEPARATOR.$target_filename2;
            copy($source2,$target2);
            $sql = "update driver set LEX='$doc_expiry',DLD='$target_filename1',DLD2='$target_filename2' where id=$veid";
            DB::update($sql);
            $sql = "update driver_upload set approved=1 where id = $upload_id";
            DB::update($sql);
       }
    }

    public function reject_doc($id){
        $sql = "select a.id,b.DCN,b.DNM,b.DSN from driver_upload a,driver b where a.id=$id and a.driver_id=b.id and approved=0";
        $result = DB::select(DB::raw($sql));
        if(count($result) > 0){
            $DCN = $result[0]->DCN;
            $DNM = $result[0]->DNM." ".$result[0]->DSN;
            $id = $result[0]->id;
            $sql = "update driver_upload set doc_expiry = null ,file_name='',file_name2='',rejected=1 where id = $id";
            DB::update(DB::raw($sql));
            $msg = "Hi $DNM, Your licence upload is rejected.Please upload again";
            SMSFleetops::send($DCN,$msg);
            $DAT = date("Y-m-d");
            $TIM = date("H:i:s");
            $CTX = "Licence rejected";
            $sql = "insert into sms_log (PHN,MSG,DAT,TIM,CTX,NAM) values ('$DCN','$msg','$DAT','$TIM','$CTX','$DNM')";
            DB::insert($sql);
        }
    }

    public function reject_insurance($id){
        $sql = "select a.id,b.DCN,b.DNM,b.DSN from driver_upload a,driver b where a.id=$id and a.driver_id=b.id and approved=0";
        $result = DB::select(DB::raw($sql));
        if(count($result) > 0){
            $DCN = $result[0]->DCN;
            $DNM = $result[0]->DNM." ".$result[0]->DSN;
            $id = $result[0]->id;
            $sql = "update driver_upload set rejected=1 where id = $id";
            DB::update(DB::raw($sql));
            $msg = "Hi $DNM, Your insurance upload is rejected.Please upload again";
            SMSFleetops::send($DCN,$msg);
            $DAT = date("Y-m-d");
            $TIM = date("H:i:s");
            $CTX = "Insurance rejected";
            $sql = "insert into sms_log (PHN,MSG,DAT,TIM,CTX,NAM) values ('$DCN','$msg','$DAT','$TIM','$CTX','$DNM')";
            DB::insert($sql);
        }
    }


    public function reject_roadworthy($id){
        $sql = "select a.id,b.DCN,b.DNM,b.DSN from driver_upload a,driver b where a.id=$id and a.driver_id=b.id and approved=0";
        $result = DB::select(DB::raw($sql));
        if(count($result) > 0){
            $DCN = $result[0]->DCN;
            $DNM = $result[0]->DNM." ".$result[0]->DSN;
            $id = $result[0]->id;
            $sql = "update driver_upload set rejected=1 where id = $id";
            DB::update(DB::raw($sql));
            $msg = "Hi $DNM, Your Roadworthy Certificate upload is rejected.Please upload again";
            SMSFleetops::send($DCN,$msg);
            $DAT = date("Y-m-d");
            $TIM = date("H:i:s");
            $CTX = "Roadworthy Certificate rejected";
            $sql = "insert into sms_log (PHN,MSG,DAT,TIM,CTX,NAM) values ('$DCN','$msg','$DAT','$TIM','$CTX','$DNM')";
            DB::insert($sql);
        }
    }


    public function save_new_licence(Request $request){
        $driver_id = $request->get('driver_id');
        $LEX = $request->get('LEX');
        $VNO = $request->get('VNO');
        $upload_id = $request->get('upload_id');
        $sql = "select driver_id from vehicle where VNO='$VNO'";
        $result = DB::select(DB::raw($sql));
        if(count($result) > 0){
            $DLD =  $driver_id.'_front.'.$request->DLD->extension(); 
            $filepath = public_path('uploads'.DIRECTORY_SEPARATOR.'DLD'.DIRECTORY_SEPARATOR);
            move_uploaded_file($_FILES['DLD']['tmp_name'], $filepath.$DLD);
            $DLD2 =  $driver_id.'_back.'.$request->DLD2->extension(); 
            $filepath = public_path('uploads'.DIRECTORY_SEPARATOR.'DLD'.DIRECTORY_SEPARATOR);
            move_uploaded_file($_FILES['DLD']['tmp_name'], $filepath.$DLD2);
            $sql = "update driver set LEX='$LEX',DLD='$DLD',DLD2='$DLD2' where id=$driver_id";
            DB::update($sql);
            $sql = "update driver_upload set approved=2 where id = $upload_id";
            DB::update($sql);

            return redirect('/workflow')->with('message', 'Licence Updated Successfully');
       }
    }

    public function renew($id){
        $sql = "select a.*,b.DNM,b.DSN from driver_upload a,driver b where a.driver_id = b.id and a.id=$id and approved=0";
        $result = DB::select(DB::raw($sql));
        if(count($result) > 0){
            $DNM = $result[0]->DNM . " " . $result[0]->DSN;
            $VNO = $result[0]->VNO;
            $driver_id = $result[0]->driver_id;
            $upload_id = $result[0]->id;
            return view('renew',compact('result','DNM','VNO','upload_id','driver_id'));
       }
    }

    public function save_contract(Request $request){
        $driver_id = $request->get('driver_id');
        $CEX = $request->get('CEX');
        $VNO = $request->get('VNO');
        $upload_id = $request->get('upload_id');
        $sql = "select driver_id from vehicle where VNO='$VNO'";
        $result = DB::select(DB::raw($sql));
        if(count($result) > 0){
            $VCC =  $driver_id.'.'.$request->VCC->extension(); 
            $filepath = public_path('uploads'.DIRECTORY_SEPARATOR.'VCC'.DIRECTORY_SEPARATOR);
            move_uploaded_file($_FILES['VCC']['tmp_name'], $filepath.$VCC);
            $sql = "update driver_upload set  doc_expiry='$CEX',file_name='$VCC' where id=$upload_id";
            DB::update($sql);
            
            return redirect('/workflow')->with('message', 'Contract Updated Successfully');
       }
    }

    public function service($id){
        $sql = "select a.*,b.DNM,b.DSN from driver_upload a,driver b where a.driver_id = b.id and a.id=$id and approved=0";
        $result = DB::select(DB::raw($sql));
        if(count($result) > 0){
            $DNM = $result[0]->DNM . " " . $result[0]->DSN;
            $VNO = $result[0]->VNO;
            $driver_id = $result[0]->driver_id;
            $upload_id = $result[0]->id;
            $file_name = $result[0]->file_name;
            $current_mileage = $result[0]->current_mileage;
            return view('service',compact('result','DNM','VNO','upload_id','driver_id','file_name','current_mileage'));
       }
    }
}

	
	
	

	
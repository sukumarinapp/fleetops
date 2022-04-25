<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;  
use DB;
use App\rhplatform;
use App\Vehicle;
use App\User;
use Auth;
use App\Formulae;
use App\SMSFleetops;
use PDF;

class VehicleController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    private function check_access($mode){
        if($mode == "BPC" && Auth::user()->usertype != "Admin" && Auth::user()->BPC == false){
            echo "Access Denied";
            die;
        }else if($mode == "BPF" && Auth::user()->usertype != "Admin" && Auth::user()->BPF == false){
            echo "Access Denied";
            die;
        }
    }

    public function index()
    {
        $this->check_access("BPC");
        $today = date("Y-m-d");
        $sql = "SELECT a.*,b.id as did,b.DNM,b.DSN,b.VBM,c.name FROM vehicle a LEFT JOIN driver b ON a.driver_id = b.id INNER JOIN users c ON a.CAN = c.UAN";
        $vehicles = DB::select(DB::raw($sql));
        
        foreach($vehicles as $vehicle){
            $TID = $vehicle->TID;
            $VNO = $vehicle->VNO;
            $sql3 = "SELECT * from tracker_status where TID='$TID' and status=0";
            $offline = DB::select(DB::raw($sql3));
            if(count($offline) > 0){
                $vehicle->offline  = 1;
            }else{
                $vehicle->offline  = 0;
            }
            $sql4 = "select VNO from tbl136 where DECL=0 and VNO='$VNO'";
            $DECL = DB::select(DB::raw($sql4));
            if(count($DECL) > 0){
                $vehicle->DECL  = 0;
            }else{
                $vehicle->DECL  = 1;
            }
        }
        //dd($vehicles);
        return view('vehicle.index', compact('vehicles'));
    }
   
    public function create()
    {
        $this->check_access("BPC");
        $user_id = Auth::user()->id;
        $usertype = Auth::user()->usertype;
        if($usertype == "Admin"){
            $clients = User::Where('usertype','Client')->get();
        }else if($usertype == "Manager"){
            $clients = User::Where('usertype','Client')->Where('parent_id',$user_id)->get();
        }
        $rhplatforms = rhplatform::all();
        return view('vehicle.create', compact('rhplatforms','clients'));
    }
   
    public function store(Request $request)
    {
        $this->check_access("BPC");
        $VNO = trim($request->get('VNO'));
        $VNO = str_replace(' ', '', $VNO);
        $sql = "SELECT * FROM vehicle where VNO='$VNO'";
        $vehicles = DB::select(DB::raw($sql));
        if(count($vehicles) > 0){
            return redirect('/vehicle/create')->with('error', 'Duplicate Vehicle Reg No');
        }else{
            $VTV = ($request->get("VTV") != null) ? 1 : 0;
            $ECY = trim($request->get('ECY'));
            $CON = Formulae::CON($VNO);
            $AVI = ($request->get("AVI") != null) ? 1 : 0;
            $AVR = ($request->get("AVR") != null) ? 1 : 0;
            $MSH = ($request->get("MSH") != null) ? 1 : 0;
            $insert = array(
                'CAN' => $request->get('CAN'),
                'VNO' => $request->get('VNO'),
                'VDT' => date("Y-m-d"),
                'IEX' => $request->get('IEX'),
                'REX' => $request->get('REX'),
                'VMK' => $request->get('VMK'),
                'VMD' => $request->get('VMD'),
                'VCL' => $request->get('VCL'),
                'chassis_no' => $request->get('chassis_no'),
                'ECY' => $ECY,
                'CON' => $CON,
                'VFT' => $request->get('VFT'),
                'VFC' => $request->get('VFC'),
                'TSN' => $request->get('TSN'),
                'TID' => $request->get('TID'),
                'TSM' => $request->get('TSM'),
                'TIP' => $request->get('TIP'),
                'VZC1' => $request->get('VZC1'),
                'VZC0' => $request->get('VZC0'),
                'VBC1' => $request->get('VBC1'),
                'VBC0' => $request->get('VBC0'),
                'AVI' => $AVI,
                'AVR' => $AVR,
                'MSH' => $MSH,
                'VTV' => $VTV,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            );
 
            $vehicle = new Vehicle($insert);
            $vehicle->save();

            $last_insert_id = $vehicle->id;

            $SSD = $request->SSD;
            $SSD =  trim($request->get('SSD'));
            if($SSD == "") $SSD = "NULL";
            $SSM = trim($request->SSM) == "" ? 0 : $request->SSM;
            $SMF = trim($request->SMF) == "" ? 0 : $request->SMF;
            $SSFP = trim($request->SSFP) == "" ? 0 : $request->SSFP;
            $RSS = ($request->get("RSS") != null) ? 1 : 0;
            if($SSD == "NULL")
                $sql = "insert into vehicle_service (VID,SSD,SSM,SMF,SSFP,RSS) values ($last_insert_id,$SSD,'$SSM','$SMF','$SSFP','$RSS')";
            else
                $sql = "insert into vehicle_service (VID,SSD,SSM,SMF,SSFP,RSS) values ($last_insert_id,'$SSD','$SSM','$SMF','$SSFP','$RSS')";
            DB::insert($sql);

            $ISD =  trim($request->get('ISD'));
            if($ISD == "") $ISD = "NULL";
            $ISM = trim($request->ISM) == "" ? 0 : $request->ISM;
            $IMF = trim($request->IMF) == "" ? 0 : $request->IMF;
            $ISFP = trim($request->ISFP) == "" ? 0 : $request->ISFP;
            $RIS = ($request->get("RIS") != null) ? 1 : 0;
            if($ISD == "NULL")
                $sql = "insert into vehicle_inspect (VID,ISD,ISM,RIS,IMF,ISFP) values ($last_insert_id,$ISD,'$ISM','$RIS','$IMF','$ISFP')";
            else
                $sql = "insert into vehicle_inspect (VID,ISD,ISM,RIS,IMF,ISFP) values ($last_insert_id,'$ISD','$ISM','$RIS','$IMF','$ISFP')";
            DB::insert($sql);

            $VID = "";
            if($request->VID != null){
                $VID =  $last_insert_id.'.'.$request->VID->extension(); 
                $filepath = public_path('uploads'.DIRECTORY_SEPARATOR.'VID'.DIRECTORY_SEPARATOR);
                move_uploaded_file($_FILES['VID']['tmp_name'], $filepath.$VID);
            }

            $VRD = "";
            if($request->VRD != null){
                $VRD =  $last_insert_id.'.'.$request->VRD->extension(); 
                $filepath = public_path('uploads'.DIRECTORY_SEPARATOR.'VRD'.DIRECTORY_SEPARATOR);
                move_uploaded_file($_FILES['VRD']['tmp_name'], $filepath.$VRD);
            }

            $vehicle = Vehicle::find($last_insert_id);
            $vehicle->VID  =  $VID;
            $vehicle->VRD  =  $VRD;
            $vehicle->save();
            return redirect('/vehicle')->with('message', 'Vehicle added Successfully');
        }
    }
      
    public function edit($id)
    {
        $this->check_access("BPC");
        $user_id = Auth::user()->id;
        $usertype = Auth::user()->usertype;
        if($usertype == "Admin"){
            $clients = User::Where('usertype','Client')->get();
        }else if($usertype == "Manager"){
            $clients = User::Where('usertype','Client')->Where('parent_id',$user_id)->get();
        }
        $rhplatforms = rhplatform::all();
        $vehicle = Vehicle::find($id);
        $VNO = $vehicle->VNO;
        $TID = $vehicle->TID;
        $VID = $vehicle->id;
        $today = date("Y-m-d");
        $sql3 = " select distinct terminal_id from current_location where capture_date='$today' and terminal_id='$TID'";
        $tracker = DB::select(DB::raw($sql3));
        $online = 0;
        if(count($tracker) > 0){
            $online = 1;
        }
        $sql = "select * from vehicle_service where VID ='$VID'";
        $service = DB::select(DB::raw($sql));
        if(count($service) > 0){

            $vehicle->SSD = $service[0]->SSD;
            $vehicle->SSM = $service[0]->SSM;
            $vehicle->RSS = $service[0]->RSS;
            $vehicle->SMF = $service[0]->SMF;
            $vehicle->SSFP = $service[0]->SSFP;
            $vehicle->SVE = $service[0]->SVE;
        }
        $sql = "select * from vehicle_inspect where VID ='$VID'";
        $service = DB::select(DB::raw($sql));
        if(count($service) > 0){

            $vehicle->ISD = $service[0]->ISD;
            $vehicle->ISM = $service[0]->ISM;
            $vehicle->RIS = $service[0]->RIS;
            $vehicle->IMF = $service[0]->IMF;
            $vehicle->ISFP = $service[0]->ISFP;
            $vehicle->IVE = $service[0]->IVE;
        }
        $workflow = 0;
        $sql = "select * from driver_upload where doc_type in ('Insurance','RdWCert','Service','Inspection') and VNO='$VNO' and approved=0";
        $result = DB::select(DB::raw($sql));
        if(count($result) > 0){
            $workflow = 1;
        }
        return view('vehicle.edit', compact('vehicle','rhplatforms','clients','online','workflow'));
    }
   
    public function update(Request $request, $id)
    {
        $this->check_access("BPC");
        $VNO = trim($request->get('VNO'));
        $VNO = str_replace(' ', '', $VNO);
        $sql = "SELECT * FROM vehicle where VNO='$VNO'  and id <> $id";
        $vehicles = DB::select(DB::raw($sql));
        if(count($vehicles) > 0){
            return redirect("/vehicle/$id/edit")->with('error', 'Duplicate Vehicle Reg No');
        }else{
            $VTV = ($request->get("VTV") != null) ? 1 : 0;
            $AVI = ($request->get("AVI") != null) ? 1 : 0;
            $AVR = ($request->get("AVR") != null) ? 1 : 0;
            $MSH = ($request->get("MSH") != null) ? 1 : 0;
            $VID = "";
            if($request->VID != null){
                $VID =  $id.'.'.$request->VID->extension(); 
                $filepath = public_path('uploads'.DIRECTORY_SEPARATOR.'VID'.DIRECTORY_SEPARATOR);
                move_uploaded_file($_FILES['VID']['tmp_name'], $filepath.$VID);
            }
          

            $VRD = "";
            if($request->VRD != null){
                $VRD =  $id.'.'.$request->VRD->extension(); 
                $filepath = public_path('uploads'.DIRECTORY_SEPARATOR.'VRD'.DIRECTORY_SEPARATOR);
                move_uploaded_file($_FILES['VRD']['tmp_name'], $filepath.$VRD);
            }

            $ECY = trim($request->get('ECY'));
            $vehicle = Vehicle::find($id);            
            $vehicle->VNO  =  $request->get('VNO');
            $CON = Formulae::CON($vehicle->VNO);
            $vehicle->CAN  =  $request->get('CAN');
            if($VID != "") $vehicle->VID  =  $VID;
            if($VRD != "") $vehicle->VRD  =  $VRD;
            $vehicle->IEX  =  $request->get('IEX');
            $vehicle->REX  =  $request->get('REX');
            $vehicle->VMK  =  $request->get('VMK');
            $vehicle->VMD  =  $request->get('VMD');            
            $vehicle->VCL =  $request->get('VCL');
            $vehicle->chassis_no =  $request->get('chassis_no');
            $vehicle->ECY = $ECY;
            $vehicle->CON = $CON;
            $vehicle->VFT =  $request->get('VFT');
            $vehicle->VFC =  $request->get('VFC');
            $vehicle->TSN =  $request->get('TSN');
            $vehicle->TID =  $request->get('TID');
            $vehicle->TSM =  $request->get('TSM');
            $vehicle->TIP =  $request->get('TIP');
            $vehicle->VZC1 =  $request->get('VZC1');
            $vehicle->VZC0 =  $request->get('VZC0');
            $vehicle->VBC1 =  $request->get('VBC1');
            $vehicle->VBC0 =  $request->get('VBC0');
            $vehicle->AVI =  $AVI;
            $vehicle->AVR =  $AVR;
            $vehicle->MSH =  $MSH;
            if($vehicle->driver_id == ""){
                $vehicle->VTV = $VTV;
            }
            $vehicle->updated_at =  date("Y-m-d H:i:s");        
            $vehicle->save();

            $SVE =  trim($request->get('SVE'));
            $SSD =  trim($request->get('SSD'));
            if($SSD == "") $SSD = "NULL";
            $SSM = trim($request->SSM) == "" ? 0 : $request->SSM;
            $SMF = trim($request->SMF) == "" ? 0 : $request->SMF;
            $SSFP = trim($request->SSFP) == "" ? 0 : $request->SSFP;
            $RSS = ($request->get("RSS") != null) ? 1 : 0;

            $sql = "SELECT * FROM vehicle_service where VID = $id";
            $check = DB::select(DB::raw($sql));
            if(count($check) > 0){
                if($SSD == "NULL")
                    $sql = "update vehicle_service set SSD=$SSD,SSM='$SSM',SMF='$SMF',SSFP='$SSFP',SVE='$SVE',RSS='$RSS' where VID = '$id'";
                else
                    $sql = "update vehicle_service set SSD='$SSD',SSM='$SSM',SMF='$SMF',SSFP='$SSFP',SVE='$SVE',RSS='$RSS' where VID = '$id'";
                DB::update($sql);
            }else{
                if($SSD == "NULL")
                    $sql = "insert into vehicle_service (VID,SSD,SSM,SMF,SSFP,RSS,SVE) values ($id,$SSD,'$SSM','$SMF','$SSFP','$RSS','$SVE')";
                else
                    $sql = "insert into vehicle_service (VID,SSD,SSM,SMF,SSFP,RSS,SVE) values ($id,'$SSD','$SSM','$SMF','$SSFP','$RSS','$SVE')";
                DB::insert($sql);
            }
            
            $IVE =  trim($request->get('IVE'));
            $ISD =  trim($request->get('ISD'));
            if($ISD == "") $ISD = "NULL";
            $ISM = trim($request->ISM) == "" ? 0 : $request->ISM;
            $IMF = trim($request->IMF) == "" ? 0 : $request->IMF;
            $ISFP = trim($request->ISFP) == "" ? 0 : $request->ISFP;
            $RIS = ($request->get("RIS") != null) ? 1 : 0;

            $sql = "SELECT * FROM vehicle_inspect where VID = $id";
            $check = DB::select(DB::raw($sql));
            if(count($check) > 0){
                if($ISD == "NULL")
                    $sql = "update vehicle_inspect set ISD=$ISD,ISM='$ISM',IMF='$IMF',ISFP='$ISFP',RIS='$RIS',IVE='$IVE' where VID = '$id'";
                else
                    $sql = "update vehicle_inspect set ISD='$ISD',ISM='$ISM',IMF='$IMF',ISFP='$ISFP',IVE='$IVE',RIS='$RIS' where VID = '$id'";
                DB::update($sql);
            }else{
                if($ISD == "NULL")
                    $sql = "insert into vehicle_inspect (VID,ISD,ISM,RIS,IMF,ISFP,IVE) values ($id,$ISD,'$ISM','$RIS','$IMF','$ISFP','$IVE')";
                else
                    $sql = "insert into vehicle_inspect (VID,ISD,ISM,RIS,IMF,ISFP,IVE) values ($id,'$ISD','$ISM','$RIS','$IMF','$ISFP','$IVE')";
                DB::insert($sql);
            }

            return redirect('/vehicle')->with('message', 'Vehicle Updated Successfully');
        }

    } 
   
    public function destroy($id)
    {
        $this->check_access("BPC");
        $sql = "SELECT * FROM vehicle where id=$id and driver_id is not null";
        $check = DB::select(DB::raw($sql));
        if(count($check) > 0){
            return redirect('/vehicle')->with('error', 'Vehicle cannot be deleted');
        }else{
            $this->check_access("BPC");
            $vehicle = Vehicle::find($id);
            $vehicle->delete();
            $sql = "delete from vehicle_inspect where VID = $id";
            DB::delete(DB::raw($sql));
            $sql = "delete from vehicle_service where VID = $id";
            DB::delete(DB::raw($sql));
            return redirect('/vehicle')->with('message', 'Vehicle Deleted Successfully');
        }
    }

    public function assigndriver(Request $request){
        $this->check_access("BPF");
        $vehicle = Vehicle::find($request->get('vehicle_id'));
        $DID = $request->get('driver_id');
        $VID = $vehicle->id;
        $password = rand(1001,9999);
        $vehicle->driver_id = $DID;
        $vehicle->status = "pending";
        $vehicle->password = $password;
        $vehicle->save();
        $CAN = $vehicle->CAN;
        $VNO = $vehicle->VNO;
        $UAN = Auth::user()->name;
        $TIM = date("Y-m-d H:i");
        $LDT = date("Y-m-d");
        $sql = "insert into vehicle_log (LDT,CAN,VNO,DID,UAN,TIM,ATN) values ('$LDT','$CAN','$VNO','$DID','$UAN','$TIM','Assign Vehicle')";
        DB::insert($sql);
        $log_id = DB::getPdo()->lastInsertId();
        $CF01 = $request->get('CF01');
        $CF02 = $request->get('CF02');
        $CF03 = $request->get('CF03');
        $CF04 = $request->get('CF04');
        $CF05 = $request->get('CF05');
        $CF06 = $request->get('CF06');
        $CF07 = $request->get('CF07');
        $CF08 = $request->get('CF08');
        $CF09 = $request->get('CF09');
        $CF10 = $request->get('CF10');
        $CF11 = $request->get('CF11');
        $CF12 = $request->get('CF12');
        $CF13 = $request->get('CF13');
        $CF14 = $request->get('CF14');
        $CF15 = $request->get('CF15');
        $CF16 = $request->get('CF16');
        $CF17 = $request->get('CF17');
        $CF18 = $request->get('CF18');

        $CC01 = $request->get('CC01');
        $CC02 = $request->get('CC02');
        $CC03 = $request->get('CC03');
        $CC04 = $request->get('CC04');
        $CC05 = $request->get('CC05');
        $CC06 = $request->get('CC06');
        $CC07 = $request->get('CC07');
        $CC08 = $request->get('CC08');
        $CC09 = $request->get('CC09');
        $CC10 = $request->get('CC10');
        $CC11 = $request->get('CC11');
        $CC12 = $request->get('CC12');
        $CC13 = $request->get('CC13');
        $CC14 = $request->get('CC14');
        $CC15 = $request->get('CC15');
        $CC16 = $request->get('CC16');
        //$acceptance_code = rand(1001,9999);
        $sql = "delete from handover where VNO='$VNO' and driver_id=$DID and accepted=0";
        DB::delete($sql);
        $sql = "insert into  handover (log_id,VNO,driver_id,CF01,CF02,CF03,CF04,CF05,CF06,CF07,CF08,CF09,CF10,CF11,CF12,CF13,CF14,CF15,CF16,CF17,CF18,CC01,CC02,CC03,CC04,CC05,CC06,CC07,CC08,CC09,CC10,CC11,CC12,CC13,CC14,CC15,CC16) values ('$log_id','$VNO','$DID','$CF01','$CF02','$CF03','$CF04','$CF05','$CF06','$CF07','$CF08','$CF09','$CF10','$CF11','$CF12','$CF13','$CF14','$CF15','$CF16','$CF17','$CF18','$CC01','$CC02','$CC03','$CC04','$CC05','$CC06','$CC07','$CC08','$CC09','$CC10','$CC11','$CC12','$CC13','$CC14','$CC15','$CC16')";
        DB::insert($sql);
        $handover_id = DB::getPdo()->lastInsertId();
        $photo = "";
        if($request->photo != null){
            $photo =  $handover_id.'.'.$request->photo->extension(); 
            $filepath = public_path('uploads'.DIRECTORY_SEPARATOR.'photo'.DIRECTORY_SEPARATOR);
            move_uploaded_file($_FILES['photo']['tmp_name'], $filepath.$photo);
        }
        $CFP2 = "";
        if($request->CFP2 != null){
            $CFP2 =  $handover_id.'_front.'.$request->CFP2->extension(); 
            $filepath = public_path('uploads'.DIRECTORY_SEPARATOR.'photo'.DIRECTORY_SEPARATOR);
            move_uploaded_file($_FILES['CFP2']['tmp_name'], $filepath.$CFP2);
        }
        $CFP3 = "";
        if($request->CFP3 != null){
            $CFP3 =  $handover_id.'_right.'.$request->CFP3->extension(); 
            $filepath = public_path('uploads'.DIRECTORY_SEPARATOR.'photo'.DIRECTORY_SEPARATOR);
            move_uploaded_file($_FILES['CFP3']['tmp_name'], $filepath.$CFP3);
        }
        $CFP4 = "";
        if($request->CFP4 != null){
            $CFP4 =  $handover_id.'_rear.'.$request->CFP4->extension(); 
            $filepath = public_path('uploads'.DIRECTORY_SEPARATOR.'photo'.DIRECTORY_SEPARATOR);
            move_uploaded_file($_FILES['CFP4']['tmp_name'], $filepath.$CFP4);
        }
        $CFP5 = "";
        if($request->CFP5 != null){
            $CFP5 =  $handover_id.'_left.'.$request->CFP5->extension(); 
            $filepath = public_path('uploads'.DIRECTORY_SEPARATOR.'photo'.DIRECTORY_SEPARATOR);
            move_uploaded_file($_FILES['CFP5']['tmp_name'], $filepath.$CFP5);
        }
        $sql = "update handover set photo='$photo',CFP2='$CFP2',CFP3='$CFP3',CFP4='$CFP4',CFP5='$CFP5' where id=$handover_id";
        DB::update($sql);
        $sql = "update vehicle set handover_id=$handover_id where id=$VID";
        DB::update($sql);
        $sql = "select DNM,DSN,DCN from driver where id=$DID";
        $result = DB::select(DB::raw($sql));
        $DNM = "";
        $DCN = "";
        if(count($result) > 0){
            $DNM = $result[0]->DNM ." ".$result[0]->DSN;
            $DCN = $result[0]->DCN;
        }
        self::send_sms($VID);
        return redirect('/vehicle')->with('message', 'Driver Assigned Successfully');
    }

   

    public function resendsms($VID){
        self::send_sms($VID);
        return redirect('/fdriver')->with('message', 'SMS Sent Successfully');
    }

    public function assign($id){
        $this->check_access("BPF");
        $today = date("Y-m-d");
        $sql = "SELECT a.*,b.name FROM vehicle a,users b where a.CAN=b.UAN and a.id=$id";
        $vehicle = DB::select(DB::raw($sql));
        $vehicle = $vehicle[0];
        $IEX = $vehicle->IEX;
        $REX = $vehicle->REX;
        if($IEX <= $today){
            return redirect('/vehicle')->with('error', 'Vehicle insurance is expired');
        }
        if($REX <= $today){
            return redirect('/vehicle')->with('error', 'Roadworthy certificate is expired');
        }
        $sql = "SELECT id,DNO,DNM,DSN,DNO,DCN FROM driver where LEX >'$today' and CEX >'$today' and id not in (select driver_id from vehicle where driver_id<>'')";
        $drivers = DB::select(DB::raw($sql));
        return view('vehicle.assign', compact('vehicle','drivers'));
    }

    private function send_sms($VID){
        $sql = "select a.password,b.DCN,b.DNM,b.DSN,b.VBM,b.VAM,b.VPF,b.WDY,b.MDY,b.VPD,c.name,c.UCN from vehicle a,driver b,users c where a.driver_id=b.id and a.CAN=c.UAN and a.id=$VID";
        $vehicle = DB::select(DB::raw($sql));
        $vehicle = $vehicle[0];
        $password = $vehicle->password;
        $VBM = $vehicle->VBM;
        $DNM = $vehicle->DNM;
        $VAM = $vehicle->VAM;
        $VPF = $vehicle->VPF;
        $WDY = $vehicle->WDY;
        $MDY = $vehicle->MDY;
        $VPD = $vehicle->VPD;
        $name = $vehicle->name;
        $UCN = $vehicle->UCN;
        $DNM = $vehicle->DNM." ".$vehicle->DSN;
        $DCN = $vehicle->DCN;
        $SMS = "";
        $SMS = "Dear ".$DNM.",\n";
        $SMS = $SMS ."You have been setup successfully on FOVCollector(v2.1) by FleetOps as follows:\n";
        if($VBM == "Ride Hailing"){
            $SMS = $SMS ."Independent Contractor on Ride Hailing\n";    
            $SMS = $SMS ."Declare sales daily by 10:00am\n";
        }else if($VBM == "Rental"){
            $SMS = $SMS ."Vehicle Rental Customer\n";    
            $SMS = $SMS ."Rental Fee: ".$VAM."\n";    
            $SMS = $SMS ."Payment Freq: ".$VPF."\n";    
            if($VPF == "Weekly"){
                $SMS = $SMS ."Payment Day: ".$WDY."\n";    
            }else if($VPF == "Monthly"){
                $SMS = $SMS ."Payment Day: ".$MDY."\n";    
            }
            $SMS = $SMS ."First Payment: ".$VPD."\n";    
        }else if($VBM == "Hire Purchase"){
            $SMS = $SMS ."Hire Purchase Customer\n";    
            $SMS = $SMS ."Instalment: ".$VAM."\n";    
            $SMS = $SMS ."Payment Freq: ".$VPF."\n";    
            if($VPF == "Weekly"){
                $SMS = $SMS ."Payment Day: ".$WDY."\n";    
            }else if($VPF == "Monthly"){
                $SMS = $SMS ."Payment Day: ".$MDY."\n";    
            }
            $SMS = $SMS ."First Payment: ".$VPD."\n";    
        }
        $SMS = $SMS . "Your password is ".$password.". ";
        $SMS = $SMS ."Please make prompt payments to avoid any inconveniences. For further details you may contact ".$name." on ".$UCN."\n";
        $SMS = $SMS ."Thank you.\n";
        $DAT = date("Y-m-d");
        $TIM = date("H:i:s");
        $CTX = "Driver";
        $sql = "insert into sms_log (PHN,MSG,DAT,TIM,CTX,NAM) values ('$DCN','$SMS','$DAT','$TIM','$CTX','$DNM')";
        DB::insert($sql);
        SMSFleetops::send($DCN,$SMS);
    }

    public function removedriver(Request $request){
        $this->check_access("BPF");
        $vehicle = Vehicle::find($request->get('vehicle_id'));
        $handover_id = $vehicle->handover_id;
        $DID = $vehicle->driver_id;
        
        $CAN = $vehicle->CAN;
        $VNO = $vehicle->VNO;
        $UAN = Auth::user()->name;
        $TIM = date("Y-m-d H:i");
        $LDT = date("Y-m-d");
        $sql = "insert into vehicle_log (LDT,CAN,VNO,DID,UAN,TIM,ATN) values ('$LDT','$CAN','$VNO','$DID','$UAN','$TIM','Unassign Vehicle')";
        DB::insert($sql);
        $log_id = DB::getPdo()->lastInsertId();
        $CF01 = $request->get('CF01');
        $CF02 = $request->get('CF02');
        $CF03 = $request->get('CF03');
        $CF04 = $request->get('CF04');
        $CF05 = $request->get('CF05');
        $CF06 = $request->get('CF06');
        $CF07 = $request->get('CF07');
        $CF08 = $request->get('CF08');
        $CF09 = $request->get('CF09');
        $CF10 = $request->get('CF10');
        $CF11 = $request->get('CF11');
        $CF12 = $request->get('CF12');
        $CF13 = $request->get('CF13');
        $CF14 = $request->get('CF14');
        $CF15 = $request->get('CF15');
        $CF16 = $request->get('CF16');
        $CF17 = $request->get('CF17');
        $CF18 = $request->get('CF18');

        $CC01 = $request->get('CC01');
        $CC02 = $request->get('CC02');
        $CC03 = $request->get('CC03');
        $CC04 = $request->get('CC04');
        $CC05 = $request->get('CC05');
        $CC06 = $request->get('CC06');
        $CC07 = $request->get('CC07');
        $CC08 = $request->get('CC08');
        $CC09 = $request->get('CC09');
        $CC10 = $request->get('CC10');
        $CC11 = $request->get('CC11');
        $CC12 = $request->get('CC12');
        $CC13 = $request->get('CC13');
        $CC14 = $request->get('CC14');
        $CC15 = $request->get('CC15');
        $CC16 = $request->get('CC16');

        $sql = "insert into retrieval (handover_id,log_id,VNO,driver_id,CF01,CF02,CF03,CF04,CF05,CF06,CF07,CF08,CF09,CF10,CF11,CF12,CF13,CF14,CF15,CF16,CF17,CF18,CC01,CC02,CC03,CC04,CC05,CC06,CC07,CC08,CC09,CC10,CC11,CC12,CC13,CC14,CC15,CC16) values ($handover_id,'$log_id','$VNO','$DID','$CF01','$CF02','$CF03','$CF04','$CF05','$CF06','$CF07','$CF08','$CF09','$CF10','$CF11','$CF12','$CF13','$CF14','$CF15','$CF16','$CF17','$CF18','$CC01','$CC02','$CC03','$CC04','$CC05','$CC06','$CC07','$CC08','$CC09','$CC10','$CC11','$CC12','$CC13','$CC14','$CC15','$CC16')";
        DB::insert($sql);
        $retrieval_id = DB::getPdo()->lastInsertId();
        $CFP2 = "";
        if($request->CFP2 != null){
            $CFP2 =  $retrieval_id.'_frontr.'.$request->CFP2->extension(); 
            $filepath = public_path('uploads'.DIRECTORY_SEPARATOR.'photo'.DIRECTORY_SEPARATOR);
            move_uploaded_file($_FILES['CFP2']['tmp_name'], $filepath.$CFP2);
        }
        $CFP3 = "";
        if($request->CFP3 != null){
            $CFP3 =  $retrieval_id.'_rightr.'.$request->CFP3->extension(); 
            $filepath = public_path('uploads'.DIRECTORY_SEPARATOR.'photo'.DIRECTORY_SEPARATOR);
            move_uploaded_file($_FILES['CFP3']['tmp_name'], $filepath.$CFP3);
        }
        $CFP4 = "";
        if($request->CFP4 != null){
            $CFP4 =  $retrieval_id.'_rearr.'.$request->CFP4->extension(); 
            $filepath = public_path('uploads'.DIRECTORY_SEPARATOR.'photo'.DIRECTORY_SEPARATOR);
            move_uploaded_file($_FILES['CFP4']['tmp_name'], $filepath.$CFP4);
        }
        $CFP5 = "";
        if($request->CFP5 != null){
            $CFP5 =  $retrieval_id.'_leftr.'.$request->CFP5->extension(); 
            $filepath = public_path('uploads'.DIRECTORY_SEPARATOR.'photo'.DIRECTORY_SEPARATOR);
            move_uploaded_file($_FILES['CFP5']['tmp_name'], $filepath.$CFP5);
        }
        $sql = "update retrieval set CFP2='$CFP2',CFP3='$CFP3',CFP4='$CFP4',CFP5='$CFP5' where id=$retrieval_id";
        DB::update($sql);
        self::save_pdf($handover_id);
        $vehicle->driver_id  =  null;
        $vehicle->status  =  "";
        $vehicle->handover_id = 0;
        $vehicle->save();
        return redirect('/vehicle')->with('message', 'Driver Removed Successfully');
    }

      private function save_pdf($handover_id){
        $sql = "select a.*,b.chassis_no,b.IEX,b.REX,c.DNM,c.DSN,d.CF01 as RCF01,d.CF02 as RCF02,d.CF03 as RCF03,d.CF04 as RCF04,d.CF05 as RCF05,d.CF06 as RCF06,d.CF07 as RCF07,d.CF08 as RCF08,d.CF09 as RCF09,d.CF10 as RCF10,d.CF11 as RCF11,d.CF12 as RCF12,d.CF13 as RCF13,d.CF14 as RCF14,d.CF15 as RCF15,d.CF16 as RCF16,d.CF17 as RCF17,d.CF18 as RCF18,d.CFP2 as RCFP2,d.CFP3 as RCFP3,d.CFP4 as RCFP4,d.CFP5 as RCFP5,d.CC01 as RCC01,d.CC02 as RCC02,d.CC03 as RCC03,d.CC04 as RCC04,d.CC05 as RCC05,d.CC06 as RCC06,d.CC07 as RCC07,d.CC08 as RCC08,d.CC09 as RCC09,d.CC10 as RCC10,d.CC11 as RCC11,d.CC12 as RCC12,d.CC13 as RCC13,d.CC14 as RCC14,d.CC15 as RCC15,d.CC16 as RCC16 from handover a,vehicle b,driver c,retrieval d where a.VNO=b.VNO and b.driver_id=c.id and a.id=d.handover_id and a.id ='$handover_id'";
        $result = DB::select(DB::raw($sql));
        $pdf = PDF::loadView('retrievalpdf', compact('result'));
        $pdf->save("uploads".DIRECTORY_SEPARATOR."handover".DIRECTORY_SEPARATOR.$handover_id.".pdf");
    }

    public function retrievalpdf(){
        return view('retrievalpdf');
    }


    public function remove($id){
        $this->check_access("BPF");
        $sql = "SELECT a.*,b.name,c.DCN,c.DNO,c.DNM,c.DSN  FROM vehicle a,users b,driver c where a.CAN=b.UAN and a.driver_id=c.id and a.id=$id";
        $vehicle = DB::select(DB::raw($sql));
        $vehicle = $vehicle[0];
        $handover_id = $vehicle->handover_id;
        $sql = "SELECT photo FROM handover where id=$handover_id";
        $result = DB::select(DB::raw($sql));
        $photo = "";
        if(count($result) > 0){
            $photo = $result[0]->photo;
        }
        return view('vehicle.remove', compact('vehicle','photo'));
    }

    public function checkVNO(Request $request){
        $VNO = trim($request->get('VNO'));
        $id = trim($request->get('id'));
        if($id == 0){
            $sql = "SELECT * FROM vehicle where VNO='$VNO'";
        }else{
            $sql = "SELECT * FROM vehicle where VNO='$VNO' and id <> $id";
        }
        $vehicles = DB::select(DB::raw($sql));
        if(count($vehicles) > 0){
            return response()->json(array("exists" => true));
        }else{
            return response()->json(array("exists" => false));   
        }
    }

    public function tracker_device_sn(Request $request){
        $TSN = trim($request->get('TSN'));
        $id = trim($request->get('id'));
        if($id == 0){
            $sql = "SELECT * FROM vehicle where TSN='$TSN'";
        }else{
            $sql = "SELECT * FROM vehicle where TSN='$TSN' and id <> $id";
        }
        $vehicles = DB::select(DB::raw($sql));
        if(count($vehicles) > 0){
            return response()->json(array("exists" => true));
        }else{
            return response()->json(array("exists" => false));   
        }
    }

    public function tracker_id(Request $request){
        $TID = trim($request->get('TID'));
        $id = trim($request->get('id'));
        if($id == 0){
            $sql = "SELECT * FROM vehicle where TID='$TID'";
        }else{
            $sql = "SELECT * FROM vehicle where TID='$TID' and id <> $id";
        }
        $vehicles = DB::select(DB::raw($sql));
        if(count($vehicles) > 0){
            return response()->json(array("exists" => true));
        }else{
            return response()->json(array("exists" => false));   
        }
    }

    public function tracker_sim_no(Request $request){
        $TSM = trim($request->get('TSM'));
        $id = trim($request->get('id'));
        if($id == 0){
            $sql = "SELECT * FROM vehicle where TSM='$TSM'";
        }else{
            $sql = "SELECT * FROM vehicle where TSM='$TSM' and id <> $id";
        }
        $vehicles = DB::select(DB::raw($sql));
        if(count($vehicles) > 0){
            return response()->json(array("exists" => true));
        }else{
            return response()->json(array("exists" => false));   
        }
    }
}

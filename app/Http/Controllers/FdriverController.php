<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;  
use DB;
use App\rhplatform;
use App\Driver;
use App\DriverPlatform;
use Auth;
use App\SMSFleetops;

class FdriverController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    private function check_access($mode){
        if($mode == "BPF" && Auth::user()->usertype != "Admin" && Auth::user()->BPF == false){
            echo "Access Denied";
            die;
        }
    }

   public function index()
   {
        $this->check_access("BPF");
        $sql = "SELECT a.*,b.id as vid,b.VNO FROM driver a LEFT JOIN vehicle b ON a.id = b.driver_id";
        $drivers = DB::select(DB::raw($sql));
        return view('fdriver.index', compact('drivers'));
    }
   
    public function create()
    {
        $this->check_access("BPF");
        $sql = "SELECT * FROM tbl361 where id <> 1";
        $rhplatforms = DB::select(DB::raw($sql));
        return view('fdriver.create', compact('rhplatforms'));
    }
   
    public function store(Request $request)
    {
        
        $this->check_access("BPF");
        $DNO = trim($request->get('DNO'));
        $sql = "SELECT * FROM driver where DNO='$DNO'";
        $drivers = DB::select(DB::raw($sql));
        if(count($drivers) > 0){
            return redirect('/fdriver/create')->with('error', 'Duplicate License Number');
        }else{
            $VPF = "";
            $WDY = 0;
            $MDY = 0;
            $VPD = "";
            $VAM = 0;
            $EPD = 0;
            $NOD = 0;
            $PAM = 0;
            $PAT = 0;
            $NODB = 0;
            $PPR = 0;
            $PDP = 0;
            $SDP = 0;
            if($request->get('VBM') != "Ride Hailing"){
               $VPF = $request->get('VPF');
               $WDY = $request->get('WDY');
               $MDY = $request->get('MDY');
               $VPD = $request->get('VPD'); 
               $VAM = $request->get('VAM'); 
               $EPD = $request->get('EPD'); 
               $NOD = $request->get('NOD'); 
               $NODB = $request->get('NODB'); 
               $PAM = $request->get('PAM'); 
               $PAT = $request->get('PAT'); 
               $PPR = $request->get('PPR'); 
               $PDP = $request->get('PDP'); 
               $SDP = $request->get('SDP'); 
            }
           
            $AVL = ($request->get("AVL") != null) ? 1 : 0;
            $AVC = ($request->get("AVC") != null) ? 1 : 0;
            $DVE = ($request->get("DVE") != null) ? 1 : 0;
            $EPD = ($request->get("EPD") != null) ? 1 : 0;
            $insert = array(
                'DNO' => $request->get('DNO'),
                'DNM' => $request->get('DNM'),
                'DSN' => $request->get('DSN'),
                'DCN' => $request->get('DCN'),
                'VBM' => $request->get('VBM'),
                'VPL' => $request->get('VPL'),
                'VPF' => $VPF,
                'WDY' => $WDY,
                'MDY' => $MDY,
                'VAM' => $VAM,
                'PPR' => $PPR,
                'PDP' => $PDP,
                'SDP' => $SDP,
                'AVC' => $AVC,
                'AVL' => $AVL,
                'DVE' => $DVE,
                'EPD' => $EPD,
                'NOD' => $NOD,
                'NODB' => $NODB,
                'PAM' => $PAM,
                'PAT' => $PAT,
                'LEX' => $request->get('LEX'),
                'CEX' => $request->get('CEX'),
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            );
            if($VPD != "") $insert += array('VPD' => $VPD);
            $driver = new Driver($insert);
            //echo$driver;die;
            $driver->save();
            $last_insert_id = $driver->id;

            $DLD = "";
            if($request->DLD != null){
                $DLD =  $last_insert_id.'_front.'.$request->DLD->extension(); 
                $filepath = public_path('uploads'.DIRECTORY_SEPARATOR.'DLD'.DIRECTORY_SEPARATOR);
                move_uploaded_file($_FILES['DLD']['tmp_name'], $filepath.$DLD);
            }
            $DLD2 = "";
            if($request->DLD2 != null){
                $DLD2 =  $last_insert_id.'_back.'.$request->DLD2->extension(); 
                $filepath = public_path('uploads'.DIRECTORY_SEPARATOR.'DLD'.DIRECTORY_SEPARATOR);
                move_uploaded_file($_FILES['DLD2']['tmp_name'], $filepath.$DLD2);
            }
            $VCC = "";
            if($request->VCC != null){
                $VCC =  $last_insert_id.'.'.$request->VCC->extension(); 
                $filepath = public_path('uploads'.DIRECTORY_SEPARATOR.'VCC'.DIRECTORY_SEPARATOR);
                move_uploaded_file($_FILES['VCC']['tmp_name'], $filepath.$VCC);
            }
            $driver = Driver::find($last_insert_id);
            $driver->DLD  =  $DLD;
            $driver->DLD2  =  $DLD2;
            $driver->VCC  =  $VCC;
            $driver->save();

            $sql = "delete from driver_platform where driver_id=$last_insert_id";
            DB::delete(DB::raw($sql));
            
            $PLFS = $request->get('PLF');
            foreach($PLFS as $PLF){
                $driverplatform = new DriverPlatform();
                $driverplatform->driver_id = $last_insert_id;
                $driverplatform->PLF = $PLF;
                $driverplatform->save();
            }
            return redirect('/fdriver')->with('message', 'Driver added Successfully');
        }
    }
      
    public function edit($id)
    {
        $this->check_access("BPF");
        $sql = "SELECT * FROM tbl361 where id <> 1";
        $rhplatforms = DB::select(DB::raw($sql));
        $driver = Driver::find($id);
        $sql = "SELECT PLF FROM driver_platform where driver_id='$id'";
        $driver_platforms = DB::select(DB::raw($sql));
        $password = "";
        $vehicle_id = 0;
        $sql = "SELECT * FROM vehicle where driver_id = $id";
        $result = DB::select(DB::raw($sql));
        if(count($result) > 0){
            $password = $result[0]->password;
            $vehicle_id = $result[0]->id;
        }
        $workflow = 0;
        $sql = "select * from driver_upload where doc_type in ('Licence','Contract') and approved=0 and driver_id=$id";
        $result = DB::select(DB::raw($sql));
        if(count($result) > 0){
            $workflow = 1;
        }
        return view('fdriver.edit', compact('driver','rhplatforms','driver_platforms','password','vehicle_id','workflow'));
    }
   
    public function update(Request $request, $id)
    {
        $this->check_access("BPF");
        $DNO = trim($request->get('DNO'));
        $sql = "SELECT * FROM driver where DNO='$DNO' and id <> $id";
        $drivers = DB::select(DB::raw($sql));
        if(count($drivers) > 0){
            return redirect("/driver/$id/edit")->with('error', 'Duplicate License Number');
        }else{
            $DLD = "";
            if($request->DLD != null){
                $DLD =  $id.'_front.'.$request->DLD->extension(); 
                $filepath = public_path('uploads'.DIRECTORY_SEPARATOR.'DLD'.DIRECTORY_SEPARATOR);
                move_uploaded_file($_FILES['DLD']['tmp_name'], $filepath.$DLD);
            }
            $DLD2 = "";
            if($request->DLD2 != null){
                $DLD2 =  $id.'_back.'.$request->DLD2->extension(); 
                $filepath = public_path('uploads'.DIRECTORY_SEPARATOR.'DLD'.DIRECTORY_SEPARATOR);
                move_uploaded_file($_FILES['DLD2']['tmp_name'], $filepath.$DLD2);
            }
            $VCC = "";
            if($request->VCC != null){
                $VCC =  $id.'.'.$request->VCC->extension(); 
                $filepath = public_path('uploads'.DIRECTORY_SEPARATOR.'VCC'.DIRECTORY_SEPARATOR);
                move_uploaded_file($_FILES['VCC']['tmp_name'], $filepath.$VCC);
            }
            $driver = Driver::find($id);
            $VPF = "";
            $WDY = 0;
            $MDY = 0;
            $VPD = NULL;
            $VAM = 0;
            $EPD = 0;
            $NOD = 0;
            $PAM = 0;
            $PAT = 0;
            $PPR = 0;
            $PDP = 0;
            $SDP = 0;
            if($request->get('VBM') != "Ride Hailing"){
               $VPF = $request->get('VPF');
               $WDY = $request->get('WDY');
               $MDY = $request->get('MDY');
               $VPD = $request->get('VPD'); 
               $VAM = $request->get('VAM'); 
               $EPD = $request->get('EPD'); 
               $NOD = $request->get('NOD'); 
               $NODB = $request->get('NODB'); 
               $PAM = $request->get('PAM'); 
               $PAT = $request->get('PAT'); 
               $PPR = $request->get('PPR'); 
               $PDP = $request->get('PDP'); 
               $SDP = $request->get('SDP'); 
            }
            $AVL = ($request->get("AVL") != null) ? 1 : 0;
            $AVC = ($request->get("AVC") != null) ? 1 : 0;
            $DVE = ($request->get("DVE") != null) ? 1 : 0;
            $EPD = ($request->get("EPD") != null) ? 1 : 0;
            $NODB = ($request->get("NODB") != null) ? 1 : 0;
            $driver->DNO =  $request->get('DNO');
            $driver->DNM =  $request->get('DNM');
            $driver->DSN =  $request->get('DSN');
            $DNM = $driver->DNM . " " . $driver->DSN;
            $driver->DCN =  $request->get('DCN');
            $DCN = $driver->DCN;
            $driver->VPL =  $request->get('VPL');
            if($DLD != "") $driver->DLD  =  $DLD;
            if($DLD2 != "") $driver->DLD2  =  $DLD2;
            if($VCC != "") $driver->VCC  =  $VCC;
            if($request->get('VBM') != ""){
                $driver->VBM =  $request->get('VBM');
            }
            $driver->VPF =  $VPF;
            $driver->WDY =  $WDY;
            $driver->MDY =  $MDY;
            $driver->VPD =  $VPD;
            $driver->VAM =  $VAM;
            $driver->EPD =  $EPD;
            $driver->NOD =  $NOD;
            $driver->NODB =  $NODB;
            $driver->PAM =  $PAM;
            $driver->PAT =  $PAT;
            $driver->PPR =  $PPR;
            $driver->PDP =  $PDP;
            $driver->SDP =  $SDP;
            $driver->LEX =  $request->get('LEX');
            $driver->CEX =  $request->get('CEX');
            $driver->updated_at =  date("Y-m-d H:i:s");
            $password = ($request->get("password") != null) ? $request->get('password') : "";  
            $driver->save();

            $sql = "update vehicle set password='$password' where driver_id=$id";
            DB::update(DB::raw($sql));

            $sql = "delete from driver_platform where driver_id=$id";
            DB::delete(DB::raw($sql));
            
            $PLFS = $request->get('PLF');
            foreach($PLFS as $PLF){
                $driverplatform = new DriverPlatform();
                $driverplatform->driver_id = $id;
                $driverplatform->PLF = $PLF;
                $driverplatform->save();
            }

            $send = ($request->get("send") != null) ? 1 : 0;
            if($send == 1){
                $SMS = "";
                $SMS = "Dear ".$DNM.",\n";
                $SMS = $SMS ."You password has been reset.\n";
                $SMS = $SMS . "Your new password is ".$password.". ";
                $DAT = date("Y-m-d");
                $TIM = date("H:i:s");
                $CTX = "Driver";
                $sql = "insert into sms_log (PHN,MSG,DAT,TIM,CTX,NAM) values ('$DCN','$SMS','$DAT','$TIM','$CTX','$DNM')";
                DB::insert($sql);
                SMSFleetops::send($DCN,$SMS); 
            }

            return redirect('/fdriver')->with('message', 'Driver Updated Successfully');
        }

    }
   
    public function destroy($id)
    {
        $this->check_access("BPF");
        $sql = "SELECT * FROM vehicle where driver_id=$id";
        $check = DB::select(DB::raw($sql));
        if(count($check) > 0){
            return redirect('/fdriver')->with('error', 'Driver cannot be deleted');
        }else{
            $driver = Driver::find($id);
            $driver->delete();
            return redirect('/fdriver')->with('message', 'Driver Deleted Successfully');
        }
    }

    public function checkDNO(Request $request){
        $DNO = trim($request->get('DNO'));
        $id = trim($request->get('id'));
        if($id == 0){
            $sql = "SELECT * FROM driver where DNO='$DNO'";
        }else{
            $sql = "SELECT * FROM driver where DNO='$DNO' and id <> $id";
        }
        $drivers = DB::select(DB::raw($sql));
        if(count($drivers) > 0){
            return response()->json(array("exists" => true));
        }else{
            return response()->json(array("exists" => false));   
        }
    }

    public function checkDCN(Request $request){
        $DCN = trim($request->get('DCN'));
        $id = trim($request->get('id'));
        if($id == 0){
            $sql = "SELECT * FROM driver where DCN='$DCN'";
        }else{
            $sql = "SELECT * FROM driver where DCN='$DCN' and id <> $id";
        }
        $drivers = DB::select(DB::raw($sql));
        if(count($drivers) > 0){
            return response()->json(array("exists" => true));
        }else{
            return response()->json(array("exists" => false));   
        }
    }
}

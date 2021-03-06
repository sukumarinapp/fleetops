<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/test', 'HomeController@test')->name('test');
Route::get('/replay', 'HomeController@replay')->name('replay');
Route::get('/track/{VNO}/{starttime}/{endtime}','HomeController@track')->name('track');
Route::get('/parameter', 'ParameterController@index')->name('parameter');
Route::post('/paramupdate','ParameterController@update')->name('paramupdate');
Route::resource('/rhplatform', 'RHPlatformController');

Route::resource('/manager', 'ManagerController');
Route::post('/checkemail','ManagerController@checkEmail')->name('checkemail');
Route::post('/duplicateUserContact','ManagerController@duplicateUserContact')->name('duplicateUserContact');
Route::resource('/client', 'ClientController');
Route::resource('/vehicle', 'VehicleController');
Route::get('/allvehicle/{sort}', 'VehicleController@allvehicle')->name('allvehicle');
Route::get('/assignvehicle/{id}', 'VehicleController@assign')->name('assignvehicle');
Route::post('/assigndriver','VehicleController@assigndriver')->name('assigndriver');

Route::get('/cancel_process/{id}', 'WorkflowController@cancel_process')->name('cancel_process');
Route::get('/cancel_handover/{id}', 'WorkflowController@cancel_handover')->name('cancel_handover');
Route::get('/reject_handover/{id}', 'DriverController@reject_handover')->name('reject_handover');
Route::get('/reject_contract', 'DriverController@reject_contract')->name('reject_contract');
Route::get('/reject_inspection', 'DriverController@reject_inspection')->name('reject_inspection');
Route::get('/removevehicle/{id}', 'VehicleController@remove')->name('removevehicle');
Route::get('/send_warningsms/{type}/{driver_id}', 'VehicleController@send_warningsms')->name('send_warningsms');
Route::post('/removedriver','VehicleController@removedriver')->name('removedriver');
Route::resource('/fdriver', 'FdriverController');
Route::get('/agreementdriver/{id}', 'FdriverController@agreementdriver')->name('agreementdriver');
Route::post('/checkDNO','FdriverController@checkDNO')->name('checkDNO');
Route::post('/checkDCN','FdriverController@checkDCN')->name('checkDCN');
Route::post('/checkVNO','VehicleController@checkVNO')->name('checkVNO');
Route::post('/tracker_device_sn','VehicleController@tracker_device_sn')->name('tracker_device_sn');
Route::post('/tracker_id','VehicleController@tracker_id')->name('tracker_id');
Route::post('/tracker_sim_no','VehicleController@tracker_sim_no')->name('tracker_sim_no');
Route::get('/sms', 'SMSController@index')->name('sms');
Route::post('/smsupdate','SMSController@update')->name('smsupdate');
Route::get('/change_password','ManagerController@change_password')->name('change_password');
Route::post('/update_password','ManagerController@update_password')->name('update_password');

Route::get('/driver', 'DriverController@index')->name('driver');
Route::get('/driverlogin', 'DriverController@driverlogin')->name('driverlogin');
Route::post('/validate_login', 'DriverController@validate_login')->name('validate_login');
Route::get('/otp', 'DriverController@otp')->name('otp');
Route::post('/resend_otp', 'DriverController@resend_otp')->name('resend_otp');
Route::post('/validate_otp', 'DriverController@validate_otp')->name('validate_otp');
Route::get('/myaccount', 'DriverController@myaccount')->name('myaccount');
Route::get('/tasks', 'DriverController@tasks')->name('tasks');
Route::get('/agreement', 'DriverController@agreement')->name('agreement');
Route::get('/receipts', 'DriverController@receipts')->name('receipts');
Route::get('/salesreport', 'DriverController@salesreport')->name('salesreport');
Route::get('/buyerstatement', 'DriverController@buyerstatement')->name('buyerstatement');
Route::get('/uploadlicence', 'DriverController@uploadlicence')->name('uploadlicence');
Route::post('/savelicence', 'DriverController@savelicence')->name('savelicence');
Route::get('/uploadinsurance', 'DriverController@uploadinsurance')->name('uploadinsurance');
Route::post('/saveinsurance', 'DriverController@saveinsurance')->name('saveinsurance');
Route::post('/save_new_insurance', 'WorkflowController@save_new_insurance')->name('save_new_insurance');
Route::post('/save_new_roadworthy', 'WorkflowController@save_new_roadworthy')->name('save_new_roadworthy');
Route::post('/save_new_licence', 'WorkflowController@save_new_licence')->name('save_new_licence');
Route::post('/save_contract', 'WorkflowController@save_contract')->name('save_contract');
Route::get('/uploadroadworthy', 'DriverController@uploadroadworthy')->name('uploadroadworthy');
Route::post('/saveroadworthy', 'DriverController@saveroadworthy')->name('saveroadworthy');
Route::get('/vehiclehandover', 'DriverController@vehiclehandover')->name('vehiclehandover');
Route::get('/contract', 'DriverController@contract')->name('contract');
Route::get('/inspect', 'DriverController@inspect')->name('inspect');
Route::post('/acceptcontract', 'DriverController@acceptcontract')->name('acceptcontract');
Route::post('/acceptinspection', 'DriverController@acceptinspection')->name('acceptinspection');
Route::post('/acceptance_code', 'DriverController@acceptance_code')->name('acceptance_code');
Route::post('/accept_handover', 'DriverController@accept_handover')->name('accept_handover');
Route::post('/confirm_handover', 'DriverController@confirm_handover')->name('confirm_handover');
Route::get('/handoverpdf', 'DriverController@handoverpdf')->name('handoverpdf');
Route::get('/retrievalpdf', 'VehicleController@retrievalpdf')->name('retrievalpdf');
Route::post('/accept_code', 'DriverController@accept_code')->name('accept_code');
Route::get('/uploadservice', 'DriverController@uploadservice')->name('uploadservice');
Route::post('/saveservicedriver', 'DriverController@saveservicedriver')->name('saveservicedriver');
Route::get('/drivervno', 'DriverController@drivervno')->name('drivervno');
Route::post('/drivervnovalid', 'DriverController@drivervnovalid')->name('drivervnovalid');
Route::get('/driverrhsales', 'DriverController@driverrhsales')->name('driverrhsales');
Route::get('/driverrental', 'DriverController@driverrental')->name('driverrental');
Route::get('/drivervnoerror', 'DriverController@drivervnoerror')->name('drivervnoerror');
Route::post('/driverpay','DriverController@driverpay')->name('driverpay');
Route::post('/driverpaysave','DriverController@driverpaysave')->name('driverpaysave');
Route::get('/driverpaysuccess', 'DriverController@driverpaysuccess')->name('driverpaysuccess');
Route::get('/prompt', 'DriverController@prompt')->name('prompt');
Route::get('/billbox', 'DriverController@billbox')->name('billbox');

Route::get('/balance/{DCR}', 'DriverController@balance')->name('balance');
Route::get('/driverpayerror', 'DriverController@driverpayerror')->name('driverpayerror');
Route::get('/driverhelp/{VNO}/{DCN}', 'DriverController@driverhelp')->name('driverhelp');
Route::get('/resendsms/{VID}', 'VehicleController@resendsms')->name('resendsms');
Route::get('/driverhelp1/{VNO}/{DCN}', 'DriverController@driverhelp1')->name('driverhelp1');
Route::get('/driverhelp2/{VNO}/{DCN}', 'DriverController@driverhelp2')->name('driverhelp2');
Route::get('/driverhelp3/{VNO}/{DCN}', 'DriverController@driverhelp3')->name('driverhelp3');
Route::get('/driverhelpprev1/{VNO}/{DCN}', 'DriverController@driverhelpprev1')->name('driverhelpprev1');
Route::get('/driverhelpprev2/{VNO}/{DCN}', 'DriverController@driverhelpprev2')->name('driverhelpprev2');
Route::get('/driverhelpprev3/{VNO}/{DCN}', 'DriverController@driverhelpprev3')->name('driverhelpprev3');

Route::get('/workflow', 'WorkflowController@index')->name('workflow');
Route::get('/vehiclelog/{from}/{to}/{ref}', 'WorkflowController@vehiclelog')->name('vehiclelog');
Route::get('/rhreport/{from}/{to}', 'WorkflowController@rhreport')->name('rhreport');
Route::get('/sales/{from}/{to}', 'WorkflowController@sales')->name('sales');
Route::get('/collection/{from}/{to}', 'WorkflowController@collection')->name('collection');
Route::get('/notificationslog/{from}/{to}/{ref}', 'WorkflowController@notificationslog')->name('notificationslog');
Route::get('/telematicslog/{from}/{to}', 'WorkflowController@telematicslog')->name('telematicslog');
Route::get('/movementlog/{from}/{to}/{VNO}', 'WorkflowController@movementlog')->name('movementlog');
Route::get('/alertlog/{from}/{to}', 'HomeController@alertlog')->name('alertlog');
Route::get('/raisedflags/{from}/{to}', 'WorkflowController@raisedflags')->name('raisedflags');
Route::get('/acknowledge/{id}', 'HomeController@acknowledge')->name('acknowledge');
Route::get('/workflowlog/{from}/{to}', 'WorkflowController@workflowlog')->name('workflowlog');
Route::get('/override/{VNO}', 'WorkflowController@override')->name('override');
Route::get('/last_location/{VNO}', 'HomeController@last_location')->name('last_location');
Route::get('/overrides/{VNO}', 'WorkflowController@overrides')->name('overrides');
Route::post('/saveoverride', 'WorkflowController@saveoverride')->name('saveoverride');
Route::get('/auditsrch', 'WorkflowController@auditsrch')->name('auditsrch');
Route::get('/auditing/{VNO}/{DCR}', 'WorkflowController@auditing')->name('auditing');
Route::post('/rhresettesting/{DCR}', 'WorkflowController@rhresettesting')->name('rhresettesting');
Route::post('/resendsms/{id}', 'WorkflowController@resendsms')->name('resendsms');
Route::post('/auditingsave', 'WorkflowController@auditingsave')->name('auditingsave');
Route::get('/inspection/{id}', 'WorkflowController@vehicleinspection')->name('inspection');
Route::post('/saveinspection', 'WorkflowController@saveinspection')->name('saveinspection');
Route::post('/saveservice', 'WorkflowController@saveservice')->name('saveservice');
Route::get('/insurance/{id}', 'WorkflowController@insurance')->name('insurance');
Route::get('/approve_insurance/{id}', 'WorkflowController@approve_insurance')->name('approve_insurance');
Route::get('/reject_doc/{id}', 'WorkflowController@reject_doc')->name('reject_doc');
Route::get('/reject_insurance/{id}', 'WorkflowController@reject_insurance')->name('reject_insurance');
Route::get('/reject_roadworthy/{id}', 'WorkflowController@reject_roadworthy')->name('reject_roadworthy');
Route::get('/roadworthy/{id}', 'WorkflowController@roadworthy')->name('roadworthy');
Route::get('/approve_roadworthy/{id}', 'WorkflowController@approve_roadworthy')->name('approve_roadworthy');
Route::get('/licence/{id}', 'WorkflowController@licence')->name('licence');
Route::get('/renew/{id}', 'WorkflowController@renew')->name('renew');
Route::get('/service/{id}', 'WorkflowController@service')->name('service');
Route::get('/approve_licence/{id}', 'WorkflowController@approve_licence')->name('approve_licence');
Route::get('/copy_test', 'WorkflowController@copy_test')->name('copy_test');


Route::get('/locations', 'HomeController@locations')->name('locations');
Route::get('/vehicle_location/{VNO}', 'HomeController@vehicle_location')->name('vehicle_location');
Route::get('/initial_location/{VNO}', 'HomeController@initial_location')->name('initial_location');
Route::get('/alerts', 'HomeController@alerts')->name('alerts');

Route::get('/fuelsrch', 'FuelController@fuelsrch')->name('fuelsrch');
Route::get('/fueler/{VNO}', 'FuelController@fueler')->name('fueler');
Route::get('/fuel_consumed/{DCR}', 'WorkflowController@fuel_consumed')->name('fuel_consumed');

Route::get('/help', 'WorkflowController@help')->name('help');

Route::get('/test', 'HomeController@test')->name('test');


Route::get('/test_tracker_command', 'VehicleController@test_tracker_command')->name('test_tracker_command');
Route::post('/insert_tracker_command', 'VehicleController@insert_tracker_command')->name('insert_tracker_command');





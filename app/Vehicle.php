<?php
  
namespace App;
  
use Illuminate\Database\Eloquent\Model;
   
class Vehicle extends Model
{
    protected $fillable = [
        'CAN','VDT','driver_id','VNO','VID','VRD','IEX','REX','AVI','AVR','VMK','VMD','VCL','CON','VFT','VFC',
        'TSN','TID','TSM','TIP','VZ1','VZC0','VZC1','VBC1','VBC0','VTV','ECY' 
    ];

    protected $table = 'vehicle';
    
    protected $primaryKey = 'id';

}

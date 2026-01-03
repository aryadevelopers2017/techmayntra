<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
use App\Models\Customer;

class project_milestone extends Model
{
    use HasFactory;

    protected $table = 'project_milestone';

    protected $dates = ['deleted_at'];
    protected $fillable = ['id', 'project_id', 'milestone_id', 'milestone', 'start_date', 'due_date', 'remarks', 'created_at', 'updated_at'];

    public static function get_ProjectMilestoneByProjectId($id)
    {
        $result=project_milestone::where(['project_id' => $id])->get();

        return $result;
    }
    
    public static function add($request)
    {
        date_default_timezone_set("Asia/Kolkata");
        $date = date("Y-m-d h:i:s");
        $i=0;

        while($request->total_milestone>=$i)
        {
        	$i++;
        	$milestone_no='milestone_no_'.$i;
        	$milestone='milestone_'.$i;
        	$start_date='start_date'.$i;
        	$due_date='due_date'.$i;
        	$remarks='remarks'.$i;

        	$start_date=$request->$start_date;
        	$due_date=$request->$due_date;
        	$remarks=$request->$remarks;

        	if($start_date!='' && $due_date!='')
        	{
				$existing_data=project_milestone::where(['project_id' => $request->project_id, 'milestone' => $request->$milestone])->get();

				if(isset($existing_data[0]->id))
				{
					$id=$existing_data[0]->id;

					$result=project_milestone::find($id);

					$result->start_date=$start_date;
					$result->due_date=$due_date;
					$result->remarks=$remarks;

					$result->update();
				}
				else
			    {
				    $data=new project_milestone();

				    $data->project_id=$request->project_id;
				    $data->milestone_id=$request->$milestone_no;
				    $data->milestone=$request->$milestone;
				    $data->start_date=$start_date;
					$data->due_date=$due_date;
					$data->remarks=$remarks;
					
			        $data->save();
			    }
			}
        }
    }
}

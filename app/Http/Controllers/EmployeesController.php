<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Employees;
use App\Companies;

class EmployeesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    { 

        return view('employees.index');
    }
 
    public function list(Request $request)
    {
        $columns = array( 
            0 => 'id',
            1 => 'first_name',
            2 => 'last_name',
            3 => 'email',
            4 => 'phone',
        );
  
        $totalData = Employees::count();
        $totalFiltered = $totalData; 
        $limit = $request->request->get('length');
        $start = $request->request->get('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if(!empty($request->input('search.value')))
        {            
            $search = $request->input('search.value'); 

            $posts =  Employees::where(function ($query) use($search){
                        $query->orWhere('first_name', 'LIKE',"%{$search}%")
                        ->orWhere('last_name','LIKE',"%{$search}%")
                        ->orWhere('email', 'LIKE',"%{$search}%")
                        ->orWhere('phone','LIKE',"%{$search}%")
                        ->orWhere('id','LIKE',"%{$search}%");
                    })
                    ->offset($start)
                    ->limit($limit)
                    ->orderBy($order,$dir)
                    ->get();

            $totalFiltered = Employees::where(function ($query) use($search){
                         $query->orWhere('first_name', 'LIKE',"%{$search}%")
                        ->orWhere('last_name','LIKE',"%{$search}%")
                        ->orWhere('email', 'LIKE',"%{$search}%")
                        ->orWhere('phone','LIKE',"%{$search}%")
                        ->orWhere('id','LIKE',"%{$search}%");
                    })
                    ->count();
        }   
        else
        {            
            $posts = Employees::offset($start)
                    ->limit($limit)
                    ->orderBy($order,$dir)
                    ->get();
        }
        $data = array();
        $data1=array();

        if(count($posts) > 0)
        {
            foreach ($posts as $post) 
            {

                $first_name = $post->first_name ? $post->first_name : '';
                $last_name = $post->last_name ? $post->last_name : '';
                $email = $post->email ? $post->email : '';
                $phone= $post->phone ? $post->phone : '';
            
                $data['id'] = $post->id;
                $data['first_name'] = $first_name;
                $data['last_name'] = $last_name;
                $data['email'] = $email;
                $data['phone'] = $phone;

                $data['action'] = "<div class='d-flex'><a style='float:left;' href=".route('employees.form',['id'=>$post->id])." title='EDIT' class='btn btn-primary' >Edit</a>
                <form style='float:left;margin-left:6px;' method='POST' action=".route('employees.delete',['id'=>$post->id]).">";
               
                $data['action'] .=  csrf_field();
                $data['action'] .= method_field("DELETE");
                $data['action'] .=  "<button class='btn btn-danger'>Delete</button></form></div>";

                $data1[]=$data;
            }
        }
        $json_data = array(
            "draw"            => intval($request->request->get('draw')),  
            "recordsTotal"    => intval($totalData),  
            "recordsFiltered" => intval($totalFiltered),
            "data"            => $data1   
        );
        echo json_encode($json_data); 
    }
    
    public function form(Request $request)
    {   
        $Employees = $request->id ? Employees::find($request->id) : new Employees ;
        $compniesList = Companies::all();

        return view('employees.create',['Employees'=>$Employees,'compniesList'=>$compniesList]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'company_id' => 'required',
        ]);
        if($validator->fails())
        {
            return redirect()->route('employees.form',['id'=>$request->id])->withErrors($validator)->withInput();
        } 

        $Employees = $request->id ? Employees::findOrFail($request->id) : new Employees;
        
        $Employees->first_name = $request->first_name;
        $Employees->last_name = $request->last_name;
        $Employees->email = $request->email;
        $Employees->phone = $request->phone;
        $Employees->company_id = $request->company_id;
     
        $Employees->save();
        
        $message = $request->id ? "Employees Updated Successfully" :"New Employees Created Successfully";
        
        return redirect()->route('employees.index')->with('message', $message );

    }

    public function destroy($id)
    {   
        $Employees = Employees::findOrFail($id);
        $Employees->delete();
        return redirect()->route('employees.index')->with('message',"Employees Deleted Successfully");
      
    }

}

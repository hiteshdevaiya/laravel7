<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Companies;
use URL;

class CompaniesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    { 

        return view('companies.index');
    }

    public function list(Request $request)
    {
        $columns = array( 
            0 => 'id',
            1 => 'name',
            2 => 'email',
            3 => 'website',
        );
  
        $totalData = Companies::count();
        $totalFiltered = $totalData; 
        $limit = $request->request->get('length');
        $start = $request->request->get('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if(!empty($request->input('search.value')))
        {            
            $search = $request->input('search.value'); 

            $posts =  Companies::where(function ($query) use($search){
                        $query->orWhere('name', 'LIKE',"%{$search}%")
                        ->orWhere('email', 'LIKE',"%{$search}%")
                        ->orWhere('website', 'LIKE',"%{$search}%")
                        ->orWhere('id','LIKE',"%{$search}%");
                    })
                    ->offset($start)
                    ->limit($limit)
                    ->orderBy($order,$dir)
                    ->get();

            $totalFiltered = Companies::where(function ($query) use($search){
                        $query->orWhere('name', 'LIKE',"%{$search}%")
                        ->orWhere('email', 'LIKE',"%{$search}%")
                        ->orWhere('website', 'LIKE',"%{$search}%")
                        ->orWhere('id','LIKE',"%{$search}%");
                    })
                    ->count();
        }   
        else
        {            
            $posts = Companies::offset($start)
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

                $name = $post->name ? $post->name : '';
                $email = $post->email ? $post->email : '';
                $website = $post->website ? $post->website : '';
                $img= $post->logo ? $post->logo : '';
                
                if($img != '' && file_exists(public_path('/companies_image/'.$img)))
                {
                    $image = "<img src=".URL::To('public/companies_image/'.$img)." width='50px' height='50px'>";
                }
                else
                {
                    $image = "<img src=".URL::To('public/default.jpg')." width='50px' height='50px'>";
                }
                
                $data['id'] = $post->id;
                $data['name'] = $name;
                $data['email'] = $email;
                $data['logo'] = $image;
                $data['website'] = $website;

                $data['action'] = "<div class='d-flex'><a style='float:left;' href=".route('companies.form',['id'=>$post->id])." title='EDIT' class='btn btn-primary' >Edit</a>
                <form style='float:left;margin-left:6px;' method='POST' action=".route('companies.delete',['id'=>$post->id]).">";
               
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
        $Companies = $request->id ? Companies::find($request->id) : new Companies ;

        return view('companies.create',['Companies'=>$Companies]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'logo' => 'dimensions:min_width=100,min_height=100',
        ]);
        if($validator->fails())
        {
            return redirect()->route('companies.form',['id'=>$request->id])->withErrors($validator)->withInput();
        } 

        $Companies = $request->id ? Companies::findOrFail($request->id) : new Companies;
        
        $Companies->name = $request->name;
        $Companies->email = $request->email;
        $Companies->website = $request->website;
      
        if ($request->hasFile('logo')) {
            $oldFile = $Companies->logo ? $Companies->logo : '';
            if($oldFile != ''){
                if(file_exists(public_path('companies_image/'.$Companies->logo))){
                    $oldFile = $Companies->logo ? public_path('companies_image/'.$Companies->logo) : '';
                    $oldFile != '' ? unlink($oldFile) : '';
                }
                
            }
            $files = $request->logo;
            $destinationPath = public_path('companies_image/'); // upload path
            $cat_image = time() . "." . $files->getClientOriginalName();
           
            $files->move($destinationPath, $cat_image);
            $Companies->logo = $cat_image;    
        } 

        $Companies->save();
        
        $message = $request->id ? "Companies Updated Successfully" :"New Companies Created Successfully";
        
        return redirect()->route('companies.index')->with('message', $message );

    }

    public function destroy($id)
    {   
        $Companies = Companies::findOrFail($id);

        $oldFile = $Companies->logo ? $Companies->logo : '';
            if($oldFile != ''){
                if(file_exists(public_path('companies_image/'.$Companies->logo))){
                    $oldFile = $Companies->logo ? public_path('companies_image/'.$Companies->logo) : '';
                    $oldFile != '' ? unlink($oldFile) : '';
                }
                
            }

        $Companies->delete();
        return redirect()->route('companies.index')->with('message',"Companies Deleted Successfully");
      
    }
}

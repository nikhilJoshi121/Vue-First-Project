<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;   

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $getData = Category::paginate(3);
        
        return response()->json($getData, 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       $request->validate([ 'name'=>'required| min:3',
                            'image'=> 'required|image|mimes:jpeg,png,jpg'
                         ]);
      
        if($request->hasFile('image'))
        {
            $file = $request->file('image');
            $filename = rand(1, 999).$file->getClientOriginalName();
            $file->move('userImages/', $filename);

        }

      
        $data = Category::create([ 'name'=>$request['name'],
                            'image'=>$filename,
         ]);


        return response()->json(['data'=> $data,'result'=>'successful submited data!'], 200);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
       
        $request->validate([ 'name'=>'required| min:3',
        // 'image'=> 'required|image|mimes:jpeg,png,jpg'
                             ]);

            $old = Category::find($id);

            if($request->hasFile('image')){
            
                if(file_exists('userImages/'.$old->image)){
                    unlink('userImages/'.$old->image);
                }     
            }
  

            if($request->hasFile('image'))
            {
                $request->validate([ 
                 'image'=> 'required|image|mimes:jpeg,png,jpg'
                                     ]);
                $file = $request->file('image');
                $filename = rand(1, 999).$file->getClientOriginalName();
                $file->move('userImages/', $filename);

            }else{
                $filename =  $old->image;
            }


            Category::whereId($id)->update([ 'name'=>$request['name'],
                                                     'image'=>$filename,
            ]);

           $data = Category::findOrFail($id);
            return response()->json(['data'=> $data,'result'=>'successful Updated data!'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $id = Category::find($id);
        
        if(file_exists('userImages/'.$id->image)){

            unlink('userImages/'.$id->image);
        }
          

        if($id->delete()){
            return response()->json(['result'=>'Category Successfuly deleted',
                                      'status_code'=> 200
                                   ], 200);

        } else {
            return response()->json(['result'=>'Some Error Occured., please try again later',
                                    'status_code'=> 500
                                ], 500);

        }
    }

  
}

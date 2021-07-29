<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Person;
use App\Models\FileUpload;
use Illuminate\Support\Facades\DB;

class PersonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $people = Person::get();
        
        return response()->json([
            'people' => $people,
        ]);
    }

    public function changestatus(Request $request)
    {
        $sql = "UPDATE people SET is_active = IF(is_active=1, 0, 1) WHERE id=".$request->id;

        if(DB::update($sql)){
            return response()->json(['status' => 'success']);
        }
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validated = $request->validate([
            'name' => 'required|max:255',
            'surname' => 'required',
            'file' => 'required|mimes:jpg,jpeg,png,csv,txt,xlx,xls,pdf|max:2048',
        ]);

        $person = new Person;

        
        try {

            if($request->file){
                $name = time().'_'.$request->file->getClientOriginalName();
                
                \Image::make($request->file)->save(public_path('uploads/').$name);
                // $request->merge(['file' => $name]);
                $person->picture = $name;

            }
            
            $person->name = $request->name;
            $person->surname = $request->surname;
            // $person->picture = $request->file;
            $person->is_active = (bool) $request->is_active;

            if($person->save()){
                return response()->json(['status' => 'success']); 
            }
            
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ]);
        }
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

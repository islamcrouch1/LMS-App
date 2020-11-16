<?php

namespace App\Http\Controllers\API;


use App\Http\Resources\LearningSystemCollection;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\LearningSystem;
use Illuminate\Support\Facades\Validator;


class LearningSystemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // return new LearningSystemCollection(LearningSystem::all());

        return LearningSystemCollection::collection(LearningSystem::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name_ar' => "required|string|max:255|unique:learning_systems",
            'name_en' => "required|string|max:255|unique:learning_systems",
            'description_ar' => "string",
            'description_en' => "string",
            'country' => "required|array|min:1",
            'image' => "required|image",
        ]);

        if ($validator->fails()) {
            return response()->json([
                "error" => true,
                "errors" => $validator->errors()
            ] , 422);
        }

        
        $learning_system = LearningSystem::create([
            'name_ar' => $request['name_ar'],
            'name_en' => $request['name_en'],
            'description_ar' => $request['description_ar'],
            'description_en' => $request['description_en'],
            'image' => $request['image']->store('images/learningSystems', 'public')
        ]);

        $learning_system->countries()->attach($request['country']);


        return response()->json([
            "error" => false,
            "message" => "success",
        ] , 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return new LearningSystemCollection(LearningSystem::find($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, LearningSystem $learning_system)
    {
        $validator = Validator::make($request->all(), [
            'name_ar' => "required|string|max:255|unique:learning_systems,name_ar," .$learning_system->id,
            'name_en' => "required|string|max:255|unique:learning_systems,name_en," .$learning_system->id,
            'description_ar' => "string",
            'description_en' => "string",
            'country' => "required|min:1",
            'image' => "image",
        ]);

        if ($validator->fails()) {
            return response()->json([
                "error" => true,
                "errors" => $validator->errors()
            ] , 422);
            
        }


        if($request->hasFile('image')){
                
            \Storage::disk('public')->delete($learning_system->image);
            $learning_system->update([
                'image' => $request['image']->store('images/learningSystems', 'public'),
            ]);
        }

        $learning_system->update([
            'name_ar' => $request['name_ar'],
            'name_en' => $request['name_en'],
            'description_ar' => $request['description_ar'],
            'description_en' => $request['description_en'],

        ]);


        $learning_system->countries()->sync($request['country']);



        return response()->json([
            "error" => false,
            "message" => "success",
        ] , 201);


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(LearningSystem $learning_system)
    {
        $learning_system->forceDelete();

        return response()->json([
            "error" => false,
            "message" => "Force Deleted Successfully"
        ],200);
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Models\Food;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FoodController extends Controller
{



    public function __construct()
    {
        $this->middleware('can:index')->only('index');
        $this->middleware('can:show')->only('show');
        $this->middleware('can:store')->only('store');
        $this->middleware('can:update')->only('update');
        $this->middleware('can:destroy')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Food::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'image' => 'required|image',
            'description' => 'required',
            'price' => 'required',
            'preparationTime' => 'required',
        ]);

        $newFood = new Food;

        if ($request->hasFile('image')) {
            $originalNameImage = $request->file('image')->getClientOriginalName();
            $newName = Carbon::now()->timestamp . "_" . $originalNameImage;
            $destinyFolder = './upload/';
            $request->file('image')->move($destinyFolder, $newName);

            // $img = $request->file('image')->store('public/images');

            //$url = Storage::url($img);

            $newFood->name = $request->name;
            $newFood->description = $request->description;
            //$newFood->image = $url;
            $newFood->image = ltrim($destinyFolder, '.') . $newName;
            $newFood->price = $request->price;
            $newFood->preparation_time = $request->preparationTime;
            $newFood->save();

            return response()->json($newFood);
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
        $food = Food::find($id);

        if (is_null($food)) {
            return response()->json("index not found", 404);
        }

        return $food;
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
        $food = Food::find($id);

        if (is_null($food)) {
            return response()->json("index not found", 404);
        }

        if ($request->input('name')) {
            $food->name = $request->input('name');
        }

        if ($request->input('description')) {
            $food->description = $request->input('description');
        }

        if ($request->input('price')) {
            $food->price = $request->input('price');
        }

        if ($request->input('preparationTime')) {
            $food->preparation_time = $request->input('preparationTime');
        }

        $food->update();

        return response()->json($food);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $food = Food::find($id);

        if (is_null($food)) {
            return response()->json("index not found", 404);
        }

        $food->delete();

        return response()->noContent();
    }
}

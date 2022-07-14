<?php

namespace App\Http\Controllers;

use App\Models\Ads;
use Illuminate\Http\Request;

class AdsController extends Controller
{
    private $fields = ['id', 'name', 'price', 'foto_main'];
    /**
     * @param  Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function get(Request $request)
    {
        $fields = $this->fields;
        if ($request->get("fields") == "true") {
            $fields = array_merge($fields, ['text', 'foto_2', 'foto_3']);
        }
        $ad = Ads::select($fields)
            ->where('id', $request->get("ad"))
            ->get();
        return response()->json($ad);
    }

    /**
     * @param  Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAll(Request $request)
    {
        $ad = Ads::select(array_merge($this->fields, ['created_at']))
            ->limit(200)
            ->get();
        return response()->json($ad);
    }

    /**
     * @param  Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(Request $request)
    {
        $request->validate([
            'name' => 'required|max:200',
            'text' => 'required|max:1000',
            'price' => 'required|numeric|min:0|not_in:0',
            'foto_main' => 'required|max:255',
            'foto_2' => 'max:255',
            'foto_3' => 'max:255',
        ]);
        $id = Ads::insertGetId([
            "name" => strval($request->get("name")),
            "text" => strval($request->get("text")),
            "price" => intval($request->get("price")),
            "foto_main" => strval($request->get("foto_main")),
            "foto_2" => strval($request->get("foto_2")),
            "foto_3" => strval($request->get("foto_3")),
        ]);
        return response()->json($id);
    }

}

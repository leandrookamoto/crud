<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TodoList;

class ApiController extends Controller
{
      public function getAllDescription() {
       $description = TodoList::get()->toJson(JSON_PRETTY_PRINT);
    return response($description, 200);
    }

    public function createDescription(Request $request) {
      $table = new TodoList;
      $table->description = $request->description;
     $table->save();

      error_log('Não foi salvo');

    return response()->json([
        "message" => "description record created"
    ], 201);
    }


    public function updateDescription(Request $request, $id) {
      if (TodoList::where('id', $id)->exists()) {
        $description = TodoList::find($id);
        $description->description = is_null($request->description) ? $description->description : $request->description;
        $description->save();

        return response()->json([
            "message" => "records updated successfully"
        ], 200);
        } else {
        return response()->json([
            "message" => "Description not found"
        ], 404);
    }
    }

    public function deleteDescription ($id) {
       if(TodoList::where('id', $id)->exists()) {
        $description = TodoList::find($id);
        $description->delete();

        return response()->json([
          "message" => "records deleted"
        ], 202);
      } else {
        return response()->json([
          "message" => "Description not found"
        ], 404);
      }
    }
}

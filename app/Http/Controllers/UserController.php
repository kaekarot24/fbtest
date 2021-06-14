<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
      public function getAllUsers() {
        // logic to get all students goes here
        $user = User::get()->toJson(JSON_PRETTY_PRINT);
        return response($user, 200);
      }
  
      public function getUser($id) {
        // logic to get a student record goes here
        if (User::where('id', $id)->exists()) {
            $user = User::where('id', $id)->get()->toJson(JSON_PRETTY_PRINT);
            return response($user, 200);
          } else {
            return response()->json([
              "message" => "Student not found"
            ], 404);
          }
      }
  
      /*public function updateUser(Request $request, $id) {
        // logic to update a student record goes here
        if (User::where('id', $id)->exists()) {
            $user = User::find($id);
            $user->name = is_null($request->name) ? $user->name : $request->name;
            $user->course = is_null($request->course) ? $user->course : $request->course;
            $user->save();
    
            return response()->json([
                "message" => "records updated successfully"
            ], 200);
            } else {
            return response()->json([
                "message" => "Student not found"
            ], 404);
            
        }
      }*/
  
      public function deleteUser ($id) 
      {
        // logic to delete a student record goes here
        if(User::where('id', $id)->exists()) {
            $user = User::find($id);
            $user->delete();
    
            return response()->json([
              "message" => "records deleted",
              "status" => "ok"
            ], 202);
          } else {
            return response()->json([
              "message" => "Student not found",
              "status" => "failed"
            ], 404);
          }
       }

       public function ChangePassword(Request $request, $id)
       {
           # code...
           if(User::where("id", $id)->exists()){
                $user = User::find($id);
                $user->password = Hash::make($request->password);               
                $user->save();

                return response()->json([
                    "message" => "Password Changed Successfully",
                    "status" => "ok"
                ], 200);

           } else {
               return response()->json([
                   'message' => "Record not Found",
                   "status" => "failed"
               ], 404);
           }

       }
    
}

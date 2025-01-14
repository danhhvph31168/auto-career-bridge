<?php
namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Support\Facades\Hash;

class UsersImport implements ToModel, WithHeadingRow
{
   public function model(array $row)
   {
       $dataExport = array();
       $i = 0;
       $university_id = 4;
       foreach ($row as $key => $value){
           $dataExport[$i++] = $value;
       }
       
       // Assign role based on input
       $role = isset($dataExport[5]) ? $dataExport[5] : null;
       if ($role == "Giáo vụ") {
           $dataExport[5] = 2; 
       } else {
           $dataExport[5] = 1; 
       }
       // Hash password or use a default one
        $password = isset($dataExport[4]) && $dataExport[4] != '' ? Hash::make($dataExport[4]) : Hash::make('default_password');
        // Register user using Sentinel
       $user = Sentinel::register(array(
           'email' => isset($dataExport[2]) ? $dataExport[2] : "",
           'password' => $password,
       ));

       // Update additional fields
       $user->university_id = $university_id; 
       $user->role_id = isset($dataExport[5]) ? $dataExport[5] : 1; 
       $user->username = isset($dataExport[1]) ? $dataExport[1] : ''; 
       $user->phone = isset($dataExport[3]) ? $dataExport[3] : ''; 
       
       // Save user to the database
       $user->save();
       
       return $user; 
   }
}

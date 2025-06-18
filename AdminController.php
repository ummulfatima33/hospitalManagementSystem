<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function dashboard() {
        $doctors = User::where('usertype','=',1)->count();
        $patients = User::where('usertype','=',0)->count();
        return view('admin.dashboard',compact('doctors','patients'));
    }

      public function doctors() {
        $doctors = User::where('usertype','=',1)->get();
        return view('admin.doctors.doctors',compact('doctors'));
    }

     public function logout(){
        Auth::logout();
        return redirect()->route('login');
       }

        public function patients() {
        $patients = User::where('usertype','=',0)->get();
        return view('admin.patients.patients',compact('patients'));
    }

        public   function patients_delete($id){
         User::find($id)->delete();
         return redirect()->route('admin.patients');
        }

         public   function doctors_delete($id){
         User::find($id)->delete();
         return redirect()->route('admin.doctors');
        }
 
            //  Doctors Method Start

         public function add_doctors(){
            return view('admin.doctors.create');
        }

         public function store_doctors(Request $req){
            $doctors = new User();
            $doctors->name = $req->name;
            $doctors->email = $req->email;
            $doctors->password = Hash::make ($req->password);
            $doctors->phone = $req->phone;
            $doctors->address = $req->address;
            $doctors->usertype = 1;
            $doctors->save();
            return redirect()->route('admin.doctors');
        }

         public function edit_doctors($id){
            $doctors = User::find($id);
             return view('admin.doctors.edit',compact('doctors'));
         }

          public function update_doctors($id, Request $req){
             $doctors = User::find($id);
            $doctors->name = $req->name;
            $doctors->email = $req->email;
            // $doctors->password = Hash::make ($req->password);
            $doctors->phone = $req->phone;
            $doctors->address = $req->address;
            // $doctors->usertype = 1;
            $doctors->update();
            return redirect()->route('admin.doctors');
        }
            //   Doctors Method End

            // Patients Method Start

          public function add_patients(){
            return view('admin.patients.create');
          }  

          public function store_patients(Request $req){
            $patients = new User();
            $patients->name = $req->name;
            $patients->email = $req->email;
            $patients->password = Hash::make ($req->password);
            $patients->phone = $req->phone;
            $patients->address = $req->address;
            $patients->usertype = 0;
            $patients->save();
            return redirect()->route('admin.patients');
        }

         public function edit_patients($id){
            $patients = User::find($id);
             return view('admin.patients.edit',compact('patients'));
         }

         public function update_patients($id, Request $req){
            $patients = User::find($id);
            $patients->name = $req->name;
            $patients->email = $req->email;
            // $doctors->password = Hash::make ($req->password);
            $patients->phone = $req->phone;
            $patients->address = $req->address;
            // $doctors->usertype = 1;
            $patients->update();
            return redirect()->route('admin.patients');
        }


            // Patients Method End
             
}

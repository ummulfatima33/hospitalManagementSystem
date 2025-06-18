<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
  public function home()
  {
    $doctors = User::where('usertype', 1)
    ->whereHas('doctorProfile', function ($query) {
        $query->whereNotNull('description')->where('description', '!=', '')
              ->whereNotNull('speciality')->where('speciality', '!=', '')
              ->whereNotNull('experience')->where('experience', '!=', '')
              ->whereNotNull('education')->where('education', '!=', '')
              ->whereNotNull('timing')->where('timing', '!=', '');
    })
    ->with('doctorProfile')
    ->get();
    return view('home', compact('doctors'));
  }

  public function doctor_detail($id)
  {
    $doctor = User::where('id', '=', $id)->firstOrFail();
    return view('doctor-detail', compact('doctor'));
  }

  public function appointment($id)
  {

    $user = User::where('id', '=', $id)->firstOrFail();
    // dd($user->id);die();
    return view('appointment', compact('user'));
  }


  public function book_appointment(Request $request)
  {
    // dd($request->all());die();
    if (Auth::check()) {
      $appoint = new Appointment();
      $appoint->user_id =  Auth::user()->id;
      $appoint->doctor_id = $request->doctor_id;
      $appoint->date = $request->date;
      $appoint->time  = $request->time;
      $appoint->message = $request->message;
      $appoint->phone = $request->phone;
      $appoint->save();
    } else {
      return redirect()->back()->with('error', 'please login first');
    }
    return redirect('/');
  }
}

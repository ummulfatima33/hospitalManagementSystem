<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\Appointment;
use App\Mail\Appointments;
use App\Models\doctor_profile;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class DoctorController extends Controller
{
    public function dashboard()
    {
        return view('doctor.dashboard');
    }

    public function profile($id)
    {
        $id =  Auth::user()->id;
        $doctor = User::find($id);
        $profile = Doctor_profile::where('doctor_id', '=', $id)->firstorfail();
        // dd($profile->image);die();
        return view('doctor.profile', compact('doctor', 'profile'));
    }


    //  public function appointments()
    // {
    //     $id = Auth::user()->id;
    //     $appointments = Appointment::with(['user','doctor'])->where('doctor_id',$id)->get();
    //     return view('doctor.appointment',compact('appointments'));
    // }   

    public function profile_store(Request $request)
    {
        $id = Auth::user()->id;
        $doctor = User::find($id);
        $doctor->name = $request->name;
        $doctor->email = $request->email;
        $doctor->address = $request->address;
        $doctor->phone = $request->phone;
        $doctor->save();

        $doctor_detail = doctor_profile::where('doctor_id', $id)->first();

        if (!$doctor_detail) {
            $doctor_detail = new doctor_profile();
            $doctor_detail->doctor_id = $id;
        }

        $doctor_detail->description = $request->description;
        $doctor_detail->speciality = $request->speciality;
        $doctor_detail->experience = $request->experience;
        $doctor_detail->education = $request->education;
        $doctor_detail->timing = $request->timing;
        $doctor_detail->fees = $request->fees;

        if ($request->hasFile('img')) {
            $filename = time() . '_' . $request->img->getClientOriginalName();
            $request->img->move(public_path('doctors/profile/'), $filename);
            $doctor_detail->image = 'doctors/profile/' . $filename;
        }

        // Save or update the profile
        $doctor_detail->save();

        return redirect()->route('doctor.dashboard');
    }

    public function appointments()
    {
        $id = Auth::user()->id;
        $appointments = Appointment::with(['user', 'doctor'])->where('doctor_id', $id)->get();
        return view('doctor.appointment', compact('appointments'));
    }


    public function approved($id)
    {
        $appoint = Appointment::with('user')->find($id);

        if (!$appoint || !$appoint->user) {
            return redirect()->back()->with('error', 'Appointment or user not found.');
        }

        $appoint->status = 'approved';
        $to = $appoint->user->email;
        // dd($to);die();
        $subject = "Appointment Approved";
        $message = "Your Appointment Has Been Approved";

        Mail::to($to)->send(new Appointments($message, $subject));
        $appoint->save();

        return redirect()->back()->with('success', 'Appointment approved and email sent.');
    }


    public function rejected($id)
    {
        $appoint = Appointment::find($id);
        $appoint->status = 'rejected';
        $to = $appoint->user->email;
        $subject = "Appointment Approved";
        $message = "Your Appointment Has Been Approved";
        Mail::to($to)->send(new Appointments($message, $subject));
        $appoint->save();
        return redirect()->back();
    }
}

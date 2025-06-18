
<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\HomeController;

Route::get('/',[HomeController::class,'home']);

Route::get('/doctor-detail/{id}',[HomeController::class,'doctor_detail'])->name('doctor.detail');

Route::get('/appointment/{id}',[HomeController::class,'appointment'])->name('appointment');
Route::post('/book-appointment',[HomeController::class,'book_appointment'])->name('appointment.store');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

 Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');


 Route::get('/admin/doctors', [AdminController::class, 'doctors'])->name('admin.doctors');
 Route::get('/admin/doctors/{id}', [AdminController::class, 'doctors_delete'])->name('admin.doctors.delete');
 Route::get('/admin/add-doctors', [AdminController::class, 'add_doctors'])->name('admin.doctors.add');
 Route::post('/admin/store-doctors', [AdminController::class, 'store_doctors'])->name('admin.doctors.store');
 Route::get('/admin/edit-doctors{id}', [AdminController::class, 'edit_doctors'])->name('admin.doctors.edit');
 Route::get('/admin/update-doctors/{id}', [AdminController::class, 'update_doctors'])->name('admin.doctors.update');
 Route::get('/doctor/dashboard', [DoctorController::class, 'dashboard'])->name('doctor.dashboard');
 Route::get('/doctor/appointment', [DoctorController::class, 'appointments'])->name('doctor.appointment');
 Route::post('/approved-appointment/{id}', [DoctorController::class, 'approved'])->name('approved-appointment');
 Route::post('/rejected-appointment/{id}', [DoctorController::class, 'rejected'])->name('rejected-appointment');

Route::get('/myprofile/{id}',[DoctorController::class,'profile'])->name('doctor.profile');
Route::post('/myprofile-store',[DoctorController::class,'profile_store'])->name('doctors.profile.store');

 Route::get('/admin/patients', [AdminController::class, 'patients'])->name('admin.patients');
 Route::get('/admin/patients/{id}', [AdminController::class, 'patients_delete'])->name('admin.patients.delete');
 Route::get('/admin/add-patients', [AdminController::class, 'add_patients'])->name('admin.patients.add');
 Route::post('/admin/store-patients', [AdminController::class, 'store_patients'])->name('admin.patients.store');
 Route::get('/admin/edit-patients/{id}', [AdminController::class, 'edit_patients'])->name('admin.patients.edit');
 Route::get('/admin/update-patients/{id}', [AdminController::class, 'update_patients'])->name('admin.patients.update');


 Route::get('/logout', [AdminController::class, 'logout'])->name('logout');



require __DIR__.'/auth.php';

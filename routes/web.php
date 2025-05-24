<?php

use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\AdviserController;
use App\Http\Controllers\AppController;
use App\Http\Controllers\ClassRecordController;
use App\Http\Controllers\PrincipalController;
use App\Http\Controllers\ReportCardController;
use App\Http\Controllers\SchoolYearController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\StudentStatusController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\SubjectTeacherController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::prefix('/admin')->middleware('loggedIn')->group(function() {
    // Dashboard
    Route::get('/dashboard', [AppController::class, 'viewDashboardAdmin'])->name('viewDashboardAdmin');

    // Student = Add, View, and List of the students
    Route::get('/students', [AppController::class, 'viewStudents'])->name('viewStudents');
    Route::get('/addStudent', [AppController::class, 'viewAddStudent'])->name('viewAddStudent');
    Route::get('/viewStudent/{studentLRN}', [AppController::class, 'viewStudent'])->name('viewStudent');

    // Teacher = Add, View, and List of the teachers
    Route::get('/teachers', [AppController::class, 'viewTeachers'])->name('viewTeachers');
    Route::get('/addTeacher', [AppController::class, 'viewAddTeacher'])->name('viewAddTeacher');
    Route::get('/viewTeacher/{teacherID}', [AppController::class, 'viewTeacher'])->name('viewTeacher');

    // Principal = Add, View, and List of the principals
    Route::get('/principals', [AppController::class, 'viewPrincipals'])->name('viewPrincipals');
    Route::get('/addPrincipal', [AppController::class, 'viewAddPrincipal'])->name('viewAddPrincipal');
    Route::get('/viewPrincipal/{principalID}', [AppController::class, 'viewPrincipal'])->name('viewPrincipal');

    // Adviser
    Route::get('/advisers', [AppController::class, 'viewAdvisers'])->name('viewAdvisers');

    // Subjects
    Route::get('/subjects', [AppController::class, 'viewSubjectList'])->name('viewSubjectList');

    // Subject Teacher
    Route::get('/subjectTeachers', [AppController::class, 'viewSubjectTeacherList'])->name('viewSubjectTeacherList');
    Route::get('/subjectTeachersList', [AppController::class, 'subjectTeachersList'])->name('subjectTeachersList');
    Route::get('/sectionList/{gradeLevel}', [AdviserController::class, 'getAdviserByGradeLevel'])->name('getAdviserByGradeLevel');

    // Settings
    Route::get('/viewSettings', [AppController::class, 'viewSettings'])->name('viewSettings');

    // Users = Add, View, and List of the users
    Route::get('/viewUsers', [AppController::class, 'viewUsers'])->name('viewUsers');
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::put('/users/{userID}', [UserController::class, 'update'])->name('users.update');
});

Route::prefix('/principal')->middleware('loggedIn')->group(function() {
    // Dashboard
    Route::get('/dashboard', [AppController::class, 'viewDashboardPrincipal'])->name('viewDashboardPrincipal');
    // Teachers
    Route::get('/teachers', [AppController::class, 'viewTeacherList'])->name('viewTeacherList');
    // Students
    Route::get('/students', [AppController::class, 'viewStudentList'])->name('viewStudentList');
});

Route::prefix('/teacher')->middleware('loggedIn')->group(function() {
    // Dashboard
    Route::get('/dashboard', [AppController::class, 'viewDashboardTeacher'])->name('viewDashboardTeacher');
    // Advisory
    Route::get('/advisory', [AppController::class, 'viewAdvisory'])->name('viewAdvisory');
    Route::get('/advisories', [AppController::class, 'getAdvisoryStudents'])->name('getAdvisoryStudents');
    // Subject handle
    Route::get('/subjectHandled', [AppController::class, 'viewTeacherSubject'])->name('viewTeacherSubject');
    // Attendance = Add and List of the attendance
    Route::get('/attendances', [AppController::class, 'viewAttendanceTeacher'])->name('viewAttendanceTeacher');
    // Class Records = Add and List of the attendance
    Route::get('/classRecords', [AppController::class, 'viewClassRecordTeacher'])->name('viewClassRecordTeacher');
    Route::get('/viewClassRecord/{subjectListing}', [AppController::class, 'viewClassRecord'])->name('viewClassRecord');
    Route::put('/updateScore', [AppController::class, 'updateScore'])->name('updateScore');
    Route::put('/updateTotalScore', [AppController::class, 'updateTotalScore'])->name('updateTotalScore');
    Route::get('/viewClassRecordBySubjectListing/{subjectListing}', [AppController::class, 'viewClassRecordBySubjectListing'])->name('viewClassRecordBySubjectListing');
    // Report Card = Generate
    Route::get('/reportCard', [AppController::class, 'viewReportCardTeacher'])->name('viewReportCardTeacher');
    Route::get('/advisoriesBySchoolYear', [AppController::class, 'getAdvisoryStudentsBySchoolYear'])->name('getAdvisoryStudentsBySchoolYear');
    // Section List
    Route::get('/sectionList/{gradeLevel}', [AdviserController::class, 'getAdviserByGradeLevel'])->name('getAdviserByGradeLevelTeacher');
});

Route::prefix('/student')->middleware('loggedIn')->group(function() {
    // Dashboard
    Route::get('/dashboard', [AppController::class, 'viewDashboardStudent'])->name('viewDashboardStudent');
    Route::get('/attendances', [AppController::class, 'viewAttendances'])->name('viewAttendances');
    Route::get('/attendances/getStudentAttendance', [AttendanceController::class, 'getStudentAttendance'])->name('getStudentAttendance');
    Route::get('/grades', [AppController::class, 'viewGrades'])->name('viewGrades');
    Route::get('/classRecords', [AppController::class, 'viewClassRecordStudent'])->name('viewClassRecordStudent');
    Route::get('/subjects', [AppController::class, 'getStudentSubject'])->name('getStudentSubject');
    Route::get('/viewStudentRecords/{subjectListing}', [AppController::class, 'viewStudentRecords'])->name('viewStudentRecords');
});

// Address
Route::prefix('/address')->group(function() {
    Route::get('/getProvinces/{regionCode}', [AddressController::class, 'getProvinces'])->name('getProvinces');
    Route::get('/getMunicipalities/{provinceCode}', [AddressController::class, 'getMunicipalities'])->name('getMunicipalities');
    Route::get('/getBrgys/{municipalityCode}', [AddressController::class, 'getBrgys'])->name('getBrgys');
    Route::get('/getZipCode/{municipalityCode}', [AddressController::class, 'getZipCode'])->name('getZipCode');
});

// Resource Controller
Route::resource('/students', StudentController::class);
Route::post('/students/updateImage/{studentLRN}', [StudentController::class, 'upload'])->name('updateImageStudent');
Route::resource('/teachers', TeacherController::class);
Route::post('/teachers/updateImage/{teacherID}', [TeacherController::class, 'upload'])->name('updateImageTeacher');
Route::resource('/principals', PrincipalController::class);
Route::post('/principals/updateImage/{principalID}', [PrincipalController::class, 'upload'])->name('updateImagePrincipal');
Route::resource('/advisers', AdviserController::class);
Route::resource('/student_statuses', StudentStatusController::class);
Route::resource('/subjects', SubjectController::class);
Route::resource('/subjectTeachers', SubjectTeacherController::class);
Route::get('/subjectTeachers/getEnrolledStudent/{subjectListing}', [SubjectTeacherController::class, 'getEnrolledStudent'])->name('getEnrolledStudent');
Route::resource('/schoolYears', SchoolYearController::class);
Route::resource('/attendances', AttendanceController::class);
Route::get('/attendances/getAttendanceByDate/{attendanceDate}', [AttendanceController::class, 'getAttendanceByDate'])->name('getAttendanceByDate');
Route::resource('/subjectTeachers', SubjectTeacherController::class);
Route::resource('/classRecords', ClassRecordController::class);

Route::get('/classRecords/getClassRecordsByTeacher/{teacherID}', [ClassRecordController::class, 'getClassRecordsByTeacher'])->name('getClassRecordsByTeacher');
Route::get('/classRecords/viewClassRecords/{recordsName}', [ClassRecordController::class, 'viewClassRecords'])->name('viewClassRecords');
Route::get('/classRecords/exportToExcel/{subjectListing}', [ClassRecordController::class, 'exportToExcel'])->name('exportToExcel');
Route::get('/classRecords/downloadExcel/{subject_listing}/{fileName}', [ClassRecordController::class, 'downloadExcel'])->name('downloadExcel');
Route::resource('/reportCards', ReportCardController::class);
Route::get('/reportCards/downloadReportCard/{studentLRN}/{fileName}', [ReportCardController::class, 'downloadReportCard'])->name('downloadReportCard');
Route::get('/reportCards/getStudentGrades/{gradeLevel}/{section}', [ReportCardController::class, 'getStudentGrades'])->name('getStudentGrades');

//Profile
Route::get('/profile', [AppController::class, 'viewProfile'])->name('viewProfile');
Route::get('/passwordCheck', [UserController::class, 'passwordCheck'])->name('passwordCheck');
Route::put('/passwordChange/{userID}', [UserController::class, 'passwordChange'])->name('passwordChange');

// Change School Year
Route::put('/changeSchoolYear/{schoolYear}', [AppController::class, 'changeSchoolYear'])->name('changeSchoolYear');

// Validation
Route::post('/check-email', [UserController::class, 'checkEmail'])->name('checkEmail');
Route::post('/check-contact', [UserController::class, 'checkContact'])->name('checkContact');
Route::post('/check-username', [UserController::class, 'checkUsername'])->name('checkUsername');
Route::post('/check-subject_code', [SubjectController::class, 'checkSubjectCode'])->name('checkSubjectCode');

// Login or Logout
Route::get('/', [AppController::class, 'getLoginPage'])->name('getLoginPage')->middleware('guest');
Route::post('/login', [UserController::class, 'login'])->name('login');
Route::post('/logout', [UserController::class, 'logout'])->name('logout');



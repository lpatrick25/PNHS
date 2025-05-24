<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\SchoolYear;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $response = User::with(['student', 'teacher', 'principal'])
                ->where('role', '!=', 'admin')
                ->get()
                ->map(function ($user, $key) {
                    // Check if the user has a related student, teacher, or principal
                    $student = $user->student;
                    $teacher = $user->teacher;
                    $principal = $user->principal;

                    // Default values in case no relation is found
                    $fullname = '';
                    $contact = '';
                    $email = '';
                    $image = '';

                    // Determine which related table the user belongs to (Client, Inspector, or Marshall)
                    if ($student) {
                        $fullname = $student->first_name . ' ' . $student->middle_name . ' ' . $student->last_name;
                        $contact = $student->contact;
                        $email = $student->email;
                        $image = asset($student->image);
                    } elseif ($teacher) {
                        $fullname = $teacher->first_name . ' ' . $teacher->middle_name . ' ' . $teacher->last_name;
                        $contact = $teacher->contact;
                        $email = $teacher->email;
                        $image = asset($teacher->image);
                    } elseif ($principal) {
                        $fullname = $principal->first_name . ' ' . $principal->middle_name . ' ' . $principal->last_name;
                        $contact = $principal->contact;
                        $email = $principal->email;
                        $image = asset($principal->image);
                    }

                    // Return the formatted result
                    return [
                        'count' => $key + 1,
                        'image' => '<img class="img img-fluid img-rounded" alt="User Avatar" src="' . asset($image) . '" style="width: 50px;">',
                        'fullname' => $fullname,
                        'contact' => $contact,
                        'email' => $email,
                        'username' => $user->username,
                        'role' => ucfirst($user->role),
                        'action' => '<button type="button" class="btn btn-md btn-primary" onclick="update(' . "'" . $user->user_id . "'" . ')"><i class="fa fa-edit"></i></button>',
                    ];
                });

            return response()->json($response->toArray());
        } catch (\Exception $e) {
            return response()->json(['error' => 'Unable to retrieve students.'], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $user_id)
    {
        try {
            DB::beginTransaction();

            $user = User::where('user_id', $user_id)->first();
            if (!$user) {
                throw new \Exception('User not found.');
            }

            $user->update([
                'password' => Hash::make($request->password),
            ]);

            DB::commit();
            return response()->json(['valid' => true, 'msg' => 'Data successfully updated'], 200);
        } catch (\Exception $e) {
            DB::rollback();

            Log::error('Failed to update data', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'input' => $request->all(),
            ]);

            return response()->json(['valid' => false, 'msg' => 'Data failed to update: ' . $e->getMessage()], 422);
        }
    }

    public function checkUsername(Request $request)
    {
        $username = $request->input('username');
        $exists = DB::table('users')->where('username', $username)->exists();

        return response()->json(!$exists); // Only returns true or false
    }

    public function checkEmail(Request $request)
    {
        $email = $request->input('email');
        $exists = DB::table('students')->where('email', $email)->exists() ||
            DB::table('teachers')->where('email', $email)->exists() ||
            DB::table('principals')->where('email', $email)->exists();

        return response()->json(!$exists); // Only returns true or false
    }

    public function checkContact(Request $request)
    {
        $contact = $request->input('contact');
        $exists = DB::table('students')->where('contact', $contact)->exists() ||
            DB::table('teachers')->where('contact', $contact)->exists() ||
            DB::table('principals')->where('contact', $contact)->exists();

        return response()->json(!$exists); // Only returns true or false
    }

    public function logout(Request $request)
    {
        Auth::logout();

        // Optional: Flush the session data
        $request->session()->flush();

        // Optional: Regenerate the session ID
        // $request->session()->regenerate();

        return response()->json(['valid' => true, 'msg' => 'Logout Success.'], 200);
    }

    public function login(Request $request)
    {
        try {
            $username = $request->username;
            $password = $request->password;

            // Get the current school year
            $schoolYear = SchoolYear::first();
            $schoolYearList = SchoolYear::all();

            if (Auth::attempt(['username' => $username, 'password' => $password])) {
                $user = auth()->user();
                $role = $user->role;

                // Set base session data
                session([
                    'user_id' => $user->user_id,
                    'role' => $role,
                    'username' => $user->username,
                    'school_year' => $schoolYear->school_year,
                    'schoolYearList' => $schoolYearList,
                ]);

                // Handle role-specific data
                $profileImage = null;
                $fullName = null;
                $isAdviser = false;

                switch ($role) {
                    case "student":
                        $profile = DB::table('students')->where('student_lrn', $username)->first();
                        if ($profile) {
                            $profileImage = $profile->image;
                            $fullName = $this->formatFullName(
                                $profile->first_name,
                                $profile->middle_name,
                                $profile->last_name,
                                $profile->extension_name
                            );
                        }
                        break;

                    case "teacher":
                        $profile = DB::table('teachers')->where('teacher_id', $username)->first();
                        if ($profile) {
                            $profileImage = $profile->image;
                            $fullName = $this->formatFullName(
                                $profile->first_name,
                                $profile->middle_name,
                                $profile->last_name,
                                $profile->extension_name
                            );
                            $adviser = DB::table('advisers')->where('teacher_id', $profile->teacher_id)->first();
                            if ($adviser) {
                                $isAdviser = true;
                            }
                        }

                        break;

                    case "principal":
                        $profile = DB::table('principals')->where('principal_id', $username)->first();
                        if ($profile) {
                            $profileImage = $profile->image;
                            $fullName = $this->formatFullName(
                                $profile->first_name,
                                $profile->middle_name,
                                $profile->last_name,
                                $profile->extension_name
                            );
                        }
                        break;

                    default:
                        $fullName = 'Administrator';
                        break;
                }

                // Set session values for profile image and full name
                session([
                    'image' => asset($profileImage ?? 'dist/img/avatar5.png'),
                    'fullname' => $fullName,
                    'is_adviser' => $isAdviser,
                ]);

                return response()->json(['valid' => true, 'msg' => 'Login Success.', 'user' => $user], 200);
            }

            return response()->json(['valid' => false, 'msg' => 'Invalid credentials.'], 200);
        } catch (\Exception $e) {
            Log::error('Failed to login: ' . $e->getMessage());
            return response()->json(['valid' => false, 'msg' => 'Failed to login', 'error' => $e->getMessage()], 500);
        }
    }

    public function passwordCheck()
    {
        try {
            // Retrieve the current user using the session's user_id
            $user = User::where('user_id', session()->get('user_id'))->firstOrFail();
            $username = $user->username;

            // Check if the user is using the default password
            if (Auth::attempt(['username' => $username, 'password' => $username])) {
                return response()->json([
                    'valid' => false,
                    'msg' => 'You are using the default password. It is highly recommended to change your password for better security.',
                    'user_id' => $user->user_id,
                ], 200);
            }

            return response()->json([
                'valid' => true,
                'msg' => 'Your password is strong and secure.',
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            // Handle case where user is not found
            Log::warning('User not found during password check: ' . $e->getMessage());
            return response()->json([
                'valid' => false,
                'msg' => 'User not found. Please ensure you are logged in.',
            ], 404);
        } catch (\Exception $e) {
            // Handle other exceptions
            Log::error('Error during password check: ' . $e->getMessage());
            return response()->json([
                'valid' => false,
                'msg' => 'An error occurred while checking your password. Please try again later.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function passwordChange(Request $request, $user_id)
    {
        try {
            DB::beginTransaction();

            $user = User::where('user_id', $user_id)->first();
            if (!$user) {
                throw new \Exception('User not found.');
            }

            $user->update([
                'password' => Hash::make($request->password),
            ]);

            DB::commit();
            return response()->json(['valid' => true, 'msg' => 'Data successfully updated'], 200);
        } catch (\Exception $e) {
            DB::rollback();

            Log::error('Failed to update data', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'input' => $request->all(),
            ]);

            return response()->json(['valid' => false, 'msg' => 'Data failed to update: ' . $e->getMessage()], 422);
        }
    }

    /**
     * Format the full name with proper handling of the middle name.
     *
     * @param string $firstName
     * @param string|null $middleName
     * @param string $lastName
     * @param string|null $extensionName
     * @return string
     */
    private function formatFullName($firstName, $middleName, $lastName, $extensionName)
    {
        $middleInitial = $middleName ? strtoupper(substr($middleName, 0, 1)) . '.' : '';
        $fullName = trim("{$firstName} {$middleInitial} {$lastName} {$extensionName}");
        return $fullName;
    }
}

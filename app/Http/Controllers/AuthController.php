<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use Google_Client;
use Google_Service_Sheets;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.login');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',

        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),

        ]);

        // Auth::login($user);

        // return match ($user->role) {
        //     'admin' => redirect()->route('admin.dashboard'),
        //     'professor' => redirect()->route('professor.dashboard'),
        //     default => redirect()->route('student.dashboard'),
        // };

        return redirect()->route('login')->with('success', 'Registration successful! Please login.');
    }


    public function verify(){
        return view('verify');
    }




    public function verification(Request $request)
   {


        $validated = $request->validate([
            'student_number' => 'required'
        ]);

        $studentNumber = $validated['student_number'];

        $credentialsPath = storage_path('app/google/credentials.json');
        putenv("GOOGLE_APPLICATION_CREDENTIALS=$credentialsPath");


        $client = new Google_Client();
        $client->setAuthConfig($credentialsPath);
        $client->addScope('https://www.googleapis.com/auth/spreadsheets.readonly');


        $service = new Google_Service_Sheets($client);



        $spreadsheetId = '1fz4qZo_BhhTPqftB36MpbkolkkhN0Du0-RBtGHcUcIg';
        $range = 'CIT!A1:F99';

        try {

            $response = $service->spreadsheets_values->get($spreadsheetId, $range);
            $values = $response->getValues();



            if (empty($values)) {
                return response()->json(['message' => 'No data found.']);
            }


            $found = false;
            foreach ($values as $row) {
                if ($row[0] == $studentNumber) {
                    $found = true;
                    // $fullName = trim($row[3] . ' ' . $row[4] . ' ' . $row[2]);
                     $fullName = $row[1] ?? null;
                    $gmail = $row[2]?? null;
                    $section = $row[3]?? null;
                    break;
                }
            }


            if (!$found) {
                return redirect()->back()->with('error', 'Student Number Not Found');
            }

            return redirect()->route('register', compact('fullName', 'gmail', 'section'));

        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch data from Google Sheets: ' . $e->getMessage()]);
        }
    }




   public function useGoogleClient()
    {
        $credentialsPath = storage_path('app/google/credentials.json');
        putenv("GOOGLE_APPLICATION_CREDENTIALS=$credentialsPath");


        $client = new Google_Client();
        $client->setAuthConfig($credentialsPath);
        $client->addScope('https://www.googleapis.com/auth/spreadsheets.readonly');


        $service = new Google_Service_Sheets($client);


        $spreadsheetId = '1fz4qZo_BhhTPqftB36MpbkolkkhN0Du0-RBtGHcUcIg';
        $range = 'CIT!A1:F99';

        try {

            $response = $service->spreadsheets_values->get($spreadsheetId, $range);


            $values = $response->getValues();

            if (empty($values)) {
                return response()->json(['message' => 'No data found.']);
            } else {
                return view('Student_list', ['data' => $values]);
            }

        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch data from Google Sheets: ' . $e->getMessage()]);
        }
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            if (Auth::user()->role === 'admin') {
                return redirect()->route('admin.dashboard');
            } elseif (Auth::user()->role === 'professor') {
                return redirect()->route('professor.dashboard');
            } else {
                return redirect()->route('student.dashboard');
            }
        }

        return back()->withErrors(['email' => 'Invalid credentials'])->onlyInput('email');
    }



}

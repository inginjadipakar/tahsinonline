<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\TahsinClass;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(Request $request): View|RedirectResponse
    {
        // Enforce Wizard Flow
        if (!$request->has('class_id') || !$request->has('package') || !$request->has('program')) {
            return redirect('/#pricing');
        }

        $classes = TahsinClass::where('is_active', true)->orderBy('order')->get();
        $selectedClass = TahsinClass::find($request->class_id);
        
        // Debug
        \Log::info('Register page loaded. Classes count: ' . $classes->count());
        
        return view('auth.register', compact('classes', 'selectedClass'));
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // First, get the selected class to determine validation rules
        $selectedClass = TahsinClass::find($request->tahsin_class_id);
        $isChildClass = $selectedClass && str_contains(strtolower($selectedClass->name), 'anak');

        // Dynamic validation based on class type
        $rules = [
            'tahsin_class_id' => ['required', 'exists:tahsin_classes,id'],
            'phone' => ['required', 'string', 'max:20', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'gender' => ['required', 'in:male,female'],
            'address' => ['required', 'string'],
            'occupation' => ['required', 'string', 'max:255'],
        ];

        if ($isChildClass) {
            // Validation for child classes
            $rules['parent_name'] = ['required', 'string', 'max:255'];
            $rules['child_name'] = ['required', 'string', 'max:255'];
            $rules['age'] = ['required', 'integer', 'min:3', 'max:17'];
        } else {
            // Validation for adult classes
            $rules['name'] = ['required', 'string', 'max:255'];
            $rules['age'] = ['required', 'integer', 'min:18', 'max:100'];
        }

        // Format phone number using helper
        $phone = \App\Helpers\PhoneHelper::normalize($request->phone);
        $request->merge(['phone' => $phone]);

        $request->validate($rules);

        // Prepare user data
        $userData = [
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'role' => 'student',
            'tahsin_class_id' => $request->tahsin_class_id,
            'gender' => $request->gender,
            'age' => $request->age,
            'address' => $request->address,
            'occupation' => $request->occupation,
            'is_child_account' => $isChildClass,
        ];

        if ($isChildClass) {
            // For child classes - use parent name as main name
            $userData['name'] = $request->parent_name;
            $userData['parent_name'] = $request->parent_name;
            $userData['child_name'] = $request->child_name;
        } else {
            // For adult classes - use their own name
            $userData['name'] = $request->name;
        }

        $user = User::create($userData);

        event(new Registered($user));

        Auth::login($user);

        // Handle Subscription Creation if Package/Program selected
        if ($request->has('selected_package') && $request->has('selected_program')) {
            $startDate = now();
            $endDate = now();
            
            switch($request->selected_package) {
                case 'monthly':
                    $endDate = $startDate->copy()->addMonth();
                    break;
                case 'semester':
                    $endDate = $startDate->copy()->addMonths(6);
                    break;
                case 'yearly':
                    $endDate = $startDate->copy()->addYear();
                    break;
                default:
                    $endDate = $startDate->copy()->addMonth();
            }

            \App\Models\Subscription::create([
                'user_id' => $user->id,
                'start_date' => $startDate,
                'end_date' => $endDate,
                'status' => 'pending', // Pending payment
                'program_type' => $request->selected_program,
                'tahsin_class_id' => $request->tahsin_class_id,
            ]);
        }

        return redirect(route('dashboard', absolute: false));
    }
}

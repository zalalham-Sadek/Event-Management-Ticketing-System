<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // تسجيل مستخدم جديد
    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6',
            'phone' => 'nullable|string|max:20',
        ]);

        // إنشاء المستخدم بدور افتراضي Attendee
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password'], // سيُحوّل تلقائياً إلى hashed
            'phone' => $data['phone'] ?? null,
            'role' => 'Attendee',
        ]);

        // إنشاء Token
        $token = $user->createToken('api-token')->plainTextToken;

        return response()->json([
            'message' => 'تم إنشاء الحساب بنجاح',
            'user' => $user,
            'token' => $token
        ], 201);
    }

    // تسجيل الدخول
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string'
        ]);

        if (!Auth::attempt($credentials)) {
            return response()->json(['message' => 'بيانات الدخول غير صحيحة'], 401);
        }

        $user = Auth::user();
        $token = $user->createToken('api-token')->plainTextToken;

        return response()->json([
            'message' => 'تم تسجيل الدخول بنجاح',
            'user' => $user,
            'token' => $token
        ]);
    }

     public function logout(Request $request)
    {
        $user = $request->user();
        // حذف جميع التوكنات الخاصة بالمستخدم
        $user->tokens()->delete();

        return response()->json(['message' => 'تم تسجيل الخروج بنجاح']);
    }

    // نسيت كلمة المرور
    public function forgotPassword(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        if ($status === Password::RESET_LINK_SENT) {
            return response()->json(['message' => 'تم إرسال رابط إعادة تعيين كلمة المرور إلى بريدك الإلكتروني']);
        }

        throw ValidationException::withMessages([
            'email' => ['لم نتمكن من إرسال رابط إعادة التعيين إلى هذا البريد.']
        ]);
    }
}

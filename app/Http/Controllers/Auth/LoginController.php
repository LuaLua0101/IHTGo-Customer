<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;
use App\Http\Controllers\Controller;

class LoginController extends Controller
{

    public function postLogin(Request $request)
    {
        try {
            // Nếu dữ liệu hợp lệ sẽ kiểm tra trong csdl
            $email = $request->input('email');
            $password = $request->input('password');
            if (Auth::attempt(['email' => $email, 'password' => $password])) {
                // Kiểm tra đúng email và mật khẩu sẽ chuyển trang
                if (Auth::user()->level == 3) {
                    Session::flash('success', 'Đăng nhập thành công');
                    return redirect('/');
                }else{
                    Auth::logout();
                    Session::flash('error', 'Bạn không được phân quyền đăng nhập!');
                    return redirect('/');
                }
            } else {
                // Kiểm tra không đúng sẽ hiển thị thông báo lỗi
                Session::flash('error', 'Email hoặc mật khẩu không đúng!');
                return redirect('/');
            }
            
        } catch (\Exception $ex) {
            return $ex;
        }
    }
}

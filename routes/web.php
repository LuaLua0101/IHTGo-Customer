<?php
Route::get('locale/{locale}', function ($locale) {
    Session::put('locale', $locale);
    return redirect()->back();
});

// Sửa đường dẫn trang chủ mặc định
Route::get('/', 'HomeController@index');
// Đăng ký, đăng nhập, đăng xuất thành viên
Route::post('register', 'Auth\RegisterController@postRegister');
Route::get('checkExistEmail/{email?}', 'Auth\RegisterController@checkExistEmail');
Route::get('checkExistPhone/{phone?}', 'Auth\RegisterController@checkExistPhone');

Route::post('login', ['as' => 'login', 'uses' => 'Auth\LoginController@postLogin']);
Route::post('logout', ['as' => 'logout', 'uses' => 'Auth\LogoutController@postLogout']);

// chỉnh sửa,thay đổi password thành viên
Route::post('edit-user', 'UserController@editUser');
Route::post('change-password', 'UserController@changePassword');
Route::get('checkExistPasswordCurrent/{password?}', 'UserController@checkExistPasswordCurrent');

//trang hiển thị
Route::get('gioi-thieu', 'HomeController@contact');
Route::post('contact-us', 'HomeController@contactUs');
Route::get('bang-gia', 'HomeController@price_list');
Route::get('tin-tuc', 'HomeController@news');
Route::get('noi-dung', 'HomeController@new_detail');
Route::get('don-hang', 'HomeController@order');
Route::get('chi-tiet-don-hang/id={id?}', 'HomeController@order_detail');
Route::get('tim-don-hang', 'HomeController@order_search');

//hiển thị danh sách  (AJAX)
Route::get('districtOfProvince/{province_id?}', 'DistrictController@districtOfProvince');
Route::get('loadHistoryDelivery/{order_detail_id?}', 'OrderController@loadHistoryDelivery');
//đơn hàng
Route::get('total-price-order-all', 'OrderController@totalPriceAll'); //ajax
Route::get('total-price-order', 'OrderController@totalPrice'); //ajax
Route::get('total-price-order-all-search', 'OrderController@totalPriceAllSearch'); //ajax
Route::get('total-price-order-search', 'OrderController@totalPriceSearch'); //ajax
Route::post('create-order', 'OrderController@create');

//xóa cache
Route::get('/clear-cache', function () {
    Artisan::call('cache:clear');
    return "Cache is cleared";
});

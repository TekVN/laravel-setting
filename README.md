# Laravel Setting

Laravel Setting là một package được viết nhằm phục vụ mục đích cá nhân, giúp quản lý các cài đặt trong ứng dụng Laravel
một cách dễ dàng. Mặc dù ban đầu package này được phát triển cho nhu cầu cá nhân, chúng tôi vẫn luôn hoan nghênh và mong
đợi các đóng góp từ cộng đồng. Nếu bạn có ý tưởng hoặc cải tiến, xin vui lòng gửi pull request!

## Tương thích

- [x] PHP-FPM
- [x] Laravel Octane

## Yêu cầu

- PHP >= 8.3
- Laravel Framework >= 11.0

## Cài đặt

Bạn có thể cài đặt package này thông qua Composer:

```bash
composer require dnt/laravel-setting
```

## Cấu hình

Nếu bạn không muốn sử dụng cấu hình mặc định. Hãy `publish` config và bạn có thể thay đổi chúng

```bash
php artisan vendor:publish --provider="DNT\Setting\SettingServiceProvider"
```

## Sử dụng

Để sử dụng các chức năng của package, bạn có thể làm theo ví dụ dưới đây:

```php
use DNT\Setting\Facade as Setting;

// Lưu một cài đặt
Setting::set('site_name', 'Laravel Setting');

// Lấy giá trị của một cài đặt
$siteName = Setting::get('site_name');

// Kiểm tra xem một cài đặt có tồn tại hay không
if (Setting::has('site_name')) {
    echo "Cài đặt site_name tồn tại.";
}

// Lấy tất cả cài đặt
Setting::all();
```

#### Nhóm cài đặt

Chúng tôi đưa ra cơ chế quản lý cài đặt theo nhóm. Tuy nhiên giá trị này có mặc định là `default`

```php
use DNT\Setting\Facade as Setting;

// Lưu một cài đặt
Setting::set('site_name', 'Laravel Setting', 'general');

// Lấy giá trị của một cài đặt
$siteName = Setting::get('site_name', group: 'general');

// Kiểm tra xem một cài đặt có tồn tại hay không
if (Setting::has('site_name', group: 'general')) {
    echo "Cài đặt site_name tồn tại.";
}

// Lấy tất cả cài đặt trong nhóm
Setting::allFromGroup('general');
```

## Đóng góp

Chúng tôi rất mong đợi các đóng góp từ cộng đồng để cải thiện và phát triển package này. Nếu bạn có ý tưởng, sửa lỗi
hoặc cải tiến, hãy gửi pull request trên GitHub.

## Donate

Nếu bạn thấy package này hữu ích và muốn ủng hộ chúng tôi, bạn có thể donate thông qua các kênh sau:

<img src="https://github.com/ducconit/ducconit/blob/master/assets/qr/mono.jpg?raw=true" alt="Buy Me A Coffee" width="150" height="170">

Mọi sự ủng hộ của bạn đều là nguồn động viên lớn đối với chúng tôi!

## Giấy phép

Package này được cấp phép theo MIT License.

Cảm ơn bạn đã sử dụng Laravel Setting!

<p align="center"><h1>Ckuthai</h1></p>
<br>
<br>

## New Version v2.0 soat web content manager

### add feature

-   [ ] alert log del table for line notify
-   [x] add library activity log
-   [ ] add library check country (allow for ip from thailand) for Auth Admin only
-   [ ] edit visitor counter with best pictice (https://hibbard.eu/how-to-make-a-simple-visitor-counter-using-php)
-   [x] Counter Page and Home using Session if check for first time.
-   [x] resheach listiner DB Alert
-   [x] edit file picture add content ws_post
-   [x] add Content type for page manage content etc. ws_post, ws_post_edit
-   [x] Edit datatable sortorder for drag and drop \(keyword etc. laravel data table drop position ,\)

*   **Create Miedleware**
    -   php artisan make:middleware AntihackMiddleware

*   **Wait Edit**
    -   [ ] Flie Manager new with UniSharp/laravel-filemanager

*   **Library add more**
    -   [torann/geoip](https://lyften.com/projects/laravel-geoip/doc/)
        -   using check country for admin
    -   [spatie/laravel-activitylog](https://docs.spatie.be/laravel-activitylog/v3/introduction/)
        -   using save activity log about insert update delete with database
    -   [linecorp/line-bot-sdk](https://github.com/line/line-bot-sdk-php)
        -   using alert to line notification for del data with database important
    -   [pusher/pusher-php-server](https://pusher.com/tutorials/web-notifications-laravel-pusher-channels)
        -   using Notification to Web App for new content
    -   [sentry/sentry-laravel](https://docs.sentry.io/platforms/php/laravel/#laravel-5x-6x--7x)
        -   using reporting for mail by a debug route that will throw an exception

### Fix Database

-   www_ucf_category add colum content_type VARCHAR\(50\)
-   www_security_user add colum seq INT\(11\) primary key
-   add table www_activity_log and create colum to same ckuthai_db database
-   www_ucf_user_group add colum seq int\(11\) NOT NULL AUTO_INCREMENT

### Fix

-   admin
    -   edit ui all page
    -   ui share content page ws_post and ws_post_edit to sub widget
    -   Edit page method add content about file_upload and pic_upload

### NEW! Feature

-   Push Notification with pusher
-   Notification with sentry for bug to mail , web or line

<br>
<br>
<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/d/total.svg" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/license.svg" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

-   [Simple, fast routing engine](https://laravel.com/docs/routing).
-   [Powerful dependency injection container](https://laravel.com/docs/container).
-   Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
-   Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
-   Database agnostic [schema migrations](https://laravel.com/docs/migrations).
-   [Robust background job processing](https://laravel.com/docs/queues).
-   [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains over 1400 video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the Laravel [Patreon page](https://patreon.com/taylorotwell).

-   **[Vehikl](https://vehikl.com/)**
-   **[Tighten Co.](https://tighten.co)**
-   **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
-   **[64 Robots](https://64robots.com)**
-   **[Cubet Techno Labs](https://cubettech.com)**
-   **[Cyber-Duck](https://cyber-duck.co.uk)**
-   **[British Software Development](https://www.britishsoftware.co)**
-   **[Webdock, Fast VPS Hosting](https://www.webdock.io/en)**
-   **[DevSquad](https://devsquad.com)**
-   [UserInsights](https://userinsights.com)
-   [Fragrantica](https://www.fragrantica.com)
-   [SOFTonSOFA](https://softonsofa.com/)
-   [User10](https://user10.com)
-   [Soumettre.fr](https://soumettre.fr/)
-   [CodeBrisk](https://codebrisk.com)
-   [1Forge](https://1forge.com)
-   [TECPRESSO](https://tecpresso.co.jp/)
-   [Runtime Converter](http://runtimeconverter.com/)
-   [WebL'Agence](https://weblagence.com/)
-   [Invoice Ninja](https://www.invoiceninja.com)
-   [iMi digital](https://www.imi-digital.de/)
-   [Earthlink](https://www.earthlink.ro/)
-   [Steadfast Collective](https://steadfastcollective.com/)
-   [We Are The Robots Inc.](https://watr.mx/)
-   [Understand.io](https://www.understand.io/)
-   [Abdel Elrafa](https://abdelelrafa.com)
-   [Hyper Host](https://hyper.host)

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-source software licensed under the [MIT license](https://opensource.org/licenses/MIT).
"# tistr" 

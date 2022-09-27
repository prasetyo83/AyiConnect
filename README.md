Requirement:

- Laravel Version: 9.x
- Composer version 2.1.14

Instalation Step:
1. Repository https://github.com/prasetyo83/AyiConnect.git

2. run command 
git clone git@github.com:prasetyo83/AyiConnect.git

3. run "composer install" on your local path

4. configure database on .env file

5. run command "php artisan migrate"

6. run app with command below
php artisan serve --host=test.id --port=8080


Testing:
1. Language translation base Localization
Goto path /ayiconnection/app/Http/Controllers/Auth/AuthController.php
UnRemark ip address for countries english, spain and indonesia to bypass testing page with IP

 public function __construct() {
        //$ip = "103.10.67.255"; //id
        //$ip ="103.82.128.67"; //uk
        //$ip = "109.227.191.100"; //spain
        //App::setLocale('es');
        //App::setLocale('es');
        $ip = request()->ip(); 
        //dd($clientIP);
        
        $this->currentUserInfo = Location::get($ip);
        $this->langLocale = $this->currentUserInfo->countryCode;
        $this->country = $this->currentUserInfo->countryName;
        
        \Illuminate\Support\Facades\App::setLocale(strtolower($this->langLocale));
    }
    
2. Login with multiple subdomain
Copy whole of ayiconnect into other path on your server
a. running command main domain test
php artisan serve --host=test.id --port=8080
b. running command for second subdomain test
php artisan serve --host=test.id --port=8089

Please login on one side and see other subdomain response by refresh "/dashboard" page

Thanks

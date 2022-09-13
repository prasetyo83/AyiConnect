<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\AuthorbookController;
use App\Http\Controllers\AuthorsController;
use App\Http\Controllers\AuthorDetailsController;
use App\Http\Controllers\AuthorSocialController;
use App\Http\Controllers\DailyProseController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MoodController;
use App\Http\Controllers\QuotesController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\ReasonController;
use App\Http\Controllers\FeelingController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\MultiTranslationController;
use App\Http\Controllers\SocialController;
use App\Http\Controllers\NewAdminController;
//use App\Http\Controllers\BookStoreController;
//use App\Http\Controllers\GroupCountriesController;
//use App\Http\Controllers\MasterGroupController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware(['auth','2fa'])->group(function () {
    Route::get('/home', function () {
        return view('dashboard');
    });
    Route::get('/sections', function () {
        return view('sections');
    });
    Route::get('/categories', function () {
        return view('categories');
    });
    Route::get('/authors', function () {
        return view('authors');
    });
    
    Route::resource('quotes',QuotesController::class);
    Route::get('/quotes', function () {
        return view('quotes');
    });
    
    Route::get('/fetchquotes', [QuotesController::class, 'datatable'])->name('fetchquotes');
    
    Route::get('/fetchauthor', [QuotesController::class, 'fetchauthor'])->name('fetchauthor');
    Route::get('/fetchbook', [QuotesController::class, 'fetchbook'])->name('fetchbook');
    Route::get('/fetchcategory', [QuotesController::class, 'fetchcategory'])->name('fetchcategory');
    Route::get('/fetchcountry', [QuotesController::class, 'fetchcountry'])->name('fetchcountry');
    
    Route::resource('multilang',MultiTranslationController::class);
    Route::get('/multilang', function () {
        return view('multilang');
    });
    
    
    Route::get('/daily-prose', function () {
        return view('daily-prose');
    });

    Route::resource('mood', MoodController::class);
    // Route::get('/mood', [MoodController::class, 'index'])->name('mood.serve.data');

    Route::resource('setting', SettingsController::class);
    Route::resource('user', UsersController::class);
    Route::get('/policy',  [SettingsController::class, 'index_terms'])->name('index_terms');
    Route::get('/password',  [SettingsController::class, 'index_password'])->name('index_password');
    
    // Route::resource('reason', ReasonController::class);
    Route::get('/reason', function () {
        return view('reason');
    });
    
    Route::get('/showmood', [ReasonController::class, 'showMood'])->name('showmood');
    Route::get('/reason', [ReasonController::class, 'index'])->name('reason.table');
    
    Route::get('/reasonedit', [ReasonController::class, 'edit'])->name('reason.edit');
     
    // Route::resource('feeling', FeelingController::class);
    Route::get('/feeling', function () {
        return view('feeling');
    });
    
    Route::get('/showreason', [FeelingController::class, 'showReason'])->name('showreason');
    Route::get('/showfeeling', [FeelingController::class, 'showFeeling'])->name('showfeeling');
    Route::get('/feeling', [FeelingController::class, 'index'])->name('feeling.table');
    
    Route::get('/feelingedit', [FeelingController::class, 'edit'])->name('feeling.edit');
    
    Route::get('/import', function () {
        return view('import');
    });
    Route::get('/users', function () {
        return view('users');
    });
    
    Route::get('/users/export2csv', [UsersController::class, 'export2csv'])->name('users.export2csv');
    
    Route::get('/settings', function () {
        return view('settings');
    });
    Route::post('logout', [LoginController::class, 'logout'])->name('logout');
    Route::resource('sections', SectionController::class);
    Route::resource('dailyprose', DailyProseController::class);
    Route::resource('authors', AuthorsController::class);
    Route::post('author/reorder', [AuthorsController::class, 'reorder'])->name('authorreorder');
    Route::post('section/reorder', [SectionController::class, 'reorder'])->name('sectionreorder');
    Route::post('categories/reorder', [CategoriesController::class, 'reorder'])->name('categoriesreorder');
    Route::get('gethastag', [AuthorsController::class, 'getHastag'])->name('getHastag');
    Route::post('storeHastag', [AuthorsController::class, 'store_hastag'])->name('storeHastag');
    Route::resource('categories', CategoriesController::class);
    Route::resource('dashboard', DashboardController::class);
    Route::resource('authordetails', AuthorDetailsController::class);
    Route::get('/authorsdetail/{id}', [AuthorDetailsController::class, 'index']);

    // Route::get('/authorsdetail/{id}/social', [AuthorDetailsController::class, 'social'])->name("authorsdetail.social");
    Route::get('/authorsdetail/{id}/social', [AuthorSocialController::class, 'index'])->name("authorsdetail.social");
    Route::resource('authorsocial', AuthorSocialController::class);
    Route::get('/fetchsocial', [AuthorSocialController::class, 'fetchsocial'])->name("fetchsocial");

    Route::get('/authorsdetail/{id}/book', [AuthorbookController::class, 'index'])->name("authorsdetail.book");
    
    Route::resource('authorbook', AuthorbookController::class);
    Route::get('/authorsdetail/{id}/quote', [QuotesController::class, 'author'])->name("authorsdetail.quote");
    Route::get('/authorsdetail/{id}/chart', [AuthorDetailsController::class, 'chart'])->name("authorsdetail.chart");
    Route::resource('quotes', QuotesController::class);

    Route::post('authordetail/social', [AuthorDetailsController::class, 'socialstore'])->name('authorsdetail.socialstore');
    Route::get('/show_section', [CategoriesController::class, 'show_section'])->name('show_section');
    
    Route::get('/social', function () {
        return view('social');
    });
    Route::resource('social', SocialController::class);
    Route::post('social/reorder', [SocialController::class, 'reorder'])->name('socialreorder');
    
    //Route::get('fetchbookstore', [BookStoreController::class, 'fetchbookstore'])->name('fetchbookstore');
    //Route::get('fetchgc', [GroupCountriesController::class, 'fetchgc'])->name('fetchgc');
    //Route::get('fetchmg', [MasterGroupController::class, 'fetchmg'])->name('fetchmg');    



    // ===rendra new
    Route::get('/newadmin',  [SettingsController::class, 'index_newadmin'])->name('index_newadmin');
    Route::post('registeradmin',  [NewAdminController::class, 'register'])->name('registeradmin');
    // Route::get('admins',  [NewAdminController::class, 'index'])->name('admins.index');
    Route::resource('admin', NewAdminController::class);

});


Route::get('/login', function () {
    return view('login');
});
Route::get('/', [LoginController::class, 'view'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('plogin');

Route::post('/2fa', function () {
    return redirect(URL()->previous());
})->name('2fa')->middleware('2fa');

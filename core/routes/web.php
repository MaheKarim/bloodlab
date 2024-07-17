<?php

use Illuminate\Support\Facades\Route;

Route::get('/clear', function(){
    \Illuminate\Support\Facades\Artisan::call('optimize:clear');
});


// User Support Ticket
Route::controller('TicketController')->prefix('ticket')->name('ticket.')->group(function () {
    Route::get('/', 'supportTicket')->name('index');
    Route::get('new', 'openSupportTicket')->name('open');
    Route::post('create', 'storeSupportTicket')->name('store');
    Route::get('view/{ticket}', 'viewTicket')->name('view');
    Route::post('reply/{id}', 'replyTicket')->name('reply');
    Route::post('close/{id}', 'closeTicket')->name('close');
    Route::get('download/{attachment_id}', 'ticketDownload')->name('download');
});


Route::controller('SiteController')->group(function () {
    Route::get('/contact', 'contact')->name('contact');

    Route::post('/contact', 'contactSubmit');

    Route::get('/change/{lang?}', 'changeLanguage')->name('lang');

    Route::get('cookie-policy', 'cookiePolicy')->name('cookie.policy');

    Route::get('/cookie/accept', 'cookieAccept')->name('cookie.accept');

    Route::get('blog/{slug}', 'blogDetails')->name('blog.details');

    Route::get('policy/{slug}', 'policyPages')->name('policy.pages');

    Route::get('placeholder-image/{size}', 'placeholderImage')->withoutMiddleware('maintenance')->name('placeholder.image');

    Route::get('maintenance-mode','maintenance')->withoutMiddleware('maintenance')->name('maintenance');

    Route::get('/{slug}', 'pages')->name('pages');

    Route::get('/', 'index')->name('home');

    Route::get('donor', 'donor')->name('donor');
    Route::get('donor/{slug}/{id}', 'donorDetails')->name('donor.details');
    Route::get('donor/search', 'donorSearch')->name('donor.search');
    Route::post('donor/contact', 'contactWithDonor')->name('donor.contact');
    Route::get('blood/donor/{slug}/{id}', 'bloodGroup')->name('blood.group.donor');

    Route::get('apply/donor', 'applyDonor')->name('apply.donor');
    Route::post('apply/donor/store', 'applyDonorStore')->name('apply.donor.store');
//    Route::get('menu/{slug}', 'footerMenu')->name('footer.menu');

    Route::get('add/{id}', 'adClicked')->name('add.clicked');
    Route::post('subscribe', 'subscribe')->name('subscribe');
});

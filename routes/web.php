<?php

use App\Http\Controllers\ContactController;
use App\Http\Controllers\NotifyController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'home')->name('home');

Route::get('/contact', [ContactController::class, 'show'])->name('contact');
Route::post('/contact', [ContactController::class, 'send'])
    ->middleware('throttle:5,1')
    ->name('contact.send');

Route::post('/notify', [NotifyController::class, 'store'])
    ->middleware('throttle:5,1')
    ->name('notify');

// Feature and documentation pages, one per search intent
Route::view('/pro', 'guides.pro')->name('pro');
Route::view('/audiobookshelf', 'guides.audiobookshelf')->name('audiobookshelf');
Route::view('/transcripts', 'guides.transcripts')->name('transcripts');
Route::view('/formats', 'guides.formats')->name('formats');
Route::view('/android-auto', 'guides.android-auto')->name('android-auto');
Route::view('/sync-protocol', 'guides.sync-protocol')->name('sync-protocol');
Route::view('/changelog', 'guides.changelog')->name('changelog');
Route::redirect('/feed', '/changelog.xml', 301);
Route::redirect('/rss', '/changelog.xml', 301);
Route::redirect('/feed.xml', '/changelog.xml', 301);
Route::redirect('/rss.xml', '/changelog.xml', 301);
Route::get('/changelog.xml', fn () => response()->view('crawlers.changelog-feed')->header('Content-Type', 'application/rss+xml; charset=utf-8'))->name('changelog.feed');

Route::view('/how-to/add-chapters-to-m4b', 'howto.add-chapters-to-m4b')->name('howto.m4b-chapters');
Route::view('/how-to/audiobookshelf-setup', 'howto.audiobookshelf-setup')->name('howto.audiobookshelf-setup');
Route::view('/how-to/leaving-audible', 'howto.leaving-audible')->name('howto.leaving-audible');

Route::view('/compare', 'compare.index')->name('compare');
Route::view('/compare/smart-audiobook-player', 'compare.smart-audiobook-player')->name('compare.smart-audiobook-player');
Route::view('/compare/audiobookshelf-app', 'compare.audiobookshelf-app')->name('compare.audiobookshelf-app');
Route::view('/compare/audible', 'compare.audible')->name('compare.audible');

Route::view('/terms', 'legal.terms')->name('terms');
Route::view('/privacy', 'legal.privacy')->name('privacy');

// Crawler-facing files, generated so they always carry the right host.
Route::get('/sitemap.xml', fn () => response()->view('crawlers.sitemap')->header('Content-Type', 'application/xml'))->name('sitemap');
Route::get('/robots.txt', fn () => response()->view('crawlers.robots')->header('Content-Type', 'text/plain'))->name('robots');
Route::get('/llms.txt', fn () => response()->view('crawlers.llms')->header('Content-Type', 'text/plain; charset=utf-8'))->name('llms');

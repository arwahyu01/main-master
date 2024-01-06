<?php
use Illuminate\Support\Facades\Route;
Route::group(['prefix'=>config('master.app.url.backend')], function () {
    //public route
    Route::resource('dashboard', "Dashboard\DashboardController")->name('index', 'dashboard');
    Route::get('/list-menu', "Menu\MenuController@listMenu")->name('menu.list-menu');
    Route::get('announcement-detail/{id}/{slug}', "Announcement\AnnouncementController@detail")->name('announcement');
    Route::get('sidebar-notification', 'Notification\NotificationController@getSideBarNotification');
    Route::get('get-notification', 'Notification\NotificationController@getNotification');
    Route::get('clear-notification', 'Notification\NotificationController@markAsRead');
    Route::post('logout','Auth\AuthController@logout')->name('logout');
    //end public route
    //question
    Route::prefix('question')->as('question')->group(function () {
        Route::get('data', "Question\QuestionController@data");
        Route::get('page/{page}', "Question\QuestionController@page");
        Route::get('viewer', "Question\QuestionController@updateViewer");
        Route::post('response', "Question\QuestionController@response");
    });
    Route::resource('question', "Question\QuestionController")->name('index', 'question');
    //file
    Route::prefix('file')->as('file')->group(function () {
        Route::get('stream/{id}/{name}', "File\FileController@getFile");
        Route::get('download/{id}/{name}', "File\FileController@downloadFile");
        Route::get('delete/{id}/{name}', "File\FileController@deleteFile");
        Route::post('upload-image-editor','File\FileController@handleEditorImageUpload');
    });
    Route::group(['middleware'=>['userRoles']], function () {
        //user
        Route::prefix('user')->as('user')->group(function () {
            Route::get('data', "User\UserController@data");
            Route::get('delete/{id}', "User\UserController@delete");
        });
        Route::resource('user', "User\UserController");
        //end-user
        //menu
        Route::post('/sorted', "Menu\MenuController@sorted")->name('menu.sorted');
        Route::prefix('menu')->as('menu')->group(function () {
            Route::get('/data', "Menu\MenuController@data");
            Route::get('delete/{id}', "Menu\MenuController@delete");
        });
        Route::resource('menu', "Menu\MenuController");
        //end-menu
        //access-group
        Route::prefix('access-group')->as('access-group')->group(function () {
            Route::get('data', "AccessGroup\AccessGroupController@data");
            Route::get('delete/{id}', "AccessGroup\AccessGroupController@delete");
        });
        Route::resource('access-group', "AccessGroup\AccessGroupController");
        //end-access-group
        //level
        Route::prefix('level')->as('level')->group(function () {
            Route::get('data', "Level\LevelController@data");
            Route::get('delete/{id}', "Level\LevelController@delete");
        });
        Route::resource('level', "Level\LevelController");
        //end-level
        //access-menu
        Route::prefix('access-menu')->as('access-menu')->group(function () {
            Route::get('data', "AccessMenu\AccessMenuController@data");
            Route::get('delete/{id}', "AccessMenu\AccessMenuController@delete");
        });
        Route::resource('access-menu', "AccessMenu\AccessMenuController");
        //end-access-menu
        //faq
        Route::prefix('faq')->as('faq')->group(function () {
            Route::get('data', "Faq\FaqController@data");
            Route::get('delete/{id}', "Faq\FaqController@delete");
        });
        Route::resource('faq', "Faq\FaqController");
        //end-faq
    	//announcement
		Route::prefix('announcement')->as('announcement')->group(function () {
			Route::get('data', 'Announcement\AnnouncementController@data');
			Route::get('delete/{id}', 'Announcement\AnnouncementController@delete');
		});
		Route::resource('announcement', 'Announcement\AnnouncementController');
		//end-announcement
        //notification
		Route::prefix('notification')->as('notification')->group(function () {
			Route::get('data', 'Notification\NotificationController@data');
			Route::get('delete/{id}', 'Notification\NotificationController@delete');
		});
		Route::resource('notification', 'Notification\NotificationController');
		//end-notification
	});
});



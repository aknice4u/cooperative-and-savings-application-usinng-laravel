<?php

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
Route::get('/', 									'WelcomeController@loadPage')->name('index'); 
//Member Application
Route::get('/member-application','MemberApplicationController@index')->name('memberApply'); 
Route::post('/member-application','MemberApplicationController@save')->name('saveMemberApply');	
Route::post('/get-local-government','MemberApplicationController@LGA');

Auth::routes();
Route::get('/logout', 								'Auth\LoginController@logout')->name('logout'); 
//
//BOTH ADMIN AND MEMBER
Route::group(['middleware' => ['auth']], function () 
{
	Route::get('/home', 							'HomeController@loadPage')->name('home');
	//ToDo List 
	Route::post('/todo-list', 						'HomeController@addToDolist')->name('addToDoList'); 
	Route::post('/remove-todo-list', 					'HomeController@removeToDolist')->name('removeToDoList'); 
	Route::post('/flag-todo-list', 						'HomeController@flagToDolist'); 
	Route::get('/edit-account', 						'EditAccountController@create')->name('editAccount'); 
	Route::post('/edit-account', 						'EditAccountController@processAccount')->name('postEditAccount');
	//SEARCH MEMBER
	Route::any('/member-portal',                 				'MemberPortalController@index');
	//Director
	Route::get('/nicn-cooperative-committee',                 	   	'DirectorCommitteeController@allCoopCommittee')->name('committee');
	
	
	
	
});



//MEMBER -E-PORTAL
Route::group(['middleware' => ['auth'], 'middleware' => ['trackUser'], 'middleware' => ['trackMember']], function () 
{

	Route::get('/all-my-transaction-histroty', 		  'MemberController@getMemberTransaction')->name('myTrasaction'); 
//Loan Request
Route::get('/loan-request/create', 'LoanRequestController@create');
Route::post('/loan-request/create', 'LoanRequestController@store');
Route::post('/calculate/loan-interest-rate', 'LoanRequestController@interest');
Route::post('/get-members/detail', 'LoanRequestController@members');
Route::post('/calculate/monthly-repayment', 'LoanRequestController@monthly_repay');
Route::get('/my-request/list', 'LoanRequestController@myRequest');
Route::get('/my-request/edit/{id}', 'LoanRequestController@editmyRequest');
Route::post('/my-request/update', 'LoanRequestController@update');
Route::any('/self-transaction/history',                          'ReportController@MemberReportself');
Route::any('/self-archive/report',                          'ReportController@ArciveReportself');
Route::get('/guarantor/acceptance/{code}', 'LoanRequestController@guarantorAcceptance');
Route::get('/loan/bond/{id?}', 'LoanRequestController@bond');

Route::any('/edit-contribution', 'RemitanceAmountController@index');

Route::any('/monthly-delete/{id?}', 'RemitanceAmountController@delete');

Route::get('/loan-request/add', 'LoanRequestController@createLoanAdmin');
Route::post('/loan-request/add', 'LoanRequestController@store');
Route::post('/user/details', 'LoanRequestController@userDetails');


});



//ADMIN - E-PORTAL
Route::group(['middleware' => ['auth'], 'middleware' => ['trackUser'], 'middleware' => ['trackAdmin']], function () 
{
	
	Route::any('/monthly/contribution',                          'TransactionController@computation');
	Route::any('/archive/report',                          'TransactionController@ArchiveTransaction');
	Route::any('/member-transaction/report',                          'TransactionController@MemberReport');
	Route::any('/member-summary/report',                          'ReportController@MemberSummaryList');
	Route::any('/monthly/contribution-report',                          'ReportController@MonthlyContribution');
	Route::any('/payment-transaction',					  'PaymentTransactionController@paymenttransaction');
	Route::any('/record/upload',                          'TransactionController@DataUpload');
	Route::any('/salary/record',                          'TransactionController@ContributionFromSalary');
	
	//Member Registration
	//Route::get('/edit-member-profile-information', 		'AdminMemberController@createEditProfile')->name('editProfile'); 
	//Route::get('/member-registration', 					'AdminMemberController@createMemberRegistration')->name('memberRegistration');
	Route::get('/get-applicants',               'MemberRegistrationController@getApplicants')->name('getApplicants'); 
	Route::get('/retrieve-applicant/{id}',      'MemberRegistrationController@retrieveApplicants'); 
	
	Route::any('/member-registration/{id?}','MemberRegistrationController@index')->name('regMember');
	Route::get('/edit-member-profile-information','MemberRegistrationController@edit')->name('editProfile'); 
	Route::post('/member-registration-save','MemberRegistrationController@save')->name('memberRegistration');	
	Route::post('/get-lga','MemberRegistrationController@LGA');
	Route::post('/ajaxcall/application','MemberRegistrationController@ajaxcall');
	Route::post('/approve-application','MemberRegistrationController@approve')->name('approveApplication');




	
	//Loan Request Approval/Rejection
	Route::get('/loan-requests/list', 'LoanRequestController@viewLoanRequest');
	Route::post('/loan/details', 'LoanRequestController@loanDetails');
	Route::post('/guarantor/details', 'LoanRequestController@guarantorDetails');
	
		Route::get('/loan-requests/bulk-list', 'LoanRequestController@viewLoanRequestBulk');
	    Route::post('/loan-requests/bulk-approval', 'LoanRequestController@approvalBulk');
	
	Route::post('/approve-request', 'LoanRequestController@approval');
	Route::post('/reject-request', 'LoanRequestController@reject');
	
	//epayment
	Route::get('/epayment', 'EpaymentController@index');
	Route::post('/epayment/export/', 'EpaymentController@export');
	Route::get('/epayment/report/', 'EpaymentController@allApprovedLoans');
	Route::post('/epayment/update-selected', 'EpaymentController@updateSelected');
	Route::get('/payment/generated', 'EpaymentController@paymentGenerated');
	Route::post('/epayment/confirm', 'EpaymentController@confirm');
	
	Route::get('/epayment/restore', 'EpaymentController@payRestore');
	Route::post('/epayment/restore', 'EpaymentController@postRestore');
	Route::get('/epayment/view-batch', 'EpaymentController@viewBatch');
	Route::get('/epayment/view-epayment/{batch}', 'EpaymentController@epaymentBatch');
	 Route::post('/batch/search',    'EpaymentController@postBatch');
	Route::get('/loan-history/list', 'LoanRequestController@loanHistory');
	Route::post('/loan-history/list', 'LoanRequestController@searchHistory');
	
	
	
	Route::any('/bank-details', 'BankDetailsController@index');
	
	Route::any('/edit-contrib-approve', 'RemitanceAmountController@admin');
	
	Route::any('/print-change/{id?}', 'RemitanceAmountController@print');
	
	Route::any('/printslip/{id?}', 'RemitanceAmountController@printslip');
	
	Route::any('/change-rate', 'RemitanceAmountController@rating');
	
	Route::any('/edit-rate', 'RemitanceAmountController@rate'); 
	
	Route::any('/bank-delete/{id?}', 'BankDetailsController@delete');
	
	Route::any('/approve-change/{id?}', 'RemitanceAmountController@approve_req');
	
	//Division
	Route::get('/division', 'DivisionController@index')->name('showDivisions');
	Route::post('/division', 'DivisionController@add')->name('addDivision');
	Route::get('/division-delete/{id}', 'DivisionController@destroy')->name('deleteDivision');
	Route::post('/division-update', 'DivisionController@update')->name('updateDivision');
	
	//ADD BANK
	Route::get('/add-new-bank-details', 				'CoopBankDetailsController@createBank')->name('addBankDetails'); 
	Route::post('/add-new-bank-details', 				'CoopBankDetailsController@storeBank')->name('postBankDetails'); 
	Route::get('/remove-bank-details/{id}', 			'CoopBankDetailsController@deleteBank')->name('removeBankDetails');
	//Management Committee
	Route::get('create-new-committee',                 	   	'DirectorCommitteeController@create')->name('createCommittee');
	Route::post('create-new-committee',                 	   	'DirectorCommitteeController@store')->name('createCommittee');
	Route::get('update-committee',                 	   		'DirectorCommitteeController@createUpdate');
	Route::post('update-committee',                 	   	'DirectorCommitteeController@update')->name('updateCreateCommittee');
	Route::get('delete-committee/{deleteID?}',                 	'DirectorCommitteeController@delete');
	
	
	Route::get('/loan-request/add', 'LoanRequestController@createLoanAdmin');
	Route::post('/loan-request/add', 'LoanRequestController@storeLoan');
	Route::post('/user/details', 'LoanRequestController@userDetails');
	Route::post('/calculate/loan-interest', 'LoanRequestController@interest');
	Route::post('/get-members', 'LoanRequestController@members');
	Route::get('/loan/bond/{id?}', 'LoanRequestController@bond');
	
	Route::post('/approve-request', 'LoanRequestController@approval');
	Route::get('/loan-request/secretary', 'LoanRequestController@secretaryView');
	Route::get('/loan-request/treasurer', 'LoanRequestController@treasurerView');
	Route::post('/approval-steps/update', 'LoanRequestController@pushTo');
	Route::get('/searchUser/{q?}', 						'LoanRequestController@autocomplete');
	
	
	Route::post('/update-loan-date', 'LoanRequestController@updateDate');
});



////////////////ERROR HANDLER/////////////
Route::get('500', function()
{
    abort(500);
});

Route::get('503', function()
{
    abort(503);
});

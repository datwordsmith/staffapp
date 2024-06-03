<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;

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

Route::get('/', function () {
    return view('/home');
});

Auth::routes();

Route::get('', App\Livewire\AllStaff\Index::class);
Route::get('/home', App\Livewire\AllStaff\Index::class)->name('home');
Route::get('/profile/{staffId}', App\Livewire\AllStaff\Profile::class);


Route::prefix('admin')->middleware(['auth', 'isAdmin'])->group(function (){
    // Route::get('/dashboard', [DashboardController::class, 'index'])->name('index');

    Route::get('/titles', App\Livewire\Admin\Title\Index::class);
    Route::get('/ranks', App\Livewire\Admin\Rank\Index::class);
    Route::get('/social_media', App\Livewire\Admin\SocialMedia\Index::class);

    Route::get('/units', App\Livewire\Admin\Unit\Index::class)->name('units');
    Route::get('/sub_units', App\Livewire\Admin\SubUnit\Index::class)->name('subunits');
    Route::get('/faculties', App\Livewire\Admin\Faculty\Index::class);
    Route::get('/departments', App\Livewire\Admin\Department\Index::class);
    //Route::get('/programmes', App\Livewire\Admin\Programme\Index::class);

    Route::get('/academicstaff', App\Livewire\Admin\User\AcademicStaff::class)->name('academicstaff');
    Route::get('/nonacademic-staff', App\Livewire\Admin\User\NonAcademicStaff::class)->name('non-academic-staff');
    Route::get('/profile/{staffId}', App\Livewire\Admin\User\Profile::class)->name('profile');


    Route::get('/appraisal_requests', App\Livewire\Admin\Aper\Index::class);
    Route::get('/aper/{aperId}/evaluation', App\Livewire\Admin\Aper\Evaluation::class)->name('evaluate');
    Route::get('/aper/{aperId}/approval', App\Livewire\Admin\Aper\Approval::class)->name('approval');
    Route::get('/aper/{aperId}/report', App\Livewire\Admin\Aper\Report::class)->name('aperreport');
});

Route::prefix('staff')->middleware(['isStaff'])->group(function (){
    Route::get('/profile', App\Livewire\Staff\Profile\Index::class)->name('myprofile');
    Route::get('/interests', App\Livewire\Staff\Interests\Index::class);
    // Route::get('/publications', App\Livewire\Staff\Publications\Index::class);
    Route::get('/socialmedia', App\Livewire\Staff\SocialMedia\Index::class);
    Route::get('/teachingexperience', App\Livewire\Staff\TeachingExperience\Index::class);
    Route::get('/scholarships_prizes', App\Livewire\Staff\Awards\Index::class);
    Route::get('/honours_distinctions', App\Livewire\Staff\Honours\Index::class);
    Route::get('/societymemberships', App\Livewire\Staff\Memberships\Index::class);
    Route::get('/conferences', App\Livewire\Staff\Conferences\Index::class);
    Route::get('/initial_qualifications', App\Livewire\Staff\InitialQualifications\Index::class);
    Route::get('/additional_qualifications', App\Livewire\Staff\AdditionalQualifications\Index::class);
    Route::get('/completed_researches', App\Livewire\Staff\CompletedResearches\Index::class);
    Route::get('/ongoing_researches', App\Livewire\Staff\OngoingResearches\Index::class);
    Route::get('/creative_works', App\Livewire\Staff\CreativeWorks\Index::class);
    Route::get('/university_administration', App\Livewire\Staff\UniversityAdministration\Index::class);
    Route::get('/community_services', App\Livewire\Staff\CommunityServices\Index::class);
    Route::get('/accepted_papers', App\Livewire\Staff\JournalPapers\Accepted::class);
    Route::get('/submitted_papers', App\Livewire\Staff\JournalPapers\Submitted::class);
    Route::get('/first_appointment', App\Livewire\Staff\FirstAppointment\Index::class);
    Route::get('/monographs_books', App\Livewire\Staff\StaffPublications\Index::class)->name('monographs_books');
    Route::get('/journal_articles', App\Livewire\Staff\StaffPublications\JournalArticles::class)->name('journal_articles');
    Route::get('/conference_proceedings', App\Livewire\Staff\StaffPublications\ConferenceProceedings::class)->name('conference_proceedings');
    Route::get('/appraisal_request', App\Livewire\Staff\AppraisalRequest\Index::class);
    Route::get('/appraisal_request/{aperId}/view', App\Livewire\Staff\AppraisalRequest\View::class)->name('aperview');
});


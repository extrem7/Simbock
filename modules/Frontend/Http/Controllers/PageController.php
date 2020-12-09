<?php

namespace Modules\Frontend\Http\Controllers;

use App\Models\Page;
use App\Models\Vacancy;
use App\Models\Volunteers\Volunteer;
use Illuminate\Http\JsonResponse;
use Modules\Frontend\Http\Requests\ContactFormRequest;
use Modules\Frontend\Mail\ContactForm;

class PageController extends Controller
{
    public function home()
    {
        $page = Page::find(1);

        $this->seo()->setTitle($page->meta_title ?? $page->title, false);

        if ($description = $page->meta_description) {
            $this->seo()->setDescription($description);
        }

        \Route2Class::addClass('bg-linear-gradient');

        $vacancies = Vacancy::count();
        $resumes = Volunteer::count();

        return view('frontend::pages.home', compact('vacancies', 'resumes'));
    }

    public function work(Page $page)
    {
        $vacancies = Vacancy::active()
            ->where('company_id', '=', 4)
            ->latest()
            ->get(['id', 'title', 'city_id', 'created_at'])
            ->map(function (Vacancy $vacancy) {
                $vacancy->append(['date', 'location']);

                return $vacancy;
            });

        share(compact('vacancies'));

        return view('frontend::pages.work');
    }

    public function help(Page $page)
    {
        share(['title' => $page->title]);
        return view('frontend::pages.help');
    }

    public function show(Page $pageModel)
    {
        $page = $pageModel;

        $this->seo()->setTitle($page->meta_title ?? $page->title);
        if ($description = $page->meta_description) {
            $this->seo()->setDescription($description);
        }

        share([
            'content' => $page->body
        ]);

        $view = 'default';

        if ($page->id === 2 || $page->slug === 'our-vacancies') {
            return $this->work($page);
        }

        \Route2Class::addClass('bg-linear-gradient');

        if ($page->id === 5 || $page->slug === 'help') {
            return $this->help($page);
        }

        if ($page->id === 0) {
            $view = '';
        }

        return view("frontend::pages.$view");
    }

    public function contactForm(ContactFormRequest $request): JsonResponse
    {
        \Mail::to(config('frontend.emails_for_contacts'))->send(new ContactForm($request->validated()));

        return response()->json(['message' => 'Your message has been sent.']);
    }
}

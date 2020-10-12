<?php

namespace Modules\Frontend\Http\Controllers;

use App\Models\Page;
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

        return view('frontend::pages.home');
    }

    public function show(Page $pageModel)
    {
        $page = $pageModel;

        $this->seo()->setTitle($page->meta_title ?? $page->title);
        if ($description = $page->meta_description) {
            $this->seo()->setDescription($description);
        }

        $view = 'default';

        if ($page->id === 2) {
            $view = '';
        }

        return view("frontend::pages.$view", compact('page'));
    }

    public function contactForm(ContactFormRequest $request)
    {
        \Mail::to(config('frontend.emails_for_contacts'))->send(new ContactForm($request->validated()));

        return response()->json(['status' => 'Your message has been sent']);
    }
}

<?php namespace Components\ContactManager\Controllers\Backend;

/*
=================================================
CMS Name  :  DOPTOR
CMS Version :  v1.2
Available at :  www.doptor.org
Copyright : Copyright (coffee) 2011 - 2015 Doptor. All rights reserved.
License : GNU/GPL, visit LICENSE.txt
Description :  Doptor is Opensource CMS.
===================================================
*/
use App;
use Backend\AdminController as BaseController;
use Components\ContactManager\Models\ContactCategory;
use File;
use Input;
use Redirect;
use Request;
use Sentry;
use Services\Validation\ValidationException as ValidationException;
use Str;
use View;

class ContactCategoriesController extends BaseController
{

    public function __construct()
    {
        parent::__construct();
        // Add location hinting for views
        View::addNamespace('contact_categories',
          app_path() . "/../resources/views/{$this->link_type}/{$this->current_theme}/contact_categories");
    }

    /**
     * Display a listing of the contact-categories.
     *
     * @return Response
     */
    public function index()
    {
        $contact_cats = ContactCategory::all();
        $this->layout->title = trans('cms.contact_categories');
        $this->layout->content = View::make('contact_categories::index')
          ->with('contact_cats', $contact_cats);
    }

    /**
     * Show the form for creating a new contact.
     *
     * @return Response
     */
    public function create()
    {
        $this->layout->title = 'New Contact Category';
        $this->layout->content = View::make('contact_categories::create_edit');
    }

    /**
     * Store a newly created contact in storage.
     *
     * @return Response
     */
    public function store()
    {
        $input = Input::all();
        try {
            ContactCategory::create($input);
            return Redirect::to("backend/contact-categories")
              ->with('success_message', trans('success_messages.contact_cat_create'));
        } catch (ValidationException $e) {
            return Redirect::back()->withInput()->withErrors($e->getErrors());
        }
    }

    /**
     * Display the specified contact.
     *
     * @param  int $id
     * @return Response
     */
    public function show($id)
    {
        $category = ContactCategory::with('contacts')->findOrFail($id);
        if (!$category) {
            App::abort('404');
        }
        $this->layout->title = "Contacts in category $category->name";
        $this->layout->content = View::make('contact_categories::show')
          ->with('category', $category);
    }

    /**
     * Show the form for editing the specified contact.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {
        $this->layout->title = 'Edit Contact Category';
        $this->layout->content = View::make('contact_categories::create_edit')
          ->with('contact_cat', ContactCategory::findOrFail($id));
    }

    /**
     * Update the specified contact category in storage.
     *
     * @param  int $id
     * @return Response
     */
    public function update($id)
    {
        try {
            ContactCategory::findOrFail($id)->update(Input::all());
            return Redirect::to("backend/contact-categories")
              ->with('success_message', trans('success_messages.contact_cat_update'));
        } catch (ValidationException $e) {
            return Redirect::back()->withInput()->withErrors($e->getErrors());
        }
    }

    /**
     * Remove the specified contact category from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id = null)
    {
        // If multiple ids are specified
        if ($id == 'multiple') {
            $selected_ids = trim(Input::get('selected_ids'));
            if ($selected_ids == '') {
                return Redirect::back()
                  ->with('error_message', trans('error_messages.nothing_selected_delete'));
            }
            $selected_ids = explode(' ', $selected_ids);
        } else {
            $selected_ids = array($id);
        }
        foreach ($selected_ids as $id) {
            $contact_cat = ContactCategory::findOrFail($id);
            $contact_cat->delete();
        }
        $wasOrWere = (count($selected_ids) > 1) ? ' were' : ' was';
        $message = trans('success_messages.contact_cat_delete');
        return Redirect::to("backend/contact-categories")
          ->with('success_message', $message);
    }

}

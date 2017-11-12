<?php
namespace Components\Posts\Controllers\Backend;

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
use Category;
use File;
use Input;
use PostCategory;
use Redirect;
use Request;
use Sentry;
use Services\Validation\ValidationException as ValidationException;
use Str;
use View;

class PostCategoriesController extends BaseController
{

    public function __construct()
    {
        // Add location hinting for views
        View::addLocation(app_path() . '/components/posts/views');
        View::addNamespace('posts', app_path() . '/components/posts/views');
        if (Request::is('backend/page-categories*')) {
            $this->type = 'page';
        } else {
            $this->type = 'post';
        }
        parent::__construct();
    }

    /**
     * Display a listing of the posts-categories.
     *
     * @return Response
     */
    public function index()
    {
        $post_cats = Category::type($this->type)->get();
        if ($this->type == 'post') {
            $title = trans('cms.page_categories');
        } else {
            $title = trans('cms.post_categories');
        }
        $this->layout->title = $title;
        $this->layout->content = View::make($this->link_type . '.' . $this->current_theme . '.categories.index')->with('post_cats',
          $post_cats)->with('type', $this->type);
    }

    /**
     * Show the form for creating a new post.
     *
     * @return Response
     */
    public function create()
    {
        $this->layout->title = 'New ' . Str::title($this->type) . ' Category';
        $this->layout->content = View::make($this->link_type . '.' . $this->current_theme . '.categories.create_edit')->with('type',
          $this->type);
    }

    /**
     * Store a newly created post in storage.
     *
     * @return Response
     */
    public function store()
    {
        $input = Input::all();
        try {
            Category::create($input);
            return Redirect::to("backend/{$this->type}-categories")->with('success_message',
              trans('success_messages.post_cat_create'));
        } catch (ValidationException $e) {
            return Redirect::back()->withInput()->withErrors($e->getErrors());
        }
    }

    /**
     * Display the specified post.
     *
     * @param  int $id
     * @return Response
     */
    public function show($id)
    {
        $post = Category::findOrFail($id);
        if (!$post) {
            App::abort('404');
        }
        $this->layout->title = $post->title;
        $this->layout->content = View::make($this->link_type . '.' . $this->current_theme . '.categories.show')->with('post',
          $post);
    }

    /**
     * Show the form for editing the specified post.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {
        $this->layout->title = 'Edit ' . Str::title($this->type) . ' Category';
        $this->layout->content = View::make($this->link_type . '.' . $this->current_theme . '.categories.create_edit')->with('post_cat',
          Category::findOrFail($id))->with('type', $this->type);;
    }

    /**
     * Update the specified post category in storage.
     *
     * @param  int $id
     * @return Response
     */
    public function update($id)
    {
        try {
            Category::findOrFail($id)->update(Input::all());
            return Redirect::to("backend/{$this->type}-categories")->with('success_message',
              trans('success_messages.post_cat_update'));
        } catch (ValidationException $e) {
            return Redirect::back()->withInput()->withErrors($e->getErrors());
        }
    }

    /**
     * Remove the specified post category from storage.
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
                return Redirect::back()->with('error_message', trans('error_messages.nothing_selected_delete'));
            }
            $selected_ids = explode(' ', $selected_ids);
        } else {
            $selected_ids = array($id);
        }
        foreach ($selected_ids as $id) {
            $post_cat = Category::findOrFail($id);
            $post_cat->delete();
        }
        if (count($selected_ids) > 1) {
            $message = trans('success_messages.post_cats_delete');
        } else {
            $message = trans('success_messages.post_cat_delete');
        }
        return Redirect::to("backend/{$post_cat->type}-categories")->with('success_message', $message);
    }
}

<?php namespace Modules\Doptor\Slideshow\Controllers\Backend;

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
use File;
use Input;
use Redirect;
use View;
use Sentry;
use Backend\AdminController;
use Services\Validation\ValidationException as ValidationException;
use Modules\Doptor\Slideshow\Models\Slideshow;

class SlideshowController extends AdminController
{

    public function __construct()
    {
        parent::__construct();
        View::addNamespace('slideshow',
          app_path() . "/Modules/Doptor/Slideshow/Views");
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $slides = Slideshow::all();
        $this->layout->title = 'All Slides';
        $this->layout->content = View::make('slideshow::slideshow.index')
          ->with('slides', $slides);
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        $this->layout->title = 'New slide';
        $all_statuses = Slideshow::all_status();
        $this->layout->content = View::make('slideshow::slideshow.create_edit')
          ->with('all_statuses', $all_statuses);
    }

    /**
     * Store a newly created resource in storage.
     * @return Response
     */
    public function store()
    {
        $input = Input::all();
        $input['created_by'] = Sentry::getUser()->id;
        try {
            $slide = new Slideshow($input);
            $slide->save();
            return Redirect::route("{$this->link_type}.modules.doptor.slideshow.index")
              ->with('success_message', trans('success_messages.slide_create'));
        } catch (ValidationException $e) {
            return Redirect::back()->withInput()->withErrors($e->getErrors());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function show($id)
    {
        return View::make('slideshow::slideshow.show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {
        $this->layout->title = 'Edit slide';
        $all_statuses = Slideshow::all_status();
        $this->layout->content = View::make('slideshow::slideshow.create_edit')
          ->with('slide', Slideshow::findOrFail($id))
          ->with('all_statuses', $all_statuses);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @return Response
     */
    public function update($id)
    {
        $input = Input::all();
        $input['updated_by'] = Sentry::getUser()->id;
        try {
            $slide = Slideshow::findOrFail($id);
            $slide->update($input);
            return Redirect::route("{$this->link_type}.modules.doptor.slideshow.index")
              ->with('success_message', trans('success_messages.slide_update'));
        } catch (ValidationException $e) {
            return Redirect::back()->withInput()->withErrors($e->getErrors());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        $slide = Slideshow::findOrFail($id);
        File::exists($slide->image) && File::delete($slide->image);
        if ($slide->delete()) {
            return Redirect::route("{$this->link_type}.modules.doptor.slideshow.index")
              ->with('success_message', trans('success_messages.slide_delete'));
        } else {
            return Redirect::route("{$this->link_type}.modules.doptor.slideshow.index")
              ->with('error_message', trans('error_messages.slide_delete'));
        }
    }

}

<?php namespace Backend;

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
class FormCategoriesController extends AdminController
{

    /**
     * Display a listing of the form categories.
     *
     * @return Response
     */
    public function index()
    {
        $form_cats = \FormCategory::latest()->get();
        $this->layout->title = 'All Form Categories';
        $this->layout->content = \View::make($this->link_type . '.' . $this->current_theme . '.form_categories.index')
          ->with('form_cats', $form_cats);
    }

    /**
     * Show the form for creating a new form categories.
     *
     * @return Response
     */
    public function create()
    {
        $this->layout->title = 'Create New Form Category';
        $this->layout->content = \View::make($this->link_type . '.' . $this->current_theme . '.form_categories.create_edit');
    }

    /**
     * Store a newly created form categories in storage.
     *
     * @return Response
     */
    public function store()
    {
        try {
            $input = \Input::all();
            $validator = \FormCategory::validate($input);
            if ($validator->passes()) {
                $form_cat = \FormCategory::create($input);
                if ($form_cat) {
                    return \Redirect::to('backend/form-categories')
                      ->with('success_message', trans('success_messages.form_cat_create'));
                } else {
                    return \Redirect::to('backend/form-categories')
                      ->with('error_message', trans('error_messages.form_cat_create'));
                }
            } else {
                // Form validation failed
                return \Redirect::back()
                  ->withInput()
                  ->withErrors($validator);
            }
        } catch (\Exception $e) {
            return \Redirect::to('backend/form-categories')
              ->with('error_message', trans('error_messages.form_cat_create'));
        }
    }

    /**
     * Display the specified form categories.
     *
     * @param  int $id
     * @return Response
     */
    public function show($id)
    {
        $form_cat = FormCategory::findOrFail($id);
        $this->layout->title = $form_cat->title;
        $this->layout->content = \View::make($this->link_type . '.' . $this->current_theme . '.form_categories.show')
          ->with('form_cat', $form_cat);
    }

    /**
     * Show the form for editing the specified form categories.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {
        $form_cat = \FormCategory::findOrFail($id);
        $this->layout->title = $form_cat->name;
        $this->layout->content = \View::make($this->link_type . '.' . $this->current_theme . '.form_categories.create_edit')
          ->with('form_cat', $form_cat);
    }

    /**
     * Update the specified form categories in storage.
     *
     * @param  int $id
     * @return Response
     */
    public function update($id)
    {
        try {
            $input = \Input::all();
            $validator = \FormCategory::validate($input, $id);
            unset($input['id']);
            if ($validator->passes()) {
                $form_cat = \FormCategory::findOrFail($id);
                if ($form_cat->update($input)) {
                    if (\Request::ajax()) {
                        return \Response::json(trans('success_message.form_cat_update'), 200);
                    } else {
                        return \Redirect::to('backend/form-categories')
                          ->with('success_message', trans('success_messages.form_cat_update'));
                    }
                } else {
                    if (\Request::ajax()) {
                        return \Response::json(trans('error_messages.form_cat_update'), 400);
                    } else {
                        return \Redirect::to('backend/form-categories')
                          ->with('error_message', trans('error_messages.form_cat_update'));
                    }
                }
            } else {
                // Form validation failed
                if (\Request::ajax()) {
                    $errors = '<ul>' . implode('', $validator->getMessageBag()->all('<li>:message</li>')) . '</ul>';
                    return \Response::json($errors, 400);
                } else {
                    return \Redirect::back()
                      ->withInput()
                      ->withErrors($validator);
                }
            }
        } catch (\Exception $e) {
            if (\Request::ajax()) {
                return \Response::json(trans('error_messages.form_cat_update'), 400);
            } else {
                return \Redirect::to('backend/form-categories')
                  ->with('error_message', trans('error_messages.form_cat_update'));
            }
        }
    }

    /**
     * Remove the specified form categories from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        $form_cat = \FormCategory::findOrFail($id);
        if ($form_cat->forms->count() > 0) {
            return \Redirect::to('backend/form-categories')
              ->with('error_message', trans('error_messages.form_cat_delete_assoc'));
        }
        if ($form_cat && $form_cat->delete()) {
            if (\Request::ajax()) {
                return \Response::json(trans('success_messages.form_cat_delete'), 200);
            }
            return \Redirect::to('backend/form-categories')
              ->with('success_message', trans('success_messages.form_cat_delete'));
        } else {
            if (\Request::ajax()) {
                return \Response::json('The form category wasn\'t deleted.', 400);
            }
            return \Redirect::to('backend/form-categories')
              ->with('error_message', trans('error_messages.form_cat_delete'));
        }
    }

}

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
use MenuPosition;

class MenuCategoriesController extends AdminController
{

    /**
     * Display a listing of the menu categories.
     *
     * @return Response
     */
    public function index()
    {
        $menu_cats = \MenuCategory::latest()->get();
        $this->layout->title = 'All Menu Categories';
        $this->layout->content = \View::make($this->link_type . '.' . $this->current_theme . '.menu_categories.index')
          ->with('menu_cats', $menu_cats);
    }

    /**
     * Show the menu for creating a new menu categories.
     *
     * @return Response
     */
    public function create()
    {
        $positions = MenuPosition::lists('name', 'id');
        $this->layout->title = 'Create New Menu Category';
        $this->layout->content = \View::make($this->link_type . '.' . $this->current_theme . '.menu_categories.create_edit')
          ->with('positions', $positions);
    }

    /**
     * Store a newly created menu categories in storage.
     *
     * @return Response
     */
    public function store()
    {
        try {
            $input = \Input::all();
            $validator = \MenuCategory::validate($input);
            if ($validator->passes()) {
                $menu_cat = \MenuCategory::create($input);
                if ($menu_cat) {
                    return \Redirect::to('backend/menu-categories')
                      ->with('success_message', trans('success_messages.menu_cat_create'));
                } else {
                    return \Redirect::to('backend/menu-categories')
                      ->with('error_message', trans('error_messages.menu_cat_create'));
                }
            } else {
                // Menu validation failed
                return \Redirect::back()
                  ->withInput()
                  ->withErrors($validator);
            }
        } catch (\Exception $e) {
            return \Redirect::to('backend/menu-categories')
              ->with('error_message', trans('error_messages.menu_cat_create'));
        }
    }

    /**
     * Display the specified menu categories.
     *
     * @param  int $id
     * @return Response
     */
    public function show($id)
    {
        $menu_cat = MenuCategory::findOrFail($id);
        $this->layout->title = $menu_cat->title;
        $this->layout->content = \View::make($this->link_type . '.' . $this->current_theme . '.menu_categories.show')
          ->with('menu_cat', $menu_cat);
    }

    /**
     * Show the menu for editing the specified menu categories.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {
        $menu_cat = \MenuCategory::findOrFail($id);
        $positions = MenuPosition::lists('name', 'id');
        $this->layout->title = $menu_cat->name;
        $this->layout->content = \View::make($this->link_type . '.' . $this->current_theme . '.menu_categories.create_edit')
          ->with('menu_cat', $menu_cat)
          ->with('positions', $positions);
    }

    /**
     * Update the specified menu categories in storage.
     *
     * @param  int $id
     * @return Response
     */
    public function update($id)
    {
        try {
            $input = \Input::all();
            $validator = \MenuCategory::validate($input, $id);
            unset($input['id']);
            if ($validator->passes()) {
                $menu_cat = \MenuCategory::findOrFail($id);
                if ($menu_cat->update($input)) {
                    if (\Request::ajax()) {
                        return \Response::json(trans('success_messages.menu_cat_create'), 200);
                    } else {
                        return \Redirect::to('backend/menu-categories')
                          ->with('success_message', trans('success_messages.menu_cat_update'));
                    }
                } else {
                    if (\Request::ajax()) {
                        return \Response::json(trans('error_messages.menu_cat_update'), 400);
                    } else {
                        return \Redirect::to('backend/menu-categories')
                          ->with('error_message', trans('error_messages.menu_cat_update'));
                    }
                }
            } else {
                // Menu validation failed
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
                return \Response::json(trans('error_messages.menu_cat_update'), 400);
            } else {
                return \Redirect::to('backend/menu-categories')
                  ->with('error_message', trans('error_messages.menu_cat_update'));
            }
        }
    }

    /**
     * Remove the specified menu categories from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        $menu_cat = \MenuCategory::findOrFail($id);
        if ($menu_cat->menus->count() > 0) {
            return \Redirect::to('backend/menu-categories')
              ->with('error_message', trans('error_messages.menu_cat_delete_assoc'));
        }
        if ($menu_cat && $menu_cat->delete()) {
            if (\Request::ajax()) {
                return \Response::json(trans('success_messages.menu_cat_delete'), 200);
            }
            return \Redirect::to('backend/menu-categories')
              ->with('success_message', trans('success_messages.menu_cat_delete'));
        } else {
            if (\Request::ajax()) {
                return \Response::json(trans('error_messages.menu_cat_delete'), 400);
            }
            return \Redirect::to('backend/menu-categories')
              ->with('error_message', trans('error_messages.menu_cat_delete'));
        }
    }

}

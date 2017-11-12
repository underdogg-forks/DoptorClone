<?php namespace Components\ContactManager\Presenters;

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
use Str;
use Sentry;
use Robbo\Presenter\Presenter;

class ContactPresenter extends Presenter
{
    /**
     * Get the page's excerpt
     * @return string
     */
    public function excerpt($length = 80)
    {
        if (strpos($this->content, '<!--more-->')) {
            list($excerpt, $more) = explode('<!--more-->', $this->content);
            return Services\String::tidy($excerpt);
        } else {
            return Services\String::tidy(Str::limit($this->content, $length));
        }
    }

    /**
     * Get all the categories that a post lies in
     * @return string
     */
    public function selected_categories($field = 'id')
    {
        $ret = array();
        foreach ($this->categories as $category) {
            $ret[] = $category->{$field};
        }
        return $ret;
    }

    /**
     * Get the page's status
     * @return string
     */
    public function status()
    {
        return Str::title($this->status);
    }

    public function image()
    {
        return $this->image;
    }

    /**
     * Get the page's author
     * @return string
     */
    public function author()
    {
        try {
            $user = Sentry::findUserById($this->created_by);
            return $user->username;
        } catch (Cartalyst\Sentry\Users\UserNotFoundException $e) {
            return '';
        }
    }

    /**
     * Get the page's editor
     * @return string
     */
    public function editor()
    {
        if ($this->updated_by == null) {
            return '';
        }
        try {
            $user = Sentry::findUserById($this->updated_by);
            return $user->username;
        } catch (Cartalyst\Sentry\Users\UserNotFoundException $e) {
            return '';
        }
    }
}

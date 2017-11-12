<?php
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
use Robbo\Presenter\PresentableInterface;

class Theme extends Eloquent implements PresentableInterface
{
    public static $rules = array();
    protected $table = 'themes';
    protected $guarded = array('id');

    // Path in the public folder to upload image and its corresponding thumbnail
    protected $images_path = 'uploads/media/';
    protected $thumbs_path = 'uploads/media/thumbs/';

    /**
     * When creating a theme, run the attributes through a validator first.
     * @param array $attributes
     * @return void
     */
    public static function create(array $attributes = array())
    {
        // App::make('Components\\ThemeManager\\Validation\\ThemeValidator')->validateForCreation($attributes);
        $attributes['created_by'] = current_user()->id;
        return parent::create($attributes);
    }

    /**
     * Get all the targets available for a theme
     * @return array
     */
    public static function all_targets()
    {
        return array(
          'public' => 'Public',
          'admin' => 'Admin',
          'backend' => 'Backend'
        );
    }

    public static function themeLists($target = null)
    {
        if ($target) {
            $items = static::where('target', '=', $target)->get();
            return array_pluck($items, 'name', 'id');
        }
    }

    /**
     * When updating a theme, run the attributes through a validator first.
     * @param array $attributes
     * @return void
     */
    public function update(array $attributes = array(), array $options = array())
    {
        // App::make('Components\\ThemeManager\\Validation\\ThemeValidator')->validateForUpdate($attributes);
        $attributes['updated_by'] = current_user()->id;
        return parent::update($attributes);
    }

    /**
     * Relation with the categories table
     * A post can have many categories
     */
    public function settings()
    {
        return $this->hasMany('ThemeSetting');
    }

    /**
     * Initiate the presenter class
     */
    public function getPresenter()
    {
        return new ThemePresenter($this);
    }
}

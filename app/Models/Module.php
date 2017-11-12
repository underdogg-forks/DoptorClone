<?php
use Illuminate\Database\Eloquent\Model;
use Robbo\Presenter\PresentableInterface;

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

class Module extends Model implements PresentableInterface
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'modules';

    protected $guarded = array('id');

    public static $rules = array(
      'name' => 'alpha_spaces|required|unique:modules,name',
      'version' => 'required',
      'author' => 'required'
    );

    /**
     * Validation during create/update of modules
     * @param  array $input Input received from the form
     * @return Validator
     */
    public static function validate($input, $id = false)
    {
        if ($id) {
            static::$rules['name'] .= ',' . $id;
        }
        return Validator::make($input, static::$rules);
    }

    /**
     * Initiate the presenter class
     */
    public function getPresenter()
    {
        return new ModulePresenter($this);
    }
}

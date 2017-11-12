<?php namespace Components\ReportGenerator\Models;

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
use Eloquent;
use Str;

class ReportGenerator extends Eloquent
{

    protected $table = 'report_generators';

    protected $guarded = array('id');
}

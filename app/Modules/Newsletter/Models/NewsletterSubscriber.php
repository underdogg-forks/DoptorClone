<?php namespace Modules\Newsletter\Models;

use Eloquent;

class NewsletterSubscriber extends Eloquent
{
    protected $table = 'mdl_newsletter_subscribers';

    protected $guarded = array('id');

    protected $fillable = array('name', 'email');

    public function alias($name, $field_name = 'alias')
    {
        $alias = Str::slug($name);
        $aliases = $this->whereRaw("{$field_name} REGEXP '^{$alias}(-[0-9]*)?$'");
        if ($aliases->count() === 0) {
            return $alias;
        } else {
            // get reverse order and get first
            $lastAliasNumber = intval(str_replace($alias . '-', '',
              $aliases->orderBy($field_name, 'desc')->first()->{$field_name}));
            return $alias . '-' . ($lastAliasNumber + 1);
        }
    }
}

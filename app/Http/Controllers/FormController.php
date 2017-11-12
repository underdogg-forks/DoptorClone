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
use Services\Validation\ValidationException as ValidationException;

class FormController extends BaseController
{

    public function __construct()
    {
        parent::__construct();
        // Add location hinting for views
        View::addNamespace('forms',
          base_path() . "/resources/views/{$this->link_type}/{$this->current_theme}/forms");
    }

    public function index($id = null)
    {
        if ($id) {
            $form_entries = FormEntry::where('form_id', $id)->get();
        } else {
            $form_entries = FormEntry::all();
        }
        $this->layout->title = 'Form Entries';
        $this->layout->content = View::make('forms::index')
          ->with('form_id', $id)
          ->with('form_entries', $form_entries);
    }

    public function show($id)
    {
        $form = BuiltForm::find($id);
        $form->rendered = $this->formatForm($form);
        $this->layout->title = 'Form';
        $this->layout->content = View::make('forms::create_edit')
          ->with('form', $form);
    }

    private function formatForm($form)
    {
        $form->rendered = str_replace("/\n/", '', $form->rendered);
        $form->rendered = str_replace("//", '', $form->rendered);
        $form_data = str_replace('<form class="form-horizontal">', '', urldecode($form->rendered));
        $view = str_replace('</form>', '', $form_data);
        $view .= $form->extra_code . "\n";
        return $view;
    }

    public function store()
    {
        $input = Input::all();
        try {
            FormEntry::create($input);
            $this->sendEmail($input);
        } catch (ValidationException $e) {
            return Redirect::back()->withInput()->withErrors($e->getErrors());
        } catch (Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return Redirect::back()
              ->withInput()
              ->with('error_message', trans('error_messages.form_found'));
        } catch (Exception $e) {
            return Redirect::back()
              ->withInput()
              ->with('error_message', $e->getMessage());
        }
        return Redirect::back()
          ->with('success_message', trans('success_messages.form_submit'));
    }

    private function sendEmail($input)
    {
        $form = BuiltForm::findOrFail($input['form_id']);
        if ($form->email == '') {
            return;
        }
        $input = $this->formatInputForEmail($input, $form->data);
        $exported_var = var_export($input, true);
        $exported_var = str_replace("array (", "", $exported_var);
        $exported_var = str_replace("',", "'<br>", $exported_var);
        $exported_var = str_replace(")", "", $exported_var);
        $input['exported_var'] = $exported_var;
        Mail::send('public.' . $this->current_theme . '.email_form', $input,
          function ($email_message) use ($input, $form) {
              $email_message->from($form->email);
              $email_message->to($form->email)
                ->subject('Email from Form');
          });
    }

    private function formatInputForEmail($input, $form_data)
    {
        $module_builder = new Services\ModuleBuilder;
        $form_fields = $module_builder->getFormFields($form_data);
        $fields = array_combine($form_fields['fields'], $form_fields['field_names']);
        foreach ($fields as $key => $value) {
            // dd($key);
            $input[$value] = $input[$key];
            unset($input[$key]);
        }
        unset($input['_token']);
        unset($input['form_id']);
        if (isset($input['captcha'])) {
            // Do not save the value of captcha to database
            unset($input['captcha']);
        }
        return $input;
    }

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
            $post = FormEntry::findOrFail($id);
            $post->delete();
        }
        $translation = (count($selected_ids) > 1) ? 'form_entries_delete' : 'form_entry_delete';
        $message = trans('success_messages.' . $translation);
        return Redirect::back()
          ->with('success_message', $message);
    }
}

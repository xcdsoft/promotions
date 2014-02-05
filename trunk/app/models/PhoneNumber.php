<?php

class PhoneNumber extends Eloquent
{
    protected $table = "phoneNumbers";
    protected $hidden = array('id');


    public function imports()
    {
        return $this->belongsToMany('Import', 'imports_phoneNumbers');
    }

}
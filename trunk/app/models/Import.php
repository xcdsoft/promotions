<?php

class Import extends Eloquent
{

    protected $table = "imports";

    public function phoneNumbers()
    {
        return $this->belongsToMany('PhoneNumber', 'imports_phoneNumbers');
    }

    public function contacts()
    {
        $this->hasMany('Contacts', 'importId');
    }
}
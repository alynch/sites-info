<?php

namespace Tests;


trait ValidatesFields
{
    /**
     *  Validate request fields
     */
    public function validate($model, $url, $field)
    {
        $this->actingAs(factory('App\User')->create());

        $data = factory($model)->raw([$field => '']);
        
        $this->post($url, $data)->assertSessionHasErrors($field);
    }
}

<?php

class job extends Eloquent {

	protected $fillable = array('title', 'orgname', 'email', 'description', 'salary', 'slug', 'enabled');

}
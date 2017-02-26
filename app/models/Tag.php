<?php

class Tag extends \Eloquent {

	use SoftDeletingTrait;
	protected $fillable = ['name'];
	public function articles()
	{
		return $this->belongsToMany('Article');
	}
}
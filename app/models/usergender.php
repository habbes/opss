<?php

final class UserGender extends Enum
{
	const MALE = 1;
	const FEMALE = 2;
	
	protected $values = [
			self::MALE => "Male",
			self::FEMALE => "Female"
	];
}
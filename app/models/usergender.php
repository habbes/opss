<?php

final class UserGender extends Enum
{
	const MALE = 1;
	const FEMALE = 2;
	
	protected static $values = [
			self::MALE => "Male",
			self::FEMALE => "Female"
	];
}
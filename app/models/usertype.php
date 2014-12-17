<?php

final class UserType extends Enum
{
	const ADMIN = 1;
	const RESEARCHER = 2;
	const REVIEWER = 3;
	
	protected $values = [
			self::ADMIN => "Admin",
			self::RESEARCHER => "Researcher",
			self::REVIEWER => "Reviewer"
	];
}
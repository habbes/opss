<?php

/**
 * class that associates a research area of specilization, either collaborative or thematic,
 * for users (researchers)
 * @author Habbes
 *
 */
class UserResearchArea extends DBModel
{
	protected $user_id;
	protected $paper_group;
	protected $type;
	
	private $_user;
	
	const THEMATIC = 1;
	const COLLABORATIVE = 2;
	
	/**
	 * 
	 * @param User $user
	 * @param int $group PaperGroup
	 * @param type $type THEMATIC or COLLABORATIVE
	 * @return UserResearchArea
	 */
	public static function create($user, $group, $type)
	{
		$r = new static();
		$r->user_id = $user->getId();
		$r->_user = $user;
		$r->paper_group = $group;
		$r->type = $type;
		return $r->save();
	}
	
	/**
	 * 
	 * @param User $user
	 * @param int $group PaperGroup
	 * @return UserResearchArea
	 */
	public static function createThematic($user, $group)
	{
		return static::create($user, $group, self::THEMATIC);
	}
	
	/**
	 * 
	 * @param User $user
	 * @param int $group PaperGroup
	 * @return UserResearchArea
	 */
	public static function createCollaborative($user, $group)
	{
		return static::create($user, $group, self::COLLABORATIVE);
	}
	
	/**
	 * 
	 * @return number PaperGroup
	 */
	public function getGroup()
	{
		return (int) $this->paper_group;
	}
	
	protected function validate(&$errors)
	{
		if(!PaperGroup::isValue((int)$this->paper_group))
			$errors[] = ValidationError::PAPER_GROUP_INVALID;
		
		return true;
	}
	
	/**
	 * 
	 * @param User $user
	 * @return array(UserResearchArea)
	 */
	public static function findThematicByUser($user)
	{
		return static::findAll("user_id=? AND type=?",[$user->getId(), (int) self::THEMATIC]);
	}
	
	/**
	 * 
	 * @param User $user
	 * @return array(UserResearchArea)
	 */
	public static function findCollaborativeByUser($user)
	{
		return static::findAll("user_id=? AND type=?", [$user->getId(), (int) self::COLLABORATIVE]);
	}
}
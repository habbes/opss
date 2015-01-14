<?php

/**
 * the level of a paper indicitating at which phase/stage of its lifecycle it is
 * @author Habbes
 *
 */
class PaperLevel extends Enum
{
	const PROPOSAL = 1;
	const WIP = 2;
	const FINAL_REPORT = 3;
	
	protected static $values = [
			self::PROPOSAL => "Proposal",
			self::WIP => "Work In Progress",
			self::FINAL_REPORT => "Final Report"
	];
}
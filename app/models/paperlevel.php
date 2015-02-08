<?php

/**
 * the level of a paper indicitating at which phase/stage of its lifecycle it is
 * @author Habbes
 *
 */
class PaperLevel extends Enum
{
	const PROPOSAL = "proposal";
	const R_PROPOSAL = "revisedProposal";
	const WIP = "wip";
	const R_WIP = "revisedWip";
	const FINAL_REPORT = "finalReport";
	const R_FINAL_REPORT = "revisedFinalReport";
	
	protected static $values = [
			self::PROPOSAL => "Proposal",
			self::R_PROPOSAL => "Revised Proposal",			
			self::WIP => "Work In Progress",
			self::R_WIP => "Revised Work In Progress",
			self::FINAL_REPORT => "Final Report",
			self::R_FINAL_REPORT => "Revised Final Report"
	];
}
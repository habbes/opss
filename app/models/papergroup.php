<?php

/**
 * the research area of a paper
 * @author Habbes
 *
 */
final class PaperGroup extends Enum
{
	const OTHER = 1;
	const A = 2;
	const B = 3;
	const C = 4;
	const D = 5;
	const E = 6;
	
	protected static $values = [
			self::A => "A: Poverty, Labor Markets, and Income Distribution",
			self::B => "B: Macroeconomic Policy and Growth",
			self::C => "C: Finance and Resource Mobilization",
			self::D => "D: Production, Trade, and Economic Integration",
			self::E => "E: Agriculture, Climate Change, and Natural Resource Management",
			self::OTHER => "None Applicable"
		];
}
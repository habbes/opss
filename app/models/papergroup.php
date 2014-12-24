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
			self::A => "A: Poverty, Income Distribution and Food Security",
			self::B => "B: Macroeconomic Policies, Investments and Growth",
			self::C => "C: Finance and Resource Mobilization",
			self::D => "D: Trade and Regional Integration",
			self::E => "E: Political Economy, Natural Resource Management and Agricultural Policy Issues",
			self::OTHER => "None Applicable"
		];
}
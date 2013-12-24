<?php
class StatMod {

	public static function getLevelModifier($level) {
		return self::getModifier($level, 2, 0);
	}
	
	public static function getModifier($attribute, $split = 2, $shift = 5) {
		if (empty($split)) {
			$split = 1;
		}
		if (empty($shift)) {
			$shift = 0;
		}
		return floor($attribute / $split) - $shift;
	}
	
	public static function rollDice($count, $sides = null) {
		if (empty($sides)) {
			$sides = $count;
			$count = 1;
		}
		$val = 0;
		for ($i = 0; $i < $count; $i++) {
			$val += rand(1, $sides);
		}
		return $val;
	}
}
package com.Plex.util {
	public class Number_Util {
		public static function getNumbers(text:String):String {
			var regex:RegExp = new RegExp("\\d+", "g");
			var numbers:String = text.match(regex).join('');
			
			return numbers;
		}
		
	}
}
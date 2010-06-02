package com.Plex.util {
	import com.Plex.controls.Prompt;
	
	import mx.validators.Validator;

	public class Validator extends mx.validators.Validator {
		
		public static function valid(validatorArray:Array, prompt:Boolean=false):Boolean {
			var validatorErrorArray:Array = validateAll(validatorArray);;
            var isValidForm:Boolean = validatorErrorArray.length == 0;
            
            if (!isValidForm) {
            	if(prompt) {
            		Prompt.error("All Fields Are Required");            	
            	}
				return false;
            } else {
            	return true;
            }
		}
		
	}
}
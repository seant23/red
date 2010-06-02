package com.Plex.util {
	import flash.events.Event;
	
	import mx.controls.TextInput;
	import mx.formatters.PhoneFormatter;
	
	public class String_Helper {
		
		public static var phoneFormatter:PhoneFormatter;
		
		public static function getNumbers(text:String):String {
			var regex:RegExp = new RegExp("\\d+", "g");
			var numbers:String = text.match(regex).join('');
			
			return numbers;
		}
		
		public function formatAndValidatePhoneInput(event:Event):void {
			var input:TextInput = event.currentTarget as TextInput;
			var formatted:String = formatPhoneNumber(input.text);
			
			if(formatted) {
				input.text = formatted;
			}		
		}
		
		public static function formatPhoneNumber(input:String):String {
			if(!phoneFormatter) {
				phoneFormatter = new PhoneFormatter();
				phoneFormatter.formatString = "(###) ###-####";
			}
			
			return phoneFormatter.format(getNumbers(input));
		}
				
		public static function calculateHtmlPosition(htmlstr:String, pos:int):int {
		    if (pos <= -1) {
		        return -1;
		    }
		 
		    var openTags:Array = ["<","&"];
		    var closeTags:Array = [">",";"];
		    
		    var tagReplaceLength:Array = [0,1];
		    
		    var isInsideTag:Boolean = false;
		    var cnt:int = 0;
		    
		    var tagId:int = -1;
		    var tagContent:String = "";
		 
		    for (var i:int = 0; i < htmlstr.length; i++) {
		        if (cnt>=pos) 
		            break;
		            
		        var currentChar:String = htmlstr.charAt(i);
		        
		        for (var j:int = 0; j < openTags.length; j++) {
		            if (currentChar == openTags[j]) {
		                isInsideTag = true;
		                tagId = j;
		            }
		        }
		        
		        if (!isInsideTag) {
		            cnt++;
		        } else {
		            tagContent += currentChar;
		        }
		        
		        if (currentChar == closeTags[tagId]) {
		            if (tagId > -1) cnt += tagReplaceLength[tagId];
		            if (tagContent == "</P>") cnt++;
		            isInsideTag = false;
		            tagContent = "";
		        }
		    }
		    
		    return i;
		}
		
	}
}
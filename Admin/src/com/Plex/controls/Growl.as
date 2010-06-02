package com.Plex.controls {
	import com.Plex.controls.Growl_Assets.Message;
	
	import flash.display.DisplayObject;
	
	import mx.containers.VBox;
	import mx.core.Application;
	import mx.effects.Fade;
	import mx.events.EffectEvent;
	
	public class Growl {
		public static var Growl_Box:VBox=null;
		
		public static function message(title:String, body:String=null):void {
			Growl.init();
			var msg:Message = new Message();
			msg.message = {
				'title':title,
				'body':body
			};
			
			Growl.open(msg);
		}
		
		public static function init():Boolean {
			if(Growl_Box) {
				return true;
			} else {
				Growl_Box = new VBox();
				Growl_Box.setStyle("right", 15);
				Growl_Box.setStyle("bottom", 10);
				Growl_Box.width = 300;
				
				Application.application.addChild(Growl_Box);
				return true;
			}
		}
		
		public static function open(target:DisplayObject):void {
			Growl_Box.addChild(target);
			
		    var fadeIN:Fade = new Fade();
		    fadeIN.alphaFrom = 0;
		    fadeIN.alphaTo = 1
		    fadeIN.duration = 1000;
		    fadeIN.target = target;
		    fadeIN.play();
		    
		    var fadeOUT:Fade = new Fade();
		    fadeOUT.alphaTo = 0;
		    fadeOUT.duration = 1000;
		    fadeOUT.target = target;
		    fadeOUT.startDelay = 5000;
		    fadeOUT.addEventListener(EffectEvent.EFFECT_END, function():void {
		    	Growl_Box.removeChild(target);
		    });
		    
		    fadeOUT.play();
		    
		    
		}
	}
}

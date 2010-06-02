// ActionScript file
package com.Plex.effects {
	import flash.display.DisplayObject;
	
	import mx.collections.ArrayCollection;
	import mx.containers.TitleWindow;
	import mx.core.Application;
	import mx.core.IFlexDisplayObject;
	import mx.effects.Fade;
	import mx.effects.Move;
	import mx.effects.Parallel;
	import mx.effects.easing.Exponential;
	import mx.events.EffectEvent;
	import mx.managers.PopUpManager;
		
	public class Slick {
		
		public static var openPopups:ArrayCollection = new ArrayCollection();
		public static var disabled:Boolean = false;
		
		public static function newPopup():void {
						
		}
		
		public static function add(window:*, modal:Boolean=true):IFlexDisplayObject {
			if(disabled) {
				return null;
			}
			
			newPopup();
			PopUpManager.addPopUp(window, Application.application as DisplayObject, modal);
						
			window.x = (Application.application.width  - window.width) / 2;
            window.y = -500;
            
            var move:Move = new Move();
		    move.easingFunction = Exponential.easeOut;
		    move.duration = 300;
		    move.yTo = (Application.application.height - window.height) /2;
		
		    var fade:Fade = new Fade();
		    fade.easingFunction = Exponential.easeIn;
		    fade.alphaFrom = .5;
		    fade.alphaTo = 1;
		    fade.duration = 300;
		
		    var msgEffect:Parallel = new Parallel();
		    msgEffect.target = window;
		    msgEffect.addChild(move);
		    msgEffect.addChild(fade);
		    msgEffect.play();
		    		    
			openPopups.addItem(window);
		    return window;
		}
		
		public static function open(Window:Class, modal:Boolean=true):DisplayObject {
			if(disabled) {
				return null;
			}
			
			newPopup();
			var window:DisplayObject = Window(PopUpManager.createPopUp(Application.application as DisplayObject,Window,modal));
			
			window.x = (Application.application.width  - window.width) / 2;
            window.y = -500;
					
		    var move:Move = new Move();
		    move.easingFunction = Exponential.easeOut;
		    move.duration = 300;
		    move.yTo = (Application.application.height - window.height) /2;
		
		    var fade:Fade = new Fade();
		    fade.easingFunction = Exponential.easeIn;
		    fade.alphaFrom = .5;
		    fade.alphaTo = 1;
		    fade.duration = 300;
		
		    var msgEffect:Parallel = new Parallel();
		    msgEffect.target = window;
		    msgEffect.addChild(move);
		    msgEffect.addChild(fade);
		    msgEffect.play();
		    		    
			openPopups.addItem(window);
		    return window;
		}
		
		public static function center(window:TitleWindow, duration:uint=300):void {
			var move:Move = new Move();
		    move.easingFunction = Exponential.easeOut;
		    move.duration = duration;
		    move.target = window;
		    move.xTo = (Application.application.width - window.width) /2;
		    move.yTo = (Application.application.height - window.height) /2;
		    move.play();
		}
		
		public static function close(window:*):void{	
			if(disabled) {
				return;
			}
			
		    var move:Move = new Move();
		    move.easingFunction = Exponential.easeIn;
		    move.duration = 300;
		    move.yTo = -500;
		
		    var fade:Fade = new Fade();
		    fade.easingFunction = Exponential.easeIn;
		    fade.alphaFrom = 0.5;
		    fade.alphaTo = 0;
		    fade.duration = 300;
		
		    var msgEffect:Parallel = new Parallel();
		    msgEffect.target = window;
		    msgEffect.addChild(move);
		    msgEffect.addChild(fade);
		    msgEffect.addEventListener(EffectEvent.EFFECT_END, function():void{	
		    	if(openPopups.getItemIndex(window)!=-1) {
		    		openPopups.removeItemAt(openPopups.getItemIndex(window));
		    		PopUpManager.removePopUp(window);
		    	}
		    	
		    	
		    });
		    msgEffect.play();
		}
				
		public static function closeAll():void{
			if(disabled) {
				return;
			}
			
			for(var i:uint = 0; i<openPopups.length; i++) {
				Slick.close(openPopups[i]);
			}
        }
		
		public static function doNothing():void {
			
		}
	}
}

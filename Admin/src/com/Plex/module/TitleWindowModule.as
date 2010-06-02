package com.Plex.module {
	
	import com.Plex.effects.Slick;
	
	import flash.events.Event;
	
	import mx.containers.TitleWindow;
	[Frame(factoryClass="mx.core.FlexModuleFactory")]

	public class TitleWindowModule extends TitleWindow {	
		public function TitleWindowModule() {
        	super();
    	}
    	
    	public function slickClose(event:Event=null):void {
			Slick.close(this);
		}
	}
}
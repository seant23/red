package com.Plex.events {
	import flash.events.Event;
	
	public class CollapseEvent extends Event {
		public static const OPEN:String = 'collapseOpen';
		public static const CLOSE:String = 'collapseClose';
		
		public function CollapseEvent(type:String):void {
			super(type);
		}
	} 	
}
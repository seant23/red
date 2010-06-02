package com.Plex.events {
	import flash.events.Event;
	
	public class AdvancedTitleWindowEvent extends Event {
		public static const COLLAPSE:String = 'collapse';
		public static const EXPAND:String = 'expand';
		public static const MAXIMIZE:String = 'maximize';
		public static const MINIMIZE:String = 'minimize';
		public static const RESIZE:String = 'resize';
		public static const OPEN:String = 'open';
		public static const CLOSE:String = 'close';
		
		public function CollapseEvent(type:String):void {
			super(type);
		}
	} 	
}
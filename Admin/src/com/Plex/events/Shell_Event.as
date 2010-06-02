package com.Plex.events {
	import flash.events.Event;
	
	public class Shell_Event extends Event {
		public static const Closing_Module:String = 'shellClosingModule';
		public static const LOGOUT:String = 'shellLogout';
		public static const LOGIN:String = 'shellLogin';
		
		public var canceled:Boolean = false;
		
		public function Shell_Event(type:String):void {
			super(type);
		}
	} 	
}
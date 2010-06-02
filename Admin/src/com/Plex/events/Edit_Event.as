package com.Plex.events {
	import flash.events.Event;

	public class Edit_Event extends Event {
		public static const STARTED:String = 'editStart';
		public static const COMPLETE:String = 'editComplete';
		
		public function Edit_Event(type:String, bubbles:Boolean=false, cancelable:Boolean=false) {
			super(type, bubbles, cancelable);
		}
	}
}
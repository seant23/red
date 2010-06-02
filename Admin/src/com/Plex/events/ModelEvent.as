package com.Plex.events {
	import flash.events.Event;
	
	public class ModelEvent extends Event {
		public static const CREATE_COMPLETE:String = 'modelCreateComplete';
		public static const UPDATE_COMPLETE:String = 'modelUpdateComplete';
		public static const DELETE_COMPLETE:String = 'modelDeleteComplete';
		
		public function ModelEvent(type:String, bubbles:Boolean=false):void {
			super(type, bubbles);
		}
	} 	
}
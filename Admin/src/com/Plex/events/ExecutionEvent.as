package com.Plex.events {
	import flash.events.Event;
	
	public class ExecutionEvent extends Event {
		public static const COMPLETE:String = 'executionFinish';
		public static const START:String = 'executionStart';
		public static const ERROR:String = 'executionError';
		public static const CANCEL:String = 'executionCancel';
		public static const TASK_COMPLETE:String = 'executionTaskComplete';
		
		public function ExecutionEvent(type:String):void {
			super(type);
		}
	} 	
}
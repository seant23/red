package com.Plex.controls {
	import mx.controls.Alert;
	
	public class Prompt extends Alert
	{
		public static const YES:uint = Alert.YES;
		public static const NO:uint = Alert.NO;
		public static const OK:uint = Alert.OK;
		
		
		[Embed(source="Prompt_Assets\\alert_error.gif")]
		private static var iconError:Class;
		
		[Embed(source="Prompt_Assets\\alert_info.gif")]
		private static var iconInfo:Class;
		
		[Embed(source="Prompt_Assets\\alert_confirm.gif")]
		private static var iconConfirm:Class;

		public static function info(message:String, closehandler:Function=null):void{
			show(message, "Information", Alert.OK, null, closehandler, iconInfo);
		}
		
		public static function error(message:String, closehandler:Function=null):void{
			show(message, "Error", Alert.OK, null, closehandler, iconError);
		}
		
		public static function confirm(message:String, closehandler:Function=null):void{
			show(message, "Confirmation", Alert.YES | Alert.NO, null, closehandler, iconConfirm);
		}
	}
}
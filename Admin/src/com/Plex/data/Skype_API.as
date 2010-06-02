package com.Plex.data
{
	import com.Plex.rpc.http.Jax;
	import com.Plex.util.Number_Util;
	
	import flash.external.ExternalInterface;
	import flash.utils.setTimeout;
	
	public class Skype_API
	{
		[Bindable]
		public var username:String;

		[Bindable]
		public var status:String;
		
		[Bindable]
		public var code:uint = 1;
		
		[Bindable]
		public var online:Boolean;
		public var autoUpdate:Boolean = false;
				
		public function Skype_API(username:String=null, autoUpdate:Boolean=false) {
			this.autoUpdate = autoUpdate;

			if(username) {
				this.username = username;
				loadStatus();
			}			
		}
		
		private var handler:Function;
		
		public function loadStatus(handler:Function=null):void {
			if(username) {
				Jax.call("Skype.Status", {username:username}, loadStatusHandler);
				this.handler = handler; 
			}
			
			if(autoUpdate) {
				setTimeout(loadStatus, 15000);
			}
		}
		
		private function loadStatusHandler(data:Object):void {
			code = parseInt(data.response.code);
			status = data.response.status;
			online = this.code > 1;
			
			if(this.handler!=null) {
				this.handler();
			}
		}
		
		public static function call(username:String):void {
			ExternalInterface.call("skype", "skype:" + username + "?call");
		}
		
		public static function chat(username:String):void {
			ExternalInterface.call("skype", "skype:" + username + "?chat");
		}

		public static function callNumber(phoneNumber:String):void {
			phoneNumber = Number_Util.getNumbers(phoneNumber);
			ExternalInterface.call("skype", "skype:+1" + phoneNumber + "?call");
		}

	}
}
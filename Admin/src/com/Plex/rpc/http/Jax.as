package com.Plex.rpc.http {
	import com.Plex.controls.Prompt;
	
	import mx.controls.Alert;
	import mx.managers.CursorManager;
	import mx.rpc.AsyncToken;
	import mx.rpc.events.FaultEvent;
	import mx.rpc.events.ResultEvent;
	import mx.rpc.http.HTTPService;
	
	public class Jax extends HTTPService {
		
		[Bindable] public static var Base_URL:String;
		
		public var useServiceMode:Boolean = true;
		public var successHandler:Function = function():void{};
		public var webService:String;
		public var lastParams:Object;
		
		public function Jax(webService:String=null, successHandler:Function=null, useServiceMode:Boolean=true):void {
			this.useServiceMode = useServiceMode;
			this.successHandler = successHandler;	
			this.webService = webService;
			super();			
		}
		
		public function setupHandlers():void {
			
			var resultHandler:Function = function(event:ResultEvent):void {
				if(successHandler!=null) {
					successHandler(event.result);
				}
				
		        //For GC References
		        this.removeEventListener(ResultEvent.RESULT, resultHandler);
			}
			
			var faultHandler:Function = function(event:FaultEvent):void {
	        	var faultstring:String = event.fault.faultString;
		        Prompt.error("Unable To Communicate With Server: " + faultstring);
		        
		        //For GC References
		        this.removeEventListener(FaultEvent.FAULT, faultHandler);
	        }
			
			this.addEventListener(ResultEvent.RESULT, resultHandler);
			this.addEventListener(FaultEvent.FAULT, faultHandler);
		}
		
		public function refresh():void {
			this.send(lastParams);
		}
		
		public override function send(params:Object=null):AsyncToken {
			
			if(!params) {
				params = {};
			}
			
			if(Shell.version) {
				params['shellVersion'] = Shell.version;
			}
			
			if(useServiceMode) {
				url = Base_URL + "Plex/Web_Service/Exec/XML/" + webService;
			}
			
			lastParams = params;
			
			return super.send(params);
		}
		
		public static function call(webService:String, params:Object=null, handler:Function=null, type:String='object', callBack:Object=null):void {
			CursorManager.setBusyCursor();
			var service:HTTPService = new HTTPService();
	        service.url = Base_URL + "Plex/Web_Service/Exec/XML/" + webService;
	        service.method = "POST";
	        service.resultFormat = type;
	        
	        var resultHandler:Function = function(event:ResultEvent):void{
	        	CursorManager.removeBusyCursor();
		        if(event.result.hasOwnProperty('script') && event.result.script != null) {
		        	trace("script: " + event.result.script + " Type: " + typeof event.result.script);
		        	Alert.show("Your Not Logged In");
		      	} else {
		      		if(handler!=null) {
		      			if(callBack) {
		      				handler.call(callBack, event.result);
		      			} else {
			      			handler(event.result);
		      			}
		      		}
		       	}
		       	
		       	 //For GC References
		       	service.removeEventListener(ResultEvent.RESULT, resultHandler);
		       	service = null;
	        }
	        
	        var faultHandler:Function = function(event:FaultEvent):void {
	        	var faultstring:String = event.fault.faultString;
		        Prompt.error("Unable To Communicate With Server (" + service.url + "): " + faultstring);
		        
		        //For GC References
		        service.removeEventListener(FaultEvent.FAULT, faultHandler);
		        service = null;
	        }
	        
	        service.addEventListener(ResultEvent.RESULT, resultHandler);
	        service.addEventListener(FaultEvent.FAULT, faultHandler);
	                
	        service.send(params);
		}
	}
}
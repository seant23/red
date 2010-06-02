package com.Plex.module{
	
	
	import flash.display.DisplayObject;
	import flash.events.EventDispatcher;
	import flash.system.ApplicationDomain;
	
	import mx.events.ModuleEvent;
	import mx.modules.IModuleInfo;
	
	[Event(name="ready", type="com.Plex.module.ModuleManager")]
	
	public class ModuleInstance extends EventDispatcher {
		
	
		public var moduleInfo:IModuleInfo;
		public var module:DisplayObject;
		
		public var data:Object;
		
		public var isLoaded:Boolean = false;
		
		public function loaded():void { 
			var newInstance:* = moduleInfo.factory.create(); 
			module = DisplayObject(newInstance);
			dispatchEvent(new ModuleEvent(ModuleEvent.READY));
			isLoaded = true;
		}
		
		public function load():void {
			moduleInfo.load(ApplicationDomain.currentDomain);
		}
	}
}
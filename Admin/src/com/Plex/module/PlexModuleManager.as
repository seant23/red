package com.Plex.module {
	import com.completv.modules.AdminModule;
	import com.completv.modules.IAdminShell;
	
	import flash.display.DisplayObject;
	import flash.events.ProgressEvent;
	
	import mx.containers.TitleWindow;
	import mx.core.IFlexDisplayObject;
	import mx.events.CloseEvent;
	import mx.events.ModuleEvent;
	import mx.managers.PopUpManager;
	import mx.modules.IModuleInfo;
	import mx.modules.ModuleManager;
	
	public class PlexModuleManager extends ModuleManager {
		
		public var loadedModules:Array = new Array();
		public var Shell:IAdminShell;
		
		public function AdminModuleManager(Shell_P:IAdminShell) {
			Shell = Shell_P;
		}
		
		public function moduleLoaded(module:String):Boolean {
			return loadedModules.hasOwnProperty(module);
		}
		
		public function create(title:String, moduleName:String, parameters:Object=null, popup:Boolean=false, modal:Boolean=false):void {
			
			if(moduleLoaded(moduleName)) {
				var moduleInfo:IModuleInfo = loadedModules[moduleName] as IModuleInfo;
				
				var moduleInstanceInterface:AdminModule = moduleInfo.factory.create() as AdminModule;
				moduleInstanceInterface.Shell = Shell;
				
				var moduleInstance:DisplayObject = moduleInstanceInterface as DisplayObject;
				for(var key:String in parameters) {
					moduleInstance[key] = parameters[key];
				}
				
				
				
				
				if(popup) {
					openPopup(moduleInstance, modal);
				} else {
					
					Shell.breadCrumbTrail.addCrumb(title, function():void {
						var myIndex:int = Shell.mainStage.getChildIndex(moduleInstance);
						Shell.mainStage.selectedIndex = myIndex;
						
						var kids:Array = Shell.mainStage.getChildren();
						
						for(var i:int = kids.length-1; i>myIndex; i--) {
							trace("Removed One");
							Shell.mainStage.removeChildAt(i);
						}						
						
					});
					 
					Shell.mainStage.addChild(moduleInstance);
					Shell.mainStage.selectedIndex = Shell.mainStage.getChildIndex(moduleInstance);
				}
			} else {
 				loadedModules[moduleName] = ModuleManager.getModule(moduleName);
				var newModuleInfo:IModuleInfo = loadedModules[moduleName] as IModuleInfo;
				newModuleInfo.addEventListener(ModuleEvent.READY, function(e:ModuleEvent):void {
					trace("READY");
					create(title, moduleName, parameters, popup, modal);
				});
				
				newModuleInfo.addEventListener(ModuleEvent.PROGRESS, function(e:ProgressEvent):void {
					var num:Number = Math.round((e.bytesLoaded/e.bytesTotal) * 100);
					trace("PROGRESS: " + num);
				});
				newModuleInfo.load();
			}
		}
		
		public function openPopup(module:DisplayObject, modal:Boolean):void {
			var titleWindow:TitleWindow = new TitleWindow();
			titleWindow.showCloseButton = true;
			titleWindow.addEventListener(CloseEvent.CLOSE, function(e:CloseEvent):void {
				PopUpManager.removePopUp(e.target as IFlexDisplayObject);
			});
			titleWindow.addChild(module);
			PopUpManager.addPopUp(titleWindow, Shell.application, modal);
			PopUpManager.centerPopUp(titleWindow);
		}		
	}
}
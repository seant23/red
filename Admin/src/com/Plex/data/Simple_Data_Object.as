package com.Plex.data {
	
	import com.Plex.controls.Prompt;
	
	import flash.events.EventDispatcher;
	
	import mx.utils.ObjectUtil;
	
	public class Simple_Data_Object extends EventDispatcher {
		
		protected var _data:Object;
		protected var _data_orig:Object
		
		protected function setData(newData:Object):void {
			_data_orig = newData;
			_data = ObjectUtil.copy(_data_orig);
		}
		
		public function overWriteOriginal():void {
			_data_orig = _data;
			_data = ObjectUtil.copy(_data_orig);
		}
		
		public function get hasChanged():Boolean {
			return isDifferent(_data_orig, _data);
		}
		
		public function packSaveParams():Object {
			var params:Object = null;
			
			if(_data_orig == null) {
				Prompt.error("Server Data not Loaded!");
				return null;
			} else {
				for(var i:String in _data_orig) {
					
					if(_data_orig[i] == null) {
						_data_orig[i] = "";
					}
					
					if(_data[i] == null) {
						_data[i] = "";
					}
					
					if(_data[i] != _data_orig[i]) {
						if(!params) {
							params = {};
						}
						
						params[i] = _data[i];
					}
				}
				
				return params;
			}
		}
		
		public function isDifferent(original:Object, current:Object):Boolean {
				
			for(var i:String in current) {
				
				if(!original.hasOwnProperty(i)) {
					return true;
				}
				
				var iOrig:String = original[i]==null ? '' : original[i];
				var iCur:String = current[i]==null ? '' : current[i];
				
				if(iOrig != iCur) {	
					return true;
				}
			}
			
			return false;
		}
		
		public function checkInputObjectParam(paramObject:Object, required:Array, objectName:String='Data'):Boolean {
			for(var i:String in required) {
				if(!paramObject.hasOwnProperty(required[i])) {
					Prompt.error("Unsupported " + objectName + " Object: Missing " + required[i]);
					return false;
				}
			}
		
			return true;	
		}
	}
}
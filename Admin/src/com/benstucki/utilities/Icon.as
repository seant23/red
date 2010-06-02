package com.benstucki.utilities {
	import flash.display.Bitmap;
	import flash.display.Loader;
	import flash.events.Event;
	import flash.events.IOErrorEvent;
	import flash.net.URLRequest;
	import flash.system.LoaderContext;

	public class Icon extends Loader {
		
		private var _icon:Bitmap;
		public var source:String;
		
		[Bindable] public function get icon():Bitmap {
			if(_icon) {
				var clone:Bitmap = new Bitmap(_icon.bitmapData.clone());
				return clone;			
			} else {
				return _icon;
			}
		}
		
		public function set icon(b:Bitmap):void {
			_icon = b;
		}
		
		public function Icon(source:String=null) {
			super();
			
			if(source != null) {
				cacheLoad(source);
			}
			
		}
		
		public function cacheLoad(source:String):Loader {
			this.source = source;
			contentLoaderInfo.addEventListener(Event.COMPLETE, bind);
			contentLoaderInfo.addEventListener(IOErrorEvent.IO_ERROR,function(e:IOErrorEvent):void{});
			load(new URLRequest(source), new LoaderContext(true));
			return this;
		}
		
		public function bind(event:Event):void {
			icon = content as Bitmap;
		}
		
	}
}
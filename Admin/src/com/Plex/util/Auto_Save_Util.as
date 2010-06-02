package com.Plex.util
{
	import com.mConnects.employee.Employee_Setting;
	
	import mx.core.UIComponent;
	
	public class Auto_Save_Util
	{
		public static function startSave(textInput:UIComponent):void {
			textInput.setStyle('backgroundColor', Employee_Setting.settings.theme_color);
		}
		 
		public static function finishSave(textInput:UIComponent):void {
			textInput.setStyle('backgroundColor', 0xFFFFFF);
			textInput.errorString = null;
		}
		public static function error(textInput:UIComponent, errorMSG:String):void {
			textInput.setStyle('backgroundColor', null);
			textInput.errorString = errorMSG;
		}
	}
}
package com.Plex.controls {
	import flexlib.containers.SuperTabNavigator;
	
	import mx.controls.PopUpButton;

	public class CloseableTabNavigator extends SuperTabNavigator {
		
		public function getMenu():PopUpButton {
			return popupButton;
		}
		
	}
}
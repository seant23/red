package com.Plex.events
{
	import flash.events.KeyboardEvent;
	import flash.utils.setTimeout;
	
	import mx.controls.DataGrid;
	
	public class Grid_Event_Handler
	{
		static public function keyPress(event:KeyboardEvent):void {
			/*
			var grid:DataGrid = DataGrid(event.target);
			
			var selectedIndex = grid.selectedIndex;
			
			setTimeout(function():void {
				if(event.keyCode == 40 && grid.selectedIndex != grid.dataProvider.length-1) {
					grid.selectedIndex = selectedIndex-1;
				} else if(event.keyCode == 38 && grid.selectedIndex != 0) {
					grid.selectedIndex = selectedIndex+1;
				}
			}, 0);
			*/
		}
	}
}
package com.Plex.data
{
	import mx.collections.ArrayCollection;
	
	public class Date_DataProvider
	{
		private static var _years:ArrayCollection;
		private static var _months:ArrayCollection;
		private static var _days:ArrayCollection;
		
		public static function get years():ArrayCollection {
			Date_DataProvider.buildACs();
			return _years;
		}
		
		public static function get months():ArrayCollection {
			Date_DataProvider.buildACs();
			return _months;
		} 
		
		public static function get days():ArrayCollection {
			Date_DataProvider.buildACs();
			return _days;
		}  
		
		private static function buildACs():void {
			if(!_years) {
				_years = new ArrayCollection();
				
				var date:Date = new Date();
				var year:uint = date.fullYear;
				
				for(var i:uint=0; i<=100; i++) {
					_years.addItem(int(year-i).toString());
				}
				
				_months = new ArrayCollection([
					'January', 
					'February', 
					'March', 
					'April', 
					'May', 
					'June', 
					'July', 
					'August', 
					'September', 
					'October', 
					'November', 
					'December'
				]);
				
				_days =  new ArrayCollection([
					'1', 
					'2', 
					'3', 
					'4', 
					'5', 
					'6', 
					'7', 
					'8', 
					'9',
					'10', 
					'11', 
					'12', 
					'13', 
					'14', 
					'15', 
					'16', 
					'17', 
					'18', 
					'19',
					'20', 
					'21', 
					'22', 
					'23', 
					'24', 
					'25', 
					'26', 
					'27', 
					'28', 
					'29', 
					'30', 
					'31' 
				]); 
			} 
		}

	}
}
package com.Plex.util
{
	public class FileType
	{
		public function FileType()
		{
		}
		
        public static function formatFileSize(numSize:Number):String {
            var strReturn:String;
            numSize = Number(numSize / 1000);
            strReturn = String(numSize.toFixed(1) + " KB");
            if (numSize > 1000) {
                numSize = numSize / 1000;
                strReturn = String(numSize.toFixed(1) + " MB");
                if (numSize > 1000) {
                    numSize = numSize / 1000;
                    strReturn = String(numSize.toFixed(1) + " GB");
                }
            }                
            return strReturn;
        }

		
		public static function getTypeThumbnail(type:String):String {
			if(type == '.jpg' || type == '.gif' || type == '.png' || type == '.bmp') {
				return  "asset/image/silk/image.png";
			}
			
			if(type == '.tar' || type == '.gz' || type == '.bz2' || type == '.zip' || type == '.rar') {
				return  "asset/image/silk/page_white_compressed.png";
			}
			
			if(type == '.php') {
				return  "asset/image/silk/page_white_php.png";
			}
			
			if(type == '.htm' || type == '.html') {
				return  "asset/image/silk/page_white_world.png";
			}
			
			if(type == '.swf') {
				return "asset/image/silk/page_white_flash.png";
			}
			
			if(type == '.pdf') {
				return "asset/image/silk/page_white_acrobat.png";
			}
			
			if(type == '.docx' || type == '.doc' || type=='.rtf') {
				return "asset/image/silk/page_white_word.png";
			}
			
			if(type == '.ppt') {
				return "asset/image/silk/page_white_powerpoint.png";
			}
			
			if(type == '.xls') {
				return "asset/image/silk/page_white_excel.png";
			}
			
			if(type == '.txt') {
				return "asset/image/silk/page_white_text.png";
			}
			
			return "asset/image/silk/page_white.png";
		}

	}
}
/*
Copyright (c) 2003-2011, CKSource - Frederico Knabben. All rights reserved.
For licensing, see LICENSE.html or http://ckeditor.com/license
*/

CKEDITOR.editorConfig = function( config )
{
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';
	config.enterMode = Number(2);
	config.shiftEnterMode = Number(1);
	config.uiColor = '#006699';
	config.extraPlugins = 'tableresize';
	config.filebrowserBrowseUrl = '/ecms/ckfinder/ckfinder.html';
    config.filebrowserImageBrowseUrl = '/ecms/ckfinder/ckfinder.html?Type=Images';
    config.filebrowserFlashBrowseUrl = '/ecms/ckfinder/ckfinder.html?Type=Flash';
    config.filebrowserUploadUrl = '/ecms/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files';
    config.filebrowserImageUploadUrl = '/ecms/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images';
    config.filebrowserFlashUploadUrl = '/ecms/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash'

};

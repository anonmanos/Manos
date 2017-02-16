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
	// Custom toolbar
	config.toolbar =
[ ['Bold', 'Italic', 'Underline', '-', 'Subscript', 'Superscript', '-', 'NumberedList', 'BulletedList', '-', 'Link', 'Unlink'],
['Outdent', 'Indent', '-','Styles','Format','Font','FontSize','TextColor','BGColor', 'JustifyCenter', 'JustifyRight', 'JustifyBlock'],
['Image', 'Flash', 'Smiley', '-', 'Table', 'HorizontalRule', 'SpecialChar'] ];
	config.filebrowserBrowseUrl = '/s49/49042380148/ckfinder/ckfinder.html';
    config.filebrowserImageBrowseUrl = '/s49/49042380148/ckfinder/ckfinder.html?Type=Images';
    config.filebrowserFlashBrowseUrl = '/s49/49042380148/ckfinder/ckfinder.html?Type=Flash';
    config.filebrowserUploadUrl = '/s49/49042380148/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files';
    config.filebrowserImageUploadUrl = '/s49/49042380148/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images';
    config.filebrowserFlashUploadUrl = '/s49/49042380148/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash'

};

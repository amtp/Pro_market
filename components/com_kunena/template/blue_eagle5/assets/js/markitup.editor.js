bbcodeSettings = {
		previewParserPath:	'',
		markupSet: [{className: 'boldbutton',name: 'Bold',name: 'Жирный',key: 'B',openWith: '[b]',closeWith: '[/b]'},{className: 'italicbutton',name: 'Italic',name: 'Курсив',key: 'I',openWith: '[i]',closeWith: '[/i]'},{className: 'underlinebutton',name: 'Underline',name: 'Подчеркнутый',key: 'U',openWith: '[u]',closeWith: '[/u]'},{className: 'strokebutton',name: 'Stroke',name: 'Зачеркнутый',key: 'T',openWith: '[strike]',closeWith: '[/strike]'},{className: 'subscriptbutton',name: 'Subscript',name: 'Подстрочный',key: 'T',openWith: '[sub]',closeWith: '[/sub]'},{className: 'supscriptbutton',name: 'Supscript',name: 'Надстрочный',key: 'T',openWith: '[sup]',closeWith: '[/sup]'},{className: 'sizebutton', name:'Размер шрифта: Выберите размер шрифта и примените для выделенного текста', key:'S', openWith:'[size=[![Text size]!]]', closeWith:'[/size]',	dropMenu :[
						{name: 'Очень очень маленький', openWith:'[size=1]', closeWith:'[/size]' },
						{name: 'Очень маленький', openWith:'[size=2]', closeWith:'[/size]' },
						{name: 'Маленький', openWith:'[size=3]', closeWith:'[/size]' },
						{name: 'Нормальный', openWith:'[size=4]', closeWith:'[/size]' },
						{name: 'Большой', openWith:'[size=5]', closeWith:'[/size]' },
						{name: 'Больше', openWith:'[size=6]', closeWith:'[/size]' }
						]},{className: 'colors', name:'Цвет', key:'', openWith:'[color=[![Color]!]]', closeWith:'[/color]',dropMenu: [
						{name: 'Чёрный',	openWith:'[color=black]', 	closeWith:'[/color]', className:'col1-1' },
						{name: 'Оранжевый',	openWith:'[color=orange]', 	closeWith:'[/color]', className:'col1-2' },
						{name: 'Красный', 	openWith:'[color=red]', 	closeWith:'[/color]', className:'col1-3' },

						{name: 'Синий', 	openWith:'[color=blue]', 	closeWith:'[/color]', className:'col2-1' },
						{name: 'Фиолетовый', openWith:'[color=purple]', 	closeWith:'[/color]', className:'col2-2' },
						{name: 'Зелёный', 	openWith:'[color=green]', 	closeWith:'[/color]', className:'col2-3' },

						{name: 'Белый', 	openWith:'[color=white]', 	closeWith:'[/color]', className:'col3-1' },
						{name: 'Серый', 	openWith:'[color=gray]', 	closeWith:'[/color]', className:'col3-2' }
						]},{separator:'|' },{className: 'bulletedlistbutton',name: 'Unordered List',name: 'Ненумерованный список',openWith: '[ul]\n  [li]',closeWith: '[/li]\n  [li][/li]\n[/ul]'},{className: 'numericlistbutton',name: 'Ordered List',name: 'Упорядоченный список',openWith: '[ol]\n  [li]',closeWith: '[/li]\n  [li][/li]\n[/ol]'},{className: 'listitembutton',name: 'Li',name: 'Пункт списка',openWith: '\n  [li]',closeWith: '[/li]'},{className: 'hrbutton',name: 'HR',name: 'Разделитель',openWith: '[hr]'},{className: 'alignleftbutton',name: 'Left',name: 'Выровнять по левому краю',openWith: '[left]',closeWith: '[/left]'},{className: 'centerbutton',name: 'Center',name: 'Выравнять по центру',openWith: '[center]',closeWith: '[/center]'},{className: 'alignrightbutton',name: 'Right',name: 'Выровнять по правому краю',openWith: '[right]',closeWith: '[/right]'},{separator:'|' },{className: 'quotebutton',name: 'Quote',name: 'Цитирование',openWith: '[quote]',closeWith: '[/quote]'},{className: 'codesimplebutton',name: 'Code',name: 'Код',openWith: '[code]',closeWith: '[/code]'},{name:'code', className: 'codemodalboxbutton', beforeInsert:function() {
						jQuery('#code-modal-submit').click(function(event) {
							event.preventDefault();

							jQuery('#modal-code').modal('hide');
						});

						jQuery('#modal-code').modal(
							{overlayClose:true, autoResize:true, minHeight:500, minWidth:800, onOpen: function (dialog) {
								dialog.overlay.fadeIn('slow', function () {
									dialog.container.slideDown('slow', function () {
										dialog.data.fadeIn('slow');
									});
								});
							}});
						}
					},{className: 'tablebutton',name: 'table',openWith: '[table]\n  [tr]\n   [td][/td]\n   [td][/td]\n  [/tr]',closeWith: '\n  [tr]\n   [td][/td]\n   [td][/td]\n [/tr]\n[/table] \n'},{className: 'spoilerbutton',name: 'Spoiler',name: 'СПОЙЛЕР',openWith: '[spoiler]',closeWith: '[/spoiler]'},{className: 'hiddentextbutton',name: 'Hide',name: 'Скрыть текст для гостей',openWith: '[hide]',closeWith: '[/hide]'},{className: 'confidentialbutton',name: 'confidential',name: 'Конфиденциальная информация:',openWith: '[confidential]',closeWith: '[/confidential]'},{separator:'|' },{name:'Ссылка изображения', className: 'picturebutton', beforeInsert:function() {
						jQuery('#picture-modal-submit').click(function(event) {
							event.preventDefault();

							jQuery('#modal-picture').modal('hide');
						});

						jQuery('#modal-picture').modal(
							{overlayClose:true, autoResize:true, minHeight:500, minWidth:800, onOpen: function (dialog) {
								dialog.overlay.fadeIn('slow', function () {
									dialog.container.slideDown('slow', function () {
										dialog.data.fadeIn('slow');
									});
								});
							}});
						}
					},{name:'Ссылка', className: 'linkbutton', beforeInsert:function() {
						jQuery('#link-modal-submit').click(function(event) {
							event.preventDefault();

							jQuery('#modal-link').modal('hide');
						});

						jQuery('#modal-link').modal(
							{overlayClose:true, autoResize:true, minHeight:500, minWidth:800, onOpen: function (dialog) {
								dialog.overlay.fadeIn('slow', function () {
									dialog.container.slideDown('slow', function () {
										dialog.data.fadeIn('slow');
									});
								});
							}});
						}
					},{separator:'|' },{name:'Карта', className: 'mapbutton', beforeInsert:function() {
						jQuery('#map-modal-submit').click(function(event) {
							event.preventDefault();

							jQuery('#modal-map').modal('hide');
						});

						jQuery('#modal-map').modal(
							{overlayClose:true, autoResize:true, minHeight:500, minWidth:800, onOpen: function (dialog) {
								dialog.overlay.fadeIn('slow', function () {
									dialog.container.slideDown('slow', function () {
										dialog.data.fadeIn('slow');
									});
								});
							}});
						}
					},{name:'poll-settings', className: 'pollbutton', beforeInsert:function() {
						jQuery('#poll-settings-modal-submit').click(function(event) {
							event.preventDefault();

							jQuery('#modal-poll-settings').modal('hide');
						});

						jQuery('#modal-poll-settings').modal(
							{overlayClose:true, autoResize:true, minHeight:500, minWidth:800, onOpen: function (dialog) {
								dialog.overlay.fadeIn('slow', function () {
									dialog.container.slideDown('slow', function () {
										dialog.data.fadeIn('slow');
									});
								});
							}});
						}
					},{className: 'tweetbutton',name: 'Tweet',openWith: '[tweet]',closeWith: '[/tweet]'},{className: 'soundcloudbutton',name: 'soundcloud',openWith: '[soundcloud]',closeWith: '[/soundcloud]'},{className: 'instagrambutton',name: 'instagram',openWith: '[instagram]',closeWith: '[/instagram]'},{name:'Эмодзи', className: 'emoticonsbutton', beforeInsert:function() {
						jQuery('#emoticons-modal-submit').click(function(event) {
							event.preventDefault();

							jQuery('#modal-emoticons').modal('hide');
						});

						jQuery('#modal-emoticons').modal(
							{overlayClose:true, autoResize:true, minHeight:500, minWidth:800, onOpen: function (dialog) {
								dialog.overlay.fadeIn('slow', function () {
									dialog.container.slideDown('slow', function () {
										dialog.data.fadeIn('slow');
									});
								});
							}});
						}
					},{separator:'|' },]};
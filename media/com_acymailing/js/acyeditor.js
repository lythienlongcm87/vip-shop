/**
 * @package    AcyMailing for Joomla!
 * @version    4.2.0
 * @author     acyba.com
 * @copyright  (C) 2009-2013 ACYBA S.A.R.L. All rights reserved.
 * @license    GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */


var largeurMenuInline = 441;
var hauteurEditeurMin = 500;

var acyeditor_fullmode = false;
var acyeditor_listmode = false;
var acyeditor_templatemode = false;
var acyeditor_articlemode = false;
var typeCtrl;
var rangeIE;
var debutSelection;
var finSelection;
var rangeIE2;
var anchorNodeIE;
var realstylesheetpath;
var isJoomla2_5 = false;
var isJoomla3 = false;
var isBack = false;
var isTagAllowed = false;
var modalInitialized = false;
var tooltipTemplateDelete;
var tooltipTemplateText;
var tooltipTemplatePicture;
var tooltipShowAreas;
var templateShown = false;
var urlAcyeditor;
var boutonTags = "toolbar-popup-Acytags";

var initIE = false;
function Initialisation(id, type, urlBase, urlAdminBase, cssUrl, forceComplet, modeList, modeTemplate, modeArticle, joomla2_5, joomla3, back, tagAllowed, texteSuppression, titleSuppression, titleEdition, titleTemplateDelete, titleTemplateText, titleTemplatePicture, titleShowAreas) {

	initIE = false;
	jQuery.noConflict();
	editor = undefined;
	realstylesheetpath = cssUrl;
	isJoomla2_5 = joomla2_5;
	isJoomla3 = joomla3;
	isBack = (back == 1);
	isTagAllowed = (tagAllowed == 1);
	typeCtrl = type;
	acyeditor_listmode = modeList;
	acyeditor_templatemode = modeTemplate;
	acyeditor_articlemode = modeArticle;
	tooltipTemplateDelete = titleTemplateDelete;
	tooltipTemplateText = titleTemplateText;
	tooltipTemplatePicture = titleTemplatePicture;
	tooltipShowAreas = titleShowAreas;
	urlAcyeditor = "plugins/editors/acyeditor/acyeditor/";
	if (!isJoomla2_5 && !isJoomla3){
		urlAcyeditor = "plugins/editors/acyeditor/";
	}
	if (!isBack)
	{
		boutonTags = "acybuttontag";
	}

	if (isBrowserIE7() || isBrowserIE8())
	{
		var popupTagContainer = parent.document.getElementById(boutonTags);
		if (popupTagContainer != null
		 && popupTagContainer != undefined
		 && popupTagContainer.children[0] != null
		 && popupTagContainer.children[0] != undefined)
		{
			popupTagContainer.children[0].onclick = function () { IeCursorFix(true); };
		}
	}
	else
	{
		var popupTagContainer = parent.document.getElementById(boutonTags);
		if (popupTagContainer != null
		 && popupTagContainer != undefined
		 && popupTagContainer.children[0] != null
		 && popupTagContainer.children[0] != undefined)
		{
			popupTagContainer.children[0].onclick = function () { IeCursorFix(); };
		}
	}

	if (jQuery('#AcyLienImage')[0] == null || jQuery('#AcyLienImage')[0] == undefined)
	{
		var lienImage = document.createElement("a");
		lienImage.id = "AcyLienImage";
		lienImage.href = "index.php?option=com_media&view=images&tmpl=component&e_name=ACY_NAME_TO_REPLACE&asset=com_content&author=";
		lienImage.rel = "{handler: 'iframe', size: {x: 800, y: 518}}";
		lienImage.style.display = "none";
		document.body.appendChild(lienImage);
		jQuery('#' + lienImage.id).addClass("modal");
	}
	if (jQuery('#AcyLienTag')[0] == null || jQuery('#AcyLienTag')[0] == undefined)
	{
		if (isJoomla3)
		{
			var lienTag = document.createElement("button");
			lienTag.id = "AcyLienTag";
			jQuery(lienTag).attr("data-toggle", "modal");
			jQuery(lienTag).attr("data-target", "#modal-Acytags");
			lienTag.style.display = "none";
			lienTag.onclick = function () { try { IeCursorFix(); } catch (e) {} };
			document.body.appendChild(lienTag);
		}
		else
		{
			var lienTag = document.createElement("a");
			lienTag.id = "AcyLienTag";
			lienTag.href = "index.php?option=com_acymailing&ctrl=tag&task=tag&tmpl=component&type=" + typeCtrl;
			if (!isBack)
			{
				lienTag.href = urlBase + "index.php?option=com_acymailing&ctrl=fronttag&task=tag&tmpl=component&type=" + typeCtrl;
			}
			lienTag.rel = "{handler: 'iframe', size: {x: 780, y: 550}}";
			lienTag.onclick = function () { try { IeCursorFix(); } catch (e) {} };
			lienTag.style.display = "none";
			document.body.appendChild(lienTag);
			jQuery('#' + lienTag.id).addClass("modal");
		}
	}

	var idIframe = id + "_ifr";
	var textArea = jQuery('#' + id)[0];
	var divParent = jQuery('#' + idIframe)[0];

	if (divParent != null && divParent != undefined)
	{
		divParent.outerHTML = "";
	}

	divParent = document.createElement("div");
	divParent.style.width = textArea.style.width;
	divParent.style.height = textArea.style.height;
	divParent.id = idIframe;
	divParent.innerHTML = textArea.value;
	textArea.parentElement.appendChild(divParent);

	var acyedition = (jQuery('#' + idIframe).find(".acyeditor_delete").length > 0
					 || jQuery('#' + idIframe).find(".acyeditor_text").length > 0
					 || jQuery('#' + idIframe).find(".acyeditor_picture").length > 0);

	if (acyedition && forceComplet != 1)
	{
		acyeditor_fullmode = false;
		var iframe = document.createElement("iframe");
		iframe.frameBorder = '0';
		divParent.parentElement.appendChild(iframe);

		var code = divParent.innerHTML;
		var width = divParent.style.width;
		var height = divParent.style.height;
		divParent.outerHTML = "";
		iframe.id = idIframe;

		iframe.onload = function() {
			if (isBrowserIE() && !initIE)
			{
				initIE = true;
				var markup = '<!DOCTYPE html></html>';
				iframe.contentWindow.document.open();
				iframe.contentWindow.document.write(markup);
				iframe.contentWindow.document.close();
			}
			else
			{
				ChargementIframe(iframe, urlBase, code, width, height, id, texteSuppression, titleSuppression, titleEdition, urlAdminBase, realstylesheetpath)

				if ((isBrowserIE7() || isBrowserIE8()) && !isJoomla2_5 && !isJoomla3)
				{
					setTimeout(function() {
						SqueezeBox.initialize({});

						$$('a.modal').each(function(el) {
							el.addEvent('click', function(e) {
								new Event(e).stop();
								SqueezeBox.fromElement(el);
							});
						});
					}, 200);
				}
			}
		};

		iframe.src ="";
	}
	else
	{
		acyeditor_fullmode = true;

		var hauteur = jQuery('#' + idIframe).height() - 70 + "px";
		var largeur = "100%";

		var code = divParent.innerHTML;
		divParent.innerHTML = "<textarea id='edition_en_cours' style='width:100%;height:100%'></textarea>";
		if (acyeditor_articlemode)
		{
			largeur = jQuery(".adminform").width() + "px";
			hauteur = "150px";
		}
		if (acyeditor_listmode)
		{
			largeur = jQuery(".adminform").width() - 65 + "px";
			hauteur = "127px";
		}

		var extraPluginsCKEditor = 'resize';
		var toolbarGroupsCKEditor = [
				{ name: 'tools' },
				{ name: 'mode' },
				{ name: 'undo' },
				{ name: 'links' }];
		if (!acyeditor_listmode && isTagAllowed)
		{
			extraPluginsCKEditor += ',addtag';
			toolbarGroupsCKEditor.push({ name: 'insert', items: [ "image", "addtag" ]});
		}
		else
		{
			toolbarGroupsCKEditor.push({ name: 'insert', items: [ "image" ]});
		}
		toolbarGroupsCKEditor.push({ name: 'basicstyles',   groups: [ 'basicstyles', 'cleanup' ] },
									{ name: 'colors' },
									{ name: 'paragraph',   groups: [ 'list', 'indent' ] },
									{ name: 'align' },
									{ name: 'styles' });
		if (acyeditor_templatemode)
		{
			extraPluginsCKEditor += ',templatemode';
			toolbarGroupsCKEditor.push({ name: 'templatemode', items: [ "textarea", "picturearea", "deletearea", "-", "showarea" ]});
		}

		editor = CKEDITOR.replace("edition_en_cours",{
			toolbarGroups : toolbarGroupsCKEditor,
			height : hauteur,
			width : largeur,
			baseHref : urlBase,
			filebrowserImageUploadUrl : urlBase + urlAcyeditor + 'kcfinder/upload.php?type=images',
			removeButtons: 'Cut,Copy,Paste,Blockquote,HorizontalRule,SpecialChar,Symbol',
			extraPlugins: extraPluginsCKEditor
		});

		editor.setData(code);
		editor.on('instanceReady',function(e){
			var iframe = jQuery('#edition_en_cours')[0].parentElement.getElementsByTagName('iframe')[0];
			editor.on('paste', function(e){ IeCursorFix(); });
			iframe.contentWindow.document.body.onkeyup = function () { IeCursorFix(); };
			iframe.contentWindow.document.body.onclick = function () { IeCursorFix(); };
			rangeIE = undefined;
			IeCursorFix();

			if (realstylesheetpath == null || realstylesheetpath == undefined || realstylesheetpath == "")
			{
				var headEditor = iframe.contentWindow.document;
				headEditor = headEditor.head || headEditor;
				var linkCss = headEditor.getElementsByTagName("link")[0];
				jQuery(linkCss).removeAttr("href");
			}
			else
			{
				var headEditor = iframe.contentWindow.document;
				headEditor = headEditor.head || headEditor;
				var linkCss = headEditor.getElementsByTagName("link")[0];
				SetStyleSheetEnBoucle(linkCss, urlBase, realstylesheetpath, Date.now());
			}

			ShowTemplateCss(true);

			editor.on('selectionChange', function(e) { IECursorFix(); });

			editor.on('mode',function(e){
				var iframe = jQuery('#' + id)[0].parentElement.getElementsByTagName("iframe")[0];
				if (iframe != undefined)
				{
					var headEditor = iframe.contentWindow.document;
					headEditor = headEditor.head || headEditor;
					var linkCss = headEditor.getElementsByTagName("link")[0];
					if (realstylesheetpath != null && realstylesheetpath != undefined && realstylesheetpath != "")
					{
						SetStyleSheetEnBoucle(linkCss, urlBase, realstylesheetpath, Date.now());
					}
					else
					{
						jQuery(linkCss).removeAttr("href");
					}
					if (acyeditor_templatemode)
					{
						ShowTemplateCss(templateShown);
						SetStateForSelection();
					}
				}
				var textarea = jQuery('#cke_edition_en_cours .cke_inner .cke_contents textarea')[0];
				if (textarea != undefined)
				{
					textarea.title = "";
					textarea.parentElement.style.paddingRight = "5px";
				}
			});

			var editorBody = jQuery('#' + id + '_ifr')[0];
			var htmlfieldset = jQuery('#htmlfieldset')[0];
			var textfieldset = jQuery('#textfieldset')[0];
			if (htmlfieldset != undefined && textfieldset != undefined)
			{
				htmlfieldset.style.width = jQuery(textfieldset).width() + "px";
			}
			if (editorBody != undefined)
			{
				editorBody.style.width = "100%";
				if (acyeditor_articlemode && isJoomla3)
				{
					editorBody.style.marginBottom = "27px";
				}
			}

			setTimeout(function() {
				jQuery("body")[0].onresize = function(e) {
					jQuery("#cke_edition_en_cours")[0].style.width = "10px";
					jQuery("#cke_edition_en_cours")[0].style.width = jQuery("#edition_en_cours")[0].parentElement.clientWidth - 10 + "px";
				};
			}, 500);

			jQuery("#edition_en_cours")[0].parentElement.style.height = "";
		});

		var listeForms = document.getElementsByTagName('form');
		for (indexForm = 0; indexForm < listeForms.length; ++indexForm)
		{
			listeForms[indexForm].onsubmit = function () { OnSubmit(id); };
		}
	}
}

function ChargementIframe(iframe, urlBase, code, width, height, id, texteSuppression, titleSuppression, titleEdition, urlAdminBase, stylesheetpath){
 	iframe.contentWindow.document.body.innerHTML = code;
	iframe.frameborder = "0";
	iframe.allowtransparency = "true";
	iframe.style.width = width;
	iframe.style.height = height;

	var header = jQuery('#' + iframe.id).contents().find("head")[0];
	var base1 = document.createElement("base");
	base1.href = urlBase;
	header.appendChild(base1);
	var script1 = document.createElement("script");
	script1.type = "text/javascript";
	script1.src =  urlBase + urlAcyeditor + "ckeditor/ckeditor.js" + "?time=" + Date.now();
	header.appendChild(script1);
	var link1 = document.createElement("link");
	var link2 = document.createElement("link");
	link1.type = "text/css"; link2.type = "text/css";
	link1.rel = "stylesheet"; link2.rel = "stylesheet";
	link1.href =  urlBase + urlAcyeditor + "css/acyeditor.css" + "?time=" + Date.now();
	if (stylesheetpath != null && stylesheetpath != undefined && stylesheetpath != "")
	{
		link2.href =  urlBase + stylesheetpath + "?time=" + Date.now();
	}
	link2.id = "acy_template_css";
	header.appendChild(link1); header.appendChild(link2);

	InitContent(id, texteSuppression, titleSuppression, titleEdition, urlAdminBase);
}

function InitContent(id, texteSuppression, titleSuppression, titleEdition, urlAdminBase){
	var idIframe = id + "_ifr";

	CreationDesZones(id, texteSuppression, titleSuppression, titleEdition, urlAdminBase);
	SetEditablesElements(id);

	SetImagesId(id);

	document.getElementsByTagName('body')[0].onclick = function (e) { CheckDeselection(id, e); };
	var listeForms = document.getElementsByTagName('form');
	for (indexForm = 0; indexForm < listeForms.length; ++indexForm)
	{
		listeForms[indexForm].onsubmit = function () { CheckDeselection(id); };
	}
	jQuery('#' + idIframe)[0].contentWindow.document.body.onclick = function (e) { CheckDeselection(id, e); };

	setTimeout(function() {
		ResizeIframe(id);
	}, 100);

	if (isBrowserIE())
	{
		jQuery('#' + idIframe).contents().find(".acyeditor_picture").hover(
			function () {
				if (jQuery(this)[0].className.indexOf("acyeditor_enedition") < 0)
				{
					jQuery(this).addClass('acyeditor_editablehover');
					jQuery(this).find(".acyeditor_zoneeditionsuppression").addClass('acyeditor_zoneeditionsuppressionhover');
				}
			},
			function() {
				jQuery(this).removeClass('acyeditor_editablehover');
				jQuery(this).find(".acyeditor_zoneeditionsuppression").removeClass('acyeditor_zoneeditionsuppressionhover');
			}
		);
		jQuery('#' + idIframe).contents().find(".acyeditor_text").hover(
			function () {
				if (jQuery(this)[0].className.indexOf("acyeditor_enedition") < 0)
				{
					jQuery(this).addClass('acyeditor_editablehover');
					jQuery(this).find(".acyeditor_zoneeditionsuppression").addClass('acyeditor_zoneeditionsuppressionhover');
				}
			},
			function() {
				jQuery(this).removeClass('acyeditor_editablehover');
				jQuery(this).find(".acyeditor_zoneeditionsuppression").removeClass('acyeditor_zoneeditionsuppressionhover');
			}
		);
		jQuery('#' + idIframe).contents().find(".acyeditor_delete").hover(
			function () {
				if (jQuery(this)[0].className.indexOf("acyeditor_enedition") < 0)
				{
					jQuery(this).find(".acyeditor_zoneeditionsuppression").addClass('acyeditor_zoneeditionsuppressionhover');
				}
			},
			function() {
				jQuery(this).find(".acyeditor_zoneeditionsuppression").removeClass('acyeditor_zoneeditionsuppressionhover');
			}
		);
	}
}

function jInsertEditorText(text, editor){
	var id = jQuery('#htmlfieldset')[0] != null ? jQuery('#htmlfieldset')[0].getElementsByTagName("textarea")[0].id : "edition_en_cours";
	var element = GetElement(id, editor)[0];
	if (element == null || element == undefined)
	{
		element = document.getElementById(editor);
	}

	insertAtCursor(element, text);
}

function insertAtCursor(myField, myValue){

	var id = jQuery('#htmlfieldset')[0] != null ? jQuery('#htmlfieldset')[0].getElementsByTagName("textarea")[0].id : "edition_en_cours";

	if (myField.className.indexOf("acyeditor_picture") >= 0)
	{
		GetElement(id, myField.id).removeClass('acyeditor_picture');
		var zone = GetElement(id, "ZoneEditionSuppression_" + myField.id);
		if (zone[0] != null && zone[0] != undefined)
		{
			EffaceZone(zone[0]);
			zone.remove();
		}
		if (myValue == undefined)
		{
			myValue = "";
		}
		var width = myField.clientWidth;
		if (myField.children.length > 0)
		{
			width = myField.children[0].clientWidth;
		}
		myField.innerHTML = myValue;
		var images = myField.getElementsByTagName("img");
		for (indexImage = 0; indexImage < images.length; ++indexImage)
		{
			images[indexImage].width = width;
			images[indexImage].height = images[indexImage].clientHeight;
		}
		if (zone[0] != null && zone[0] != undefined)
		{
			myField.appendChild(zone[0]);
		}

		AdapteTaille(id, zone);
		GetElement(id, myField.id).addClass('acyeditor_picture');
		Sauvegarde(id);
		ResizeIframe(id);
	}
	else
	{
		var acyframe =  jQuery('#' + id)[0].parentElement.getElementsByTagName("iframe")[0];
		if (acyframe != null
		 && acyframe != undefined
		 && acyframe.contentWindow != null
		 && acyframe.contentWindow != undefined
		 && acyframe.contentWindow.getSelection)
		{
			var sel = acyframe.contentWindow.getSelection();
			var newNode = acyframe.contentWindow.document.createElement("div");
			newNode.innerHTML = myValue;
			if (isBrowserIE()
			 && rangeIE != undefined)
			{
				rangeIE.deleteContents();
				while (newNode.childNodes.length > 0)
				{
					rangeIE.insertNode(newNode.childNodes[newNode.childNodes.length - 1]);
				}
				if (editor != null && editor != undefined)
				{
					editor.fire( 'saveSnapshot' );
				}
			}
			else if (isEnEdition(sel.anchorNode) && sel.getRangeAt && sel.rangeCount) {
				range = sel.getRangeAt(0);
				range.deleteContents();
				while (newNode.childNodes.length > 0)
				{
					range.insertNode(newNode.childNodes[newNode.childNodes.length - 1]);
				}
				if (editor != null && editor != undefined)
				{
					editor.fire( 'saveSnapshot' );
				}
			}
			else
			{
				AjoutTagDansSujet(myValue);
			}
		}
		else if (acyframe != null
				&& acyframe != undefined
				&& acyframe.contentWindow.document != null
				&& acyframe.contentWindow.document != undefined
				&& acyframe.contentWindow.document.selection
				&& isBrowserIE()
				&& rangeIE != undefined
				&& rangeIE.parentElement
				&& isInForm(id, rangeIE.parentElement()))
		{
			if (isJoomla3
			 && (isBrowserIE7() || isBrowserIE8())
			 && debutSelection >= 0 && finSelection >= 0
			 && (acyframe.contentWindow.document.selection.createRange().parentElement
				&& isInForm(id, acyframe.contentWindow.document.selection.createRange().parentElement())
			 || !acyeditor_fullmode)
			&& rangeIE.text.length != "")
			{
				rangeIE.moveStart('character', debutSelection);
				rangeIE.moveEnd('character', -finSelection);
			}
			try
			{
				rangeIE.pasteHTML(myValue);
			}
			catch (e)
			{
				rangeIE.text = myValue;
			}
			if (editor != null && editor != undefined)
			{
				editor.fire( 'saveSnapshot' );
			}
		}
		else
		{
			AjoutTagDansSujet(myValue);
		}
	}
}

function AjoutTagDansSujet(myValue){
	jQuery("#subject").val(jQuery("#subject").val() + myValue);
}

function isEnEdition(element){
	var enedition = true;
	if (acyeditor_fullmode == false)
	{
		enedition = false;
		var parent = element;
		while (parent != null && parent != undefined)
		{
			if (parent.className != null && parent.className != undefined && parent.className.indexOf("acyeditor_enedition") >= 0)
			{
				enedition = true;
			}
			parent = parent.parentElement || parent.parentNode;
		}
	}
	return enedition;
}

function isInForm(id, element){
	var inForm = false;
	var parent = element;
	var idForm = jQuery("#" + id)[0].parentElement.id;
	var acyframe = jQuery("#" + id + "_ifr")[0].contentWindow;
	if (acyframe == undefined)
	{
		acyframe = jQuery(".cke_wysiwyg_frame")[0].contentWindow;
	}
	while (parent != null && parent != undefined)
	{
		if (parent.id == idForm
		 || acyframe != undefined
		 && (parent.id != "" && acyframe.document.getElementById(parent.id) != null
			|| parent.className != undefined && parent.className.indexOf("cke_editable") >= 0))
		{
			inForm = true;
		}
		parent = parent.parentElement || parent.parentNode;
	}
	return inForm;
}

function isBrowserIE(){
	return navigator.appName=="Microsoft Internet Explorer";
}

function isBrowserIE7(){
	return (navigator.appName=="Microsoft Internet Explorer" &&
			navigator.appVersion.indexOf("MSIE 7.0") >= 0);
}

function isBrowserIE8(){
	return (navigator.appName=="Microsoft Internet Explorer" &&
			navigator.appVersion.indexOf("MSIE 8.0") >= 0);
}

function IeCursorFix(avecPosition){
	debutSelection = -1;
	finSelection = -1;
	if (isBrowserIE()) {
		var id = jQuery('#htmlfieldset')[0] != null ? jQuery('#htmlfieldset')[0].getElementsByTagName("textarea")[0].id : "edition_en_cours";
		var acyframe =  jQuery('#' + id)[0].parentElement.getElementsByTagName("iframe")[0];
		if (acyframe != null
		 && acyframe != undefined
		 && acyframe.contentWindow != null
		 && acyframe.contentWindow != undefined
		 && acyframe.contentWindow.getSelection)
		{
			rangeIE = undefined;
			var sel = acyframe.contentWindow.getSelection();
			if (isEnEdition(sel.anchorNode) && sel.getRangeAt && sel.rangeCount) {
				rangeIE = sel.getRangeAt(0);
			}
		}
		else if (acyframe != null
				&& acyframe != undefined
				&& acyframe.contentWindow.document != null
				&& acyframe.contentWindow.document != undefined
				&& acyframe.contentWindow.document.selection)
		{
			if (acyframe.contentWindow.document.selection.createRange().parentElement)
			{
				anchorNodeIE = acyframe.contentWindow.document.selection.createRange().parentElement();
			}
			if (avecPosition
			 || rangeIE == undefined
			 || acyframe.contentWindow.document.selection.createRange().parentElement
			 && isEnEdition(acyframe.contentWindow.document.selection.createRange().parentElement()))
			{
				var nouvelleSelection = acyframe.contentWindow.document.selection;
				var bonElement = (nouvelleSelection.type != "Control");
				if ((rangeIE == undefined
					|| !avecPosition
					|| rangeIE.text != nouvelleSelection.createRange().text)
				 && bonElement)
				{
					rangeIE = nouvelleSelection.createRange();
					rangeIE2 = nouvelleSelection.createRange();
				}

				if (isJoomla3 && bonElement && avecPosition && (isBrowserIE7() || isBrowserIE8()))
				{
					var textComplet = rangeIE.parentElement().innerText;
					if (textComplet.length > rangeIE.text.length)
					{
						for (indexDebut = 0; indexDebut < textComplet.length; ++indexDebut)
						{
							rangeIE2.moveToBookmark(rangeIE.getBookmark());
							var longueurInitiale = rangeIE2.text.length;
							rangeIE2.moveStart('character', -indexDebut);
							var longueurIntermediaire = rangeIE2.text.length;
							var indexFin = textComplet.length - rangeIE2.text.length;
							rangeIE2.moveEnd('character', indexFin);
							if (rangeIE2.text.length > textComplet.length)
							{
								rangeIE2.moveEnd('character', -(rangeIE2.text.length - textComplet.length));
							}
							if (rangeIE2.text.length < textComplet.length)
							{
								rangeIE2.moveEnd('character', -(textComplet.length - rangeIE2.text.length));
							}
							var longueurFinale = rangeIE2.text.length;
							if (rangeIE2.text == textComplet)
							{
								debutSelection = indexDebut;
								finSelection = indexFin;

								indexDebut = textComplet.length + 1;
							}
						}
					}
					else
					{
						debutSelection = 0;
						finSelection = 0;
					}
				}
			}
		}
		else
		{
			rangeIE = undefined;
		}
	}
	return true;
}

function setStylesheet(id, stylesheeturl, stylesheetpath){
	realstylesheetpath = stylesheetpath;
	rangeIE = undefined;
	var idIframe = id + "_ifr";
	var linkCss = GetElement(id, "acy_template_css")[0];
	if (linkCss == undefined)
	{
		if (editor != undefined)
		{
			editor.on('instanceReady',function(){
				var iframe = jQuery('#' + id)[0].parentElement.getElementsByTagName("iframe")[0];
				if (iframe != undefined)
				{
					var headEditor = iframe.contentWindow.document;
					headEditor = headEditor.head || headEditor;
					var base = headEditor.getElementsByTagName("base")[0];
					linkCss = headEditor.getElementsByTagName("link")[0];
					SetStyleSheetEnBoucle(linkCss, base.href, stylesheetpath, Date.now());
				}
			});
		}
	}
	else if (stylesheetpath != null && stylesheetpath != undefined && stylesheetpath != "")
	{
		linkCss.href = linkCss.baseURI + stylesheetpath + "?time=" + Date.now();
	}
}

function SetStyleSheetEnBoucle(linkCss, urlBase, stylesheetpath, date){
	SetStyleSheet(linkCss, urlBase, stylesheetpath, date);
	setTimeout(function() {
		SetStyleSheet(linkCss, urlBase, stylesheetpath, date);
	}, 200);
	setTimeout(function() {
		SetStyleSheet(linkCss, urlBase, stylesheetpath, date);
	}, 500);
	setTimeout(function() {
		SetStyleSheet(linkCss, urlBase, stylesheetpath, date);
	}, 1500);
}
function SetStyleSheet(linkCss, urlBase, stylesheetpath, date){
	linkCss.href = urlBase+stylesheetpath+"?time=" + date;
}

function ResizeIframe(id){
	if (acyeditor_listmode)
	{
		var iframe = jQuery('#' + id)[0].parentElement.getElementsByTagName("iframe")[0];
		var textarea = jQuery('#edition_en_cours')[0];
		if (iframe != undefined && textarea != undefined)
		{
			var innerHeight = iframe.contentWindow.document.body.clientHeight;
			if (innerHeight < hauteurEditeurMin)
			{
				innerHeight = hauteurEditeurMin;
			}
			iframe.parentElement.style.height = innerHeight + 90 + "px";
			textarea.parentElement.style.height = "";
			var editorBody = jQuery('#' + id + '_ifr')[0];
			editorBody.style.width = "100%";
		}
	}
	else
	{
		var iframe = jQuery('#' + id)[0].parentElement.getElementsByTagName("iframe")[0];
		var editorBody = jQuery('#' + id + '_ifr')[0];
		var htmlfieldset = jQuery('#htmlfieldset')[0];
		if (acyeditor_templatemode)
		{
			htmlfieldset = editorBody.parentElement;
			editorBody.style.width = "100%";
		}
		if (iframe != undefined && editorBody != undefined && htmlfieldset != undefined)
		{
			if (acyeditor_fullmode)
			{
				var innerHeight = iframe.contentWindow.document.body.clientHeight;
				if (innerHeight < hauteurEditeurMin)
				{
					innerHeight = hauteurEditeurMin;
				}
				iframe.parentElement.style.height = innerHeight + 90 + "px";
				editorBody.style.height = "";
				htmlfieldset.style.height = "";
				if (jQuery("#textfieldset").length > 0)
				{
					htmlfieldset.style.width = jQuery("#textfieldset").width() + "px";
					editorBody.style.width = "100%";
				}
			}
			else
			{
				var innerHeight = iframe.contentWindow.document.body.children[0].clientHeight;
				if (innerHeight < hauteurEditeurMin)
				{
					innerHeight = hauteurEditeurMin;
				}
				editorBody.style.height = innerHeight + 80 + "px";
				htmlfieldset.style.height = "";
				editorBody.style.width = "100%";
			}
		}
	}
}

function OnSubmit(id){
	if (acyeditor_templatemode)
	{
		SetTitleTemplate(true);
	}

	jQuery('#' + id)[0].value = (editor != null && editor != undefined) ? editor.getData() : "";
}

function SetEditablesElements(id){
	var idIframe = id + "_ifr";
	var elements = jQuery('#' + idIframe)[0].contentWindow.document.body.getElementsByTagName('*');
	for (i = 0; i < elements.length; ++i)
	{
		var element = elements[i];
		if (element.className.indexOf("acyeditor_text") >= 0
		 && element.onclick == null)
		{
			if (element.id == null || element.id == '' || element.id == undefined)
			{
				element.id = GetNewId(id);
			}
			SetOnClick(id, element);
		}
	}
}

function SetImagesId(id){
	var idIframe = id + "_ifr";
	var elements = jQuery('#' + idIframe)[0].contentWindow.document.body.getElementsByTagName('img');
	for (indexImagesId = 0; indexImagesId < elements.length; ++indexImagesId)
	{
		var element = elements[indexImagesId];
		if (element.id == null || element.id == '' || element.id == undefined)
		{
			element.outerHTML = element.outerHTML.replace("<img ", "<img id=\"" + GetNewId(id) + "\" ");
		}
		else
		{
			element.outerHTML = element.outerHTML;
		}
	}
}

function CreationDesZones(id, texteSuppression, titleSuppression, titleEdition, urlBase){
	var idIframe = id + "_ifr";
	var elementsZones = jQuery('#' + idIframe)[0].contentWindow.document.body.getElementsByTagName('*');
	for (indexZone = 0; indexZone < elementsZones.length; ++indexZone)
	{
		var elementZone = elementsZones[indexZone];
		CreationZone(id, elementZone, texteSuppression, titleSuppression, titleEdition, urlBase);
	}
}

function CreationZone(id, element , texteSuppression, titleSuppression, titleEdition, urlBase){
 	if (jQuery(element).hasClass("acyeditor_delete")
	 || jQuery(element).hasClass("acyeditor_text")
	 || jQuery(element).hasClass("acyeditor_picture"))
	{
		if (element.id == null || element.id == '' || element.id == undefined)
		{
			element.id = GetNewId(id);
		}

		if (element.tagName == "TR")
		{
			if (jQuery(element).hasClass("acyeditor_delete"))
			{
				var elementTDEditables = jQuery(element).find("td:not(td.acyeditor_text), td:not(td.acyeditor_picture)");
				if (elementTDEditables.length == 0)
				{
					elementTDEditables = element.children;
				}
				for (j = 0; j < elementTDEditables.length; ++j)
				{
					var sousElementsTD = elementTDEditables[j];
					if (sousElementsTD.tagName == "TD")
					{
						if (sousElementsTD.id == null || sousElementsTD.id == '' || sousElementsTD.id == undefined)
						{
							sousElementsTD.id = GetNewId(id);
						}

						GetElement(id, sousElementsTD.id).addClass("acyeditor_delete");
						CreationZone(id, sousElementsTD , texteSuppression, titleSuppression, titleEdition, urlBase);
						GetElement(id, sousElementsTD.id).removeClass("acyeditor_delete");
					}
				}
			}
		}
		else if (jQuery(element).find(".acyeditor_delete").length
				 + jQuery(element).find(".acyeditor_text").length
				 + jQuery(element).find(".acyeditor_picture").length == 0)
		{
			if (Existe(id, "ZoneEditionSuppression_" + element.id) == false)
			{
				var zone = document.createElement("div");
				zone.id = "ZoneEditionSuppression_" + element.id;
				zone.style.position = "absolute";
				element.appendChild(zone);
				GetElement(id, zone.id).addClass('acyeditor_zoneeditionsuppression');
				if (jQuery(element).hasClass("acyeditor_text")
				 || jQuery(element).hasClass("acyeditor_picture"))
				{
					if (jQuery(element).hasClass('acyeditor_picture'))
					{
						zone.onclick = function () {
							if (!jQuery(element).hasClass('nepasediter'))
							{
								jQuery('#AcyLienImage')[0].href = jQuery('#AcyLienImage')[0].href.replace('ACY_NAME_TO_REPLACE', element.id);
								FireClick(jQuery('#AcyLienImage')[0]);
								jQuery('#AcyLienImage')[0].href = jQuery('#AcyLienImage')[0].href.replace(element.id, 'ACY_NAME_TO_REPLACE');
							}
							else if (!isBrowserIE())
							{
								jQuery(element).removeClass('nepasediter');
							}
						};
						if (isBrowserIE())
						{
							zone.parentElement.onclick = function () {
								if (!jQuery(element).hasClass('nepasediter'))
								{
									jQuery('#AcyLienImage')[0].href = jQuery('#AcyLienImage')[0].href.replace('ACY_NAME_TO_REPLACE', element.id);
									FireClick(jQuery('#AcyLienImage')[0]);
									jQuery('#AcyLienImage')[0].href = jQuery('#AcyLienImage')[0].href.replace(element.id, 'ACY_NAME_TO_REPLACE');
								}
								else
								{
									jQuery(element).removeClass('nepasediter');
								}
							};
						}
					}

					var zoneBoutonEdition = document.createElement("div");
					zoneBoutonEdition.style.position = "absolute";
					zone.appendChild(zoneBoutonEdition);
					jQuery(zoneBoutonEdition).addClass("acyeditor_zoneboutonedition");
					var boutonEdition = document.createElement("div");
					boutonEdition.id = "BoutonEdition_" + element.id;
					boutonEdition.title = titleEdition;
					zoneBoutonEdition.appendChild(boutonEdition);
					if (jQuery(element).hasClass('acyeditor_picture'))
					{
						jQuery(boutonEdition).addClass("acyeditor_editpicture");
					}
					else
					{
						jQuery(boutonEdition).addClass("acyeditor_edittext");
					}
				}
				if (jQuery(element).hasClass("acyeditor_delete"))
				{
					var zoneBoutonSuppression = document.createElement("div");
					zoneBoutonSuppression.style.position = "absolute";
					zone.appendChild(zoneBoutonSuppression);
					jQuery(zoneBoutonSuppression).addClass("acyeditor_editdelete");
					var boutonSuppression = document.createElement("div");
					boutonSuppression.id = "BoutonSuppression_" + element.id;
					boutonSuppression.title = titleSuppression;
					boutonSuppression.onclick = function () {
						Suppression(id, element, boutonSuppression, texteSuppression);
					};
					zoneBoutonSuppression.appendChild(boutonSuppression);
					zone.onmousemove = function(e) { CheckToujoursAuDessus(id, e); };
					GetElement(id, boutonSuppression.id).addClass("acyeditor_editdelete");
				}

				SetMouseOver(id, zone);
				AdapteTaille(id, zone);
			}
		}
		else
		{
			GetElement(id, element.id).removeClass("acyeditor_delete");
			GetElement(id, element.id).removeClass("acyeditor_text");
			GetElement(id, element.id).removeClass("acyeditor_picture");
		}
	}
}

function FireClick(itemElement, arretRecursif){
	if (isBrowserIE7() || isBrowserIE8())
	{
		var popupTagContainer = parent.document.getElementById(boutonTags);
		if (popupTagContainer != null
		 && popupTagContainer != undefined
		 && popupTagContainer.children[0] != null
		 && popupTagContainer.children[0] != undefined)
		{
			popupTagContainer.children[0].onclick = function () { IeCursorFix(); };
		}
	}
	try
	{
		itemElement.click();
	}
	catch (err)
	{
		try
		{
			var ev = new Event({type: "click", target: itemElement, srcElement: itemElement});
			itemElement.fireEvent("click", ev);
		}
		catch (err2)
		{
			itemElement.fireEvent("click");
		}
	}

	if ((isBrowserIE7() || isBrowserIE8()) && isJoomla3 && arretRecursif != true && itemElement.id != "AcyLienImage")
	{
		setTimeout(function() {
			IeCursorFix();
			SetIgnoreDeselection();
			FireClick(itemElement, true);
		}, 100);
	}
	else if (isBrowserIE7() || isBrowserIE8())
	{
		var popupTagContainer = parent.document.getElementById(boutonTags);
		if (popupTagContainer != null
		 && popupTagContainer != undefined
		 && popupTagContainer.children[0] != null
		 && popupTagContainer.children[0] != undefined)
		{
			popupTagContainer.children[0].onclick = function () { IeCursorFix(true); };
		}
	}
}

function CheckToujoursAuDessus(id, e){

	var iframe = jQuery('#' + id + '_ifr');

	e = e || iframe[0].contentWindow.event;
	var target = e.currentTarget || e.srcElement;

	var parent = GetElement(id, target.parentElement.id);
	var leftElement = parent.offset().left;
	var topElement =  parent.offset().top;
	var widthElement = parent.outerWidth();
	var heightElement = parent.outerHeight();

	if (e.pageX < leftElement
	 || e.pageX > leftElement + widthElement
	 || e.pageY < topElement
	 || e.pageY > topElement + heightElement)
	{
		EffaceZone(target);
	}
}

function EffaceZone(zone){
	if (zone != null && zone != undefined)
	{
		var enfants = zone.getElementsByTagName("*");
		for (i = 0; i < enfants.length; ++i)
		{
			enfants[i].style.display = "none";
		}
		zone.style.width = "0px";
		zone.style.height = "0px";
		zone.style.borderStyle = "hidden";
	}
}

function Suppression(id, element, boutonSuppression, texteSuppression){
	GetElement(id, boutonSuppression.parentElement.parentElement.parentElement.id).addClass('nepasediter');
	if (confirm(texteSuppression))
	{
		var idParent = boutonSuppression.parentElement.parentElement.id;
		if (element.tagName == "TD")
		{
			var parentTR = element;
			while (parentTR != null
				&& parentTR != undefined
				&& (parentTR.tagName != "TR"
				 || !jQuery(parentTR).hasClass("acyeditor_delete")))
			{
				parentTR = parentTR.parentElement;
			}
			if (parentTR != null && parentTR != undefined)
			{
				parentTR.parentElement.removeChild(parentTR);
			}
		}
		else
		{
			element.parentElement.removeChild(element);
		}
		Sauvegarde(id);
		ResizeIframe(id);
	}
}

function SetMouseOver(id, zone){
	zone.parentElement.onmouseover = function() { AdapteTaille(id, zone);};
}

function AdapteTaille(id, zone){
	if (zone != null && zone.parentElement != null)
	{
		zone.style.display = "";

		zone.style.width = "0px";
		zone.style.height = "0px";

		var parentZone = zone.parentElement;
		if (parentZone.tagName == "TD")
		{
			var parentTR = parentZone;
			while (parentTR != null
				&& parentTR != undefined
				&& (parentTR.tagName != "TR"
				 || !jQuery(parentTR).hasClass("acyeditor_delete")))
			{
				parentTR = parentTR.parentElement;
			}
			if (parentTR != null && parentTR != undefined)
			{
				parentZone = parentTR;
				var zonesTaille = jQuery(parentZone).find(".acyeditor_zoneeditionsuppression");
				for (indexZoneTaille = 0; indexZoneTaille < zonesTaille.length; ++indexZoneTaille)
				{
					if (zonesTaille[indexZoneTaille].id != zone.id)
					{
						zonesTaille[indexZoneTaille].style.display = "none";
					}
				}
			}
		}

		var parent = GetElement(id, parentZone.id);
		var left = parent.offset().left;
		var top = parent.offset().top;
		var widthZone = (parent.outerWidth() - 2);
		var heightZone = (parent.outerHeight());

		if (widthZone >= 0)
		{
			zone.style.width = widthZone + "px";
		}
		if (heightZone >= 0)
		{
			zone.style.height = heightZone + "px";
		}
		zone.style.left = left + "px";
		zone.style.top = top + "px";

		var enfants = zone.getElementsByTagName("*");
		for (i = 0; i < enfants.length; ++i)
		{
			enfants[i].style.display = "block";
			if (enfants[i].tagName == "A")
			{
				enfants[i].style.width = widthZone;
				enfants[i].style.height = heightZone;
			}
		}

		zone.style.borderStyle = "";

		var zoneBoutonEdition = null;
		try
		{
			zoneBoutonEdition = jQuery(zone).find(".acyeditor_zoneboutonedition")[0];
		}
		catch (err)
		{
			var enfantsZone = zone.children;
			for (indexEnfantZone = 0; indexEnfantZone < enfantsZone.length; ++indexEnfantZone)
			{
				if (jQuery(enfantsZone[indexEnfantZone]).hasClass("acyeditor_zoneboutonedition"))
				{
					zoneBoutonEdition = enfantsZone[indexEnfantZone];
				}
			}
		}
		if (zoneBoutonEdition != null && zoneBoutonEdition != undefined)
		{
			var parentReel = GetElement(id, zone.parentElement.id);
			var leftReel = parentReel.offset().left - left;
			var topReel = parentReel.offset().top - top;
			var widthZoneReel = (parentReel.outerWidth() - 2);
			var heightZoneReel = (parentReel.outerHeight() - 2);

			if (widthZoneReel >= 0)
			{
				zoneBoutonEdition.style.width = widthZoneReel + "px";
			}
			if (heightZoneReel >= 0)
			{
				zoneBoutonEdition.style.height = heightZoneReel + "px";
			}
			zoneBoutonEdition.style.left = leftReel + "px";
			zoneBoutonEdition.style.top = topReel + "px";
		}
	}
}

function GetNewId(id) {
	for (i = 1; i < 1000; ++i)
	{
		var identifiant = "zone_" + i;
		if (Existe(id, identifiant) == false)
		{
			return identifiant;
		}
	}
	return null;
}

function Existe(id, itemId){
	var idIframe = id + "_ifr";
	var element = undefined;
	var element2 = undefined;
	try
	{
		element = document.getElementById(itemId);
	}
	catch (err)
	{
	}
	try
	{
		element2 = jQuery('#' + idIframe)[0].contentWindow.document.getElementById(itemId);
	}
	catch (err2)
	{
	}

	return (element != null && element != undefined || element2 != null && element2 != undefined);
}

function GetElement(id, itemId){
	var idIframe = id + "_ifr";
	return jQuery('#' + idIframe).contents().find('#' + itemId);
}

function SetOnClick(id, element){
	element.onclick = function(e) { ClickTemplateCKEditor(id, element.id, e);};
	if (isBrowserIE())
	{
		element.onmousedown = null;
	}
}

var editor;
function ClickTemplateCKEditor(id, idElement, e){
	var idIframe = id + "_ifr";
	ignoreDeselection = false;
	CheckDeselection(id, e)
	var elementToEditJQ = GetElement(id, idElement);
	var elementToEdit = elementToEditJQ[0];
	if (elementToEdit != undefined)
	{
		if (elementToEdit.className.indexOf('nepasediter') < 0)
		{
			var okPourEdition = true;
			var editionEnCours = GetElement(id, 'edition_en_cours');
			if (editionEnCours[0] != null && editionEnCours[0] != undefined)
			{
				if (editor != null && editor != undefined)
				{
					editor.destroy();
					editor = null;
				}
				var editionEnCoursParentJQ = GetElement(id, editionEnCours[0].parentElement.id);
				editionEnCoursParentJQ.removeClass('acyeditor_enedition');
				editionEnCoursParentJQ.addClass('acyeditor_text');
				SetOnClick(id, editionEnCoursParentJQ[0]);
				editionEnCours[0].outerHTML = editionEnCours[0].innerHTML;
				okPourEdition = false;
			}

			if (okPourEdition)
			{
				var zone = GetElement(id, "ZoneEditionSuppression_" + elementToEdit.id);

				elementToEditJQ.removeClass('acyeditor_editablehover');
				zone.removeClass('acyeditor_zoneeditionsuppressionhover');

				if (zone[0] != null && zone[0] != undefined)
				{
					zone.remove();
				}
				var code = elementToEdit.innerHTML;

				var iframeCKEDITOR = jQuery('#' + idIframe)[0].contentWindow.CKEDITOR;

				var headerIFrame = jQuery('#' + idIframe)[0].contentWindow.document;
				headerIFrame = headerIFrame.head || headerIFrame;
				var urlBase = headerIFrame.getElementsByTagName("base")[0].href;

				var borderSize = 1;
				var left = elementToEditJQ.css("padding-left");
				var right = elementToEditJQ.css("padding-right");
				var top = elementToEditJQ.css("padding-top");
				var bottom = elementToEditJQ.css("padding-bottom");
				var leftPad = (elementToEditJQ.css("padding-left").replace("px", "") - borderSize);
				var rightPad = (elementToEditJQ.css("padding-right").replace("px", "") - borderSize);
				var topPad = (elementToEditJQ.css("padding-top").replace("px", "") - borderSize);
				var bottomPad = (elementToEditJQ.css("padding-bottom").replace("px", "") - borderSize);
				leftPad = leftPad < 0 ? 0 : leftPad;
				rightPad = rightPad < 0 ? 0 : rightPad;
				topPad = topPad < 0 ? 0 : topPad;
				bottomPad = bottomPad < 0 ? 0 : bottomPad;
				elementToEdit.innerHTML = "<div id='edition_en_cours' contenteditable='true' style='border:solid " + borderSize + "px orange;padding:" + topPad + "px " + rightPad + "px " + bottomPad + "px " + leftPad + "px;margin:-" + top + " -" + right + " -" + bottom + " -" + left + ";color:inherit;background:inherit;font:inherit;text-indent:inherit;text-decoration:inherit;text-transform:inherit;text-justify:inherit;text-kashida-space:inherit;text-overflow:inherit;text-shadow:inherit;text-underline-position:inherit;unicode-bidi:inherit;word-spacing:inherit;writing-mode:inherit;word-break:inherit;word-wrap:inherit;zoom:inherit;marker-offset:inherit;marks:inherit;quotes:inherit;table-layout:inherit;text-align-last:inherit;text-autospace:inherit;outline:inherit;overflow:inherit;min-height:inherit;max-height:inherit;line-break:inherit;letter-spacing:inherit;layout-flow:inherit;layout-grid:inherit;line-height:inherit;white-space:inherit;text-align:inherit;direction:inherit;list-style:inherit;float:inherit;ime-mode:inherit;layer-background-color:inherit;layer-background-image:inherit;filter:inherit;behavior:inherit;position:inherit;clear:inherit;clip:inherit;cursor:inherit;vertical-align:inherit'>" + code + "</div><div id='bottom' style='width:" + largeurMenuInline + "px;position:absolute'></div>";
				iframeCKEDITOR.disableAutoInline = true;

				var extraPluginsCKEditor = 'sharedspace';
				var toolbarGroupsCKEditor = [{ name: 'mode' },
											 { name: 'undo' },
											 { name: 'links' }];
				if (!acyeditor_listmode && isTagAllowed)
				{
					extraPluginsCKEditor += ',addtag';
					toolbarGroupsCKEditor.push({ name: 'insert', items: [ "addtag", "image" ]});
				}
				else
				{
					toolbarGroupsCKEditor.push({ name: 'insert', items: [ "image" ]});
				}
				toolbarGroupsCKEditor.push({ name: 'basicstyles' },
											{ name: 'colors' },
											'/',
											{ name: 'paragraph',   groups: [ 'list', 'indent', 'blocks' ] },
											{ name: 'align' },
											{ name: 'styles' });
				if (acyeditor_templatemode)
				{
					toolbarGroupsCKEditor.push({ name: 'templatemode', items: [ "textarea", "picturearea", "deletearea", "-", "showarea" ] });
				}

				var elementEditor = GetElement(id, "edition_en_cours")[0];
				var xEditor = elementEditor.offsetLeft;
				var yEditor = elementEditor.offsetTop;
				var parentOffset = elementEditor.offsetParent;
				while (parentOffset != null && parentOffset != undefined)
				{
					xEditor = xEditor + parentOffset.offsetLeft;
					yEditor = yEditor + parentOffset.offsetTop;
					parentOffset = parentOffset.offsetParent;
				}
				var largeurEditor = elementEditor.clientWidth;
				var newX = ((largeurEditor - largeurMenuInline) / 2);
				if (newX + largeurMenuInline > window.outerWidth)
				{
					newX = window.outerWidth - largeurMenuInline;
				}
				else if (newX + xEditor < 0)
				{
					newX = 0;
				}
				GetElement(id, 'bottom')[0].style.marginLeft = newX + "px";
				GetElement(id, 'bottom')[0].style.marginTop = (((GetElement(id, 'edition_en_cours').css("margin-bottom").replace("px", "") - 1) + 1) * -1) + "px";

				var topValue = "";
				if (yEditor < 70)
				{
					topValue = "bottom";
				}

				editor = iframeCKEDITOR.inline('edition_en_cours',
				{
					toolbarGroups: toolbarGroupsCKEditor,
					removeButtons: 'Cut,Copy,Paste,Blockquote,RemoveFormat,Subscript,Superscript,Table,HorizontalRule,SpecialChar,Font,Symbol',
					filebrowserImageUploadUrl : urlBase + urlAcyeditor + 'kcfinder/upload.php?type=images',
					extraPlugins: extraPluginsCKEditor,
					floatSpaceDockedOffsetX : newX,
					sharedSpaces: { top: topValue }
				});

				editor.on('instanceReady',function(){
					var zoneEdition = GetElement(id, "edition_en_cours");
					zoneEdition[0].title = "";

					editor.on('change',function(e){ CleanEditorContent(id, e); IeCursorFix(); });
					GetElement(id, "edition_en_cours")[0].onkeyup = function () { IeCursorFix(); };
					GetElement(id, "edition_en_cours")[0].onclick = function () { IeCursorFix(); };
					GetElement(id, "edition_en_cours")[0].onpaste = function(e){ CleanWord(e); IeCursorFix(); };
					rangeIE = undefined;
					IeCursorFix();

					editor.on('selectionChange', function(e) { IECursorFix(); });
					editor.on('change', function(e) { ResizeIframe(id); });

					try
					{
						GetElement(id, "cke_edition_en_cours").find(".cke_inner .cke_toolbar .cke_button__bold")[0].click();
						GetElement(id, "cke_edition_en_cours").find(".cke_inner .cke_toolbar .cke_button__bold")[0].click();
					}
					catch (e)
					{
						eval(GetElement(id, "cke_edition_en_cours").find(".cke_inner .cke_toolbar .cke_button__bold")[0].onclick);
						eval(GetElement(id, "cke_edition_en_cours").find(".cke_inner .cke_toolbar .cke_button__bold")[0].onclick);
					}
					editor.resetUndo();
				});

				if (zone[0] != null && zone[0] != undefined)
				{
					elementToEdit.appendChild(zone[0]);
				}
				elementToEditJQ.removeClass('acyeditor_text');
				setTimeout(function() {
					elementToEditJQ.addClass('acyeditor_enedition');

					var inlineMenu = GetElement(id, "cke_edition_en_cours")[0];
					if (inlineMenu != undefined && inlineMenu != null)
					{
						inlineMenu.onclick = function() { IgnoreDeselection(id); };
						if (isBrowserIE())
						{
							inlineMenu.onmousedown = function (e) { IgnoreDeselection(id) };
						}
					}
				}, 200);

				elementToEdit.onclick = function (e) { IgnoreDeselection(id) };
				if (isBrowserIE())
				{
					elementToEdit.onmousedown = function (e) { IgnoreDeselection(id) };
				}
			}
		}
		else
		{
			elementToEditJQ.removeClass('nepasediter');
		}
	}
}

function CleanWord(e){

	var contenu = "";
	if (e.clipboardData) {
		var text = e.clipboardData.getData('text/plain');
		var url = e.clipboardData.getData('text/uri-list');
		var html = e.clipboardData.getData('text/html');
		contenu = text;
		if (url !== undefined) {
			contenu = url;
		}
		if (html !== undefined) {
			contenu = html;
		}
	}

	if (window.clipboardData) {
		var text = window.clipboardData.getData('Text');
		var url = window.clipboardData.getData('URL');
		contenu = text;
		if (url !== null) {
			contenu = url;
		}
	}

	if (contenu != "")
	{
		e.preventDefault(true);
	}

	var debut = contenu.indexOf("<!--StartFragment-->") + 20;
	var fin = contenu.indexOf("<!--EndFragment-->");
	if (debut < 20)
	{
		debut = 0;
	}
	if (fin < 0)
	{
		fin = contenu.length;
	}
	contenu = contenu.substring(debut, fin)
	editor.fire( 'paste', { type: 'html', dataValue:  contenu } )
}

var ignoreDeselection = false;
function IgnoreDeselection(id)
{
	ignoreDeselection = true;

	setTimeout(function() {
		var popups = jQuery('#' + id + '_ifr').contents().find('.cke_editor_edition_en_cours_dialog');
		if (popups != undefined && popups != null)
		{
			for (indexPopup = 0; indexPopup < popups.length; ++ indexPopup)
			{
				if (popups[indexPopup].style.display != "none")
				{
					popups[indexPopup].onclick = function () { IgnoreDeselection(id); };
				}
			}
		};
	}, 200);
}

function SetIgnoreDeselection()
{
	ignoreDeselection = true;
}

function CheckDeselection(id, e){
	var idIframe = id + "_ifr";
	var div = document.getElementsByTagName('body')[0];
	if (e != null && e != undefined)
	{
		div = e.srcElement? e.srcElement : (e.target ? e.target : e);
	}

	var parentElement = div;
	var acyeditor_enedition = false;
	while (parentElement != null && parentElement != undefined)
	{
		if (parentElement.className.indexOf('acyeditor_enedition') >= 0
		 || parentElement.id == boutonTags
		 || ClickSurPopup(parentElement))
		{
			acyeditor_enedition = true;
		}
		if (parentElement.parentElement == null && parentElement.tagName != "HTML")
		{
			acyeditor_enedition = true;
		}
		parentElement = parentElement.parentElement;
	}
	if (!acyeditor_enedition)
	{
		ValidationModifications(id);
	}
	else
	{
		ignoreDeselection = false;
	}
}

function ClickSurPopup(element){
	return (element.className.indexOf('cke_dialog_body') >= 0
		 || element.className.indexOf('cke_dialog_background_cover') >= 0
		 || element.id == 'cke_edition_en_cours');
}

function CleanEditorContent(id, e){
	var idIframe = id + "_ifr";
	var code = (editor != null && editor != undefined) ? editor.getData() : "";
	var fauxDiv = jQuery('#' + idIframe)[0].contentWindow.document.createElement("div");
	fauxDiv.innerHTML = code;
	code = fauxDiv.innerHTML;
	var enfantsFauxDiv = fauxDiv.getElementsByTagName("*");
	for (indexEnfantsFauxDiv = 0; indexEnfantsFauxDiv < enfantsFauxDiv.length; ++indexEnfantsFauxDiv)
	{
		if (enfantsFauxDiv[indexEnfantsFauxDiv].className != "")
		{
			jQuery(enfantsFauxDiv[indexEnfantsFauxDiv]).removeClass("acyeditor_delete");
			jQuery(enfantsFauxDiv[indexEnfantsFauxDiv]).removeClass("acyeditor_picture");
			jQuery(enfantsFauxDiv[indexEnfantsFauxDiv]).removeClass("acyeditor_text");
			if (jQuery(enfantsFauxDiv[indexEnfantsFauxDiv]).hasClass("acyeditor_zoneeditionsuppression"))
			{
				enfantsFauxDiv[indexEnfantsFauxDiv].outerHTML = "";
			}
		}
		if (Existe(id, enfantsFauxDiv[indexEnfantsFauxDiv].id))
		{
			enfantsFauxDiv[indexEnfantsFauxDiv].removeAttribute("id");
		}
	}

	if (fauxDiv.innerHTML != code)
	{
		editor.setData(fauxDiv.innerHTML);
	}
}

function ValidationModifications(id){
	if (ignoreDeselection == false)
	{
		if (!isJoomla3
		 || !(isBrowserIE7() || isBrowserIE8()))
		{
			rangeIE = undefined;
		}
		var idIframe = id + "_ifr";
		var elementJQ = jQuery('#' + idIframe).contents().find('.acyeditor_enedition');
		var element = elementJQ[0];
		if (element != null && element != undefined)
		{
			var popup = false;
			var popups = jQuery('#' + idIframe).contents().find('.cke_editor_edition_en_cours_dialog');
			if (popups != undefined && popups != null)
			{
				for (indexPopup = 0; indexPopup < popups.length; ++ indexPopup)
				{
					if (popups[indexPopup].style.display != "none")
					{
						popup = true;
					}
				}
			};
			if (popup == false)
			{
				var code = "";
				if (editor != null && editor != undefined)
				{
					code = editor.getData();
					editor.destroy();
					editor = null;
					var zone = GetElement(id, "ZoneEditionSuppression_" + element.id);
					if (zone != null && zone != undefined)
					{
						zone.remove();
					}
					element.innerHTML = code;
					if (zone[0] != null && zone[0] != undefined)
					{
						element.appendChild(zone[0]);
					}
				}
				elementJQ.removeClass('acyeditor_enedition');
				elementJQ.addClass('acyeditor_text');
				SetOnClick(id, element);
				AdapteTaille(id, zone);

				Sauvegarde(id);
			}
		}
	}
	else
	{
		ignoreDeselection = false;
	}
}

function Sauvegarde(id)
{
	var idIframe = id + "_ifr";
	var newNoeud = jQuery('#' + idIframe)[0].contentWindow.document.body.cloneNode(true);
	var elements = newNoeud.getElementsByTagName('*');
	for (i = 0; i < elements.length; ++i)
	{
		if (jQuery(elements[i]).hasClass("acyeditor_zoneeditionsuppression"))
		{
			elements[i].outerHTML = "";
			i = i - 1;
		}
	}
	jQuery('#' + id)[0].value = newNoeud.innerHTML;
}



function SetTitleTemplate(onlyRemove){
	if (acyeditor_templatemode)
	{
		var iframe = jQuery('#edition_en_cours')[0].parentElement.getElementsByTagName("iframe")[0];
		iframe = jQuery(iframe);

		if (iframe[0] != undefined)
		{
			var allZones = iframe[0].contentWindow.document.getElementsByTagName("*");
			for (indexZone = 0; indexZone < allZones.length; ++indexZone)
			{
				jQuery(allZones[indexZone]).removeAttr("title");
			}

			if (onlyRemove != true)
			{
				var zonesDelete = iframe.contents().find(".acyeditor_delete");
				for (indexZone = 0; indexZone < zonesDelete.length; ++indexZone)
				{
					zonesDelete[indexZone].title = tooltipTemplateDelete;
					if (isBrowserIE())
					{
						var children = zonesDelete[indexZone].getElementsByTagName("*");
						for (indexchild = 0; indexchild < children.length; ++indexchild)
						{
							children[indexchild].title = zonesDelete[indexZone].title;
						}
					}
				}
				var zonesTexte = iframe.contents().find(".acyeditor_text");
				for (indexZone = 0; indexZone < zonesTexte.length; ++indexZone)
				{
					zonesTexte[indexZone].title = tooltipTemplateText;
					if (isParentSupprimable(zonesTexte[indexZone]))
					{
						zonesTexte[indexZone].title =  tooltipTemplateText + "\r\n" + tooltipTemplateDelete;
					}
					if (isBrowserIE())
					{
						var children = zonesTexte[indexZone].getElementsByTagName("*");
						for (indexchild = 0; indexchild < children.length; ++indexchild)
						{
							children[indexchild].title = zonesTexte[indexZone].title;
						}
					}
				}
				var zonesPicture = iframe.contents().find(".acyeditor_picture");
				for (indexZone = 0; indexZone < zonesPicture.length; ++indexZone)
				{
					zonesPicture[indexZone].title = tooltipTemplatePicture;
					if (isParentSupprimable(zonesPicture[indexZone]))
					{
						zonesPicture[indexZone].title = tooltipTemplatePicture + "\r\n" + tooltipTemplateDelete;
					}
					if (isBrowserIE())
					{
						var children = zonesPicture[indexZone].getElementsByTagName("*");
						for (indexchild = 0; indexchild < children.length; ++indexchild)
						{
							children[indexchild].title = zonesPicture[indexZone].title;
						}
					}
				}
			}
		}
	}
}

function SetStateForSelection(){
	if (acyeditor_templatemode)
	{
		var alltemplatebuttons = jQuery(".boutontemplate_text");
		for (indexTemplateButton = 0;indexTemplateButton < alltemplatebuttons.length; ++indexTemplateButton)
		{
			SetStateForSelectionForClasse(jQuery(alltemplatebuttons[indexTemplateButton]), "acyeditor_text");
		}
		alltemplatebuttons = jQuery(".boutontemplate_picture");
		for (indexTemplateButton = 0;indexTemplateButton < alltemplatebuttons.length; ++indexTemplateButton)
		{
			SetStateForSelectionForClasse(jQuery(alltemplatebuttons[indexTemplateButton]), "acyeditor_picture");
		}
		alltemplatebuttons = jQuery(".boutontemplate_delete");
		for (indexTemplateButton = 0;indexTemplateButton < alltemplatebuttons.length; ++indexTemplateButton)
		{
			SetStateForSelectionForClasse(jQuery(alltemplatebuttons[indexTemplateButton]), "acyeditor_delete");
		}
	}
}

function SetStateForSelectionForClasse(item, classe){
	var acyframe = jQuery('#edition_en_cours')[0].parentElement.getElementsByTagName("iframe")[0];
	var node = null;
	if (isBrowserIE())
	{
		node = GetParentForClass(anchorNodeIE, classe);
	}
	else if (acyframe != null
			&& acyframe != undefined
			&& acyframe.contentWindow != null
			&& acyframe.contentWindow != undefined
			&& acyframe.contentWindow.getSelection)
	{
		var sel = acyframe.contentWindow.getSelection();
		if (sel.anchorNode) {
			node = GetParentForClass(sel.anchorNode, classe);
		}
	}

	item.removeClass("cke_button_on");
	item.removeClass("cke_button_off");
	if (node != null && node != undefined)
	{
		item.removeClass("cke_button_disabled");
		if (jQuery(node).hasClass(classe))
		{
			item.addClass("cke_button_on");
		}
		else
		{
			item.addClass("cke_button_off");
		}
	}
	else if (!item.hasClass("cke_button_disabled"))
	{
		item.addClass("cke_button_disabled");
	}
}

function GetParentForClass(item, classe){
	var parent = item;
	while (parent != null && parent != undefined)
	{
		var elementModifiables = jQuery(parent).find(".acyeditor_delete, .acyeditor_text, .acyeditor_picture").length;
		if (jQuery(parent).find(".acyeditor_delete, .acyeditor_text, .acyeditor_picture").length > 0)
		{
			var tdEditableTotaux = jQuery(parent).find("td.acyeditor_text, td.acyeditor_picture").length;
			var tdEditable = jQuery(parent).find("table td.acyeditor_text, table td.acyeditor_picture").length;
			if (parent.tagName != "TR"
			 || classe != "acyeditor_delete"
			 || elementModifiables != tdEditableTotaux
			 || tdEditable != 0)
			{
				parent = null;
			}
		}
		if (parent != null
		 && (parent.tagName == "DIV"
			|| parent.tagName == "TABLE"
			|| parent.tagName == "TR"
			&& classe == "acyeditor_delete"
			|| parent.tagName == "TD"
			&& classe != "acyeditor_delete"))
		{
			var vraiParent = parent != null ? parent.parentElement || parent.parentNode : null;
			while (vraiParent != null && vraiParent != undefined)
			{
				if (parent.tagName == "TD"
				 && vraiParent.tagName == "TR"
				 && jQuery(vraiParent).hasClass("acyeditor_delete"))
				{
					return parent;
				}
				if (jQuery(vraiParent).hasClass("acyeditor_delete")
				 || jQuery(vraiParent).hasClass("acyeditor_text")
				 || jQuery(vraiParent).hasClass("acyeditor_picture"))
				{
					return vraiParent;
				}
				vraiParent = vraiParent != null ? vraiParent.parentElement || vraiParent.parentNode : null;
			}

			return parent;
		}
		parent = parent != null ? parent.parentElement || parent.parentNode : null;
	}
	return parent;
}

function isParentSupprimable(element){
	var supprimable = false;
	var parent = element;
	while (parent != null && parent != undefined)
	{
		if (parent.className != null && parent.className != undefined && parent.className.indexOf("acyeditor_delete") >= 0)
		{
			supprimable = true;
		}
		parent = parent.parentElement || parent.parentNode;
	}
	return supprimable;
}

function AddRemoveTemplateCss(){
	if (acyeditor_templatemode)
	{
		ShowTemplateCss(!IsTemplateCssShown());
	}
}

function IsTemplateCssShown(){
	if (acyeditor_templatemode)
	{
		var boutonShow = jQuery(".boutontemplate_show")[0];
		if (boutonShow != null
		 && boutonShow != undefined
		 && boutonShow.className != null
		 && boutonShow.className != undefined
		 && boutonShow.className.indexOf("cke_button_on") >= 0)
		{
			return true;
		}
	}
	return false;
}

function ShowTemplateCss(show){
	if (acyeditor_templatemode)
	{
		var iframe = jQuery('#edition_en_cours')[0].parentElement.getElementsByTagName("iframe")[0];
		iframe = jQuery(iframe);
		var boutonShow = jQuery(".boutontemplate_show")[0];
		templateShown = show;

		if (!show)
		{
			var link = iframe.contents().find("#AcyTemplateCss")[0];
			if (link != null
			 && link != undefined)
			{
				jQuery(link).remove();
			}
			SetTitleTemplate(true);

			jQuery(boutonShow).removeClass("cke_button_on");
			jQuery(boutonShow).addClass("cke_button_off");
		}
		else
		{
			var headEditor = iframe[0].contentWindow.document;
			headEditor = headEditor.head || headEditor;
			var base = headEditor.getElementsByTagName("base")[0];
			var link1 = document.createElement("link");
			link1.type = "text/css";
			link1.rel = "stylesheet";
			link1.id = "AcyTemplateCss";
			link1.href =  base.href + urlAcyeditor + "css/acyeditor_template.css" + "?time=" + Date.now();
			headEditor.appendChild(link1);
			SetTitleTemplate();

			jQuery(boutonShow).removeClass("cke_button_off");
			jQuery(boutonShow).addClass("cke_button_on");
		}
	}
}

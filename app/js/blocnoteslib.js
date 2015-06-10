/**
 * 
 * Functions for manipulate items in the browser view.blocnoteslib.js
 * */
 
 function onAssembleOption()
 {
     
 }
 
 function allowDrop(ev) {
    ev.preventDefault();
}

function drag(ev, id) {
    ev.dataTransfer.setData("child", id);
/*
  var canvas = document.createElementNS("http://www.w3.org/1999/xhtml","canvas");
  canvas.width = canvas.height = 60;

  var ctx = canvas.getContext("2d");
  ctx.lineWidth = 4;
  ctx.moveTo(-25+25, -25+25);
  ctx.lineTo(-25+25, 25+25);
  ctx.lineTo(25+25, 25+25);
  ctx.lineTo(25+25, -25+25);
  ctx.stroke();

  ev.dataTransfer.setDragImage(canvas, 60, 60);
*/
}
function drop(event, id)
{
    event.preventDefault();
    id1 = event.dataTransfer.getData("child");
    id2 = id;
    alert("Ma note "+id1+" sur ma note "+id2);
}

function allowDrop(ev) {
    ev.preventDefault();
}

function drag(ev) {
    ev.dataTransfer.setData("text", ev.target.id);
}

function copyId(text) {
    if (window.clipboardData) { // Internet Explorer
        window.clipboardData.setData("Text", text);
    }
}
function doNoteAction(note_id, selectedIndex)
{
    //alert("ID: "+note_id+" Index menu: " + selectedIndex + "ACTION (TODO)");
    if(selectedIndex==1)
    {
        document.location.href = "page.xhtml.php?composant=reader.db&dbdoc="+note_id;
    }
    else if(selectedIndex==2)
    {
        document.location.href = "page.xhtml.php?composant=edit.db&dbdoc="+note_id;
                }
    else if(selectedIndex==3) // Move
    {
        document.location.href = "page.xhtml.php?composant=move.db&dbdoc="+note_id;
    }
    else if(selectedIndex==4) // Copier
    {
        alert("Copier pas encore autorisé");
        //document.location.href = "page.xhtml.php?composant=move.db&dbdoc="+note_id;
    }
    else if(selectedIndex==5) // Coller
    {
        alert("Coller pas encore autorisé");
        //document.location.href = "page.xhtml.php?composant=move.db&dbdoc="+note_id;
    }
    else if(selectedIndex==6) // Corbeille
    {
        if (confirm("L'élément va être supprimé. Confirmer?")) {
    document.location.href = "page.xhtml.php?composant=delete.db&dbdoc="+note_id;
    } else {
     alert ("Suppression annulée.")
  }
    }
    else if(selectedIndex==7) // Faire suite
    {
        document.location.href = "page.xhtml.php?composant=follow.db&dbdoc="+note_id;
    }
    else if(selectedIndex==8) // Vers presse-papier
    {
        copyId(note_id);
    }
 
        
}


function copyToClipboardIE1(sText)
	{
		window.clipboardData.setData('Text', sText);
		return false;
	}	
	function copyToClipboardFF(sText)
	{
		try
		{
			netscape.security.PrivilegeManager.enablePrivilege("UniversalXPConnect");
		}
		catch (e)
		{
			alert("Impossible d'accéder au presse-papier.");
		}		
		var gClipboardHelper =
			Components.classes["@mozilla.org/widget/clipboardhelper;1"]
			.getService(Components.interfaces.nsIClipboardHelper);		
		gClipboardHelper.copyString(sText);
			return false;
	}	
	function copyclipboard(sText)
	{		
		if (window.clipboardData)
		{
			return copyToClipboardIE1(sText);
		}
		else if (typeof(netscape) == 'object' && typeof(Components) == 'object')
		{
			return copyToClipboardFF(sText);
		}
		else
		{
			alert("Cette fonctionnalité n'est pas disponible pour votre navigateur.");
		}
		return false;
	}
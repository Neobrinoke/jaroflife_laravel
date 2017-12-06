$('.ui.dropdown').dropdown();
$('table.sortable').tablesort();

function onConfirmNotif( text, link )
{
	if( confirm( text ) ) {
		location.href = link;
	}
}
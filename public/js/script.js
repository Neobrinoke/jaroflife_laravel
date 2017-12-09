$('.ui.dropdown').dropdown();
$('.ui.checkbox').checkbox();
$('table.sortable').tablesort();

$('.ui.message .close').on('click', function() {
	$(this).closest('.message').transition('fade');
});

function onConfirmNotif( text, link )
{
	if( confirm( text ) ) {
		location.href = link;
	}
}
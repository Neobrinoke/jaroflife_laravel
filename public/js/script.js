$('.ui.dropdown').dropdown();
$('.ui.checkbox').checkbox();
$('table.sortable').tablesort();

$('.ui.modal.error').modal({blurring: true}).modal('show');

$('.ui.message .close').on('click', function() {
	$(this).closest('.message').transition('fade');
});

function onConfirmNotif( text, link )
{
	if( confirm( text ) ) {
		location.href = link;
	}
}
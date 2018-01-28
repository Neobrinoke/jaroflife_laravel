<?php

use Illuminate\Support\HtmlString;

function sendMessage( string $type, ?string $message, array $options = [] )
{
	$result = '
	<div class="ui ' . $type . ' message">';
	if( isset( $options['header_message'] ) )
	{
		$result .= '<div class="header">' . $options['header_message'] . '</div>';
	}
	if( isset( $options['closable'] ) )
	{
		$result .= '<i class="close icon"></i>';
	}
	$result .= '
		<p>' . $message . '</p>
	</div>';

	return new HtmlString( $result );
}

function sendMessages( string $type, array $messages, array $options = [] )
{
	$result = '
	<div class="ui ' . $type . ' message">';
	if( isset( $options['header_message'] ) )
	{
		$result .= '<div class="header">' . $options['header_message'] . '</div>';
	}
	if( isset( $options['closable'] ) )
	{
		$result .= '<i class="close icon"></i>';
	}
	$result .= '
		<ul class="list">';
	foreach( $messages as $message )
	{
		$result .= '<li>' . $message . '</li>';
	}
	$result .= '
		</ul>
	</div>';

	return new HtmlString( $result );
}
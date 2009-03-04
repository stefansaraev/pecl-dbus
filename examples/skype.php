<?php
$d = new Dbus( Dbus::BUS_SESSION, true );
$n = new DbusObject( $d, "com.Skype.API", "/com/Skype", "com.Skype.API");
var_dump( $n->Invoke( "NAME PHP" ) );
var_dump( $n->Invoke( "PROTOCOL 7" ) );
$chatId = $n->Invoke( "CHAT CREATE richardcjfoster" );
list( $ignore, $id, $stuff, $stuff2 ) = split( " ", $chatId[0] );
var_dump( $n->Invoke( "OPEN CHAT $id" ) );
/*
while ( true )
{
	var_dump( $r = $n->Invoke( "GET CHAT $id CHATMESSAGES" ) );
	$r = $n->Invoke( "GET CHAT $id RECENTCHATMESSAGES" );
	list( $ignore, $dummy, $dummy, $messageIds ) = split( ' ', $r[0], 4 );
	foreach( split( ", ", $messageIds ) as $messageId )
	{
		$data = $n->Invoke( "GET CHATMESSAGE $messageId FROM_HANDLE" );
		list( $a, $b, $c, $name ) = split( ' ', $data[0], 4 );
		$data = $n->Invoke( "GET CHATMESSAGE $messageId BODY" );
		list( $a, $b, $c, $body ) = split( ' ', $data[0], 4 );
		echo $name, ": ", $body, "\n";
		$n->Invoke( "SET CHATMESSAGE $messageId SEEN" );
	}
	sleep( 30 );
}*/

class testClass {
	static function notify($a) {
		global $n;

		var_dump( $a );
		list( $a, $b, $c ) = split( ' ', $a, 3 );
		if ( $a === "CHATMESSAGE" )
		{
			$data = $n->Invoke( "GET CHATMESSAGE $b BODY" );
			list( $a, $b, $c, $body ) = split( ' ', $data[0], 4 );
			echo $body, "\n";
		}
	}
}

$d->registerObject( '/com/Skype/Client', 'com.Skype.API.Client', 'testClass' );

do {
	$s = $d->waitLoop( 1000 );
}
while ( true );

?>


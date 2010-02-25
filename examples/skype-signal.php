<?php
$d = new Dbus( Dbus::BUS_SESSION, true );
$n = $d->createProxy( "com.Skype.API", "/com/Skype", "com.Skype.API");
var_dump( $n->Invoke( "NAME PHP" ) );
var_dump( $n->Invoke( "PROTOCOL 7" ) );
$chatId = $n->Invoke( "CHAT CREATE {$argv[1]}" );
list( $ignore, $id, $stuff, $stuff2 ) = explode( " ", $chatId );
var_dump( $id );
var_dump( $n->Invoke( "OPEN CHAT $id" ) );

class testClass {
	static function notify($a) {
		global $n;

		@list( $a, $b, $c, $d ) = explode( ' ', $a, 4 );

		if ( $a === "CHATMESSAGE" && in_array( $d, array( 'READ', 'SENT' ) ) )
		{
			$data = $n->Invoke( "GET CHATMESSAGE $b BODY" );
			list( $a, $b, $c, $body ) = explode( ' ', $data, 4 );
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

<?php
$d = new Dbus( Dbus::BUS_SESSION, true );
$d->requestName( 'nl.derickrethans.test' );

class testClass
{
	static function echoOne( $a )
	{
		return $a;
	}
}

$d->registerObject( '/nl/derickrethans/test', NULL, 'testClass' );

do
{
	$s = $d->waitLoop( 1000 );
	echo ".";
}
while (true );
?>

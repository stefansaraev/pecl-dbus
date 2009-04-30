<?php
$d = new Dbus( Dbus::BUS_SESSION, true );
$d->requestName( 'nl.derickrethans.test' );

class testClass
{
	static function echoZero()
	{
	}

	static function echoOne( $a )
	{
		return $a;
	}

	static function echoTwo( $a, $b )
	{
		return new DbusSet( $a, $b );
	}
}

$d->registerObject( '/nl/derickrethans/test', 'nl.derickrethans.test', 'testClass' );

do
{
	$s = $d->waitLoop( 1000 );
	echo ".";
}
while (true );
?>

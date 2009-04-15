<?php
$d = new Dbus( Dbus::BUS_SESSION, true );
$d->requestName( 'nl.derickrethans.test' );

class testClass {
	static function myFirstMethod($a, $b, $c, $d) {
		var_dump("yay", $a, $b, $c, $d );
		$r = new DbusSet( $a, $b, $c, $d );
		return $r;
	}

	static function dictMethod( $a = null )
	{
		var_dump( $a );
		return new DbusSet( $a );
	}
}

$d->registerObject( '/nl/derickrethans/test', 'nl.derickrethans.test', 'testClass' );
$d->registerObject( '/nl/derickrethans/test', 'nl.derickrethans.test3', 'doesNotExist' );

//$n = new DbusObject( $d, "org.gnome.ScreenSaver", "/org/gnome/ScreenSaver", "org.gnome.ScreenSaver");
//var_dump($n->GetActive());
do
{
	$s = $d->waitLoop( 1000 );
}
while (true );
?>

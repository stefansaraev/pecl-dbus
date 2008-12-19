<?php
$d = new Dbus( Dbus::BUS_SESSION, true );
$d->requestName( 'nl.derickrethans.test' );

class testClass {
	static function myFirstMethod($a, $b, $c, $d) {
		echo "yay $a $b $c $d\n";
		$r = new DbusSet( $a, $b, $c, $d );
		return $r;
	}
}

$d->registerObject( '/nl/derickrethans/test', 'nl.derickrethans.test', 'testClass' );

$n = new DbusObject( $d, "org.gnome.ScreenSaver", "/org/gnome/ScreenSaver", "org.gnome.ScreenSaver");
var_dump($n->GetActive());
do
{
	$s = $d->waitLoop( 1000 );
	if ( $s ) {
		echo "signal seen\n";
		var_dump( $s->getData() );
	}
	if ( $s && $s->matches( "org.freedesktop.PowerManagement.Backlight", 'BrightnessChanged' ) )
	{
		$b = $s->getData();
	}
	echo ".";
}
while (true );
?>

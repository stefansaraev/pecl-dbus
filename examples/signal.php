<?php
$d = new Dbus;
$d->addWatch( 'org.freedesktop.Notifications' );
$d->addWatch( 'org.freedesktop.PowerManagement.Backlight' );
$d->addWatch( 'im.pidgin.purple.PurpleInterface' );

$b = 0;

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
while ( $b < 100 );
?>

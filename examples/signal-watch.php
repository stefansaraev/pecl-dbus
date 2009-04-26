<?php
$d = new Dbus;
$d->addWatch( 'org.freedesktop.PowerManagement.Backlight' );
$d->addWatch( 'nl.derickrethans.Interface' );

$b = 0;

do
{
	$s = $d->waitLoop( 1000 );
	if ( $s && $s->matches( "org.freedesktop.PowerManagement.Backlight", 'BrightnessChanged' ) )
	{
		$b = $s->getData();
		echo "Brightness: {$b[0]}\n";
	}
	else if ( $s && $s->matches( 'nl.derickrethans.Interface', 'TestSignal' ) )
	{
		var_dump( $s->getData() );
	}
}
while ( $b[0] < 100 );
?>

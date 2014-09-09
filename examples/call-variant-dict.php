<?php
$d = new Dbus( Dbus::BUS_SESSION, true );
$n = $d->createProxy( "nl.derickrethans.test", "/nl/derickrethans/test", "nl.derickrethans.test");

$d = new DBusVariant(
	new DBusDict(DBus::VARIANT,
		array(
			"Method" => new DBusVariant("manual"),
			"Address" => new DBusVariant("192.168.1.223"),
		)
	),
	"a{sv}"
);
var_dump( $d );
var_dump( $n->echoOne( $d ) );
?>

<?php
$d = new Dbus( Dbus::BUS_SESSION, true );
$n = $d->createProxy( "nl.derickrethans.test", "/nl/derickrethans/test", null);

$d = new DBusArray(
	DBus::STRUCT,
	array(
		new DBusStruct(
			"",
			array( 
				42, "foo", 
				new DBusDict( DBus::VARIANT,
					array( new DBusVariant( "oine" ), new DBusVariant( false ) )
				),
			)
		),
		new DBusStruct(
			"",
			array( 
				43, "foo", 
				new DBusDict( DBus::VARIANT,
					array( new DBusVariant( 40 ), new DBusVariant( 53 ) )
				),
			)
		),
	),
	"(isa{sv})"
);
var_dump( $d );
var_dump( $n->echoOne( $d ) );
?>

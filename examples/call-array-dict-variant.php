<?php
$d = new Dbus( Dbus::BUS_SESSION, true );
$n = $d->createProxy( "nl.derickrethans.test", "/nl/derickrethans/test", "nl.derickrethans.test");

$d = new DBusArray(
	DBus::STRUCT,
	array(
		new DBusStruct(
			"",
			array( 
				42, "foo", 
				new DBusDict( DBus::VARIANT,
					array( "foo" => new DBusVariant( "oine" ), "foo2" => new DBusVariant( false ) )
				),
			)
		),
		new DBusStruct(
			"",
			array( 
				43, "foo", 
				new DBusDict( DBus::VARIANT,
//					array( "foo3" => new DBusVariant( 40 ), "foo4" => new DBusVariant( 53 )
					array()
				),
			)
		),
	),
	"(isa{sv})"
);
var_dump( $d );
var_dump( $n->echoOne( $d ) );
?>

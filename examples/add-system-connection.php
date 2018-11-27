<?php
$d = new Dbus( Dbus::BUS_SYSTEM, true );
$n = $d->createProxy( "org.freedesktop.NetworkManager", "/org/freedesktop/NetworkManager/Settings", "org.freedesktop.NetworkManager.Settings");
$args = new DBusDict( DBus::STRUCT,
	array(
		'connection' => new DBusDict( DBus::VARIANT,
			array(
				'id' => new DBusVariant( "PHP Added Network Connection" ),
				'uuid' => new DBusVariant( "06bd5fb0-45f1-0bb0-7ffb-5f3ed6edd604" ),
				'type' => new DBusVariant( "802-3-ethernet" )
			)
		),
		'802-3-ethernet' => new DBusDict( DBus::VARIANT,
			array(
				'mtu' => new DBusVariant( 1444 )
			)
		)
	),
	'{sa{sv}}'
);

$n->AddConnection( $args );
?>

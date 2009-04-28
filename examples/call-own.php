<?php
$d = new Dbus( Dbus::BUS_SESSION, true );
$n = $d->createProxy( "nl.derickrethans.test", "/nl/derickrethans/test", "nl.derickrethans.test");
/*var_dump( $n->myFirstMethod( new DBusInt32( 8 ), new DBusVariant( new DBusUint64( 9 ) ), 5.44, false ) );
var_dump( $n->dictMethod( new DBusDict( DBus::VARIANT, array( "x" => new DBusVariant( "foo") , "y" => new DBusVariant( "bar" ), "z" => new DBusVariant( new DBusUint64( 5123 ) ) ) ) ) );
var_dump( $n->dictMethod( new DBusDict( DBus::STRING, array( "x" => "foo" , "y" => "bar", "z" => "5123" ) ) ) );
var_dump( $n->dictMethod( array( "one" => DBus::STRING, "two" => array( "x" => "foo" , "y" => "bar", "z" => "5123" ) ) ) );
var_dump( $n->dictMethod( new DBusArray( DBus::STRING, array( "foo", "bar" ))));
var_dump( $n->dictMethod( array( new DBusInt64( 51 ), 92, "foo", "bar", new DBusInt64( 42 ), "fsadf" ) ) );
$a = new DBusByte( 54.5 );
$b = new DBusInt64( 54.5 );
$c = new DBusUInt16( 54.5 );
$d = new DBusDouble( 54.5 );
var_dump( $n->dictMethod( $a, $b, $c, $d ) );
$d = new DBusStruct( "sss", 
	array( 
		array ( "one", "two", "three" ), 
		array ( new DBusVariant( 42 ), new DBusVariant( false ) ) 
	) 
);
var_dump( $d );
var_dump( $n->dictMethod( $d ) );
*/
/*
$d = new DBusArray(
	DBus::STRUCT,
	array( 
		new DBusStruct( "", array ( "one", "two", "three", 45, new DBusVariant( 3.14 ) ) ), 
		new DBusStruct( "", array ( "een", "twee", "drie", 42, new DBusVariant( false ) ) ) 
	),
	"(sssiv)"
);
var_dump( $d );
echo "reply\n";
var_dump( $n->echoOne( $d ) );
var_dump( $n->echoTwo( $d, "test" ) );
die();
*/
/*
$d = new DBusArray(
	DBus::STRUCT,
	array( 
//		new DBusDict( DBus::STRING, array ( "one" => "two", "three" => new DBusVariant( 3.14 ) ) ), 
		new DBusDict( DBus::STRING, array ( "een" => "twee", "drie" => "foo" ) ) 
	),
	"{ss}"
);
var_dump( $d );
var_dump( $n->dictMethod( $d ) );
*/

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

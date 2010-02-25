<?php
$d = new Dbus;
$n = $d->createProxy( "org.freedesktop.Telepathy.AccountManager", "/org/freedesktop/Telepathy/AccountManager", "org.freedesktop.DBus.Properties");
$data = $n->Get( "org.freedesktop.Telepathy.AccountManager", 'ValidAccounts' );
$accounts = $data->getData()->getData();

foreach( $accounts as $account )
{
	$am = $d->createProxy( "org.freedesktop.Telepathy.AccountManager", $account->getdata(), "org.freedesktop.DBus.Properties" );
	$props = $am->GetAll( "org.freedesktop.Telepathy.Account" )->getData();
	$nick = $props['Nickname']->getData();
	$disp = $props['DisplayName']->getData();
	$norm = $props['NormalizedName']->getData();
	$conn = $props['Connection']->getData()->getData();

	if ( $conn != "/" )
	{
		echo $nick, " (", $norm, ", ", $disp, ")\n";
		echo "- $conn\n\n";

		$obj = str_replace( '/', '.', substr( $conn, 1 ) );
		$cm = $d->createProxy( $obj, $conn, "org.freedesktop.DBus.Properties" );
		$channels = $cm->Get( 'org.freedesktop.Telepathy.Connection.Interface.Requests', 'Channels' )->getData()->getData();
		foreach( $channels as $channel )
		{
			list( $path, $dict ) = $channel->getData();
			echo "  - ", $path->getData(), "\n";
			$dict = $dict->getData();
			$cn = $d->createProxy( $obj, $path->getData(), "org.freedesktop.Telepathy.Channel.Interface.Group" );
			$co = $d->createProxy( $obj, $conn, "org.freedesktop.Telepathy.Connection.Interface.Contacts" );
			if ( $dict['org.freedesktop.Telepathy.Channel.ChannelType']->getData() == 'org.freedesktop.Telepathy.Channel.Type.ContactList' )
			{
				$data = array();
				foreach( $cn->GetMembers()->getData() as $i )
				{
					$data[] = new DBusUInt32( $i );
				}
				$return = $co->GetContactAttributes( new DBusArray( DBUS::UINT32, $data ), new DBusArray( DBUS::STRING, array( 'org.freedesktop.Telepathy.Connection.Interface.Aliasing', 'org.freedesktop.Telepathy.Connection.Interface.SimplePresence' ) ), false );
				$names = array();
				foreach( $return->getData() as $contact )
				{
					$cinfo = $contact->getData();

					$pres = $cinfo["org.freedesktop.Telepathy.Connection.Interface.SimplePresence/presence"]->getData()->getData();
					$name = $cinfo["org.freedesktop.Telepathy.Connection.Interface.Aliasing/alias"]->getData();

					if ( $pres[1] != 'offline' )
					{
						$names[$name] = $pres[1];
					}
				}
				ksort( $names );
				foreach ( $names as $name => $data )
				{
					echo "    - {$name} ($data)\n";
				}
			}
		}
		echo "\n";
	}
}

?>

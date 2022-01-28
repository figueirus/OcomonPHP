<?php
// basic sequence with LDAP is connect, bind, search, interpret search
// result, close connection

echo "<h3>LDAP query test</h3>";
echo "Connecting ...";
$ds=ldap_connect("ldap.unilasalle.edu.br")
 or die("Could not connect to LDAP server.");  // must be a valid LDAP server!
echo "connect result is " . $ds . "<br />";


  $LDAP_DN = 'cn=admin,dc=unilasalle,dc=edu,dc=br';
  $LDAP_PASSWORD = 'gkw4973ldap';

ldap_set_option($ds, LDAP_OPT_PROTOCOL_VERSION, 3);
if ($ds) { 
    echo "Binding ..."; 
    $r=ldap_bind($ds, $LDAP_DN, $LDAP_PASSWORD);     // this is an "anonymous" bind, typically
                           // read-only access
    echo "Bind result is " . $r . "<br />";

    echo "Searching for (uid=guilherme) ...";
    // Search surname entry
    $sr=ldap_search($ds, "ou=usuarios,dc=unilasalle,dc=edu,dc=br", "uid=gui*");  
    echo "Search result is " . $sr . "<br />";

    echo "Number of entires returned is " . ldap_count_entries($ds, $sr) . "<br />";

    echo "Getting entries ...<p>";
    $info = ldap_get_entries($ds, $sr);
    echo "Data for " . $info["count"] . " items returned:<p>";

    for ($i=0; $i<$info["count"]; $i++) {
        echo "dn is: " . $info[$i]["dn"] . "<br />";
        echo "first cn entry is: " . $info[$i]["cn"][0] . "<br />";
        echo "first email entry is: " . $info[$i]["mail"][0] . "<br /><hr />";
    }

    echo "Closing connection";
    ldap_close($ds);

} else {
    echo "<h4>Unable to connect to LDAP server</h4>";
}
?>
                  

# User groups

MKSamlAuth supports two different ways to set groups
to users. 

1) We can map the groups, which are comes from the Identity Provider to TYPO3 Website Groups

2) We can set default groups to _all_ users. 

Theoretically you can also combine this methods, but this
isn't recommended because the IdP should decide the roles not the system.

## Default Groups

In your "Identity Provider" Configuration record you can set the website groups, which will be assigned on sign up.

## Group Matching

We provide a "Group Mapping" configuration record, which you can create via the TYPO3 Backend. 

In the Field "Groupname from SSO" you have to enter the group name which comes from the IdP. 

In Groups you have select, which are the corresponding website
groups in TYPO3. 